<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends My_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->table = "user";
        $this->rules = [
            'username' => 'required|min_length[5]|max_length[25]|is_unique[user.username]|alpha_numeric',
            'password' => 'trim|required|min_length[8]'
        ];
    }
}
