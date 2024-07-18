<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/CI_Template.php';
class Dashboard extends CI_Template
{

    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
    }

    public function index()
    {
        $this->load->view('dashboard', $this->data);
    }
}
