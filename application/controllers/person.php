<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/CI_Template.php';
class Person extends CI_Template
{
    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME), 1);
        $this->options['set_data']['gender'] = ['Male', 'Female'];
    }
}
