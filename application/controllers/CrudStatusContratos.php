<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudStatusContratos extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('StatusContratos');
        $this->load->library('session');
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 5)))
        {
            die($this->load->view("viewErrorPermiso", null, true));

        }
    }

    function index()
    {

        $data['status']=$this->StatusContratos->getAllStatus();
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'),5);
        $data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoStatusContratos", $data, TRUE);
    }

    function nuevoStatus()
    {

        print $this->load->view("formAltaStatusContratos", null, TRUE);

    }

    function insertarNuevoStatus()
    {

        $this->form_validation->set_rules('clase', 'color', 'required|max_length[100]');
        $this->form_validation->set_rules('etiqueta', 'etiqueta', 'trim|required|min_length[3]|max_length[150]');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $nuevo=array('clase' =>  $this->input->post('clase'),

            'etiqueta' => $this->input->post('etiqueta'));

        $this->StatusContratos->insertarStatus($nuevo);

    }

    function editarStatus($idStatus)

    {

        $data['status']=$this->StatusContratos->getStatus($idStatus);
        $data = $this->security->xss_clean($data);
        print $this->load->view("formEditarStatusContratos", $data, TRUE);

    }

    function editarDatosStatus()

    {
        $this->form_validation->set_rules('clase', 'color', 'required|max_length[100]');
        $this->form_validation->set_rules('etiqueta', 'etiqueta', 'trim|required|min_length[3]|max_length[150]');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $array=array('clase' => $this->input->post('clase'), 'etiqueta' => $this->input->post('etiqueta'));

        $this->StatusContratos->editarStatusContrato($this->input->post('idStatus'), $array);

    }

    function eliminarDatosStatus()
    {
        $this->form_validation->set_rules('idStatusContrato', 'identificador', 'required|numeric|trim');

        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $this->StatusContratos->eliminarStatusContrato($this->input->post("idStatusContrato"));

    }
    function ordenarStatus()
    {
        $arreglo=$this->input->post("arreglo");
        for($i=0; $i<sizeof($arreglo); $i++)
        {
            $idStatusContrato=$arreglo[$i];
            $this->StatusContratos->editarStatusContrato($idStatusContrato, array("orden" => $i));
        }
        echo json_encode($this->StatusContratos->getAllStatus());
    }


}