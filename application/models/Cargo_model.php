<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cargo_model extends My_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->table = "cargo";
        $this->column_order = ['name'];
    }
}
