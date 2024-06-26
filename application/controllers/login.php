<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/CI_Template.php';
class login extends CI_Template
{

    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME), 1);
    }

    public function index()
    {
        if (!empty($_POST['username'])) {
            $query = $this->user->get(['username' => $_POST['username']]);
            $this->form_validation->set_rules('username', strtoupper('username'), $this->master->validate_config('username'), $this->master->validate_error_message('username'));
            $this->form_validation->set_rules('password', strtoupper('password'), $this->master->validate_config('password'), $this->master->validate_error_message('password'));
        }
        if ($this->form_validation->run() == FALSE) {
            foreach ($this->form_validation->error_array() as $key => $value) {
                $this->data['is_invalid'][$key] = 'is-invalid';
            }
        } else {
            $newdata = array(
                'username' => $_POST['username'],
                'name' => $query->name,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($newdata);
            redirect('dashboard');
        }
        parent::index();
    }
}
