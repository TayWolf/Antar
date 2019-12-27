<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class CrudPermisos extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }

    }
    function verPermisos($idTipoUsuario)
    {
        $data['idTipo']=$idTipoUsuario;
        $data['nombreTipoUsuario']=$this->Permisos->getNombreTipoUsuario($idTipoUsuario);
        $data = $this->security->xss_clean($data);
        print $this->load->view("viewPermisosUsuario", $data, TRUE);
    }
    function asignarPermiso($idTipoUsuario, $permiso, $campo, $idModulo)
    {
        $this->validarExistencia($idTipoUsuario, $idModulo);
        $this->Permisos->actualizarPermiso($idTipoUsuario, $idModulo, array($campo => $permiso));
        echo json_encode($permiso);
    }
    function validarExistencia($idTipoUsuario,$idModulo)
    {
        $this->Permisos->validacionExistencia($idTipoUsuario, $idModulo);
    }
    function getPermisosUsuario($idTipoUsuario)
    {
        echo json_encode($this->Permisos->getPermisosUsuario($idTipoUsuario));
    }
}