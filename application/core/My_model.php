<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_model extends CI_Model
{
    protected $table;

    public function get($where = "", $order = "")
    {
        if (empty($where)) {
            $where = array("status" => 0);
        }

        if (!empty($order)) {
            $this->db->order_by($order, 'DESC');
        }

        return $this->db->get_where($this->table . " m", $where)->row();
    }

    public function get_field_original()
    {
        $allfield = $this->db->list_fields($this->table);
        return $allfield;
    }
}
