<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/CI_Template.php';
class User extends CI_Template
{

    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME), 1);
        $this->data['enable_add'] = ['password'];
        $this->data['enable_edit'] = ['password'];
    }
}
