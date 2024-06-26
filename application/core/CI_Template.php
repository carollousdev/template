<?php

defined('BASEPATH') or exit('No direct script access allowed');
class CI_Template extends CI_Controller
{

    public $data;
    public $master;
    public $page_info;
    public $disable;

    public function __construct($path = "", $page_info = null, $join_database = array())
    {
        parent::__construct();
        $this->load->library(['encrypt', 'encryption', 'form_validation', 'user_agent', 'session']);

        $this->data = $_POST;
        $this->data['path'] = $path;
        $this->page_info = $page_info;

        if (!empty($page_info)) {
            $this->load->model($this->data['path'] . "_model", "master");
        } else $this->load->model("dashboard_model", "master");

        $this->data['dashboard'] = $this->dashboard->get(['id' => 1]);
    }

    public function index()
    {
        $this->data['hTable'] = $this->master->getHeaderName();
        $this->load->view($this->data['path'], $this->data);
    }

    public function server_side()
    {
        $method = 'index';
        if (!empty($this->page_info)) {
            $getData = $this->master->getDataTable();
            $data = [];
            $no = $_POST['start'];
            foreach ($getData as $key => $value) {
                $row = array();
                foreach ($this->master->get_field_original($method, $this->disable[$method]) as $k => $val) {
                    if ($this->db->table_exists($val)) {
                        $change_value = $this->$val->get(['id' => $value->$val]);
                        $row[] = $change_value->name;
                    } else {
                        if ($val == 'id') {
                            $row[] = ++$no;
                        } else {
                            if ($val == 'action') {
                                $row[] = $this->master->actionButton($this->encrypt->encode($value->id));
                            } else {
                                $row[] = $value->$val;
                            }
                        }
                    }
                }
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->master->count_all_data(),
                "recordsFiltered" => $this->master->Count_filtered_data(),
                "data" => $data,
            );
        } else {
            $output = array(
                "data" => "",
            );
        }

        echo json_encode($output);
    }

    public function create()
    {
        $this->data['method'] = 'create';
        $data = [];
        $error = [];

        foreach ($_POST as $key => $value) {
            $this->form_validation->set_rules($key, strtoupper($key), $this->master->validate_config($key));
        }

        if ($this->form_validation->run() == FALSE) {
            foreach ($this->form_validation->error_array() as $key => $value) {
                $error[] = $key;
            }
        } else {
            if (isset($_POST['password'])) {
                $data['create_key'] = crypt($_POST['password'], 16);
                $_POST['password'] = $this->encrypt->encode($_POST['password'], $data['create_key']);
            }
            $data['id'] = $this->master->getLastId();
            $data = array_merge($data, $_POST);
            if ($this->master->create($data)) {
                redirect($this->data['path']);
            }
        }

        $this->data['form'] = $this->master->create_form($error);
        $this->load->view('element/form', $this->data);
    }

    public function edit()
    {
        $this->data['method'] = 'edit';
        $data = [];
        $error = [];

        $_POST['id'] = $this->encrypt->decode($_POST['id']);
        $query = $this->master->get(['id' => $_POST['id']]);

        foreach ($_POST as $key => $value) {
            if (!in_array($key, ['id', 'username'])) {
                $this->form_validation->set_rules($key, strtoupper($key), $this->master->validate_config($key));
            } else {
                if ($key == 'username' && $query->username != $value) {
                    $this->form_validation->set_rules($key, strtoupper($key), 'rule1', ['rule1' => 'username value cannot change.']);
                }
            }
        }

        if ($this->form_validation->run() == FALSE) {
            foreach ($this->form_validation->error_array() as $key => $value) {
                $error[] = $key;
            }
        } else {
            if (isset($_POST['password'])) {
                $data['create_key'] = crypt($_POST['password'], 16);
                $_POST['password'] = $this->encrypt->encode($_POST['password'], $data['create_key']);
            }
            $data = array_merge($data, $_POST);
            if ($this->master->edit($data, ['id' => $query->id])) {
                redirect($this->data['path']);
            }
        }

        $this->data['form'] = $this->master->edit_form($this->data['id'], $error);
        $this->load->view('element/form', $this->data);
    }

    public function delete()
    {
        if ($this->master->delete(['id' => $this->encrypt->decode($_POST['id'])])) {
            redirect($this->data['path']);
        }
    }

    public function get_data()
    {
        $data['name'] = $this->role->get(['id' => $this->master->get(['id' => $this->encrypt->decode($_POST['id'])])->role])->name;
        $data['id'] = $this->master->get(['id' => $this->encrypt->decode($_POST['id'])])->role;

        echo json_encode($data);
    }

    public function optionData()
    {

        $search_term = "";
        $data = array();
        foreach ($_GET['term'] as $key => $value) {
            if ($key == 'term') {
                $search_term = $value;
            }
        }

        $query = $this->role->gets("", ['name' => $search_term]);

        $usersData['result'] = array();
        foreach ($query as $key => $value) {
            $data['id'] = $value->id;
            $data['text'] = $value->name;
            array_push($usersData['result'], $data);
        }
        echo json_encode($usersData);
    }
}
