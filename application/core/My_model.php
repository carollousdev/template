<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_model extends CI_Model
{
    protected $table;
    public $column_search = ["name"];
    public $column_order = [];

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

    public function getHeaderName()
    {
        $TableHeader = "<thead><tr>";
        $fieldName = $this->get_field_original();
        foreach ($fieldName as $key => $value) {
            $TableHeader .= "<th>" . ucwords($value) . "</th>";
        }
        $TableHeader .= "</tr></thead>";
        return $TableHeader;
    }

    private function _get_data_query()
    {
        $this->db->from($this->table);
        if (isset($_POST['search']['value'])) {
            foreach ($this->column_search as $key => $value) {
                if ($key == 0) {
                    $this->db->like($value, $_POST['search']['value']);
                } else {
                    $this->db->or_like($value, $_POST['search']['value']);
                }
            }
        }

        $fieldName = $this->get_field_original();
        foreach ($fieldName as $key => $value) {
            $order[] = $value;
        }

        if (isset($_POST['order']) && !empty($order[$_POST['order']['0']['column']])) {
            if (!empty($this->column_order)) {
                foreach ($this->column_order as $value) {
                    if ($order[$_POST['order']['0']['column']] == $value) {
                        $this->db->order_by($value, $_POST['order']['0']['dir']);
                    }
                }
            } else {
                $this->db->order_by($order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }
        } else {
            $this->db->order_by('name', 'ASC');
        }
    }

    public function getDataTable()
    {
        $this->_get_data_query();
        if ($_POST['length'] !== -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function Count_filtered_data()
    {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
