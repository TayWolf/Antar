<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudBitacora extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("bitacora");
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 0)))
        {
            die($this->load->view("viewErrorPermiso", null, true));

        }
    }
    public function index()
    {
        $data['Ei'] = $this->bitacora->getDatosEi();
        $data['User'] = $this->bitacora->getDatosUser();
        $data['modu'] = $this->bitacora->getDatosModulo();
        print $string = $this->load->view('viewBitacora',$data, TRUE);

    }

    function getUsuarios($idEmpreInterna)
    {
        echo json_encode($this->bitacora->cargarEmpresasUsuario($idEmpreInterna));
    }

    function getModulos($idUser)
    {
        echo json_encode($this->bitacora->cargarmodulosUser($idUser));
    }

}