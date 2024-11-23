<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Admin extends Controller {
    

    public function admin_dashboard() {
		$this->call->view('/Admin/admin_dashboard');
	}
    public function admin_activity() {
		$this->call->view('/Admin/admin_activity');
	}
	public function admin_users() {
		$this->call->view('/Admin/admin_users');
	}

	public function admin_notification() {
		$this->call->view('/Admin/admin_notification');
	}

	public function admin_setting() {
		$this->call->view('/Admin/admin_setting');
	}
}
?>
