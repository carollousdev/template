<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Navigation_model extends My_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->table = "navigation";

        $this->rules = [
            'icon' => 'trim',
            'link' => 'trim|required',
            'type' => 'trim|required',
            'root' => 'trim|required'
        ];
        $this->change_value = ['type' => ['Root', 'Master', 'Singe']];
        $this->option_where = ['root' => ['type' => 0]];
    }

    public function sidebar()
    {
        $html = "";
        !empty($_SESSION['role']) ? $role = $_SESSION['role'] : $role = "";
        foreach ($this->navigation->gets(['type' => 1], [], ['urutan', 'ASC']) as $key => $value) {
            $header[$value->id] = '';
            $body[$value->id] = '';
            foreach ($this->navigation->gets(['root' => $value->id], [], ['name', 'ASC']) as $k => $val) {
                if (!empty($this->permissions->get(['role' => $role, 'navigation' => $val->id, 'r' => 1]))) {
                    $header[$val->root] = '<li class="nav-header">' . strtoupper($value->name) . '</li>';
                    $val->link == $this->data['path'] ? $active = 'active' : $active = "";
                    $body[$val->root] .= '<li class="nav-item">';
                    $body[$val->root] .= '<a href="' . base_url() . $val->link . '" class="nav-link ' . $active . '"><i class="nav-icon ' . $val->icon . '"></i><p>' . $val->name . '</p></a>';
                    $body[$val->root] .= '</li>';
                }
            }
            $html .= $header[$value->id] . $body[$value->id];
        }

        return $html;
    }
}
