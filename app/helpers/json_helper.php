<?php

if ( ! function_exists('json_response'))
{
	 function json_response($success, $message, $data = [])
    {
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ]);
    }
}

