<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fianzas extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function getTodosFianzas()
    {
        return $this->db->get("CatalogoFianzas")->result_array();
    }

    function updateDatosFianza($idFianza, $item)
    {
        $this->db->where('idCatalogoFianza', $idFianza);
        $this->db->update('CatalogoFianzas', $item);
    }

    function insertDatosFianza($data)
    {
        $this->db->insert("CatalogoFianzas" , $data);
    }

    function deleteDatosFianza($idFianza)
    {
        $this->db->where("idCatalogoFianza", $idFianza);
        $this->db->delete("CatalogoFianzas");
    }
	


}