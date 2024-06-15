<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_model extends CI_Model
{
    protected $table;
    public $column_search = ["name"];
    public $column_order = [];
    public $disable = [];

    public function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function edit($data, $where)
    {
        return $this->db->update($this->table, $data, $where);
    }

    public function delete($where, $delete_db = 1)
    {
        if (empty($delete_db)) {
            return $this->db->update($this->table, ['status' => 1], $where);
        } else {
            return $this->db->delete($this->table, $where);
        }
    }

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

    function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getLastId($code = "")
    {
        empty($code) ? $code = strtoupper(substr($this->table, 0, 2) . substr($this->table, -1, 1)) : $code;
        $rand_id = $this->generateRandomString(5);
        return $code . $rand_id . time();
    }


    public function get_field_original($param = array())
    {
        $allfield = $this->db->list_fields($this->table);
        $res = ['action'];
        $res = array_merge($allfield, $res);
        $disable = array_merge($this->disable, ["password", "create_key", "create_date", "status"]);
        $res = array_reverse(array_reverse(array_diff($res, $disable)));
        $res = array_merge($param, $res);
        return $res;
    }

    public function getHeaderName()
    {
        $TableHeader = "<thead><tr>";
        $fieldName = $this->get_field_original();
        foreach ($fieldName as $key => $value) {
            if ($check_character = explode('_', $value)) {
                $TableHeader .= "<th>" . ucwords(implode(" ", $check_character)) . "</th>";
            }
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

    public function actionButton($id)
    {
        $result = "";
        $array = ['edit' => 'primary', 'delete' => 'danger'];
        foreach ($array as $key => $value) {
            $result .= '<button data-id="' . $id . '" class="mt-1 btn btn-' . $value . ' btn_' . $key . ' form-control">' . ucfirst($key) . '</button>';
        }
        return $result;
    }

    public function add_form($enable_add = array())
    {
        $result = "";
        $get_field_form = $this->master->get_field_original($enable_add);
        $fields = $this->db->field_data($this->table);
        foreach ($fields as $key => $value) {
            if (in_array($value->name, $get_field_form) && $value->name !== 'id') {
                if ($check_character = explode('_', $value->name)) {
                    $result .= '<label>' . ucwords(implode(" ", $check_character)) . '</label>';
                    $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control" type="text" required>';
                    $result .= '<div class="invalid-feedback ' . $value->name . '"></div>';
                };
            }
        }

        return $result;
    }

    public function edit_form($id, $enable_edit = array())
    {
        $result = "";
        $sql = $this->master->get(['id' => $this->encrypt->decode($id)]);
        $get_field_form = $this->master->get_field_original($enable_edit);
        foreach ($sql as $key => $value) {
            if (in_array($key, $get_field_form)) {
                if ($key == "id") {
                    $result .= '<input type="hidden" name="id", id="id", value="' . $id . '">';
                } else {
                    $result .= '<label>' . ucfirst($key) . '</label>';
                    if ($key == 'password') {
                        $result .= '<input id="' . $key . '" name="' . $key . '" class="form-control" type="password" value="defaultpassword">';
                    } else {
                        $result .= '<input id="' . $key . '" name="' . $key . '" class="form-control" type="text" value="' . $value . '">';
                    }
                }
            }
        }
        return $result;
    }

    public function hash_password($password)
    {
        $timeTarget = 0.350;
        $cost = 10;
        do {
            $cost++;
            $start = microtime(true);
            $result = password_hash($password, PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        return $result;
    }
}
