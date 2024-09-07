<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/CI_Template.php';
class Navigation extends CI_Template
{

    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME), 1);
        $this->data['js'] = '<script src="http://localhost:8080/template/assets/js/navigation.js"></script>';
        $this->options['set_data']['type'] = ['Root', 'Master', 'Single'];
        $this->options['root'] = ['navigation', ['type' => 1], ['name' => $this->get['term']]];
        $this->data['rules'] = array('checkurutan_callback' => 'Sequences number not available.');
    }
}
