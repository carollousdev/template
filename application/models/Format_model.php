<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Format_model extends CI_Model
{

    public function log($name = "", $path, $method, $id = null, $data = array())
    {
        $date = date("D, d-m-y");
        $time = date("h:i:s A");
        $user = ucfirst($this->user->get(['username' => $_SESSION['username']])->name);
        $this->load->model($path . "_model", $path);
        $x = " ";
        $y = " | ";
        $z = " ~ ";
        $n = 0;
        $q = ".";

        file_exists("logs/" . $date . ".txt") == 1 ? $mode = "a" : $mode = "wb";
        $myfile = fopen("logs/" . $date . ".txt", $mode) or die("Unable to open file!");

        file_exists("logs/" . $date . ".txt") == 1 ?
            $count = count(explode('~', file_get_contents("logs/" . $date . ".txt"))) :
            $count = 1;

        if ($id == null) {
            $content = "[" . $count . "] " . ucfirst($method) . $x . $name . $x . "of " . ucfirst($path) . $y . $user . $y . $date . $x . $time . $x . $z . "\n";
        } else {
            $query =  $this->$path->get(['id' => $this->encrypt->decode($id), 'status' => 0]);
            if ($method == 'edit') {
                $content = "[" . $count . "] " . ucfirst($method) . $x;
                foreach ($data as $key => $value) {
                    if ($value !== $query->$key && $key !== 'id') {
                        $content .= $query->$key . $x . "change to" . $x . $value . $x;
                    }
                }
                $content .= "of " . ucfirst($path) . $y . $user . $y . $date . $x . $time . $x . $z . "\n";
            } else $content = "[" . $count . "] " . ucfirst($method) . $x . $query->name . $x . "of " . ucfirst($path) . $y . $user . $y . $date . $x . $time . $x . $z . "\n";
        }

        fwrite($myfile, $content);
        fclose($myfile);

        if (!empty($content)) return true;
        else return false;
    }
}
