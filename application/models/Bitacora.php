<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora extends CI_Model{

    function __construct(){
        parent::__construct();
    }

	function insertar($data){
		
		$this->db->insert("Bitacora",$data);
	}
	
    function getDatosEi()
    {

        // return $this->db->query("SELECT Usuarios.*,tipoUser.nombreTipo,area.nombreArea FROM `Usuarios` JOIN tipoUser on tipoUser.idTipo=Usuarios.idTipo join area on area.idArea=Usuarios.idArea")->result_array();
        return $this->db->get("empresainterna")->result_array();
    }

     function getDatosUser()
    {
        return $this->db->get("Usuarios")->result_array();
    }

    function getDatosModulo()
    {
    	return $this->db->get("Modulo")->result_array();
    }
    
    function cargarEmpresasUsuario($idE)
    {
    	// return $this->db->query("SELECT Usuarios.* FROM `Usuarios` JOIN UsuarioEmpresa on Usuarios.idUser=UsuarioEmpresa.idUsuario where idEmpresaInterna =$idE")->result_array();
    	if ($idE==0) {
    		return $this->db->query("SELECT Usuarios.* FROM `Usuarios` JOIN UsuarioEmpresa on Usuarios.idUser=UsuarioEmpresa.idUsuario GROUP by Usuarios.idUser ")->result_array();
    	}else{
         return $this->db->join("Usuarios","Usuarios.idUser=UsuarioEmpresa.idUsuario")-> get_where("UsuarioEmpresa", array('idEmpresaInterna' => $idE))->result_array();
    	}
    }

    function cargarmodulosUser($idUser)
    {
    	if ($idUser==0) {
    		return $this->db->query("SELECT Modulo.* FROM `Permiso` join Modulo on Modulo.idModulo=Permiso.idModulo JOIN Usuarios on Usuarios.idTipo=Permiso.idTipoUsuario WHERE Permiso.mostrar=1 GROUP by Modulo.idModulo")->result_array();
    	}else{
    		return $this->db->query("SELECT Modulo.* FROM `Permiso` join Modulo on Modulo.idModulo=Permiso.idModulo JOIN Usuarios on Usuarios.idTipo=Permiso.idTipoUsuario WHERE Usuarios.idUser=$idUser and Permiso.mostrar=1")->result_array();
    	}
    	
    }
}
