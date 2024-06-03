<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CI_Template extends CI_Controller
{

    public $data;
    public $master;
    public $page_info;

    public function __construct($path = "", $page_info = "", $join_database = array())
    {
        parent::__construct();
        $this->data = $_POST;
        $this->page_info = $page_info;
        $this->data['path'] = $path;
        $this->data['hTable'] = "";
        if (!empty($page_info)) {
            $this->load->model($this->data['path'] . "_model", "master");
        } else $this->load->model("dashboard_model", "master");

        $this->data['dashboard'] = $this->dashboard->get(['id' => 1]);
    }

    public function index()
    {

        $this->data['content'] = $this->data['path'];
        $this->load->view($this->data['path'], $this->data);
    }

    public function server_side()
    {
        if (!empty($this->page_info)) {
            $getData = $this->master->getDataTable();
            $data = [];
            $no = $_POST['start'];
            foreach ($getData as $key => $value) {
                $row = array();
                foreach ($this->master->get_field_original() as $k => $val) {
                    if ($val == 'id') {
                        $row[] = ++$no;
                    } else {
                        $row[] = $value->$val;
                    }
                }
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->master->count_all_data(),
                "recordsFiltered" => $this->master->Count_filtered_data(),
                "data" => $data
            );
        } else {
            $output = array(
                "data" => ""
            );
        }

        echo json_encode($output);
    }
}
