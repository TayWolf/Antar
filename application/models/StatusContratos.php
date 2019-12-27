<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StatusContratos extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function getAllStatus()
    {
        $this->db->order_by("orden", "asc");
        return $this->db->get("StatusContratos")->result_array();
    }

    function getStatus($idStatus)
    {
        $this->db->select("*");
        $this->db->from("StatusContratos");
        $this->db->where("idStatusContrato", $idStatus);
        return $this->db->get()->row_array();
    }

    function insertarStatus($data)
    {
        $this->db->insert("StatusContratos", $data);
    }

    function eliminarStatusContrato($id)
    {
        $this->db->where("idStatusContrato", $id);
        $this->db->delete("StatusContratos");
    }

    function editarStatusContrato($id, $data)
    {
        $this->db->where("idStatusContrato", $id);
        $this->db->update("StatusContratos", $data);
    }

}