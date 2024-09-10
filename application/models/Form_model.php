<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form_model extends CI_Model
{

    public function col($count)
    {
        if (count($count) == 5)
            $col = 'col-2';
        else if (count($count) % 2 == 0)
            $col = 'col-6';
        else if (count($count) % 3 == 0)
            $col = 'col-4';
        else $col = 'col-6';

        return $col;
    }
}
