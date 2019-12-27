<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tablero extends CI_Controller
{

	public function index()
	{
        $this->load->library('session');
        $idSesion=$this->session->userdata('iduser');
        if(!empty($idSesion))
        {
            $this->load->model("Permisos");
            $this->load->model("TableroModel");
            $totales['totalContratos']=$this->TableroModel->getTotalContratosPorVencer();
            $totales['totalFianzas']=$this->TableroModel->getTotalFianzasPorVencer();
            $data['permisos']=$this->Permisos->getPermisosUsuario($this->session->userdata('idTipo'));
            $totales= $this->security->xss_clean($totales);
            $this->load->view('header', $totales);
            $data = $this->security->xss_clean($data);
            $this->load->view('sidebar', $data);
            $this->load->view('tableroPrincipal');
            $this->load->view('footer');
        }
        else
            redirect(base_url(''));
    }
}
