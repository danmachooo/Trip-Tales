<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Entry_controller extends Controller {
    
    public function __construct()
    {
        parent::__construct();
        if(! logged_in()) {
            redirect('auth');
        }

        $this->call->model('Entry_model', 'entry');
    }

    public function get_all_entries()
    {
        $data['posts'] = $this->entry->get_all_entries();
        $this->call->view('homepage', $data);
    }

    public function save_entry()
    {
        // Check if the form was submitted
        if (!$this->form_validation->submitted()) {
            // Respond with an error if form not submitted correctly
            return json_response(false, 'Invalid form submission.');
        }

        // Gather form data
        $description = $this->io->post('description');
        $destination = $this->io->post('destination');
        $latitude = $this->io->post('latitude');
        $longitude = $this->io->post('longitude');
        $tags = $this->io->post('tags');

        // Handle file upload
        $this->call->library('upload', $_FILES['image-upload']);
        $this->upload
            ->set_dir('public') // Better to organize uploads in a subfolder
            ->allowed_extensions(array('jpg', 'jpeg', 'png'))
            ->allowed_mimes(array('image/gif', 'image/jpg', 'image/jpeg', 'image/png'))
            ->is_image();

        if (!$this->upload->do_upload()) {
            // Respond with upload errors
            return json_response(false, 'File upload failed.', $this->upload->get_errors());
        }

        $filename = $this->upload->get_filename();

        // Save the entry to the database using the model
        $is_saved = $this->entry->save_entry($destination, $tags, $description, $latitude, $longitude, $filename);

        if ($is_saved) {
            // Respond with success
            return json_response(true, 'Entry saved successfully!');
        } else {
            // Respond with database error
            return json_response(false, 'Failed to save entry to the database.');
        }
    }

}
?>
