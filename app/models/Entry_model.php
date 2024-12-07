<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Entry_model extends Model {
    
    public function __construct()
    {
        parent::__construct();
    }

    public function save_entry($destination, $tags, $description, $latitude, $longitude, $photo_url ){
        $bind = array(
            'user_id' => $this->session->userdata('user_id'),
            'destination' => $destination,
            'description' => $description,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'photo_url'=> $photo_url
            );
        
        $this->db->table('travel_entries')->insert($bind);

        $entry_id = $this->db->last_id();

        
        foreach($tags as $tag_id){
            $bind = array(
                'entry_id' => $entry_id,
                'tag_id' => $tag_id,
                );
            $this->db->table('entry_tags')->insert($bind);
        }


        return $entry_id;
    }
    public function update_entry($entry_id, $destination, $description, $latitude, $longitude, $photo_url, ){
        $bind = array(
            'destination' => $destination,
            '$description' => $description,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'photo_url'=> $photo_url
            );
        
        return $this->db->table('travel_entries')->where('id', $entry_id)->update($bind);
    }

    public function delete_entry($entry_id){
        return $this->db->table('travel_entries')->where('id', $entry_id)->delete();
    }

    public function get_all_entries(){
        
        return $this->db->table('travel_entries AS te')
        ->select('
            te.id AS entry_id,
            te.destination,
            te.description,
            te.photo_url,
            te.latitude,
            te.longitude,
            te.created_at AS posted_date,
            u.firstname,
            u.lastname,
            GROUP_CONCAT(DISTINCT t.name ORDER BY t.name ASC SEPARATOR ", ") AS tags,
            COUNT(DISTINCT l.id) AS like_count,
            COUNT(DISTINCT c.id) AS comment_count,
            GROUP_CONCAT(
                DISTINCT CONCAT(c.comment, " (", uc.firstname, " ", uc.lastname, ", ", DATE_FORMAT(c.created_at, "%Y-%m-%d %H:%i:%s"), ")")
                ORDER BY c.created_at ASC SEPARATOR "; "
            ) AS comments
        ')
        ->join('users AS u', 'te.user_id = u.id')
        ->left_join('entry_tags AS et', 'te.id = et.entry_id')
        ->left_join('tags AS t', 'et.tag_id = t.id')
        ->left_join('likes AS l', 'te.id = l.entry_id')
        ->left_join('comments AS c', 'te.id = c.entry_id')
        ->left_join('users AS uc', 'c.user_id = uc.id')  // Join with users to get the commenter's name
        ->group_by('te.id, te.destination, te.description, te.photo_url, te.created_at, u.firstname, u.lastname')
        ->order_by('te.created_at', 'DESC')
        ->get_all();
        // return $this->db->raw($query, array(), pdo::FETCH_ASSOC);
    }

    public function get_all_tags(){
        return $this->db->table('tags')->get_all();
    }

    public function toggle_like($entry_id, $user_id) {
        $data = array(
            'entry_id' => $entry_id,
            'user_id' => $user_id
        );
        if ($this->is_liked_by_user($entry_id, $user_id)) {
            return $this->db->table('likes')
                     ->where('entry_id', $entry_id)
                     ->where('user_id', $user_id)
                     ->delete();
        } else {
            return $this->db->table('likes')->insert($data);
        }
    }

    public function add_comment($entry_id, $user_id, $comment) {
        $data = array(
            'entry_id' => $entry_id,
            'user_id' => $user_id,
            'comment' => $comment
        );
        return $this->db->table('comments')->insert($data);
    }

    public function get_comments($entry_id) {
        return $this->db->table('comments c')
                        ->join('users u', 'c.user_id = u.id')
                        ->where('c.entry_id', $entry_id)
                        ->order_by('c.created_at', 'DESC')
                        ->get_all();
    }

    public function get_five_comments($entry_id) {
        return $this->db->table('comments c')
                        ->join('users u', 'c.user_id = u.id')
                        ->where('c.entry_id', $entry_id)
                        ->order_by('c.created_at', 'DESC')
                        ->limit(5)
                        ->get_all();
    }

    public function get_like_count($entry_id) {
        return $this->db->table('likes')
                        ->where('entry_id', $entry_id)
                        ->select_count('id', 'total_likes');
    }

    public function is_liked_by_user($entry_id, $user_id) {
        $query = 'SELECT COUNT(id) > 0 FROM likes WHERE entry_id = ? AND user_id = ?';
        return $this->db->raw($query, array($entry_id, $user_id), PDO::FETCH_ASSOC);


        // return $this->db->table('likes')
        //                 ->where('entry_id', $entry_id)
        //                 ->where('user_id', $user_id)
        //                 ->select_count('id') > 0
        //                 ->get();
    }


}
?>
