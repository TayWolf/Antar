<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function getDatos()
    {
        return $this->db->query("SELECT * FROM Empresa")->result_array();
    }
    function nuevaEmpresa($data)
    {
        $this->db->insert('Empresa', $data);
        return $this->db->insert_id();
    }
    function editarEmpresa($data, $id)
    {
        $this->db->where('idEmpresa', $id);
        $this->db->update('Empresa', $data);
    }
    function editarClienteDocumento($data, $id)
    {
        $this->db->where('idClienteDocumento', $id);
        $this->db->update('ClienteDocumento', $data);
    }
    function borrarEmpresa($id)
    {
        $this->db->where('idEmpresa', $id);
        $this->db->delete("Empresa");
    }
    
	function traerDocumentos($idEmpresa)
    {
        $this->db->select("*");
        $this->db->from("ClienteDocumento");
        $this->db->where("idCliente", $idEmpresa);
        return $this->db->get()->result_array();
    }
	
	
	function getUnDocumento($idDocumento)
	{
		$this->db->select("*");
        $this->db->from("ClienteDocumento");
        $this->db->where("ClienteDocumento.idClienteDocumento", $idDocumento);
        return $this->db->get()->row_array();
	}
	
	function getDatosBitacora($idDocumento)
	{
		$this->db->select("Empresa.idEmpresa, Empresa.nombre, ClienteDocumento.idClienteDocumento, ClienteDocumento.nombreDocumento");
		$this->db->from("Empresa");
		$this->db->join("ClienteDocumento", "Empresa.idEmpresa=ClienteDocumento.idCliente");
		$this->db->where("ClienteDocumento.idClienteDocumento", $idDocumento);
		return $this->db->get()->row_array();
	}
	
    function borrarArchivo($archivo)
    {
        $this->db->like("documento", $archivo);
        $this->db->delete('ClienteDocumento');
    }
    function insertDocumentoCliente($data)
    {
        $this->db->insert('ClienteDocumento', $data);
    }
    function getNombreDocumento($idClienteDocumento)
    {
        $this->db->select("documento");
        $this->db->from("ClienteDocumento");
        $this->db->where("idClienteDocumento", $idClienteDocumento);
        $nombre=$this->db->get()->row_array();
        return $nombre['documento'];
    }

}