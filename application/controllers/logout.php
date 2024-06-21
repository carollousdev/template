<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/CI_Template.php';
class logout extends CI_Controller
{
    public function index()
    {
        session_destroy();
        redirect('login');
    }
}
