<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Entry_controller extends Controller {
    
    public function __construct()
    {
        parent::__construct();

        $this->call->model('Entry_model', 'entry');
    }

    public function save_entry(){
        
    }
}
?>
