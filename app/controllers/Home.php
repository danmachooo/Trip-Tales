<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Home extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('Entry_model', 'entry');
        if(! logged_in()) {
            redirect('auth');
        }


    }

	public function index() {
        $data['tags'] = $this->entry->get_all_tags();
        $data['posts'] = $this->entry->get_all_entries();
       $this->call->view('homepage', $data);
            //  $this->call->view('chat');
    }

    public function profile() {
		$this->call->view('/profile');
	}

}
