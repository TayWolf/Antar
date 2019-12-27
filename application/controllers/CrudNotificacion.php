<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class CrudNotificacion extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Notificacion");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
    }

    function cargarNotificaciones()
    {
        print $this->load->view("viewNotificaciones", null, TRUE);
    }
    function verContratos($diasTolerancia=7)
    {
        $data['diasTolerancia']=$diasTolerancia;
        $data['verBtnEliminar']=0;
        $this->load->model("Proyectos");
        $this->load->model("Dashboard");
        $data['solicitudes'] = $this->Dashboard->getContratosVencimiento($diasTolerancia, null);
        $data['getPr'] = $this->Proyectos->getPr();
        $data['proyectoIndividual']=0;
        $data['posiblesEstados']=$this->Proyectos->getAllStatus();
        $this->load->model("Permisos");
        //permisos de contratos de proyecto
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 7);
        //permisos de fianzas
        $data['permisosFianzas']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 8);
        //permisos de versiones
        $data['permisosVersiones']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 10);
        //permisos de versiones
        $data['permisosStatusContrato']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 5);

        $data['idProyecto']=null;
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewtodosolicitudesVencimiento', $data, TRUE);

    }
    function verFianzas($diasTolerancia=7)
    {
        $idUsuario=$this->session->userdata("iduser");
        $this->load->model("Proyectos");
        $this->load->model("Dashboard");
        $this->load->model("Permisos");
        $data['verBtnEliminar']=false;
        $data['general']=true;
        $data['diasTolerancia']=$diasTolerancia;
        //variable que sirve para especificar que no se requiere un idContratoProyecto
        $data['sinContratoProyecto']="0";
        $fechaHoy=date("Y-m-d");
        $data['fianzasContratos'] = $this->Notificacion->getFianzasContratosVencimiento($diasTolerancia, $fechaHoy, $idUsuario);
        $data['fianzaIndividual']=0;
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 8);
        $data['permisosDocumentosFianza']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 9);
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoFianzasContratoVencimiento', $data, TRUE);

    }
}