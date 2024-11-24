<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Friend_model extends Model {
    
    public function __construct()
    {
        parent::__construct();
    }

    // public function get_friend_request_status($sender_id, $receiver_id) {

    //     $query = `
    //         SELECT status
    //         FROM friend_requests
    //         WHERE (sender_id = ? AND receiver_id = ?)
    //         OR (sender_id = ? AND receiver_id = ?);

    //     `;
    //     return $this->db->raw($query, array($sender_id, $receiver_id), PDO::FETCH_ASSOC);
    // }

    public function get_friend_requests($sender_id, $receiver_id) {
        return $this->db->table('friend_requests')
            ->where('sender_id', $sender_id)
            ->or_where('receiver_id', $receiver_id)
            ->or_where('status', 'pending')
            ->get_all();
    }

    public function get_all_friends($sender_id){
        $query = `
            SELECT *
            FROM friend_requests
            WHERE (sender_id = ? AND status = 'accepted')
            OR (receiver_id = ? AND status = 'accepted');

        `;

        return $this->db->raw($query, array($sender_id, $sender_id), PDO::FETCH_ASSOC); 
    }
    

    public function send_friend_request($sender_id, $receiver_id) {
        $bind = array(
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id
        );

        return $this->db->table('friend_requests')->insert($bind);
    }

    public function update_friend_request($sender_id, $receiver_id, $status){
        $now = new DateTime();

        $where = [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'status' => 'pending',
        ];

        $data = [
            'status' => $status,
            'responded_at' => $now->format('Y-m-d H:i:s')
        ];
        
        $this->db->table('friend_requests')->where($where)->update($data);
    }


}
?>