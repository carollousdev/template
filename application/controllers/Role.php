<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/CI_Template.php';
class Role extends CI_Template
{

    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME), 1);
        $this->data['js'] = '<script src="http://localhost:8080/template/assets/js/permission.js"></script>';
    }

    public function permission()
    {
        $this->data['result'] = "";
        $this->data['id'] = $_POST['id'];
        $navigation = $this->navigation->gets(['type' => 0, 'status' => 0]);
        $method = ['c', 'r', 'u', 'd', 'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'];
        $data = [];
        $dumm = [];
        $redirect = false;

        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                if ($key !== 'id') {
                    $dumm[explode('_', $key)[0]][explode('_', $key)[1]] = $value;
                }
            }
        }

        if (isset($_POST['action'])) {
            foreach ($navigation as $key => $value) {
                $data[$value->id]['role'] = $this->encrypt->decode($this->data['id']);
                $data[$value->id]['navigation'] = $value->id;
                foreach ($method as $k => $val) {
                    if (empty($dumm[$value->id][$val])) {
                        $data[$value->id][$val] = 0;
                    } else $data[$value->id][$val] = $dumm[$value->id][$val];
                }
                if (empty($this->permissions->get(['role' => $data[$value->id]['role'], 'navigation' => $data[$value->id]['navigation']]))) {
                    $this->permissions->create($data[$value->id]);
                } else {
                    $this->permissions->edit($data[$value->id], ['role' => $this->encrypt->decode($this->data['id']), 'navigation' => $value->id]);
                }
            }
            $redirect = true;
        }


        foreach ($navigation as $key => $value) {
            $this->data['result'] .= "<tr>";
            $this->data['result'] .= "<td>" . $value->name . "</td>";
            if (!empty($this->permissions->get(['role' => $this->encrypt->decode($this->data['id']), 'navigation' => $value->id]))) {
                foreach ($this->permissions->get(['role' => $this->encrypt->decode($this->data['id']), 'navigation' => $value->id]) as $k => $val) {
                    if (in_array($k, $method)) {
                        $val == 1 ? $checked = 'checked' : $checked = "";
                        $this->data['result'] .= '<td><input type="checkbox" id="' . $value->id . '_' . $k . '" name="' . $value->id . '_' . $k . '" value=1 ' . $checked . '></td>';
                    }
                }
            } else {
                foreach ($method as $k => $val) {
                    $this->data['result'] .= '<td><input type="checkbox" id="' . $value->id . '_' . $val . '" name="' . $value->id . '_' . $val . '" value=1></td>';
                }
            }
            $this->data['result'] .= "</tr>";
        }

        if ($redirect == true) {
            redirect($this->data['path']);
        } else  $this->load->view('permission', $this->data);
    }
}
