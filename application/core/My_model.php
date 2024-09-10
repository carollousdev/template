    <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class My_model extends CI_Model
    {
        protected $table;
        public $column_search = ["name"];
        public $column_order = ['name'];
        public $disable = [];
        public $add_field = [];
        public $button = ['edit' => 'primary', 'delete' => 'danger', 'create' => 'primary', 'permission' => 'warning'];
        public $method = [];
        public $rules = [];
        public $errorMessage = [];
        public $change_value = [];
        public $option_where = [];

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
                $this->db->order_by($order, 'ASC');
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

        public function get_field_form()
        {
            $allfield = $this->db->list_fields($this->table);
            $disable = array_merge($this->disable, ["id", "create_key", "create_date", "status"]);
            $res = array_reverse(array_reverse(array_diff($allfield, $disable)));
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

        public function getOption($id, $name, $checkValidation = "", $key_id = "", $data = array(), $type = null, $selected = "")
        {
            $result = "";
            $result .= '<select class="form-select select2 ' . $checkValidation . '" id="' . $id . '" name="' . $name . '">';
            $call_option = true;

            if (!empty($this->option_where[$name]) && !empty($key_id)) {
                $sql = $this->master->get(['id' => $this->encrypt->decode($key_id)]);
                foreach ($this->option_where[$name] as $key => $value) {
                    if ($sql->$key != $value) {
                        $call_option = false;
                    } else $call_option = true;
                }
            }

            if ($call_option == true) {
                if ($type == 0) {
                    foreach ($data as $key => $value) {
                        $value->id == $selected ? $select = "selected" : $select = "";
                        $result .= '<option value="' . $value->id . '" ' . $select . '>' . $value->name . '</option>';
                    }
                }
                if ($type == 1) {
                    foreach ($data as $key => $value) {
                        $key == $selected ? $select = "selected" : $select = "";
                        $result .= '<option value="' . $key . '" ' . $select . '>' . $value . '</option>';
                    }
                }
                if ($type == 2) {
                    foreach ($data as $key => $value) {
                        $value['id'] == $selected ? $select = "selected" : $select = "";
                        $result .= '<option value="' . $value['id'] . '" ' . $select . '>' . $value['text'] . '</option>';
                    }
                }
            }

            $result .= '</select>';
            return $result;
        }

        public function change_option($data = array(), $setNull = null)
        {
            $array = array();
            $result = array();

            if (empty($setNull)) {
                foreach ($data as $key => $value) {
                    $array['id'] = $value->id;
                    $array['text'] = $value->name;
                    array_push($result, $array);
                }
            }
            return $result;
        }

        public function change_options($table, $value = "")
        {
            if (!empty($this->$table->get(['id' => $value]))) {
                return $this->$table->get(['id' => $value])->name;
            } else return "-";
        }

        public function actionButton($id)
        {
            $result = "";
            $method = array_merge(['edit', 'delete'], $this->method);
            $button = '';
            $i = 0;
            foreach ($method as $key => $value) {
                if (!empty($this->data[$value . '_permission'])) {
                    $button .= '<form action="http://localhost:8080/template/' . $this->table . '/' . $value . '" method="post" accept-charset="utf-8">';
                    $button .= '<input type="hidden" name="id", id="id", value="' . $id . '">';
                    $button .= '<button data-id="' . $id . '" class="btn btn-block btn-' . $this->button[$value] . ' ' . $value . ' form-group">' . ucwords($value) . '</button>';
                    $button .= '</form>';
                    $i++;
                }
            }
            $i > 1 ? $x = 'btn-group' : $x = '';
            $result = '<div class="' . $x . '">' . $button . '</div>';

            return $result;
        }

        public function validate_config($key)
        {
            if ($key == 'name') {
                $result = 'required|is_unique[' . $this->table . '.name]';
            } else {
                !empty($this->rules[$key]) ? $result = $this->rules[$key] : $result = 'required';
            }
            return $result;
        }

        public function validate_error_message($key)
        {
            $result = $this->errorMessage[$key];

            return $result;
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
                    foreach ($this->column_order as $key => $value) {
                        $this->db->order_by($value, $_POST['order']['0']['dir']);
                    }
                } else {
                    $this->db->order_by($order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
                }
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

        public function create_form($error = array(), $option = array())
        {
            $result = "";
            $get_field_form = $this->master->get_field_form();
            $fields = $this->db->field_data($this->table);
            $col = $this->form->col($get_field_form);

            foreach ($fields as $key => $value) {
                if (in_array($value->name, $get_field_form) && $value->name !== 'id') {
                    in_array($value->name, $error) ? $isError = 'is-invalid' : $isError = '';
                    if ($check_character = explode('_', $value->name)) {
                        $result .= '<div class="' . $col . ' form-group">';
                        $result .= '<label>' . ucwords(implode(" ", $check_character)) . '</label>';
                        if ($value->type == 'text' && $value->name !== 'password') {
                            $result .= '<textarea class="form-control" id="' . $value->name . '" name="' . $value->name . '" rows="2" cols="50"></textarea>';
                        } else if ($value->type == 'date') {
                            $result .= '<input type="date" class="form-control" id="' . $value->name . '" name="' . $value->name . '">';
                        } else if ($value->name == 'password') {
                            $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control ' . $isError . '" type="password" value="' . set_value($value->name) . '" required>';
                            $result .=  form_error($value->name, '<div class="error invalid-feedback">', '</div>');
                        } else if ($this->db->table_exists($value->name)) {
                            $field = $value->name;
                            $array = $this->$field->gets();
                            $result .= $this->master->getOption($value->name, $value->name, $isError, "", $array);
                            $result .=  form_error($value->name, '<div class="error">', '</div>');
                        } else if (!empty($option['set_data'][$value->name])) {
                            $result .= $this->master->getOption($value->name, $value->name, $isError, "", $option['set_data'][$value->name], 1);
                            $result .=  form_error($value->name, '<div class="error">', '</div>');
                        } else if (!empty($option[$value->name])) {
                            $option_array =  $this->master->change_option($this->master->gets($option[$value->name][1], $option[$value->name][2]));
                            $result .= $this->master->getOption($value->name, $value->name, $isError, "", $option_array, 2);
                            $result .=  form_error($value->name, '<div class="error">', '</div>');
                        } else if ($value->name == 'email') {
                            $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control ' . $isError . '" type="email" value="' . set_value($value->name) . '" required>';
                            $result .=  form_error($value->name, '<div class="error invalid-feedback">', '</div>');
                        } else if ($value->type == 'int') {
                            $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control ' . $isError . '" type="number" value="' . set_value($value->name) . '">';
                            $result .=  form_error($value->name, '<div class="error invalid-feedback">', '</div>');
                        } else {
                            $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control ' . $isError . '" type="text" value="' . set_value($value->name) . '">';
                            $result .=  form_error($value->name, '<div class="error invalid-feedback">', '</div>');
                        }
                        $result .= '</div>';
                    }
                }
            }

            return $result;
        }

        public function edit_form($id, $error = array(), $option = array())
        {
            $result = "";
            $get_field_form = $this->master->get_field_form();
            $fields = $this->db->field_data($this->table);
            if (count($get_field_form) == 5) {
                $col = 'col-2';
            } else if (count($fields) % 4 == 0) {
                $col = 'col-3';
            } else if (count($fields) % 3  == 0) {
                $col = 'col-4';
            } else $col = 'col-6';

            $sql = $this->master->get(['id' => $this->encrypt->decode($id)]);
            foreach ($fields as $key => $value) {
                $name = $value->name;
                if (in_array($value->name, $get_field_form) && $value->name !== 'id') {
                    in_array($value->name, $error) ? $isError = 'is-invalid' : $isError = '';
                    if ($check_character = explode('_', $value->name)) {
                        $result .= '<input type="hidden" name="id", id="id", value="' . $id . '">';
                        $result .= '<div class="' . $col . ' form-group">';
                        $result .= '<label>' . ucwords(implode(" ", $check_character)) . '</label>';
                        if ($value->type == 'text' && $value->name !== 'password') {
                            !empty(set_value($name)) ? $valuekey = set_value($name) : $valuekey = $sql->$name;
                            $result .= '<textarea class="form-control" id="' . $value->name . '" name="' . $value->name . '" rows="2" cols="50">' . $valuekey . '</textarea>';
                        } else if ($value->type == 'date') {
                            !empty(set_value($name)) ? $valuekey = set_value($name) : $valuekey = $sql->$name;
                            $result .= '<input type="date" class="form-control" id="' . $value->name . '" name="' . $value->name . '" value="' . $sql->$name . '">';
                        } else if ($value->name == 'password') {
                            !empty(set_value($name)) ? $valuekey = set_value($name) : $valuekey = $this->encrypt->decode($sql->password, $sql->create_key);
                            $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control ' . $isError . '" type="password" value="' . $valuekey . '" required>';
                            $result .=  form_error($value->name, '<div class="error invalid-feedback">', '</div>');
                        } else if ($this->db->table_exists($value->name)) {
                            !empty(set_value($name)) ? $valuekey = set_value($name) : $valuekey = $sql->$name;
                            $array = $this->$name->gets();
                            $result .= $this->master->getOption($value->name, $value->name, $isError, "", $array, 0, $valuekey);
                            $result .=  form_error($value->name, '<div class="error">', '</div>');
                        } else if (!empty($option['set_data'][$value->name])) {
                            !empty(set_value($name)) ? $valuekey = set_value($name) : $valuekey = $sql->$name;
                            $result .= $this->master->getOption($value->name, $value->name, $isError, "", $option['set_data'][$value->name], 1, $valuekey);
                            $result .=  form_error($value->name, '<div class="error">', '</div>');
                        } else if (!empty($option[$value->name])) {
                            !empty(set_value($name)) ? $valuekey = set_value($name) : $valuekey = $sql->$name;
                            $option_array =  $this->master->change_option($this->master->gets($option[$value->name][1], $option[$value->name][2]));
                            $result .= $this->master->getOption($value->name, $value->name, $isError, "", $option_array, 2, $valuekey);
                            $result .=  form_error($value->name, '<div class="error">', '</div>');
                        } else if ($value->name == 'email') {
                            !empty(set_value($name)) ? $valuekey = set_value($name) : $valuekey = $sql->$name;
                            $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control ' . $isError . '" type="email" value="' . $valuekey . '" required>';
                            $result .=  form_error($value->name, '<div class="error invalid-feedback">', '</div>');
                        } else if ($value->type == 'int') {
                            !empty(set_value($name)) ? $valuekey = set_value($name) : $valuekey = $sql->$name;
                            $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control ' . $isError . '" type="int" value="' . $valuekey . '">';
                            $result .=  form_error($value->name, '<div class="error invalid-feedback">', '</div>');
                        } else {
                            !empty(set_value($name)) ? $valuekey = set_value($name) : $valuekey = $sql->$name;
                            $result .= '<input id="' . $value->name . '" name="' . $value->name . '" class="form-control ' . $isError . '" type="text" value="' . $valuekey . '">';
                            $result .=  form_error($value->name, '<div class="error invalid-feedback">', '</div>');
                        }
                        $result .= '</div>';
                    }
                }
            }

            return $result;
        }
    }
