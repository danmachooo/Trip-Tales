<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Friend_controller extends Controller {
    protected $user_id;
    
    public function __construct()
    {
        parent::__construct();
        $this->call->model('Friend_model', 'friend');
        if(! logged_in()) {
            redirect('auth');
        }
        $this->user_id = $this->session->userdata('user_id');

    }


    public function send_friend_request() {
        $sender_id = $this->io->post('sender_id');
        $receiver_id = $this->io->post('receiver_id');

        if($this->friend->send_friend_request($sender_id, $receiver_id)) {
            echo 'Friend Request has been sent!';
        } else {
            echo 'Failed to send friend request.';
        }
    }

    // public function get_friend_request_status(){
    //     $data = $this->$friend->get_friend_request_status();
    //     $this->call->view('/friends', $data);
    // }

    public function get_friend_requests(){
        $receiver_id = $this->io->post('receiver_id');

        $data = $this->friend->get_friend_requests($this->user_id, $receiver_id);
        $this->call->view('friends', $data);
    }

    public function update_friend_request() {
        $sender_id = $this->session->userdata('user_id');
        $receiver_id = $this->io->post('receiver_id');
        $status = $this->io->post('status');

        if($this->friend->update_friend_request($sender_id, $receiver_id, $status)) {
            echo 'Friend Request has been updated!';
        } else {
            echo 'Failed to update friend request.';
        }

    }
}
?>
