<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Format_model extends CI_Model
{

    public function log($name, $path, $method)
    {
        $date = date("D, d-m-y");
        $time = date("h:i:s A");
        $user = ucfirst($this->user->get(['username' => $_SESSION['username']])->name);
        $x = " ";
        $y = " | ";
        $z = " ~ ";

        file_exists("logs/" . $date . ".txt") == 1 ? $mode = "a" : $mode = "wb";
        $myfile = fopen("logs/" . $date . ".txt", $mode) or die("Unable to open file!");

        file_exists("logs/" . $date . ".txt") == 1 ?
            $count = count(explode('~', file_get_contents("logs/" . $date . ".txt"))) :
            $count = 1;

        $content = "[" . $count . "] " . ucfirst($method) . $x . $name . $x . "of " . ucfirst($path) . $y . $user . $y . $date . $x . $time . $x . $z . "\n";

        fwrite($myfile, $content);
        fclose($myfile);
    }
}
