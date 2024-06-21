<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends My_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->table = "role";
        $this->rules = [
            'short_name' => 'required|max_length[10]|is_unique[role.short_name]|alpha',
        ];
    }
}
