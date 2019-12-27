<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TipoU extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function getDatos()

    {
        return $this->db->query("SELECT * FROM tipoUser")->result_array();
    }

    function nuevotipoUser($data)

    {

        $this->db->insert('tipoUser', $data);

    }

    function editartipoUser($data, $id)

    {

        $this->db->where('idtipo', $id);

        $this->db->update('tipoUser', $data);

    }

    function borrartipoUser($id)

    {

        $this->db->where('idtipo', $id);

        $this->db->delete("tipoUser");

    }

}