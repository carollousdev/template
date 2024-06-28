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
            'icon' => 'trim|required',
            'link' => 'trim|required',
            'type' => 'trim|required'
        ];
    }

    public function sidebar()
    {
        $html = "";
        foreach ($this->navigation->gets(['type' => 1]) as $key => $value) {
            $html .= '<li class="nav-header">' . strtoupper($value->name) . '</li>';
            foreach ($this->navigation->gets(['root' => $value->id], [], ['name', 'ASC']) as $k => $val) {
                $val->link == $this->data['path'] ? $active = 'active' : $active = "";
                $html .= '<li class="nav-item">';
                $html .= '<a href="' . base_url() . $val->link . '" class="nav-link ' . $active . '"><i class="nav-icon ' . $val->icon . '"></i><p>' . $val->name . '</p></a>';
                $html .= '</li>';
            }
        }

        return $html;
    }
}
