<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Person_model extends My_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->table = "person";
        $this->change_value = ['gender' => ['Male', 'Female']];
        $this->column_order = ['pob', 'name'];
    }
}
