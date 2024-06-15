<?php

defined('BASEPATH') or exit('No direct script access allowed');
class CI_Template extends CI_Controller
{

    public $data;
    public $master;
    public $page_info;
    public $table_prefix;

    public function __construct($path = "", $page_info = "", $join_database = array())
    {
        parent::__construct();
        $this->load->library(['encrypt', 'encryption', 'form_validation']);
        $this->data = $_POST;
        $this->page_info = $page_info;

        $this->data['hTable'] = "";
        $this->data['path'] = $path;
        $this->data['enable_add'] = array();
        $this->data['enable_edit'] = array();
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
                        if ($val == 'action') {
                            $row[] = $this->master->actionButton($this->encrypt->encode($value->id));
                        } else {
                            $row[] = $value->$val;
                        }
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

    public function add()
    {
        $data = [];
        $error = [];
        foreach ($_POST as $key => $value) {
            if ($this->form_validation->set_rules($key, strtoupper($key), 'required|is_unique[user.' . $key . ']')) {
                $data[$key] = $value;
                $error[$key] = 'false';
            }
        }

        if (!empty($data['password'])) {
            $data['create_key'] = bin2hex($this->encryption->create_key(16));
            $data['password'] = $this->encrypt->encode($data['password'], $data['create_key']);
        }


        $data['id'] = $this->master->getLastId();

        if ($this->form_validation->run() != false) {
            if ($this->master->add($data)) {
                $status = 'success';
            }
        } else {
            foreach ($this->form_validation->error_array() as $key => $value) {
                $status = 'error';
                $error[$key] = $value;
            }
        }
        $output = array(
            "response" => $status,
            "error" => $error
        );

        // if (empty($error)) {
        //     if ($this->master->add($data)) {
        //         $status = 'success';
        //     }
        // } else {
        //     $status = 'false';
        // }

        echo json_encode($output);
    }

    public function addModal()
    {
        $data = $this->master->add_form($this->data['enable_add']);
        $result = array(
            'data' => $data,
        );
        echo json_encode($result);
    }

    public function edit()
    {
        $data = [];
        $error = [];
        $sql = $this->master->get(['id' => $this->encrypt->decode($_POST['id'])]);
        foreach ($_POST as $key => $value) {
            if ($key == 'password') {
                if ($value == $this->encrypt->decode($sql->password, $sql->create_key)) {
                    $error[$key] = "Data tidak boleh kosong";
                }
            } else {
                $data[$key] = $value;
            }
        }

        if (!empty($data['password'])) {
            $data['create_key'] = bin2hex($this->encryption->create_key(16));
            $data['password'] = $this->encrypt->encode($data['password'], $data['create_key']);
        }

        $error = 'carol';
        $check = $this->master->deteksiEmail($error);
        var_dump($check);
        die();
        $result = $this->master->edit($data, ['id' => $data['id']]);
        echo json_encode($result);
    }

    public function editModal()
    {
        $data = $this->master->edit_form($_POST['id'], $this->data['enable_edit']);
        $result = array(
            'data' => $data,
        );
        echo json_encode($result);
    }

    public function delete()
    {
        $result = $this->master->delete(['id' => $_POST['id']]);
        echo json_encode($result);
    }
}
