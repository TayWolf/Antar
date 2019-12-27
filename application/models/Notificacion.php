<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notificacion extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function getFianzasContratosVencimiento($diasTolerancia, $fechaHoy, $idUsuario)
    {
        $idUsuario = $this->session->userdata("iduser");
        $this->db->select("proyecto.nombreProyecto, cP.objetoContrato, cP.nomenclatura, Fianzas.*, CatalogoFianzas.nombre");
        $this->db->from("Fianzas");
        $this->db->join("CatalogoFianzas", "Fianzas.idCatalogoFianza = CatalogoFianzas.idCatalogoFianza");
        $this->db->join("contratoProyecto cP", "Fianzas.idContratoProyecto = cP.idContratoProyecto");
        $this->db->join("proyecto", "cP.idProyecto = proyecto.idProyecto");
        $this->db->join("empresainterna", "proyecto.idEmpresaInterna = empresainterna.idEmpresaInterna");
        $this->db->join("tipoContrato Contrato", "cP.idTipoContrato = Contrato.idTipoC");
        $this->db->join("UsuarioEmpresa E", "empresainterna.idEmpresaInterna = E.idEmpresaInterna");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        $this->db->where("DATE_ADD(Fianzas.vigencia, INTERVAL -$diasTolerancia DAY) <=", $fechaHoy);
        $this->db->where("Fianzas.vigencia >= ", $fechaHoy);
        $this->db->where("E.idUsuario", $idUsuario);
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("Fianzas.statusFinalizado !=", "1");

        return $this->db->get()->result_array();
    }
}