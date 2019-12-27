<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contratos extends CI_Controller
{
    public function index()

    {

        $string = $this->load->view('viewTodoContratos', '', TRUE);

        print $string;

    }

}