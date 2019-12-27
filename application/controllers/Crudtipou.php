<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Crudtipou extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tipou');
        $this->load->library('session');
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 1)))
        {
            die($this->load->view("viewErrorPermiso", null, true));
        }
    }



    function index()
    {

        $data['infoTipo']=$this->tipou->getDatos();

        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 1);
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoTipou', $data, TRUE);

    }

    function altaTipo()
    {
        print $this->load->view('formTipo', '', TRUE);
    }

    function nuevoTipp()
    {
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required|min_length[3]|max_length[200]');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }

        $nombre=$this->input->post('nombre');



        $this->tipou->nuevotipoUser(array('nombreTipo' => $nombre));

    }

    function editarTipo()

    {

        $id=$this->input->post('id');

        if ($this->input->post('action') == 'edit')
        {
            $this->form_validation->set_rules('nombreTipo', 'nombre', 'trim|required|min_length[3]|max_length[200]');
            if($this->form_validation->run()==false)
            {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $nombre=$this->input->post('nombreTipo');
            $this->tipou->editartipoUser(array('nombreTipo' => $nombre), $id);

        }



    }

    function borrarTipo()

    {
        $this->form_validation->set_rules('id', 'id', 'trim|required|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $id=$this->input->post('id');

        $this->tipou->borrartipoUser($id);

        echo $id;

    }

}