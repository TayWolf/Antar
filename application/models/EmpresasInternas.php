<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpresasInternas extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function getEmpresasInternas()
    {
        return $this->db->query("SELECT * FROM empresainterna")->result_array();
    }

    function insertEmpresa($data)
    {
        $this->db->insert("empresainterna", $data);
    }

    function editarEmpresa($data, $id)
    {
        $this->db->where("idEmpresaInterna", $id);
        $this->db->update("empresainterna", $data);
    }
    function eliminarEmpresa($id)
    {
        $this->db->where("idEmpresaInterna", $id);
        $this->db->delete("empresainterna");
    }
    function getNombreEmpresaInterna($id)
    {
        $this->db->select("nombreEmpresa");
        $name=$this->db->get_where("empresainterna", array('idEmpresaInterna' => $id))->row_array();
        return $name['nombreEmpresa'];
    }
    function getDocumentosEmpresaInterna($id)
    {
        return $this->db->get_where("DocumentoEmpresaInterna", array('idEmpresaInterna' => $id))->result_array();
    }
	
	function getUnDocumentoEmpresaInterna($idDocumento)
	{
		$this->db->select("*");
        $this->db->from("DocumentoEmpresaInterna");
        $this->db->where("idDocumentoEmpresa", $idDocumento);
        return $this->db->get()->row_array();
	}
	
	function getDatosBitacora($idDocumento)
	{
		$this->db->select("empresainterna.idEmpresaInterna, empresainterna.nombreEmpresa, DocumentoEmpresaInterna.idDocumentoEmpresa, DocumentoEmpresaInterna.nombreDocumento");
		$this->db->from("empresainterna");
		$this->db->join("DocumentoEmpresaInterna", "empresainterna.idEmpresaInterna=DocumentoEmpresaInterna.idEmpresaInterna");
		$this->db->where("DocumentoEmpresaInterna.idDocumentoEmpresa", $idDocumento);
		return $this->db->get()->row_array();
	}
	
    function obtenerDatosDocumento($idDocumento)
    {
        return $this->db->get_where("DocumentoEmpresaInterna", array('idDocumentoEmpresa' => $idDocumento))->row_array();
    }
    function insertDocumentoEmpresa($data)
    {
        $this->db->insert("DocumentoEmpresaInterna", $data);
    }
    function borrarDocumento($id)
    {
        $this->db->where("idDocumentoEmpresa", $id);
        $this->db->delete("DocumentoEmpresaInterna");
    }
    function updateDocumentoEmpresa($data, $id)
    {
        $this->db->where("idDocumentoEmpresa", $id);
        $this->db->update("DocumentoEmpresaInterna", $data);
    }
    function obtenerNombreDocumento($id)
    {
        $this->db->select("documento");
        $name=$this->db->get_where("DocumentoEmpresaInterna", array('idDocumentoEmpresa' => $id))->row_array();
        return $name['documento'];
    }


}