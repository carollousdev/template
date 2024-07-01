<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/CI_Template.php';
class Navigation extends CI_Template
{

    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME), 1);
        $this->data['js'] = '<script src="http://localhost:8080/template/assets/js/navigation.js"></script>';
        $this->option['type'] = $this->master->change_option(['Root', 'Master', 'Single'], 0);
        $this->option['root'] = $this->master->change_option($this->master->gets(['type' => 1]), 1);
    }
}
