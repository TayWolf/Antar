<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TableroModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function getTotalFianzasPorVencer($diasTolerancia=7)
    {
        $idUsuario=$this->session->userdata('iduser');
        $fechaHoy=date("Y-m-d");
        $this->db->select("Count(*) as numero ");
        $this->db->from("Fianzas");
        $this->db->join("contratoProyecto cP", "Fianzas.idContratoProyecto = cP.idContratoProyecto");
        $this->db->join("tipoContrato Contrato", "cP.idTipoContrato = Contrato.idTipoC");
        $this->db->join("proyecto p", "cP.idProyecto = p.idProyecto");
        $this->db->join("empresainterna e", "p.idEmpresaInterna = e.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        $this->db->where("DATE_ADD(Fianzas.vigencia, INTERVAL -$diasTolerancia DAY) <=", $fechaHoy);
        $this->db->where("Fianzas.vigencia >=", $fechaHoy);
        $this->db->where("Empresa.idUsuario", $idUsuario);
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("Fianzas.statusFinalizado!=", "1");
        $numero=$this->db->get()->row_array();
        return $numero['numero'];
    }
    function getTotalContratosPorVencer($diasTolerancia=7)
    {
        $idUsuario=$this->session->userdata('iduser');
        $fechaHoy=date("Y-m-d");
        $this->db->select("Count(*) as numero ");
        $this->db->from("contratoProyecto");

        $this->db->join("StatusContratos", "StatusContratos.idStatusContrato = contratoProyecto.status");
        $this->db->join("tipoContrato Contrato", "contratoProyecto.idTipoContrato = Contrato.idTipoC");
        $this->db->join("proyecto p", "contratoProyecto.idProyecto = p.idProyecto ");
        $this->db->join("empresainterna e", "p.idEmpresaInterna = e.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");

        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        $this->db->where("DATE_ADD(contratoProyecto.vigencia, INTERVAL -$diasTolerancia DAY)<=", $fechaHoy);
        $this->db->where("contratoProyecto.vigencia >=", $fechaHoy);
        $this->db->where("Empresa.idUsuario", $idUsuario);
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");
        $numero=$this->db->get()->row_array();
        return $numero['numero'];
    }
}