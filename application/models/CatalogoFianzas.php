<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class CatalogoFianzas extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function getTodosFianzas()
    {
        $this->db->order_by("orden", "asc");
        return $this->db->get("CatalogoFianzas")->result_array();
    }

    function updateDatosFianza($idFianza, $item)
    {
        $this->db->where('idCatalogoFianza', $idFianza);
        $this->db->update('CatalogoFianzas', $item);
    }

    function insertDatosFianza($data)
    {
        $this->db->insert("CatalogoFianzas", $data);
    }

    function deleteDatosFianza($idFianza)
    {
        $this->db->where("idCatalogoFianza", $idFianza);
        $this->db->delete("CatalogoFianzas");
    }

    // FUNCIONES PARA ENVIO DE CORREO FIANZAS PROXIMAS A VENCER

    function traerPendientesF()
    {
        return $this->db->query("SELECT * FROM Fianzas WHERE statusCorreo=0 AND Fianzas.statusFinalizado!=1")->result_array();
    }

    function getDatosEnvioF($idF)
    {
        $this->db->select("Fianzas.statusCorreo,Fianzas.diasAviso,,proyecto.nombreProyecto, Contrato.nombre as nombreContrato, tipoContrato.claveContrato, tipoContrato.nombreTipo, Empresa.razon_social, CF.nombre as nombreFianza, Fianzas.vigencia, Fianzas.monto");
        $this->db->from("proyecto");
        $this->db->join("contratoProyecto", "contratoProyecto.idProyecto = proyecto.idProyecto");
        $this->db->join("tipoContrato", "tipoContrato.idTipoC = contratoProyecto.idTipoContrato");
        $this->db->join("Contrato", "Contrato.idContrato = tipoContrato.idContrato");
        $this->db->join("Empresa", "Empresa.idEmpresa = contratoProyecto.idEmpresa");
        $this->db->join("Fianzas", "Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto ");
        $this->db->join("CatalogoFianzas CF", "Fianzas.idCatalogoFianza = CF.idCatalogoFianza");
        $this->db->where("Fianzas.idFianza", "$idF");

        return $this->db->get()->result_array();
    }

    function updateStatusFianza($data, $idF)
    {
        $this->db->where('idFianza', $idF);
        $this->db->update('Fianzas', $data);
    }
	



}