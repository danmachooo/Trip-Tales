<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Chat_model extends Model {
    
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
    }

    public function create_chat($user1_id, $user2_id)
    {
        $data = [
            'user1_id' => $user1_id,
            'user2_id' => $user2_id
        ];
        return $this->db->table('chats')->insert($data);
    }

    public function get_chat($chat_id)
    {
        return $this->db->table('chats')->where('id', $chat_id)->get();
    }

    public function get_user_chats($user_id)
    {
        return $this->db->table('chats')
            ->where('user1_id', $user_id)
            ->or_where('user2_id', $user_id)
            ->get_all();
    }
    

    public function send_message($chat_id, $sender_id, $message)
    {
        $data = [
            'chat_id' => $chat_id,
            'sender_id' => $sender_id,
            'message' => $message
        ];
        return $this->db->table('messages')->insert($data);
    }

    public function get_messages($chat_id, $limit = 50, $offset = 0)
    {
        return $this->db->table('messages')
            ->where('chat_id', $chat_id)
            ->order_by('sent_at', 'DESC')
            ->limit($limit, $offset)
            ->get_all();
    }

    public function mark_messages_as_seen($chat_id, $user_id)
    {
        $data = ['seen' => 1];
        return $this->db->table('messages')
            ->where('chat_id', $chat_id)
            ->where('sender_id', '!=', $user_id)
            ->where('seen', 0)
            ->update($data);
    }

    public function get_unread_message_count($user_id)
    {
        return $this->db->table('messages as m')
            ->join('chats as c', 'm.chat_id = c.id')
            ->where('m.seen', 0)
            ->where('m.sender_id', '!=', $user_id)
            ->where('c.user1_id', $user_id)
            ->or_where('c.user2_id', $user_id)
            ->select_count('m.id', 'unread_count')
            ->get();
    }

    function get_recepient_name($user_id, $receiver_id) {
		$query = `SELECT 
					u.firstname, 
					u.lastname,
					u.id
				FROM 
					friend_requests fr
				JOIN 
					users u ON (u.id = fr.sender_id OR u.id = fr.receiver_id)
				WHERE 
					(fr.sender_id = ? OR fr.receiver_id = ?)
					AND (fr.sender_id = ? OR fr.receiver_id = ?)
					AND fr.status = 'accepted';
				';
		`;

		return $this->db->raw($query, array($user_id, $receiver_id, $user_id, $receiver_id), PDO::FETCH_ASSOC);
	} 
}
?>