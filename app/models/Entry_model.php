<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Entry_model extends Model {
    
    public function __construct()
    {
        parent::__construct();
    }

    public function save_entry($destination, $description, $latitude, $longitude, $photo_url, ){
        $bind = array(
            'destination' => $destination,
            '$description' => $description,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'photo_url'=> $photo_url
            );
        
        return $this->db->table('travel_entries')->insert($bind);
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
        return $this->db->table('travel_entries')->get_all();
    }
}
?>
