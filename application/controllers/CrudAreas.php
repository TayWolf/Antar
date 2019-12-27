<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudAreas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Areas"); //cargamos el modelo
        $this->load->library('session');
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 2)))
        {
            die($this->load->view("viewErrorPermiso", null, true));
        }
    }

    public function index()
    {

        $data['areas'] = $this->Areas->getTodosAreas();
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'),2);
        $data = $this->security->xss_clean($data);
        $this->load->view('viewTodoAreas', $data);
    }
   
    function actualizarDatosArea()
    {
        $this->form_validation->set_rules('nombreArea', 'nombre del área', 'trim|required|max_length[200]|min_length[1]');
        $this->form_validation->set_rules('idArea', 'identificador', 'trim|required|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $arreglo = array(
            array('nombreArea' => $this->input->post('nombreArea'))
        );
        
        $idArea = $this->input->post('idArea');
        
        foreach ($arreglo as $item)
        {
            while($nombre_item = current($item))
            {
                if(!empty($nombre_item))
                {
                    $this->Areas->updateDatosArea($idArea, $item);
                    break;
                }
                next($item);
            }
        }
    }

    function eliminarDatosArea()
    {
        $this->form_validation->set_rules('idArea', 'identificador', 'trim|required|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $idArea = $this->input->post("idArea");
        $this->Areas->deleteDatosArea($idArea);
    }

    function altaNuevaArea()
    {
        $this->load->view('formAltaAreas');
    }

    function insertarNuevaArea()
    {
        $this->form_validation->set_rules('nombreArea', 'nombre del área', 'trim|required|max_length[200]|min_length[1]');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $data = array(
            "nombreArea" => $this->input->post("nombreArea")
        );
        $this->Areas->insertDatosArea($data);
    }

}


?>