<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_model extends CI_Model
{
    protected $table;
    public $column_search = ["name"];
    public $column_order = [];
    public $disable = [];
    public $add_field = [];
    public $button = ['edit' => 'primary', 'delete' => 'danger', 'create' => 'primary', 'permission' => 'warning'];
    public $method = [];
    public $rules = [];
    public $errorMessage = [];
    public $change_value = [];

    public function create($data)
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

    public function get($where = array(), $order = "")
    {
        if (empty($where)) {
            $where = array("status" => 0);
        }

        if (!empty($order)) {
            $this->db->order_by($order, 'DESC');
        }

        return $this->db->get_where($this->table . " m", $where)->row();
    }

    public function gets($where = "", $like = array(), $order = array(), $group = "")
    {
        if (empty($where)) {
            $where = array("m.status" => 0);
        }

        if (!empty($order)) {
            $this->db->order_by($order[0], $order[1]);
        }

        if (!empty($group)) {
            $this->db->group_by($group);
        }

        $this->db->like($like);
        $query = $this->db->get_where($this->table . " m", $where);
        return $query->result();
    }

    public function getLastId($code = "")
    {
        empty($code) ? $code = strtoupper(substr($this->table, 0, 2) . substr($this->table, -1, 1)) : $code;
        $rand_id = $this->generateRandomString(5);
        return $code . $rand_id . time();
    }

    public function get_field_original()
    {
        $allfield = $this->db->list_fields($this->table);
        $res = ['action'];
        $res = array_merge($allfield, $res);
        $disable = array_merge($this->disable, ["create_key", "create_date", "status"]);
        $res = array_reverse(array_reverse(array_diff($res, $disable)));

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

    public function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function changeColumnValue()
    {
    }

    public function actionButton($id)
    {
        $result = "";
        $method = array_merge(['edit', 'delete'], $this->method);
        $result .= '<div class="btn-group">';
        foreach ($method as $key => $value) {
            $result .= '<form action="http://localhost:8080/template/' . $this->table . '/' . $value . '" method="post" accept-charset="utf-8">';
            $result .= '<input type="hidden" name="id", id="id", value="' . $id . '">';
            $result .= '<button data-id="' . $id . '" class="mr-1 btn btn-' . $this->button[$value] . ' ' . $value . ' form-group">' . ucwords($value) . '</button>';
            $result .= '</form>';
        }
        $result .= '</div>';

        return $result;
    }

    public function validate_config($key)
    {
        !empty($this->rules[$key]) ? $result = $this->rules[$key] : $result = 'trim|required|min_length[4]|max_length[25]|alpha_numeric_spaces';
        return $result;
    }

    public function validate_error_message($key)
    {
        $result = $this->errorMessage[$key];

        return $result;
    }

    public function optionData()
    {
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

    public function create_form($error = array())
    {
        $result = "";
        $get_field_form = $this->master->get_field_original();
        $fields = $this->db->field_data($this->table);
        foreach ($fields as $key => $value) {
            if (in_array($value->name, $get_field_form) && $value->name !== 'id') {
                in_array($value->name, $error) ? $isError = 'is-invalid' : $isError = '';
                if ($check_character = explode('_', $value->name)) {
                    if ($value->name == 'password') {
                        $result .= '<div class="col">';
                        $result .= '<label>' . ucwords(implode(" ", $check_character)) . '</label>';
                        $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control ' . $isError . '" type="password" value="' . set_value($value->name) . '" required>';
                        $result .=  form_error($value->name, '<div class="error invalid-feedback">', '</div>');
                        $result .= '</div>';
                    } else {
                        if ($this->db->table_exists($value->name)) {
                            $name_role = $value->name;
                            $result .= '<div class="col">';
                            $result .= '<label>' . ucwords(implode(" ", $check_character)) . '</label>';
                            $result .= '<select class="form-select" id="' . $value->name . '" name="' . $value->name . '">';
                            $result .= '</select>';
                            $result .= '</div>';
                        } else {
                            $result .= '<div class="col">';
                            $result .= '<label>' . ucwords(implode(" ", $check_character)) . '</label>';
                            $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control ' . $isError . '" type="text" value="' . set_value($value->name) . '" required>';
                            $result .=  form_error($value->name, '<div class="error invalid-feedback">', '</div>');
                            $result .= '</div>';
                        }
                    }
                };
            }
        }

        return $result;
    }

    public function edit_form($id, $error = array())
    {
        $result = "";
        $sql = $this->master->get(['id' => $this->encrypt->decode($id)]);
        $get_field_form = $this->master->get_field_original();
        foreach ($sql as $key => $value) {
            if (in_array($key, $get_field_form)) {
                in_array($key, $error) ? $isError = 'is-invalid' : $isError = '';
                if ($key == "id") {
                    $result .= '<input type="hidden" name="id", id="id", value="' . $id . '">';
                } else {
                    $result .= '<div class="col">';
                    if ($key == 'password') {
                        !empty(set_value($key)) ? $value = set_value($key) : $value = $this->encrypt->decode($value, $sql->create_key);
                        $result .= '<label class="form-label">' . ucwords($key) . '</label>';
                        $result .= '<input id="' . $key . '" name="' . $key . '" class="form-control ' . $isError . '" type="password" value="' . $value . '" required>';
                        $result .=  form_error($key, '<div class="error invalid-feedback">', '</div>');
                    } else {
                        if ($this->db->table_exists($key)) {
                            $name_role = $key;
                            $result .= '<div class="col">';
                            $result .= '<label>' . ucwords(implode(" ", explode('_', $key))) . '</label>';
                            $result .= '<select class="form-select" id="' . $key . '" name="' . $key . '">';
                            $result .= '</select>';
                            $result .= '</div>';
                        } else {
                            if ($check_character = explode('_', $key)) {
                                !empty(set_value($key)) ? $value = set_value($key) : $value;
                                $result .= '<label  class="form-label">' . ucwords(implode(" ", $check_character)) . '</label>';
                                $result .= '<input id="' . $key . '" name="' . $key . '" class="form-control ' . $isError . '" type="text" value="' . $value . '" required>';
                                $result .=  form_error($key, '<div class="error invalid-feedback">', '</div>');
                            };
                        }
                    }
                    $result .= '</div>';
                }
            }
        }
        return $result;
    }
}
