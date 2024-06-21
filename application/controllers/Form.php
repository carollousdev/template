<?php

class Form extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    function test()
    {
        $data = 'masuk';
        $output = array(
            "data" => $data
        );

        echo json_encode($output);
    }
}
