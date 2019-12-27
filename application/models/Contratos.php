<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contratos extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function getDatos()
    {

        return $this->db->query("SELECT * FROM Contrato")->result_array();

    }


    function getNombreCt($idTipoco)
    {
        $this->db->select("*");
        $this->db->from("tipoContrato");
        $this->db->where("idTipoC", $idTipoco);
        return $this->db->get()->result_array();

    }

    function getTipoContrato($idTipoContrato)
    {
        $this->db->select("tipoContrato.*, Contrato.nombre");
        $this->db->from("tipoContrato");
        $this->db->join("Contrato", "Contrato.idContrato=tipoContrato.idContrato");
        $this->db->where("tipoContrato.idTipoC", $idTipoContrato);
        return $this->db->get()->row_array();

    }

    function getTiposContratos($idContr)
    {
        $this->db->select("tipoContrato.*,Contrato.nombre");
        $this->db->from("tipoContrato");
        $this->db->join("Contrato", "Contrato.idContrato=tipoContrato.idContrato");
        $this->db->where("tipoContrato.idContrato", $idContr);
        return $this->db->get()->result_array();
    }

    function nuevoContrato($data)
    {

        $this->db->insert('Contrato', $data);
        return $this->db->insert_id();

    }

    function nuevoTipContrato($data)
    {
        $this->db->insert('tipoContrato', $data);
        return $this->db->insert_id();
    }

    function editarContrato($data, $id)
    {

        $this->db->where('idContrato', $id);

        $this->db->update('Contrato', $data);

    }


    function updatePlantilla($data, $id)
    {
        $this->db->where('idTipoC', $id);
        $this->db->update('tipoContrato', $data);
    }
    function modificaTipoc($data, $id)

    {
        $this->db->where('idTipoC', $id);
        $this->db->update('tipoContrato', $data);
    }

    function borrarContrato($id)
    {

        $this->db->where('idContrato', $id);
        $this->db->delete("Contrato");

    }

    function borrarTipoContrato($id)
    {
        $this->db->where('idTipoC', $id);
        $this->db->delete("tipoContrato");

    }
    function borrarPlantilla($idTipoContrato)
    {
        $this->db->select('template');
        $array=$this->db->get_where('tipoContrato', array('idTipoC' => $idTipoContrato))->row_array();
        $this->db->where("idTipoC", $idTipoContrato);
        $this->db->update("tipoContrato", array('template' => ""));
        return $array['template'];
    }

}