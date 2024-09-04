<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Format_model extends CI_Model
{

    public function log($name, $path)
    {
        $date = date("D, d-m-y");
        $time = date("h:i:s A");

        file_exists("logs/" . $date . ".txt") == 1 ? $mode = "a" : $mode = "wb";
        $myfile = fopen("logs/" . $date . ".txt", $mode) or die("Unable to open file!");

        file_exists("logs/" . $date . ".txt") == 1 ?
            $count = count(explode('~', file_get_contents("logs/" . $date . ".txt"))) :
            $count = 1;

        $content = "[" . $count . "] " . ucfirst($this->user->get(['username' => $_SESSION['username']])->name) . " has created " . $name . " in " . $path . " | " . $date . " " . $time . " ~" . "\n";

        fwrite($myfile, $content);
        fclose($myfile);
    }
}
