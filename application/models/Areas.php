<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }

    function getTodosAreas()
    {
        return $this->db->get("area")->result_array();
    }
    function updateDatosArea($idArea, $item)
    {

        $this->db->where('idArea', $idArea);
        $this->db->update('area', $item);
    }

    function insertDatosArea($data)
    { 
        $this->db->insert("area", $data);
    }
    
    function deleteDatosArea($idArea)
    { 
        $this->db->where("idArea", $idArea);
        $this->db->delete("area");
    }

}