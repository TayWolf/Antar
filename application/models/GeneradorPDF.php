<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GeneradorPDF extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    //Sirve para obtener la tabla de los contratos y despues poder imprimirla en PDF
    function obtenerContratos($fechaInicial, $fechaFinal, $idStatus, $idEmpresaInterna, $Pr)
    {
        $idUsuario=$this->session->userdata("iduser");
        //para saber si la fecha Inicial, la fecha final y el status estan vacios
        //Quiere decir que se realizó la petición desde el CrudProyectos
        //La variable $Pr es el id del proyecto

        if(!empty($Pr))
        {
            $this->db->select("proyecto.nombreProyecto, tipoContrato.nombreTipo, contratoProyecto.objetoContrato, contratoProyecto.vigencia, contratoProyecto.nomenclatura, StatusContratos.etiqueta as status, contratoProyecto.idContratoProyecto, contratoProyecto.statusFinalizado");
            $this->db->from("contratoProyecto");
            $this->db->join("tipoContrato", "tipoContrato.idTipoC = contratoProyecto.idTipoContrato");
            $this->db->join("proyecto", "contratoProyecto.idProyecto = proyecto.idProyecto");
            $this->db->join("StatusContratos", "contratoProyecto.status = StatusContratos.idStatusContrato");
            $this->db->join("empresainterna e", "proyecto.idEmpresaInterna = e.idEmpresaInterna");
            $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
            $this->db->join("UsuarioTipoContrato", "tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
            $this->db->where("contratoProyecto.idProyecto", $Pr);
            $this->db->where("Empresa.idUsuario", $idUsuario );
            $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario );
            $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");
            return $this->db->get()->result_array();

        }
        //La petición se realizó desde el CrudDashboard
        else
        {
            if(empty($idEmpresaInterna))
            {
                $this->db->select("proyecto.nombreProyecto, tipoContrato.nombreTipo, contratoProyecto.objetoContrato, contratoProyecto.vigencia, contratoProyecto.nomenclatura, StatusContratos.etiqueta as status");
                $this->db->from("contratoProyecto");
                $this->db->join("tipoContrato", "tipoContrato.idTipoC = contratoProyecto.idTipoContrato");
                $this->db->join("proyecto", "contratoProyecto.idProyecto = proyecto.idProyecto");
                $this->db->join("StatusContratos", "contratoProyecto.status = StatusContratos.idStatusContrato");
                $this->db->join("empresainterna e", "proyecto.idEmpresaInterna = e.idEmpresaInterna");
                $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
                $this->db->join("UsuarioTipoContrato", "tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
                $this->db->where("StatusContratos.idStatusContrato", $idStatus);
                $this->db->where("contratoProyecto.vigencia >=", $fechaInicial);
                $this->db->where("contratoProyecto.vigencia <=", $fechaFinal);
                $this->db->where("contratoProyecto.vigencia <=", $fechaFinal);
                $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
                $this->db->where("Empresa.idUsuario", $idUsuario);
                $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");
                return $this->db->get()->result_array();
            }
            else
            {
                $this->db->select("proyecto.nombreProyecto, tipoContrato.nombreTipo, contratoProyecto.objetoContrato, contratoProyecto.vigencia, contratoProyecto.nomenclatura, StatusContratos.etiqueta as status");
                $this->db->from("contratoProyecto");
                $this->db->join("tipoContrato", "tipoContrato.idTipoC = contratoProyecto.idTipoContrato");
                $this->db->join("proyecto", "contratoProyecto.idProyecto = proyecto.idProyecto");
                $this->db->join("StatusContratos", "contratoProyecto.status = StatusContratos.idStatusContrato");
                $this->db->join("empresainterna e", "proyecto.idEmpresaInterna = e.idEmpresaInterna");
                $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
                $this->db->join("UsuarioTipoContrato", "tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
                $this->db->where("StatusContratos.idStatusContrato", $idStatus);
                $this->db->where("contratoProyecto.vigencia >=", $fechaInicial);
                $this->db->where("contratoProyecto.vigencia <=", $fechaFinal);
                $this->db->where("contratoProyecto.vigencia <=", $fechaFinal);
                $this->db->where("e.idEmpresaInterna ", $idEmpresaInterna);
                $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
                $this->db->where("Empresa.idUsuario", $idUsuario);
                $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");

                return $this->db->get()->result_array();

            }
        }
    }
    function obtenerContratosVencimiento($diasTolerancia, $idStatus, $fechaInicial="1950-01-01", $fechaFinal="2032-12-31")
    {
        $fechaHoy=date("Y-m-d");
        $idUsuario=$this->session->userdata("iduser");
        //    if(empty($idEmpresaInterna))
        $this->db->select("proyecto.nombreProyecto, tipoContrato.nombreTipo, contratoProyecto.objetoContrato, contratoProyecto.vigencia, contratoProyecto.nomenclatura, StatusContratos.etiqueta as status");
        $this->db->from("contratoProyecto");
        $this->db->join("tipoContrato", "tipoContrato.idTipoC = contratoProyecto.idTipoContrato");
        $this->db->join("proyecto", "contratoProyecto.idProyecto = proyecto.idProyecto");
        $this->db->join("StatusContratos", "contratoProyecto.status = StatusContratos.idStatusContrato");
        $this->db->join("empresainterna e", "proyecto.idEmpresaInterna = e.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");
        $this->db->join("UsuarioTipoContrato", "tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");

        $this->db->where("contratoProyecto.vigencia >=", $fechaInicial);
        $this->db->where("contratoProyecto.vigencia <=", $fechaFinal);
        $this->db->where("DATE_ADD(vigencia, INTERVAL -".$this->db->escape($diasTolerancia)." DAY) <=", $fechaHoy);
        $this->db->where("vigencia >", $fechaHoy);
        $this->db->where("Empresa.idUsuario", $idUsuario);
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");

        if(!empty($idStatus))
        {
            $this->db->where("StatusContratos.idStatusContrato", $idStatus);
        }
        return $this->db->get()->result_array();

        //    else
        //      return $this->db->query("SELECT proyecto.nombreProyecto, tipoContrato.nombreTipo, contratoProyecto.objetoContrato, contratoProyecto.vigencia, contratoProyecto.nomenclatura, StatusContratos.etiqueta as status  FROM `contratoProyecto` join tipoContrato on tipoContrato.idTipoC = contratoProyecto.idTipoContrato JOIN proyecto ON contratoProyecto.idProyecto = proyecto.idProyecto JOIN StatusContratos ON StatusContratos.idStatusContrato = contratoProyecto.status JOIN empresainterna e on proyecto.idEmpresaInterna = e.idEmpresaInterna WHERE StatusContratos.idStatusContrato = $idStatus and contratoProyecto.vigencia>=\"$fechaInicial\" and contratoProyecto.vigencia<=\"$fechaFinal\" and e.idEmpresaInterna=$idEmpresaInterna AND DATE_ADD(vigencia, INTERVAL -$diasTolerancia DAY) <= '$fechaHoy' AND vigencia > '$fechaHoy'")->result_array();
    }
    function obtenerFianzas($idContratoProyecto,  $fechaInicial="1950-01-01", $fechaFinal="2032-12-31", $idVigencia, $idPago, $idEmpresaInterna, $diasTolerancia, $consulta)
    {
        $idUsuario=$this->session->userdata("iduser");
        $this->db->select("proyecto.nombreProyecto, cP.objetoContrato, cP.nomenclatura, CatalogoFianzas.nombre, Fianzas.monto, Fianzas.vigencia, Fianzas.status");
        $this->db->from("Fianzas");
        $this->db->join("CatalogoFianzas", "Fianzas.idCatalogoFianza = CatalogoFianzas.idCatalogoFianza");
        $this->db->join("contratoProyecto cP", "Fianzas.idContratoProyecto = cP.idContratoProyecto");
        $this->db->join("proyecto", "cP.idProyecto = proyecto.idProyecto");
        $this->db->join("empresainterna", "proyecto.idEmpresaInterna = empresainterna.idEmpresaInterna");
        $this->db->join("tipoContrato Contrato", "cP.idTipoContrato = Contrato.idTipoC");
        $this->db->join("UsuarioEmpresa E", "empresainterna.idEmpresaInterna = E.idEmpresaInterna");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");

        if($idContratoProyecto)
        {
            $this->db->where("Fianzas.idContratoProyecto", $idContratoProyecto);
            $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
            $this->db->where("E.idUsuario", $idUsuario);
            $this->db->where("Fianzas.statusFinalizado!=", "1");

        }
        else
        {
            $fechaHoy=date("Y-m-d");


            if($consulta==1)
            {
                $this->db->where("DATE_ADD(Fianzas.vigencia, INTERVAL -".$this->db->escape($diasTolerancia)." DAY) <=", $fechaHoy);
                $this->db->where("Fianzas.vigencia >", $fechaHoy);

            }
            if(!empty($idEmpresaInterna))
                $this->db->where("empresainterna.idEmpresaInterna", $idEmpresaInterna);
            $this->db->where("Fianzas.vigencia>=", $fechaInicial);
            $this->db->where("Fianzas.vigencia<=", $fechaFinal);
            $fechaHoy=date("Y-m-d");
            if($idVigencia)
            {
                //vigentes
                $this->db->where("Fianzas.vigencia>=", $fechaHoy);
            }

            else
            {
                //no vigentes
                $this->db->where("Fianzas.vigencia<", $fechaHoy);

            }

            if($idPago)
            {
                $this->db->where("Fianzas.status", "1");
            }
            else
            {

                $this->db->where("Fianzas.status", "0");

            }
            $this->db->where("E.idUsuario", $idUsuario);
            $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
            $this->db->where("Fianzas.statusFinalizado!=1");

        }
        $this->db->group_by("Fianzas.idFianza");
        return $this->db->get()->result_array();
    }
    function obtenerFianzasFinalizadas($idContratoProyecto, $fechaInicial, $fechaFinal, $idVigencia, $idPago, $idEmpresaInterna)
    {
        $idUsuario=$this->session->userdata("iduser");
        $this->db->select("proyecto.nombreProyecto, cP.objetoContrato, cP.nomenclatura, CatalogoFianzas.nombre, Fianzas.monto, Fianzas.vigencia, Fianzas.status");
        $this->db->from("Fianzas");
        $this->db->join("CatalogoFianzas", "Fianzas.idCatalogoFianza = CatalogoFianzas.idCatalogoFianza");
        $this->db->join("contratoProyecto cP", "Fianzas.idContratoProyecto = cP.idContratoProyecto");
        $this->db->join("proyecto", "cP.idProyecto = proyecto.idProyecto");
        $this->db->join("empresainterna", "proyecto.idEmpresaInterna = empresainterna.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa E", "empresainterna.idEmpresaInterna = E.idEmpresaInterna");
        $this->db->join("tipoContrato Contrato", "cP.idTipoContrato = Contrato.idTipoC");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        if($idContratoProyecto)
        {
            $this->db->where("Fianzas.idContratoProyecto", $idContratoProyecto);
        }
        else {


            if (!empty($idEmpresaInterna))
            {
                $this->db->where("empresainterna.idEmpresaInterna", $idEmpresaInterna);
            }
            $this->db->where("Fianzas.vigencia>=", $fechaInicial);
            $this->db->where("Fianzas.vigencia<=", $fechaFinal);

        }
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("E.idUsuario", $idUsuario);
        return $this->db->get()->result_array();
    }
    function cargarContratosTerminados($idUsuario)
    {
        $this->db->select("proyecto.nombreProyecto, contratoProyecto.idContratoProyecto, contratoProyecto.statusFinalizado, tipoContrato.nombreTipo, contratoProyecto.objetoContrato, contratoProyecto.vigencia, contratoProyecto.nomenclatura, StatusContratos.etiqueta as status");
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
<<<<<<< HEAD

    function obtenerBitacora()
    {
        $idUsuario=$this->session->userdata("iduser");
        $this->db->select("bitacora.*, modulo.nombreModulo");
        $this->db->from("bitacora");
        $this->db->join("modulo", "modulo.idModulo = bitacora.idModulo");
        $this->db->join("contratoProyecto cP", "Fianzas.idContratoProyecto = cP.idContratoProyecto");
        $this->db->join("proyecto", "cP.idProyecto = proyecto.idProyecto");
        $this->db->join("empresainterna", "proyecto.idEmpresaInterna = empresainterna.idEmpresaInterna");
        $this->db->join("tipoContrato Contrato", "cP.idTipoContrato = Contrato.idTipoC");
        $this->db->join("UsuarioEmpresa E", "empresainterna.idEmpresaInterna = E.idEmpresaInterna");
        $this->db->join("UsuarioTipoContrato", "Contrato.idTipoC = UsuarioTipoContrato.idTipoContrato");

        if($idContratoProyecto)
        {
            $this->db->where("Fianzas.idContratoProyecto", $idContratoProyecto);
            $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
            $this->db->where("E.idUsuario", $idUsuario);
            $this->db->where("Fianzas.statusFinalizado!=", "1");

        }
        else
        {
            $fechaHoy=date("Y-m-d");


            if($consulta==1)
            {
                $this->db->where("DATE_ADD(Fianzas.vigencia, INTERVAL -".$this->db->escape($diasTolerancia)." DAY) <=", $fechaHoy);
                $this->db->where("Fianzas.vigencia >", $fechaHoy);

            }

            if(!empty($idEmpresaInterna))
            {
                $this->db->where("empresainterna.idEmpresaInterna", $idEmpresaInterna);
                $this->db->where("Fianzas.vigencia>=", $fechaInicial);
                $this->db->where("Fianzas.vigencia<=", $fechaFinal);
            }
            else
            {
                $this->db->where("Fianzas.vigencia>=", $fechaInicial);
                $this->db->where("Fianzas.vigencia<=", $fechaFinal);
            }
            $fechaHoy=date("Y-m-d");
            if($idVigencia)
            {
                //vigentes
                $this->db->where("Fianzas.vigencia>=", $fechaHoy);
            }

            else
            {
                //no vigentes
                $this->db->where("Fianzas.vigencia<", $fechaHoy);

            }

            if($idPago)
            {
                $this->db->where("Fianzas.status", "1");
            }
            else
            {

                $this->db->where("Fianzas.status", "0");

            }
            $this->db->where("E.idUsuario", $idUsuario);
            $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
            $this->db->where("Fianzas.statusFinalizado!=1");

        }
        $this->db->group_by("Fianzas.idFianza");
        return $this->db->get()->result_array();
=======
    function getStatus($idStatus)
    {
        $this->db->select("etiqueta");
        $this->db->from("StatusContratos");
        $this->db->where("StatusContratos.idStatusContrato", $idStatus);
        return $this->db->get()->row_array();
    }
    function getEmpresaInterna($idEmpresa)
    {
        $this->db->select("nombreEmpresa");
        $this->db->from("empresainterna");
        $this->db->where("empresainterna.idEmpresaInterna", $idEmpresa);
        return $this->db->get()->row_array();
    }
    function getProyecto($idProyecto)
    {
        $this->db->select("nombreProyecto");
        $this->db->from("proyecto");
        $this->db->where("idProyecto", $idProyecto);
        return $this->db->get()->row_array();
    }
    function getContrato($idContrato)
    {
        $this->db->select("nomenclatura");
        $this->db->from("contratoProyecto");
        $this->db->where("idContratoProyecto", $idContrato);
        return $this->db->get()->row_array();
>>>>>>> 53b85af5f4d8cbadd315fc890faf1de994f6ffe5
    }
}