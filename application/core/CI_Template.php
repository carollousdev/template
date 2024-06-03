<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CI_Template extends CI_Controller
{

    public $data;

    public function __construct($path = "", $database = "")
    {
        parent::__construct();
        $this->data = $_POST;
        $this->data['path'] = $path;
    }

    public function index()
    {
        $this->data['dashboard'] = $this->dashboard->get(['id' => 1]);
        $this->data['content'] = $this->data['path'];
        $this->load->view($this->data['path'], $this->data);
    }

    public function server_side()
    {
        $output = array(
            "data" => 'masuk'
        );

        echo json_encode($output);
    }
}
