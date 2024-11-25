<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Chat_controller extends Controller {

    public function __construct()
    {
        parent::__construct();
        if (!logged_in()) {
            redirect('auth/login');
        }

        $this->call->model('Chat_model', 'chat');
        $this->call->model('Friend_model', 'friend');
    }

    public function index() {
        $sender_id = $this->session->user_data('user_id');
        $data = $this->$friend->get_all_friends($sender_id, $sender_id);
        $this->call->view('chat', $data);
    }

    public function get_recepient() {
        $sender_id = $this->session->user_data('user_id');
        $receiver_id = $this->io->get('receiver_id');

        $data['friend'] = $this->chat->get_recepient_name($sender_id, $receiver_id);
        $this->call->view('chat', $data);
    }



    
}
?>
