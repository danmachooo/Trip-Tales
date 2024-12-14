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

    public function get_friend_requests($receiver_id) {
        return $this->db->table('friend_requests fr')
            ->select('u.id, u.firstname AS firstname, u.lastname AS lastname, fr.sent_at AS sent_at, fr.status AS status, u.profile_photo AS profile_photo')
            ->join('users AS u', 'u.id = fr.sender_id')
            ->where('fr.receiver_id', $receiver_id)
            ->where('fr.status', 'pending')
            ->get_all();
    }

    public function get_all_friends($sender_id){
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
        
    }

    public function get_friend($user1_id, $user2_id) {

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

    public function accept_friend($sender_id, $receiver_id) {
        $now = new DateTime();

        $where = [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'status' => 'pending',
        ];

        $data = [
            'status' => 'accepted',
            'responded_at' => $now->format('Y-m-d H:i:s')
        ];

        $this->db->table('friend_requests')->where($where)->update($data);
    }

    
    public function decline_friend($sender_id, $receiver_id) {
        $now = new DateTime();

        $where = [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'status' => 'pending',
        ];

        $data = [
            'status' => 'declined',
            'responded_at' => $now->format('Y-m-d H:i:s')
        ];

        $this->db->table('friend_requests')->where($where)->update($data);
    }

    public function get_all_users_with_relationship_status($current_user_id){
        $query = "
                SELECT 
                        u.id, 
                        u.firstname, 
                        u.lastname, 
                        u.profile_photo,
                        CASE 
                            WHEN fr.status = 'pending' AND fr.sender_id = ? THEN 'Pending Request'
                            WHEN fr.status = 'accepted' THEN 'Friend'
                            WHEN fr.status = 'pending' THEN 'Pending Approval'
                            WHEN fr.status = 'decined' THEN 'Declined'
                            ELSE 'Not Friend'
                        END AS relationship_status
                    FROM 
                        users u
                    LEFT JOIN 
                        friend_requests fr 
                    ON 
                        (fr.sender_id = ? AND fr.receiver_id = u.id) 
                        OR (fr.sender_id = u.id AND fr.receiver_id = ?)
                    WHERE 
                        u.id != ?;

            ";

        return $this->db->raw($query, array($current_user_id, $current_user_id, $current_user_id, $current_user_id), PDO::FETCH_ASSOC);
    }



    

}
?>