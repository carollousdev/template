<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vessel_model extends My_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->table = "vessel";
        $this->change_value = ['type' => ['Chemical Tanker', 'Container Tanker', 'Tugboat', 'SPOB']];
    }
}
