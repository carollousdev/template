<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CI_Template extends CI_Controller
{

    public $data;

    public function __construct($path = "", $database = "")
    {
        parent::__construct();
        $this->data = $_POST;
        empty($path) ? $this->data['path'] = 'dashboard' : $this->data['path'] = $path;
    }

    public function index()
    {
        $this->data['dashboard'] = $this->dashboard->get(['id' => 1]);
        $this->data['content'] = $this->data['path'];
        $this->load->view('user', $this->data);
    }
}
