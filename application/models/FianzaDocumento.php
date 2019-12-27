<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FianzaDocumento extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
	function getDocumento($idDocumento)
	{
		$this->db->select("*");
		$this->db->from("FianzaDocumento");
		$this->db->where("idFianzaDocumento", $idDocumento);
		return $this->db->get()->row_array();
	}
	
	function getDatosBitacora($idDocumento)
	{
		$this->db->select("proyecto.idProyecto, proyecto.nombreProyecto, contratoProyecto.idContratoProyecto, contratoProyecto.nomenclatura, Fianzas.idFianza, CatalogoFianzas.nombre, FianzaDocumento.idFianzaDocumento, FianzaDocumento.nombreDocumento");
		$this->db->from("proyecto");
		$this->db->join("contratoProyecto", "proyecto.idProyecto=contratoProyecto.idProyecto");
		$this->db->join("Fianzas", "contratoProyecto.idContratoProyecto=Fianzas.idContratoProyecto");
		$this->db->join("CatalogoFianzas", "Fianzas.idCatalogoFianza=CatalogoFianzas.idCatalogoFianza");
		$this->db->join("FianzaDocumento", "FianzaDocumento.idFianza=Fianzas.idFianza");
		$this->db->where("FianzaDocumento.idFianzaDocumento", $idDocumento);
		return $this->db->get()->row_array();
	}
    
	function getAllDocumentos($idFianza)
    {
        $this->db->select("*");
        $this->db->from("FianzaDocumento");
        $this->db->where("idFianza", $idFianza);
        return $this->db->get()->result_array();
    }
    function insertarDocumento($data)
    {
        $this->db->insert('FianzaDocumento', $data);
    }
    function updateDocumento($id, $data)
    {
        $this->db->where('idFianzaDocumento', $id);
        $this->db->update("FianzaDocumento", $data);
    }
    function borrarDocumento($idDocumento)
    {
        $this->db->where('idFianzaDocumento', $idDocumento);
        $this->db->delete("FianzaDocumento");
    }
}