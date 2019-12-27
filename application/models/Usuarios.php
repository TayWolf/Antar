<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Model{

    function __construct(){
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function login($userName,$password)
    {
        $cero=0;
        $this->load->library('encryption');
        $this->db->select('*');
        $this->db->from('Usuarios');
        $this->db->where('nickName', $userName);
        $this->db->where('Status', $cero);


        $query = $this -> db -> get();
        if($query -> num_rows() >= 1)
        {
            $datos = $query->row_array();
            $passDecrypt=$this->encryption->decrypt($datos['passwordUser']);
            if($passDecrypt)
            {
                if ($passDecrypt==$password) {
                    return $query->row();
                }
                else{
                    return false;
                }
            }
            else return false;

        }
        else
        {
            return false;
        }
    }

    function getDatos()
    {

        return $this->db->query("SELECT Usuarios.*,tipoUser.nombreTipo,area.nombreArea FROM `Usuarios` JOIN tipoUser on tipoUser.idTipo=Usuarios.idTipo join area on area.idArea=Usuarios.idArea")->result_array();
    }
    function getDatosUsuario($idUsuario)
    {
        $this->db->select("Usuarios.*");
        $this->db->from("Usuarios");
        $this->db->where("Usuarios.idUser", $idUsuario);
        return $this->db->get()->row_array();
    }
	
	function getIdUser()
    {
        return $this->db->query("SELECT idUser from Usuarios")->result_array();
	}

    function getAreaUs()
    {
        return $this->db->query("SELECT * from area")->result_array();
    }
    function getTipa()
    {
        return $this->db->query("SELECT * from tipoUser")->result_array();
    }

    function insertaDatos($data)
    {
        $this->db->insert('Usuarios', $data);
        //echo json_encode($data);altaUser
    }


    function modificaDatos($data,$idUser)
    {
        $this->db->where('idUser', $idUser);
        $this->db->update('Usuarios', $data);

    }

    function borrarDatos($id)
    {
        $this->db->where('idUser', $id);
        $this->db->delete('Usuarios');


    }
	
    function cargarEmpresasUsuario($idUsuario)
    {
        return $this->db->get_where("UsuarioEmpresa", array('idUsuario' => $idUsuario))->result_array();
    }
    function getEmpresasInternas()
    {
        return $this->db->get("empresainterna")->result_array();
    }
    function borrarEmpresaUsuario($idEmpresa, $idUsuario)
    {
        $this->db->where("idEmpresaInterna", $idEmpresa);
        $this->db->where("idUsuario", $idUsuario);
        $this->db->delete("UsuarioEmpresa");
    }
    function asignarEmpresaUsuario($data)
    {
        $this->db->insert("UsuarioEmpresa", $data);
    }
    function getTiposContrato()
    {
        return $this->db->get("tipoContrato")->result_array();
    }
	function getDocumentosUsuarios($id)
    {
        return $this->db->get_where("DocumentosUsuario", array('idUser' => $id))->result_array();
	}
	function getDocumento($idDocumento,$idUser)
	{
		return $this->db->get_where("DocumentosUsuario", array('idUser' => $idUser, 'idDocumentoUser' => $idDocumento))->row_array();
	}
	function insertDocumentoUsuario($data)
    {
        $this->db->insert('DocumentosUsuario', $data);
    }
	
	function modificaDocumentoUsuarios($idDocumento,$data)
    {
        $this->db->where('idDocumentoUser', $idDocumento);
		$this->db->update('DocumentosUsuario', $data);

    }
	
	function borrarArchivo($archivo)
    {
        $this->db->like("documento", $archivo, "before");
        $this->db->delete('DocumentosUsuario');
		
    }

// Se crearon las funciones para el tipo de contrato de la tabla usuarioTipoContrato

    function cargarTiposContrato($idUsuario)
    {
        return $this->db->get_where("UsuarioTipoContrato", array('idUsuario' => $idUsuario))->result_array();
    }
    function borrarTiposContrato($idTipoContrato, $idUsuario)
    {
        $this->db->where("idTipoContrato", $idTipoContrato);
        $this->db->where("idUsuario", $idUsuario);
        $this->db->delete("UsuarioTipoContrato");
    }
    function asignarTiposContrato($data)
    {
        $this->db->insert("UsuarioTipoContrato", $data);
    }

}