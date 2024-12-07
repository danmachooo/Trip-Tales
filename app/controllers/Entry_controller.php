<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Entry_controller extends Controller {
    protected $user_id;
    
    public function __construct()
    {
        parent::__construct();
        if(! logged_in()) {
            redirect('auth');
        }

        $this->call->model('Entry_model', 'entry');
        $this->user_id = $this->session->userdata('user_id');;
    }

    public function get_all_entries()
    {
        $posts = $this->entry->get_all_entries();
        $current_user_id = get_user_id();

        foreach ($posts as &$post) {
            $post['is_liked'] = $this->entry->is_liked_by_user($post['entry_id'], $current_user_id);
            $post['comments'] = $this->entry->get_five_comments($post['entry_id']);
        }
        $data['tags'] = $this->entry->get_all_tags();
        $data['posts'] = $this->entry->get_all_entries();
        $data['posts'] = $posts;
        $this->call->view('homepage', $data);
    }


    public function save_entry()
    {
        // Check if the form was submitted
        if (!$this->form_validation->submitted()) {
            // Respond with an error if form not submitted correctly
            json_response(false, 'Invalid form submission.');
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
            json_response(false, 'File upload failed.', $this->upload->get_errors());
        }

        $filename = $this->upload->get_filename();

        // Save the entry to the database using the model
        $is_saved = $this->entry->save_entry($destination, $tags, $description, $latitude, $longitude, $filename);

        if ($is_saved) {
            // Respond with success
            json_response(true, 'Entry saved successfully!');
        } else {
            // Respond with database error
            json_response(false, 'Failed to save entry to the database.');
        }
    }

    public function toggle_like() {
        $entry_id = $this->io->post('entry_id');
        $user_id = $this->user_id;
        $this->entry->toggle_like($entry_id, $user_id);
        $like_count = $this->entry->get_like_count($entry_id);

        echo json_encode([
            'success' => true,
            'message' => "Success post",
            'data' =>$like_count
        ]);
     }

    public function add_comment() {
        $entry_id = $this->io->post('entry_id');
        $user_id = $this->user_id;
        $comment = $this->io->post('comment');

        if (empty($comment)) {
            echo json_encode([
                'success' => true,
                'message' => "Comment cannot be empty",   
            ]); 
        }

        $result = $this->entry->add_comment($entry_id, $user_id, $comment);

        if ($result) {
            $comments = $this->entry->get_comments($entry_id);
            echo json_encode([
                'success' => true,
                'message' => "Comment added successfully",
                'data' => $comments   
            ]);   
             // return ['success' => true, 'message' => 'Comment added successfully', 'data' => $comments];
        } else {
            // return ['success' => false, 'message' => 'Failed to add comment'];
            $comments = $this->entry->get_comments($entry_id);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add comment',
                'data' => $comments   
            ]);  
        }
    }

    public function get_comments() {
        $entry_id = $this->io->get('entry_id');
        $comments = $this->entry->get_comments($entry_id);
        echo json_encode([
            'success' => true,
            'message' => 'Fetched comment',
            'data' => $comments   
        ]);  
    }
    public function get_five_comments() {
        $entry_id = $this->io->get('entry_id');
        $comments = $this->entry->get_five_comments($entry_id);
        echo json_encode([
            'success' => true,
            'message' => 'Fetched comment',
            'data' => $comments   
        ]);      }


}
?>
