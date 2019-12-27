<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ArchivoMuerto extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function cargarContratosTerminados($idUsuario)
    {
        $this->db->select("proyecto.nombreProyecto, tipoContrato.claveContrato, tipoContrato.nombreTipo, contratoProyecto.*");
        $this->db->from("contratoProyecto");
        $this->db->join("tipoContrato", "tipoContrato.idTipoC = contratoProyecto.idTipoContrato ");
        $this->db->join("proyecto", "contratoProyecto.idProyecto = proyecto.idProyecto");
        $this->db->join("StatusContratos", "StatusContratos.idStatusContrato = contratoProyecto.status");
        $this->db->join("UsuarioTipoContrato", "tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        $this->db->join("empresainterna e", "proyecto.idEmpresaInterna = e.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("Empresa.idUsuario", $idUsuario);
        $this->db->where("contratoProyecto.statusFinalizado", "1");
        $this->db->where("((SELECT COUNT(Fianzas.idFianza) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) = (SELECT COUNT(Fianzas.idFianza) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1))");
        $this->db->group_by("contratoProyecto.idContratoProyecto");

        return $this->db->get()->result_array();

    }
}