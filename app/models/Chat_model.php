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
        $query = "  
                INSERT INTO chats (user1_id, user2_id, created_at)
                    SELECT ?, ?, CURRENT_TIMESTAMP
                    FROM DUAL
                    WHERE NOT EXISTS (
                        SELECT 1 
                        FROM chats 
                        WHERE (user1_id = ? AND user2_id = ?)   
                        OR (user1_id = ? AND user2_id = ?)
                    );
                    ";
        $this->db->raw($query, array($user1_id, $user2_id, $user1_id, $user2_id, $user2_id, $user1_id), PDO::FETCH_ASSOC);

        $where1 = [
            'user1_id' => $user1_id,
            'user2_id' => $user2_id,
        ];
        
        $where2 = [
            'user1_id' => $user2_id,
            'user2_id' => $user1_id,
        ];

        return $this->db->table('chats')
            ->select('id')
            ->where($where1)
            ->or_where($where2)
            ->get();         
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
            'message' => $message,
            'sent_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->table('messages')->insert($data);
    }

    public function get_messages($chat_id)
    {
        $query = "
            SELECT 
                m.id AS message_id,
                m.chat_id,
                m.sender_id,
                m.message,
                m.sent_at,
                m.seen
            FROM 
                messages m
            WHERE 
                m.chat_id = ?
            ORDER BY 
                m.sent_at ASC
        ";
        return $this->db->raw($query, array($chat_id), PDO::FETCH_ASSOC);
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
        $query = "SELECT 
                        COUNT(m.id) AS unread_count
                    FROM 
                        messages m
                    JOIN 
                        chats c ON m.chat_id = c.id
                    WHERE 
                        m.seen = 0 AND 
                        ((c.user1_id = ? AND m.sender_id != ?) 
                        OR (c.user2_id = ? AND m.sender_id != ?));
                    ";
        return $this->db->raw($query, array($user_id, $user_id, $user_id, $user_id), PDO::FETCH_ASSOC);
    }

    public function get_recepient_name($user_id, $receiver_id) {
		$query = "
                SELECT 
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
				";

		return $this->db->raw($query, array($user_id, $receiver_id, $user_id, $receiver_id), PDO::FETCH_ASSOC);
        
	} 

    public function get_recent_chats($user_id)  {
        $query = "
                    SELECT 
                        c.id AS chat_id,
                        c.user1_id,
                        c.user2_id,
                        u1.firstname AS user1_name,
                        u2.firstname AS user2_name,
                        m.message AS last_message,
                        m.sent_at AS last_message_time
                    FROM 
                        chats c
                    LEFT JOIN 
                        messages m ON m.chat_id = c.id
                    LEFT JOIN 
                        users u1 ON c.user1_id = u1.id
                    LEFT JOIN 
                        users u2 ON c.user2_id = u2.id
                    WHERE 
                        c.user1_id = ? OR c.user2_id = ?
                    GROUP BY 
                        c.id
                    ORDER BY 
                        MAX(m.sent_at) DESC;
                    ";
        return $this->db->raw($query, array($user_id, $user_id), PDO::FETCH_ASSOC);
    }
}
?>