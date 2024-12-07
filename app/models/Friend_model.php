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

        // $where1 = [
        //     'sender_id'=> $sender_id,
        //     'status'=> 'accepted'
        // ];
        // $where2 = [
        //     'receiver_id'=> $receiver_id,
        //     'status'=> 'accepted'
        // ];

        // $this->db->table('friend_requests')->where($where1)->or_where($where2)->get_all();

        // return $this->db->table('friend_requests as fr')->join('users as u', 'fr.sender_id = u.id')->where($where1)->or_where($where2)->get_all();

        $query = "
            SELECT DISTINCT u.id, u.firstname, u.lastname, u.email
            FROM users u
            JOIN friend_requests fr1 ON u.id = fr1.receiver_id
            WHERE fr1.sender_id = ? AND fr1.status = 'accepted'
            UNION
            SELECT DISTINCT u.id, u.firstname, u.lastname, u.email
            FROM users u
            JOIN friend_requests fr2 ON u.id = fr2.sender_id
            WHERE fr2.receiver_id = ? AND fr2.status = 'accepted';";

        return $this->db->raw($query, array($sender_id, $sender_id), PDO::FETCH_ASSOC); 
        
        
        // $query = '
        //     SELECT *
        //     FROM friend_requests
        //     WHERE (sender_id = ? AND status = "accepted")
        //     OR (receiver_id = ? AND status = "accepted");
        // ';

        // return $this->db->raw($query, array($sender_id, $sender_id), PDO::FETCH_ASSOC); 
    }

    public function get_friend($user1_id, $user2_id) {

        // $where1 = [
        //     'sender_id' => $user1_id,
        //     'receiver_id' => $user2_id,
        // ];
        
        // $where2 = [
        //     'sender_id' => $user2_id,
        //     'receiver_id' => $user1_id,
        // ];

        // return $this->db->table('users as u')->join('friend_requests as fr', 'u.id =fr.sender_id OR u.id = fr.receiver_id')
        //                 ->where($where1)
        //                 ->or_where($where2)
        //                 ->where('fr.status', 'accepted')
        //                 ->where('u.id', '!=' , $user1_id)
        //                 ->get();
        $query = "
                SELECT 
                    u.id,
                    u.firstname,
                    u.lastname,
                    u.email,
                    u.profile_photo
                FROM 
                    users u
                JOIN 
                    friend_requests fr ON (u.id = fr.sender_id OR u.id = fr.receiver_id)
                WHERE 
                    ((fr.sender_id = ? AND fr.receiver_id = ?) OR (fr.sender_id = ? AND fr.receiver_id = ?))
                    AND fr.status = 'accepted'
                    AND u.id != ?
                LIMIT 1;
        ";

        return $this->db->raw($query, array($user1_id, $user2_id, $user2_id, $user1_id, $user1_id), PDO::FETCH_ASSOC);
                        
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