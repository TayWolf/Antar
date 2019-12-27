<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
        $this->db->query("SET lc_time_names = 'es_MX';");

    }

    function getGraficaContratos($fechaInicial, $fechaFinal)
    {
        $idUsuario=$this->session->userdata("iduser");
        $this->db->select("COUNT(vigencia) as ejeY, CONCAT(MONTHNAME(STR_TO_DATE(MONTH(vigencia), '%m')), ' de ', YEAR(vigencia)) as ejeX, StatusContratos.etiqueta ");
        $this->db->from("contratoProyecto");
        $this->db->join("tipoContrato Contrato", "contratoProyecto.idTipoContrato = Contrato.idTipoC");
        $this->db->join("proyecto p", "contratoProyecto.idProyecto = p.idProyecto");
        $this->db->join("empresainterna e", "p.idEmpresaInterna = e.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        $this->db->join("StatusContratos", "contratoProyecto.status = StatusContratos.idStatusContrato");
        $this->db->where("vigencia >=", $fechaInicial);
        $this->db->where("vigencia <=", $fechaFinal);
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("(SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1");
        $this->db->group_by(array("etiqueta", "YEAR(vigencia)", "MONTH(vigencia)"));
        $this->db->order_by("etiqueta", "ASC");
        $this->db->order_by("YEAR(vigencia)", "ASC");
        $this->db->order_by("MONTH(vigencia)", "ASC");
        return $this->db->get()->result_array();
    }

    function getStatus()
    {
        return $this->db->query("SELECT * FROM StatusContratos")->result_array();
    }

    function getFechas($fechaInicial, $fechaFinal, $idEmpresaInterna)
    {
        $idUsuario=$this->session->userdata('iduser');
        if(!empty($idEmpresaInterna))
        {
            $this->db->select("CONCAT(MONTHNAME(STR_TO_DATE(MONTH(vigencia), '%m')), ' de ', YEAR(vigencia)) as fecha, contratoProyecto.statusFinalizado, contratoProyecto.idContratoProyecto ");
            $this->db->from("contratoProyecto");
            $this->db->join("proyecto p", "contratoProyecto.idProyecto = p.idProyecto");
            $this->db->join("tipoContrato", "contratoProyecto.idTipoContrato = tipoContrato.idTipoC");
            $this->db->join("UsuarioTipoContrato", "tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
            $this->db->join("empresainterna e", "p.idEmpresaInterna = e.idEmpresaInterna");
            $this->db->where("vigencia >=", $fechaInicial);
            $this->db->where("vigencia <=", $fechaFinal);
            $this->db->where("e.idEmpresaInterna", $idEmpresaInterna);
            $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
            $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");
            $this->db->group_by(array("YEAR(vigencia)", "MONTH(vigencia)"));
        }
        else
        {
            $this->db->select("CONCAT(MONTHNAME(STR_TO_DATE(MONTH(contratoProyecto.vigencia), '%m')), ' de ', YEAR(contratoProyecto.vigencia)) as fecha, statusFinalizado, idContratoProyecto");
            $this->db->from("contratoProyecto");
            $this->db->join("tipoContrato", "contratoProyecto.idTipoContrato = tipoContrato.idTipoC");
            $this->db->join("UsuarioTipoContrato", "tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
            $this->db->where("vigencia >=", $fechaInicial);
            $this->db->where("vigencia <=", $fechaFinal);
            $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
//            $this->db->where("UsuarioTipoContrato.idUsuario", "1");
            $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");

            $this->db->group_by(array("YEAR(contratoProyecto.vigencia)", "MONTH(contratoProyecto.vigencia)"));
        }
        return $this->db->get()->result_array();
    }
    function getInformacionStatus($idStatus, $fecha, $empresaInterna)
    {
        $idUsuario=$this->session->userdata('iduser');
        if(!empty($empresaInterna))
        {
            $this->db->select("COUNT(CONCAT(MONTHNAME(STR_TO_DATE(MONTH(vigencia), '%m')), ' de ', YEAR(vigencia))) as informacion, contratoProyecto.idContratoProyecto, contratoProyecto.statusFinalizado");
            $this->db->from("contratoProyecto");
            $this->db->join("StatusContratos","contratoProyecto.status = StatusContratos.idStatusContrato");
            $this->db->join("proyecto p","contratoProyecto.idProyecto = p.idProyecto");
            $this->db->join("empresainterna e","p.idEmpresaInterna = e.idEmpresaInterna");
            $this->db->join("tipoContrato Contrato","contratoProyecto.idTipoContrato = Contrato.idTipoC");
            $this->db->join("UsuarioEmpresa Empresa","e.idEmpresaInterna = Empresa.idEmpresaInterna");
            $this->db->join("UsuarioTipoContrato","Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
            $this->db->where("StatusContratos.idStatusContrato",$idStatus);
            $this->db->where("CONCAT(MONTHNAME(STR_TO_DATE(MONTH(vigencia), '%m')), ' de ', YEAR(vigencia)) =",$fecha);
            $this->db->where("e.idEmpresaInterna",$empresaInterna);
            $this->db->where("UsuarioTipoContrato.idUsuario",$idUsuario);
            $this->db->where("Empresa.idUsuario ",$idUsuario);
            $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");

        }
        else
        {
            $this->db->select("COUNT(CONCAT(MONTHNAME(STR_TO_DATE(MONTH(vigencia), '%m')), ' de ', YEAR(vigencia))) as informacion, contratoProyecto.idContratoProyecto, contratoProyecto.statusFinalizado");
            $this->db->from("contratoProyecto");
            $this->db->join("proyecto p","contratoProyecto.idProyecto = p.idProyecto");
            $this->db->join("StatusContratos","contratoProyecto.status = StatusContratos.idStatusContrato");
            $this->db->join("tipoContrato","contratoProyecto.idTipoContrato = tipoContrato.idTipoC");
            $this->db->join("UsuarioTipoContrato","tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
            $this->db->join("empresainterna e","p.idEmpresaInterna = e.idEmpresaInterna");
            $this->db->join("UsuarioEmpresa Empresa","e.idEmpresaInterna = Empresa.idEmpresaInterna");
            $this->db->where("StatusContratos.idStatusContrato",$idStatus);
            $this->db->where("CONCAT(MONTHNAME(STR_TO_DATE(MONTH(vigencia), '%m')), ' de ', YEAR(vigencia)) =",$fecha);
            $this->db->where("UsuarioTipoContrato.idUsuario",$idUsuario);
            $this->db->where("Empresa.idUsuario ",$idUsuario);
            $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");
        }
        $informacion=$this->db->get()->row_array();
        return $informacion['informacion'];
    }
    function getFianzas($fechaInicial, $fechaFinal, $empresaInterna)
    {
        $idUsuario=$this->session->userdata('iduser');
        $this->db->select("Fianzas.status, Fianzas.vigencia ");
        $this->db->from("Fianzas");
        $this->db->join("contratoProyecto cP", "Fianzas.idContratoProyecto = cP.idContratoProyecto");
        $this->db->join("tipoContrato Contrato", "cP.idTipoContrato = Contrato.idTipoC");
        $this->db->join("proyecto p", "cP.idProyecto = p.idProyecto ");
        $this->db->join("empresainterna e", "p.idEmpresaInterna = e.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa Empresa ", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        $this->db->where("Fianzas.vigencia >=", $fechaInicial);
        $this->db->where("Fianzas.vigencia <=", $fechaFinal);
        $this->db->where("Empresa.idUsuario", $idUsuario);
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("Fianzas.statusFinalizado!=", "1");
        if(!empty($empresaInterna))
        {
            $this->db->where("e.idEmpresaInterna", $empresaInterna);
        }
        return $this->db->get()->result_array();


    }
    function getTarjetasContratos($fechaInicial, $fechaFinal, $idEmpresaInterna)
    {


        $idUsuario=$this->session->userdata('iduser');
        $this->db->select("COUNT(contratoProyecto.idContratoProyecto) as cuenta, StatusContratos.idStatusContrato, StatusContratos.etiqueta, StatusContratos.clase, contratoProyecto.statusFinalizado, contratoProyecto.idContratoProyecto");
        $this->db->from("contratoProyecto");
        $this->db->join("proyecto p", "contratoProyecto.idProyecto = p.idProyecto ");
        $this->db->join("empresainterna e ", "p.idEmpresaInterna = e.idEmpresaInterna ");
        $this->db->join("tipoContrato Contrato ", "contratoProyecto.idTipoContrato = Contrato.idTipoC ");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato ");
        $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
        $this->db->join("StatusContratos", "StatusContratos.idStatusContrato = contratoProyecto.status");
        //$this->db->join("Fianzas", "Fianzas.idContratoProyecto=contratoProyecto.idContratoProyecto");
        $this->db->where("contratoProyecto.vigencia >=", $fechaInicial);
        $this->db->where("contratoProyecto.vigencia <=", $fechaFinal);
        $this->db->where("Empresa.idUsuario", $idUsuario);
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        //$this->db->where("Fianzas.statusFinalizado!=", "1");
        $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");
        $this->db->group_by("StatusContratos.idStatusContrato");

        if(!empty($idEmpresaInterna))
        {
            $this->db->where("e.idEmpresaInterna", $idEmpresaInterna);
        }
        return $this->db->get()->result_array();

    }
    function getTarjetasContratosVencimiento($fechaInicial, $fechaFinal, $idEmpresaInterna, $diasTolerancia)
    {
        $fechaHoy=date("Y-m-d");
        $idUsuario=$this->session->userdata('iduser');
        $this->db->select("COUNT(idContratoProyecto) as cuenta, StatusContratos.idStatusContrato, StatusContratos.etiqueta, StatusContratos.clase, contratoProyecto.vigencia");
        $this->db->from("contratoProyecto");
        $this->db->join("StatusContratos", "StatusContratos.idStatusContrato = contratoProyecto.status");
        $this->db->join("proyecto p", "contratoProyecto.idProyecto = p.idProyecto ");
        $this->db->join("empresainterna e ", "p.idEmpresaInterna = e.idEmpresaInterna");
        $this->db->join("tipoContrato Contrato ", "contratoProyecto.idTipoContrato = Contrato.idTipoC ");
        $this->db->join("UsuarioEmpresa Empresa ", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
        $this->db->join("UsuarioTipoContrato ", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato ");
        $this->db->where("vigencia >=", $fechaInicial);
        $this->db->where("vigencia <=", $fechaFinal);
        $this->db->where("vigencia >=", $fechaHoy);
        $this->db->where("DATE_ADD(vigencia, INTERVAL -".$this->db->escape($diasTolerancia)." DAY) <=", $fechaHoy);
        $this->db->where("UsuarioTipoContrato.idUsuario ", $idUsuario);
        $this->db->where("Empresa.idUsuario", $idUsuario);
        $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");
        $this->db->group_by("StatusContratos.idStatusContrato");
        if(!empty($idEmpresaInterna))
        {
            $this->db->where(" e.idEmpresaInterna", $idEmpresaInterna);

        }
        return $this->db->get()->result_array();


    }
    function getTarjetasFianzas($fechaInicial, $fechaFinal)
    {
        $idUsuario=$this->session->userdata('iduser');
        $this->db->select("*");
        $this->db->from("Fianzas");
        $this->db->join("contratoProyecto cP ", "Fianzas.idContratoProyecto = cP.idContratoProyecto");
        $this->db->join("tipoContrato Contrato", "cP.idTipoContrato = Contrato.idTipoC");
        $this->db->join("proyecto p", "cP.idProyecto = p.idProyecto");
        $this->db->join("empresainterna e", "p.idEmpresaInterna = e.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        $this->db->where("vigencia >=", $fechaInicial);
        $this->db->where("vigencia <=", $fechaFinal);
        $this->db->where("UsuarioTipoContrato.idUsuario ", $idUsuario);
        $this->db->where("Empresa.idUsuario", $idUsuario);
        $this->db->where("Empresa.idUsuario", $idUsuario);
        $this->db->where("Fianzas.statusFinalizado!=", "1");

        return $this->db->get()->result_array();
    }
    function getEmpresasInternas()
    {
        $idUsuario=$this->session->userdata('iduser');
        $this->db->select("*");
        $this->db->from("empresainterna ");
        $this->db->join("UsuarioEmpresa E ", "empresainterna.idEmpresaInterna = E.idEmpresaInterna ");
        $this->db->where("E.idUsuario", $idUsuario);
        return $this->db->get()->result_array();
    }
    function getContratosVencimiento($diasTolerancia, $idStatus=null, $fechaInicial="1950-01-01", $fechaFinal="2032-12-31")
    {
        $fechaHoy=date("Y-m-d");
        $idUsuario=$this->session->userdata('iduser');
        if(empty($idEmpresaInterna))
        {
            $this->db->select("contratoProyecto.*, proyecto.nombreProyecto, tipoContrato.claveContrato, tipoContrato.nombreTipo ");
            $this->db->from("contratoProyecto");
            $this->db->join("tipoContrato","tipoContrato.idTipoC = contratoProyecto.idTipoContrato");
            $this->db->join("proyecto","contratoProyecto.idProyecto = proyecto.idProyecto");
            $this->db->join("StatusContratos","StatusContratos.idStatusContrato = contratoProyecto.status ");
            $this->db->join("empresainterna e","proyecto.idEmpresaInterna = e.idEmpresaInterna");
            $this->db->join("UsuarioTipoContrato","tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
            $this->db->join("UsuarioEmpresa Empresa ","e.idEmpresaInterna = Empresa.idEmpresaInterna");
            $this->db->where("contratoProyecto.vigencia >=",$fechaInicial);
            $this->db->where("contratoProyecto.vigencia <=",$fechaFinal);
            $this->db->where("vigencia>=",$fechaHoy);
            $this->db->where("DATE_ADD(vigencia, INTERVAL -".$this->db->escape($diasTolerancia)." DAY) <=",$fechaHoy);
            $this->db->where("UsuarioTipoContrato.idUsuario",$idUsuario);
            $this->db->where("Empresa.idUsuario",$idUsuario);
            $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");

            if(!empty($idStatus))
                $this->db->where("StatusContratos.idStatusContrato", $idStatus);
                return $this->db->get()->result_array();

        }

    }
    function getFianzasVencimiento($diasTolerancia, $fechaInicial, $fechaFinal, $empresaInterna)
    {
        $fechaHoy=date("Y-m-d");
        $idUsuario=$this->session->userdata('iduser');
        $this->db->select("Fianzas.status, Fianzas.vigencia");
        $this->db->from("Fianzas");
        $this->db->join("contratoProyecto cP", "Fianzas.idContratoProyecto = cP.idContratoProyecto");
        $this->db->join("proyecto p", "cP.idProyecto = p.idProyecto");
        $this->db->join("empresainterna e", "p.idEmpresaInterna = e.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
        $this->db->join("tipoContrato Contrato", "cP.idTipoContrato = Contrato.idTipoC");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        $this->db->where("Fianzas.vigencia>=", $fechaInicial);
        $this->db->where("Fianzas.vigencia<=", $fechaFinal);
        $this->db->where("DATE_ADD(Fianzas.vigencia, INTERVAL -$diasTolerancia DAY) <=", $fechaHoy);
        $this->db->where("Fianzas.vigencia >=", $fechaHoy);
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("Empresa.idUsuario ", $idUsuario);
        $this->db->where("Fianzas.statusFinalizado!=", "1");
        if(!empty($empresaInterna))
        {
            $this->db->where("e.idEmpresaInterna", $empresaInterna);
        }
        return $this->db->get()->result_array();


    }
    function getFianzasContratosVencimiento($fechaInicial, $fechaFinal, $idEmpresaInterna, $idPago, $diasTolerancia, $idVigencia=null)
    {
        $idUsuario=$this->session->userdata("iduser");
        $this->db->select("proyecto.nombreProyecto, cP.objetoContrato, cP.nomenclatura, CatalogoFianzas.nombre, Fianzas.* ");
        $this->db->from("Fianzas");
        $this->db->join("CatalogoFianzas", "Fianzas.idCatalogoFianza = CatalogoFianzas.idCatalogoFianza");
        $this->db->join("contratoProyecto cP", "Fianzas.idContratoProyecto = cP.idContratoProyecto");
        $this->db->join("proyecto", "cP.idProyecto = proyecto.idProyecto");
        $this->db->join("empresainterna", "proyecto.idEmpresaInterna = empresainterna.idEmpresaInterna");
        $this->db->join("tipoContrato Contrato", "cP.idTipoContrato = Contrato.idTipoC");
        $this->db->join("UsuarioEmpresa E", "empresainterna.idEmpresaInterna = E.idEmpresaInterna");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");

        if(!empty($idEmpresaInterna))
            $this->db->where("empresainterna.idEmpresaInterna", $idEmpresaInterna);

        $this->db->where("Fianzas.vigencia>=", $fechaInicial);
        $this->db->where("Fianzas.vigencia<=", $fechaFinal);
        $fechaHoy=date("Y-m-d");
        if($idVigencia)
            $this->db->where("Fianzas.vigencia >=", $fechaHoy);
        else
            $this->db->where("Fianzas.vigencia <", $fechaHoy);
        if($idPago)
            $this->db->where("Fianzas.status", "1");
        else
            $this->db->where("Fianzas.status", "0");

        $this->db->where("DATE_ADD(Fianzas.vigencia, INTERVAL -".$this->db->escape($diasTolerancia)." DAY) <=", $fechaHoy);
        $this->db->where("Fianzas.vigencia >", $fechaHoy);

        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("E.idUsuario", $idUsuario);
        $this->db->where("Fianzas.statusFinalizado !=", "1");
        return $this->db->get()->result_array();

    }
}