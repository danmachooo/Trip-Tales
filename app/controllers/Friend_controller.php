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


    public function accept_friend() {
        $friend_id = $this->io->post('id');

        if($this->friend->accept_friend($friend_id, $this->user_id)) {
            json_response(true, 'Friend request accepted', [], 201);
        } else {
            json_response(false, 'Something went wrong...', [], 400);
        }
    }

    public function decline_friend() {
        $friend_id = $this->io->post('id');

        if($this->friend->accept_friend($friend_id, $this->user_id)) {
            json_response(true, 'Friend request declined', [], 201);
        } else {
            json_response(false, 'Something went wrong...', [], 400);
        }
    }
    
    public function get_friend_requests(){
        $data['requests'] = $this->friend->get_friend_requests($this->user_id);
        $data['users'] = $this->friend->get_all_users_with_relationship_status($this->user_id);
        $this->call->view('friend_requests', $data);
    }
    
    
    public function get_all_users_with_relationship_status(){

    }
}
?>
