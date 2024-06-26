<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends My_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->table = "user";
        $this->load->library(['encrypt', 'encryption', 'form_validation', 'user_agent', 'session']);
        $this->rules = [
            'username' => 'is_unique_auth[user.username]',
            'password' =>  array('password_check', function ($str) {
                if ($this->user->get(['username' => $_POST['username']])) {
                    $query = $this->user->get(['username' => $_POST['username']]);
                    $decode = $this->encrypt->decode($query->password, $query->create_key);
                    if ($str !== $decode) {
                        return true;
                    }
                }
            })
        ];
        $this->errorMessage = [
            'username' => [
                'is_unique_auth' => 'The %s does not exist in the database.'
            ],
            'password' => [
                'password_check' => 'The %s is not working.'
            ]
        ];
    }
}
