<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/CI_Template.php';
class login extends CI_Template
{

    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME), 1);
    }

    public function auth()
    {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = $this->user->get(['username' => $username]);
        if ($this->encrypt->decode($query->password, $query->create_key) == $password) {
            $newdata = array(
                'username' => $_POST['username'],
                'name' => $query->name,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($newdata);
            redirect('dashboard');
        } else {
            redirect('login');
        }
    }
}
