<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Permisos extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("iduser");
        $this->db->query("SET @idUsuarioCambio=".$this->db->escape($idUser));
    }
    function validacionExistencia($idTipoUsuario, $idModulo)
    {
        $this->db->select("*");
        $this->db->from("Permiso");
        $this->db->where("idTipoUsuario", $idTipoUsuario);
        $this->db->where("idModulo", $idModulo);
        $existencia=$this->db->get()->row_array();
        if(empty($existencia))
        {
            $this->db->insert("Permiso", array('idTipoUsuario' => $idTipoUsuario, 'idModulo' => $idModulo));
        }

    }

    function actualizarPermiso($idTipoUsuario, $idModulo, $data)
    {
        $this->db->where("idTipoUsuario", $idTipoUsuario);
        $this->db->where("idModulo", $idModulo);
        $this->db->update("Permiso", $data);
    }

    function getPermisosUsuario($idTipoUsuario)
    {
        $this->db->select("*");
        $this->db->from("Permiso");
        $this->db->where("idTipoUsuario", $idTipoUsuario);
        return $this->db->get()->result_array();


    }
// Saca permisos de un usuario en un modulo
    function getPermisosUsuarioModulo($idTipoUsuario, $idModulo){
        $this->db->select("*");
        $this->db->from("Permiso");
        $this->db->where("idTipoUsuario", $idTipoUsuario);
        $this->db->where("idModulo", $idModulo);
        return $this->db->get()->row_array();

    }
    function getNombreTipoUsuario($idTipoUsuario)
    {
        $this->db->select("nombreTipo");
        $this->db->from("tipoUser");
        $this->db->where("idTipo", $idTipoUsuario);
        $array=$this->db->get()->row_array();
        return $array['nombreTipo'];
    }
    function tienePermisosUsuarioModulo($idUsuario, $idModulo)
    {

        $this->db->select("*");
        $this->db->from("Permiso");
        $this->db->join("tipoUser", "Permiso.idTipoUsuario=tipoUser.idTipo");
        $this->db->join("Usuarios", "Usuarios.idTipo=tipoUser.idTipo");
        $this->db->where("(Permiso.mostrar = 1 OR Permiso.alta = 1 OR Permiso.eliminar = 1 OR Permiso.detalle = 1 OR Permiso.editar = 1)");
        $this->db->where("Permiso.idModulo", $idModulo);
        $this->db->where("Usuarios.idUser", $idUsuario);
        return $this->db->get()->num_rows();

    }

}