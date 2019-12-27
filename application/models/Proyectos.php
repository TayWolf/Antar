<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyectos extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }

    function getTodosProyectos($idUsuario)
    {
        $this->db->select("proyecto.*");
        $this->db->from("proyecto");
        $this->db->join("empresainterna e", "proyecto.idEmpresaInterna = e.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa", "e.idEmpresaInterna = UsuarioEmpresa.idEmpresaInterna");
        $this->db->where("UsuarioEmpresa.idUsuario", $idUsuario);
        return $this->db->get()->result_array();
    }

    function updateDatosProyecto($idProyecto, $item)
    {
        $this->db->where('idProyecto', $idProyecto);
        $this->db->update('proyecto', $item);
    }
    function updateFianzaContrato($idFianzaContrato, $item)
    {
        $this->db->where('idFianza', $idFianzaContrato);
        $this->db->update('Fianzas', $item);
    }

    function verificAPassword($password)
    {
        $this->load->library('encryption');
        $this->db->select("*");
        $this->db->from("Usuarios");
        //$this->db->where("passwordUser", $password);
        $this->db->where("idTipo", "1");
        $users=$this->db->get()->result_array();
        foreach ($users as $user)
        {
            $pass=$this->encryption->decrypt($user['passwordUser']);
            if($pass==$password)
                return 1;
        }




    }

    function getDatosEnvio($id)
    {
        $this->db->select("contratoProyecto.envioCorreo,contratoProyecto.diasAviso,proyecto.nombreProyecto,Contrato.nombre as nombreContrato,tipoContrato.claveContrato,tipoContrato.nombreTipo,Empresa.razon_social,contratoProyecto.vigencia");
        $this->db->from("proyecto");
        $this->db->join("contratoProyecto", "contratoProyecto.idProyecto=proyecto.idProyecto");
        $this->db->join("tipoContrato", "tipoContrato.idTipoC=contratoProyecto.idTipoContrato");
        $this->db->join("Contrato", "Contrato.idContrato=tipoContrato.idContrato");
        $this->db->join("Empresa", "Empresa.idEmpresa=contratoProyecto.idEmpresa");
        $this->db->where("contratoProyecto.idContratoProyecto", $id);
        return $this->db->get()->result_array();
    }

    function getlistaCorreos($idCont)
    {
        //return $this->db->query("SELECT * FROM `Usuarios` WHERE `idTipo` =1")->result_array();
        return $this->db->query("SELECT Usuarios.nombreUser,Usuarios.correoDestino FROM `contratoProyecto` join tipoContrato on tipoContrato.idTipoC=contratoProyecto.idTipoContrato join UsuarioTipoContrato on UsuarioTipoContrato.idTipoContrato=tipoContrato.idTipoC join Usuarios on Usuarios.idUser=UsuarioTipoContrato.idUsuario WHERE contratoProyecto.idContratoProyecto=$idCont or Usuarios.idTipo=1 GROUP by Usuarios.idUser")->result_array();
    }


    function updateStatus($data, $idCont)
    {
        $this->db->where('idContratoProyecto', $idCont);
        $this->db->update('contratoProyecto', $data);
    }

    function traerPendientes()
    {
        return $this->db->query("SELECT * FROM contratoProyecto WHERE envioCorreo=0 and statusFinalizado!=1")->result_array();
    }

    function insertDatosProyecto($data)
    {
        $this->db->insert("proyecto", $data);
    }

    function deleteDatosProyecto($idProyecto)
    {
        $this->db->where("idProyecto", $idProyecto);
        $this->db->delete("proyecto");
    }
    function deleteDatosFianza($idFianza)
    {
        $this->db->where("idFianza", $idFianza);
        $this->db->delete("Fianzas");
    }
    function deleteDatosContratoProyecto($idContratoProyecto)
    {
        $this->db->where("idContratoProyecto", $idContratoProyecto);
        $this->db->delete("contratoProyecto");
    }
    function getIdProyecto($idContratoProyecto=0)
    {
        if($idContratoProyecto)
        {
            $this->db->select("proyecto.idProyecto");
            $this->db->from("proyecto");
            $this->db->join("contratoProyecto", "proyecto.idProyecto=contratoProyecto.idProyecto");
            $this->db->where("idContratoProyecto", $idContratoProyecto);
            return $this->db->get()->row_array();
        }
            return $this->db->query("SELECT proyecto.idProyecto FROM proyecto JOIN contratoProyecto ON proyecto.idProyecto=contratoProyecto.idProyecto")->row_array();


    }
    function getContrato()
    {
        return $this->db->query("SELECT * FROM Contrato")->result_array();
    }
    function getPr($idPr="0")
    {
        $this->db->select("*");
        $this->db->from("proyecto");
        $this->db->where("idProyecto", $idPr);
        return $this->db->get()->result_array();
    }

    function getTodoTipos($idC)
    {
        $this->db->select("*");
        $this->db->from("tipoContrato");
        $this->db->where("idContrato", $idC);
        return $this->db->get()->result_array();
    }

    function getEmpresas()
    {
        return $this->db->query("SELECT * FROM Empresa")->result_array();
    }
    function sacarStatus($idC)
    {
        $this->db->select("*");
        $this->db->from("contratoProyecto");
        $this->db->where("idContratoProyecto", $idC);
        return $this->db->get()->row();
    }

    function sacarStatusFianza($idF)
    {
        $this->db->select("*");
        $this->db->from("Fianzas");
        $this->db->where("idFianza", $idF);

        return $this->db->get()->row();
    }
    //solo las finalizadas
    function getSolcitud($Pr=null,$fechaInicial=null, $fechaFinal=null,$idStatus=null, $idEmpresaInterna=null)
    {
        $idUsuario=$this->session->userdata('iduser');
        //si llego desde el crud de proyectos
        $this->db->select("contratoProyecto.envioCorreo,contratoProyecto.statusFinalizado, proyecto.nombreProyecto, contratoProyecto.*, tipoContrato.claveContrato, tipoContrato.nombreTipo");
        $this->db->from("contratoProyecto");
        $this->db->join("tipoContrato", "tipoContrato.idTipoC = contratoProyecto.idTipoContrato");
        $this->db->join("proyecto", "contratoProyecto.idProyecto = proyecto.idProyecto");
        $this->db->join("UsuarioTipoContrato", "tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        $this->db->join("empresainterna e", "proyecto.idEmpresaInterna = e.idEmpresaInterna ");
        $this->db->join("UsuarioEmpresa Empresa", "e.idEmpresaInterna = Empresa.idEmpresaInterna");


        if(!empty($Pr))
        {
            $this->db->where("contratoProyecto.idProyecto", $Pr);
        }
        //si llego desde el crud dashboard
        else
        {
            $this->db->join("StatusContratos", "StatusContratos.idStatusContrato = contratoProyecto.status");
            $this->db->where("StatusContratos.idStatusContrato", $idStatus);
            $this->db->where("contratoProyecto.vigencia >=", $fechaInicial);
            $this->db->where("contratoProyecto.vigencia <=", $fechaFinal);
            if(!empty($idEmpresaInterna))
            {
                $this->db->where("e.idEmpresaInterna", $idEmpresaInterna);
            }

        }
        $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        $this->db->where("Empresa.idUsuario", $idUsuario);
        $this->db->where("((SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto) != (SELECT COALESCE(COUNT(*), 0) FROM Fianzas WHERE Fianzas.idContratoProyecto = contratoProyecto.idContratoProyecto AND Fianzas.statusFinalizado = 1) OR contratoProyecto.statusFinalizado != 1)");

        return $this->db->get()->result_array();

    }

    function insertSolicitud($data)
    {
        $this->db->insert('contratoProyecto', $data);
        return $this->db->insert_id();
    }
    function editarSolicitud($data, $idContratoProyecto)
    {
        $this->db->where('idContratoProyecto', $idContratoProyecto);
        $this->db->update('contratoProyecto', $data);
    }
    function editarSolicitudF($data, $idF)
    {
        $this->db->where('idFianza', $idF);
        $this->db->update('Fianzas', $data);
    }
    function getContratoProyecto($idContratoProyecto)
    {

        $this->db->select("*");
        $this->db->from("contratoProyecto");
        $this->db->join("tipoContrato", "contratoProyecto.idTipoContrato=tipoContrato.idTipoC");
        $this->db->where("idContratoProyecto", $idContratoProyecto);
        return $this->db->get()->row_array();

    }
    function getTiposContrato($idContrato)
    {
        $this->db->select("*");
        $this->db->from("tipoContrato");
        $this->db->where("idContrato", $idContrato);
        return $this->db->get()->result_array();
    }
    function getFianzasContratos($idContratoProyecto=0, $fechaInicial=null, $fechaFinal=null, $idPago=null, $idVigencia=null)
    {
        $idUsuario=$this->session->userdata("iduser");
//        $this->db->get('mytable');  // Produces: SELECT * FROM mytable
//        return $this->db->get_where('Fianzas', array('idContratoProyecto' => $idContratoProyecto))->result_array();
        $this->db->select("cP.idContratoProyecto, Fianzas.*,  CatalogoFianzas.nombre");
        $this->db->from("Fianzas");
        $this->db->join("CatalogoFianzas", "Fianzas.idCatalogoFianza = CatalogoFianzas.idCatalogoFianza");
        $this->db->join("contratoProyecto cP", "Fianzas.idContratoProyecto = cP.idContratoProyecto");
        $this->db->join("proyecto", "cP.idProyecto = proyecto.idProyecto");
        $this->db->join("empresainterna", "proyecto.idEmpresaInterna = empresainterna.idEmpresaInterna");
        $this->db->join("UsuarioEmpresa", " empresainterna.idEmpresaInterna = UsuarioEmpresa.idEmpresaInterna ");
        $this->db->join("tipoContrato", "cP.idTipoContrato = tipoContrato.idTipoC");
        $this->db->join("UsuarioTipoContrato", "tipoContrato.idTipoC = UsuarioTipoContrato.idTipoContrato");
        if($idContratoProyecto)
        {
            $this->db->where("Fianzas.idContratoProyecto", $idContratoProyecto);
            $this->db->where("UsuarioEmpresa.idUsuario", $idUsuario);
            $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
        }
        else
        {
            if(!empty($idEmpresaInterna))
            {
                $this->db->where("empresainterna.idEmpresaInterna", $idEmpresaInterna);

            }
            $this->db->where("Fianzas.vigencia>=", $fechaInicial);
            $this->db->where("Fianzas.vigencia<=", $fechaFinal);

            $fechaHoy=date("Y-m-d");
            if($idVigencia)
            {
                //vigentes
                $this->db->where("Fianzas.vigencia>=", $fechaHoy);
            }

            else{
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
            $this->db->where("UsuarioTipoContrato.idUsuario", $idUsuario);
            $this->db->where("UsuarioEmpresa.idUsuario", $idUsuario);
            $this->db->where("Fianzas.statusFinalizado!=", "1");

        }
        return $this->db->get()->result_array();


    }
    function getAllFianzas()
    {
        return $this->db->get("CatalogoFianzas")->result_array();
    }
    function insertDatosFianza($data)
    {
        $this->db->insert("Fianzas", $data);
    }
	
	function getDocumentoRelicion($idDocumento)
	{
		$this->db->select("*");
        $this->db->from("Versiones_Contrato");
        $this->db->where("idVersionContrato", $idDocumento);
        return $this->db->get()->row_array();
	}
	
	function getDatosBitacoraRel($idDocumento)
	{
		$this->db->select("proyecto.idProyecto, proyecto.nombreProyecto, contratoProyecto.idContratoProyecto, contratoProyecto.nomenclatura, Versiones_Contrato.idContratoProyecto, Versiones_Contrato.idVersionContrato");
		$this->db->from("proyecto");
		$this->db->join("contratoProyecto", "proyecto.idProyecto=contratoProyecto.idProyecto");
		$this->db->join("Versiones_Contrato", "contratoProyecto.idContratoProyecto=Versiones_Contrato.idContratoProyecto");
		$this->db->where("Versiones_Contrato.idVersionContrato", $idDocumento);
		return $this->db->get()->row_array();
	}
	
	function getDocumentoDetalles($idDocumento)
	{
		$this->db->select("*");
        $this->db->from("contratoProyecto");
        $this->db->where("idContratoProyecto", $idDocumento);
        return $this->db->get()->row_array();
	}
	
	function getDatosBitacoraDetalles($idDocumento)
	{
		$this->db->select("proyecto.idProyecto, proyecto.nombreProyecto, contratoProyecto.idContratoProyecto, contratoProyecto.nomenclatura");
		$this->db->from("proyecto");
		$this->db->join("contratoProyecto", "proyecto.idProyecto=contratoProyecto.idProyecto");
		$this->db->where("contratoProyecto.idContratoProyecto", $idDocumento);
		return $this->db->get()->row_array();
	}
	
    function getAllVersiones($idContratoProyecto)
    {

        $this->db->select("*");
        $this->db->from("Versiones_Contrato");
        $this->db->where("idContratoProyecto", $idContratoProyecto);
        return $this->db->get()->result_array();
    }
    function insertarVersion($data)
    {
        $this->db->insert("Versiones_Contrato", $data);
        return $this->db->insert_id();
    }
    function cambiarVersionesFinales($idVersion,$idContratoProyecto)
    {
        $this->db->where("idContratoProyecto", $idContratoProyecto);
        $this->db->update("Versiones_Contrato", array('final' => 0));

        $this->db->where("idVersionContrato", $idVersion);
        $this->db->update("Versiones_Contrato", array('final' => 1));

    }
    function editarVersion($idVersion, $data)
    {
        $this->db->where("idVersionContrato", $idVersion);
        $this->db->update("Versiones_Contrato",$data);
    }
    function borrarVersion($idVersion)
    {
        $this->db->where("idVersionContrato", $idVersion);
        $this->db->delete("Versiones_Contrato");
    }
    function getAllStatus()
    {

        return $this->db->query("SELECT idStatusContrato as id, etiqueta as value, CONCAT('btn ',clase, ' center-align') as class, CONCAT('font-size: 10px; padding: 0; width: 100%; line-height: normal !important;') as style FROM StatusContratos ORDER BY orden ;")->result_array();
    }
    function getTodasEmpresasInternas()
    {
        return $this->db->query("SELECT * FROM empresainterna")->result_array();
    }

}