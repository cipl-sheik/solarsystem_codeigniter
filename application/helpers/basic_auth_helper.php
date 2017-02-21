<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('basic_auth')) {

    function basic_auth() {
        $CI = & get_instance();

        $headers = apache_request_headers();
        if($headers['Authorization'] != AUTH_KEY)
        {
            $response = array("result" => "error",
                "message" => "Authorization Key Mismatch"
            );
            echo json_encode($response);
            exit;
        }
    }

}