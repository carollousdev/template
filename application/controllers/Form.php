<?php

class Form extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    function index()
    {
        $this->load->view('v_form');
    }

    function aksi()
    {
        $this->form_validation->set_rules(
            'name',
            'name',
            'required|min_length[5]|is_unique[user.name]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
            )
        );

        if ($this->form_validation->run() != false) {
            echo "Form validation oke";
        } else {
            $this->load->view('v_form');
        }
    }
}
