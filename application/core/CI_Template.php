<?php

defined('BASEPATH') or exit('No direct script access allowed');
class CI_Template extends CI_Controller
{

    public $data;
    public $master;
    public $page_info;
    public $disable;
    public $options;
    public $get;
    public $where;

    public function __construct($path = "", $page_info = null, $join_database = array())
    {
        parent::__construct();
        $this->load->library(['encrypt', 'encryption', 'form_validation', 'user_agent', 'session']);

        $this->data = $_POST;
        $this->get = $_GET;
        $this->data['option'] = array();
        $this->data['path'] = $path;
        $this->data['js'] = '';
        $this->page_info = $page_info;

        $this->get['term'] = "";
        if (!empty($_GET['term'])) {
            foreach ($_GET['term'] as $key => $value) {
                if ($key == 'term') {
                    $this->get['term'] = $value;
                }
            }
        }


        if (!empty($page_info)) {
            $this->load->model($this->data['path'] . "_model", "master");
        } else $this->load->model("dashboard_model", "master");

        $this->data['dashboard'] = $this->dashboard->get(['id' => 1]);
        $this->data['sidebar'] = $this->navigation->sidebar();
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
                                if (!empty($this->options[$val])) {
                                    $row[] = $this->master->change_options($this->options[$val][0], $value->$val);
                                } else {
                                    if (!empty($this->master->change_value[$val])) {
                                        $row[] = $this->master->change_value[$val][$value->$val];
                                    } else $row[] = $value->$val;
                                }
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

        if (count($_POST) > 1) {
            foreach ($this->master->get_field_original() as $key => $value) {
                if (!in_array($value, ['id', 'username', 'action'])) {
                    $this->form_validation->set_rules($value, strtoupper($value), $this->master->validate_config($value));
                } else {
                    if ($value == 'username') {
                        $this->form_validation->set_rules($value, strtoupper($value), $this->master->validate_config($value));
                    }
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
            $data['id'] = $this->master->getLastId();
            $data = array_merge($data, $_POST);
            if ($this->master->create($data)) {
                redirect($this->data['path']);
            }
        }

        $this->data['form'] = $this->master->create_form($error, $this->options);
        $this->load->view('element/form', $this->data);
    }

    public function edit()
    {
        $this->data['method'] = 'edit';
        $data = [];
        $error = [];

        $query = $this->master->get(['id' => $this->encrypt->decode($this->data['id'])]);

        if (count($_POST) > 1) {
            foreach ($this->master->get_field_original() as $key => $value) {
                if (!in_array($value, ['id', 'username', 'action'])) {
                    $this->form_validation->set_rules($value, strtoupper($value), $this->master->validate_config($value));
                } else {
                    if ($value == 'username' && $query->username != $_POST['username']) {
                        $this->form_validation->set_rules($value, strtoupper($value), 'rule1', ['rule1' => 'Username value cannot change.']);
                    }
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
            unset($data['id']);
            if ($this->master->edit($data, ['id' => $this->encrypt->decode($this->data['id'])])) {
                redirect($this->data['path']);
            }
        }

        $this->data['form'] = $this->master->edit_form($this->data['id'], $error, $this->options);
        $this->load->view('element/form', $this->data);
    }

    public function delete()
    {
        if ($this->master->delete(['id' => $this->encrypt->decode($_POST['id'])])) {
            redirect($this->data['path']);
        }
    }

    public function getOption()
    {
        $option = array();
        $data = array();
        $form_serialize = array();
        $call_option = true;

        foreach ($_GET['FormData'] as $key => $value) {
            $form_serialize[$value['name']] = $value['value'];
        }

        if (!empty($this->master->option_where[$_GET['tipe']])) {
            foreach ($this->master->option_where[$_GET['tipe']] as $key => $value) {
                if ($form_serialize[$key] == $value) {
                    $call_option = true;
                } else $call_option = false;
            }
        }

        !empty($form_serialize['id']) ? $id = $this->encrypt->decode($form_serialize['id']) : $id = "";
        if ($call_option == true && !empty($this->options[$_GET['tipe']])) {
            foreach ($this->master->change_option($this->master->gets($this->options[$_GET['tipe']][1], $this->options[$_GET['tipe']][2])) as $key => $value) {
                if ($value['id'] != $id) {
                    $data['id'] = $value['id'];
                    $data['text'] = $value['text'];
                    array_push($option, $data);
                }
            }
        } else {
            $data['id'] = 'no' . $_GET['tipe'];
            $data['text'] = 'No ' . $_GET['tipe'];
            array_push($option, $data);
        }

        echo json_encode($option);
    }
}
