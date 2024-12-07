<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Chat_controller extends Controller {
    protected $user_id;

    public function __construct()
    {
        parent::__construct();
        if (!logged_in()) {
            redirect('auth/login');
        }

        $this->call->model('Friend_model', 'friend');
        $this->call->model('Chat_model', 'chat');
        $this->user_id = $this->session->userdata('user_id');
    }

    public function index() {
        $data['friends'] = $this->friend->get_all_friends($this->user_id);
        $this->call->view('chat', $data);
    }
    public function get_recepient($receiver_id) {   
        $data['friends'] = $this->friend->get_all_friends($this->user_id);
        $data['recepient'] = $this->friend->get_friend($this->user_id, $receiver_id);
        $chat = $this->chat->create_chat($this->user_id, $receiver_id);
        $data['chat'] = $chat;
        $data['messages'] = $this->chat->get_messages($chat['id']);
        $data['user_id'] = $this->user_id;

        $this->call->view('chat', $data);    }  
    public function send_message() {
        $chat_id = $this->io->post('chat_id');
        $message = $this->io->post('message');
        $result = $this->chat->send_message($chat_id, $this->user_id, $message);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send message']);
        }
    }
}
?>
