<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CI_Template extends CI_Controller
{

    public $data;
    public function index()
    {
        $this->data['dashboard'] = $this->dashboard->get(['id' => 1]);
        $this->load->view('Dashboard', $this->data);
    }
}
