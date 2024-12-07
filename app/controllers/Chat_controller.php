<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Chat_controller extends Controller {
    protected $user_id;

    public function __construct()
    {
        parent::__construct();
        if (!logged_in()) {
            redirect('auth/login');
        }

        $this->call->model('Friend_model', 'friend');
        $this->call->model('Chat_model', 'chat');
        $this->user_id = $this->session->userdata('user_id');
    }

    public function index() {
        $data['friends'] = $this->friend->get_all_friends($this->user_id);
        $this->call->view('chat', $data);
    }
    public function get_recepient($receiver_id) {   
        $data['friends'] = $this->friend->get_all_friends($this->user_id);
        $data['recepient'] = $this->friend->get_friend($this->user_id, $receiver_id);
        $chat = $this->chat->create_chat($this->user_id, $receiver_id);
        $data['chat'] = $chat;
        $data['messages'] = $this->chat->get_messages($chat['id']);
        $data['user_id'] = $this->user_id;

        $this->call->view('chat', $data);
        }  
    public function send_message() {
        $chat_id = $this->io->post('chat_id');
        $message = $this->io->post('message');
        $result = $this->chat->send_message($chat_id, $this->user_id, $message);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send message']);
        }
    }
    public function get_messages()
    {
        $chat_id = $this->io->get('chat_id');
        $messages = $this->chat->get_messages($chat_id);
        $user_id = $this->session->userdata('user_id');

        $html = '';
        foreach ($messages as $message) {
            $html .= '
            <div class="mb-4 ' . ($message['sender_id'] == $user_id ? 'text-right' : 'text-left') . '">
                <div class="flex items-center ' . ($message['sender_id'] == $user_id ? 'justify-end' : 'justify-start') . ' mb-1">
                    <img src="' . ($message['sender_profile_photo'] ?? 'https://picsum.photos/id/237/50') . '" alt="Sender\'s photo" class="w-8 h-8 rounded-full mr-2">
                    <span class="text-sm text-gray-400">' . html_escape($message['sender_firstname'] . ' ' . $message['sender_lastname']) . '</span>
                </div>
                <div class="inline-block p-2 rounded-lg ' . ($message['sender_id'] == $user_id ? 'bg-blue-500 text-white' : 'bg-gray-700 text-gray-200') . '">
                    ' . html_escape($message['message']) . '
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    ' . date('M d, Y H:i', strtotime($message['sent_at'])) . '
                </div>
            </div>';
        }

        echo json_encode([
            'success' => true,
            'messages' => $html
        ]);
    }
}
?>
