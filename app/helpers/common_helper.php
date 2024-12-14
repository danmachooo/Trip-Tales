<?php

if ( ! function_exists('xss_clean'))
{
	function xss_clean($string)
	{
		$LAVA =& lava_instance();
		$LAVA->call->library('antixss');
		return $LAVA->antixss->xss_clean($string);
	}
}

if ( ! function_exists('set_flash_alert'))
{
	function set_flash_alert($alert, $message) {
		$LAVA =& lava_instance();
		$LAVA->session->set_flashdata(array('alert' => $alert, 'message' => $message));
	}
}

if ( ! function_exists('json_response'))
{
	function json_response($success, $message, $data = [], $status_code = 200) {
		// Set the HTTP response code
		http_response_code($status_code);	
	
		// Build the response array
		$response = [
			'success' => $success,
			'message' => $message,
			'data' => $data
		];
	
		header('Content-Type: application/json');
	
		echo json_encode($response);
		exit; // Terminate script to avoid additional output
	}
	
}

if ( ! function_exists('flash_alert'))
{
	function flash_alert()
	{
		$LAVA =& lava_instance();
		if($LAVA->session->flashdata('alert') !== NULL) {
			echo '
	        <div class="alert alert-' . $LAVA->session->flashdata('alert') . '">
	            <i class="icon-remove close" data-dismiss="alert"></i>
	            ' . $LAVA->session->flashdata('message') . '
	        </div>';
		}
			
	}
}

if ( ! function_exists('logged_in'))
{
	//check if user is logged in
	function logged_in() {
		$LAVA =& lava_instance();
		$LAVA->call->library('lauth');
		if($LAVA->lauth->is_logged_in())
			return true;
	}
}

if ( ! function_exists('get_user_id'))
{
	//get user id
	function get_user_id() {
		$LAVA =& lava_instance();
		$LAVA->call->library('lauth');
		return $LAVA->lauth->get_user_id();
	}
}

if ( ! function_exists('get_fullname'))
{
	//get username
	function get_fullname($user_id) {
		$LAVA =& lava_instance();
		$LAVA->call->library('lauth');
		return $LAVA->lauth->get_fullname($user_id);
	}
}

if ( ! function_exists('email_exist'))
{
	function email_exist($email) {
		$LAVA =& lava_instance();
		$LAVA->db->table('users')->where('email', $email)->get();
		return ($LAVA->db->row_count() > 0) ? true : false;
	}
}