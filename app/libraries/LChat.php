<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class LChat implements MessageComponentInterface {
    
    private $LAVA;
    protected $clients;
    protected $session;

    public function __construct() {
        // Initialize the LAVA instance (assumed to be the main framework)
        $this->LAVA = lava_instance();
        $this->clients = new \SplObjectStorage;
        $this->session = $this->LAVA->session;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Attach the new connection to the clients object
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";

        // Retrieve the user ID from the session
        $userId = $this->session->userdata('user_id');
        $conn->userId = $userId;

        // Send chat history to the new connection
        $history = $this->getChatHistory($userId);
        $conn->send(json_encode(['type' => 'history', 'data' => $history]));
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        
        switch ($data['type']) {
            case 'message':
                $this->handleNewMessage($from, $data);
                break;
            case 'fetch_messages':
                $this->handleFetchMessages($from, $data);
                break;
            case 'mark_seen':
                $this->handleMarkSeen($from, $data);
                break;
        }
    }

    protected function handleNewMessage(ConnectionInterface $from, $data) {
        // Extract chat message data
        $chatId = $data['chatId'];
        $message = $data['message'];
        $senderId = $from->userId;

        // Save the message in the database
        $messageId = $this->saveMessage($chatId, $senderId, $message);

        // Prepare the message data to send back to clients
        $messageData = [
            'id' => $messageId,
            'chat_id' => $chatId,
            'sender_id' => $senderId,
            'message' => $message,
            'sent_at' => date('Y-m-d H:i:s'),
            'seen' => false
        ];

        $response = json_encode([
            'type' => 'new_message',
            'data' => $messageData
        ]);

        // Send the new message to all connected clients in the chat
        foreach ($this->clients as $client) {
            // Only send to clients in the same chat or the sender
            if ($client->userId == $from->userId || $this->isUserInChat($client->userId, $chatId)) {
                $client->send($response);
            }
        }
    }

    protected function handleFetchMessages(ConnectionInterface $from, $data) {
        $chatId = $data['chatId'];
        // Retrieve chat history for the given chat ID
        $messages = $this->getChatHistory($chatId);
        
        // Send the chat history back to the client
        $response = json_encode([
            'type' => 'chat_history',
            'data' => $messages
        ]);
        $from->send($response);
    }

    protected function handleMarkSeen(ConnectionInterface $from, $data) {
        $messageId = $data['messageId'];
        $this->markMessageAsSeen($messageId);

        // Inform all clients in the chat about the update
        $response = json_encode([
            'type' => 'mark_seen',
            'messageId' => $messageId
        ]);
        foreach ($this->clients as $client) {
            if ($client->userId == $from->userId || $this->isUserInChat($client->userId, $chatId)) {
                $client->send($response);
            }
        }
    }

    // Helper function to fetch chat history from the database
    protected function getChatHistory($chatId) {
        // Fetch chat history from the database (LAVA->db should be set up)
        return $this->LAVA->db
            ->table('messages')
            ->where('chat_id', $chatId)
            ->order_by('sent_at', 'ASC')
            ->get();
    }

    // Helper function to save a new message to the database
    protected function saveMessage($chatId, $senderId, $message) {
        $data = [
            'chat_id' => $chatId,
            'sender_id' => $senderId,
            'message' => $message,
            'sent_at' => date('Y-m-d H:i:s')
        ];
        $this->LAVA->db->table('messages')->insert($data);
        return $this->LAVA->db->last_id(); // Return the ID of the last inserted message
    }

    // Helper function to mark a message as "seen"
    protected function markMessageAsSeen($messageId) {
        $data = [
            'seen' => true
        ];
        return $this->LAVA->db
            ->table('messages')
            ->where('id', $messageId)
            ->update($data);
    }

    // Check if the user is part of a specific chat
    protected function isUserInChat($userId, $chatId) {
        $chatParticipants = $this->LAVA->db
            ->table('chat_users')
            ->where('chat_id', $chatId)
            ->where('user_id', $userId)
            ->get();
        return $this->LAVA->db->row_count() > 0;
    }

    public function onClose(ConnectionInterface $conn) {
        // Detach the connection when it closes
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        // Handle errors
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
?>
