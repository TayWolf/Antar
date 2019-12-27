<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudEmpresasInternas extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("EmpresasInternas");
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 14)))
        {
            die($this->load->view("viewErrorPermiso", null, true));

        }
    }
    function index()
    {

        $this->load->library("session");
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 14);
        $data['permisosDocumentos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 15);
        $data['empresas']=$this->EmpresasInternas->getEmpresasInternas();
        $data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoEmpresasInternas", $data, TRUE);
    }
    function altaEmpresaInterna()
    {
        print $this->load->view("formAltaEmpresaInterna", null, TRUE);
    }
    function nuevaEmpresaInterna()
    {
        $this->form_validation->set_rules('nombre', 'nombre', 'required|min_length[3]|max_length[200]');

        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $this->EmpresasInternas->insertEmpresa(array('nombreEmpresa' => $this->input->post('nombre')));
        echo json_encode("1");
    }
    function editarEmpresaInterna()
    {
        $this->form_validation->set_rules('id', 'identificador', 'required|numeric|trim');
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required|min_length[3]|max_length[200]');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $id=$this->input->post('id');
        $nombre=$this->input->post('nombre');
        if(!empty($nombre))
            $this->EmpresasInternas->editarEmpresa(array('nombreEmpresa' => $nombre), $id);
    }
    function borrarEmpresa()
    {
        $this->form_validation->set_rules('id', 'identificador', 'required|numeric|trim');

        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $this->EmpresasInternas->eliminarEmpresa($this->input->post('id'));
    }
    function verDocumentosEmpresa($idEmpresaInterna)
    {

        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 15);
        $data['nombreEmpresa']=$this->EmpresasInternas->getNombreEmpresaInterna($idEmpresaInterna);
        $data['idEmpresaInterna']=$idEmpresaInterna;
        $data['documentos']=$this->EmpresasInternas->getDocumentosEmpresaInterna($idEmpresaInterna);
        $data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoDocumentosEmpresaInterna", $data, TRUE);
    }
    function altaDocumentoEmpresaInterna($idEmpresaInterna)
    {
        $data['nombreEmpresa']=$this->EmpresasInternas->getNombreEmpresaInterna($idEmpresaInterna);
        $data['idEmpresaInterna']=$idEmpresaInterna;
        $data = $this->security->xss_clean($data);
        print $this->load->view("formAltaDocumentoEmpresaInterna", $data, TRUE);
    }
    function borrarDocumentoEmpresa()
    {
        $this->form_validation->set_rules('id', 'identificador', 'required|numeric|trim');
        $this->form_validation->set_rules('documento', 'documento', 'trim|required|min_length[3]|max_length[150]');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $idDocumento=$this->input->post("id");
        $nombreDoc=$this->input->post("documento");
        unlink("assets/fileUpload/documentoEmpresa/".$nombreDoc);
        $this->EmpresasInternas->borrarDocumento($idDocumento);
    }
    function nuevoDocumentoEmpresaInterna($idEmpresaInterna)
    {
        $this->form_validation->set_rules('nombreDocumento', 'nombre del documento', 'required|max_length[200]');
        $this->form_validation->set_rules('observaciones', 'observaciones', 'trim');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $this->EmpresasInternas->insertDocumentoEmpresa(array('idEmpresaInterna' => $idEmpresaInterna, 'nombreDocumento'=>$this->input->post('nombreDocumento'), 'documento' => $this->subirDocumento('documento'), 'observaciones' => $this->input->post('observaciones')));
        echo json_encode("1");
    }

    function editarDocumento($idDocumento)
    {
        $data['documento']=$this->EmpresasInternas->obtenerDatosDocumento($idDocumento);
        $data = $this->security->xss_clean($data);
        print $this->load->view("formEditarDocumentoEmpresaInterna", $data, TRUE);

    }
    function editarDocumentoEmpresaInterna($idDocumento)
    {
        //borra el anterior documento y lo reemplaza por uno nuevo
        $this->form_validation->set_rules('nombreDocumento', 'nombre del documento', 'required|max_length[200]');
        $this->form_validation->set_rules('observaciones', 'observaciones', 'trim');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        if($this->input->post("archivoEditado")==1)
        {
            $nombreDocumento=$this->EmpresasInternas->obtenerNombreDocumento($idDocumento);
            unlink("assets/fileUpload/documentoEmpresa/".$nombreDocumento);
            $this->EmpresasInternas->updateDocumentoEmpresa(
                array(
                    'nombreDocumento'=>$this->input->post('nombreDocumento'),
                    'documento' => $this->subirDocumento('documento'),
                    'observaciones' => $this->input->post('observaciones')), $idDocumento);
        }
        // solo cambia la información del documento
        else
        {
            $this->EmpresasInternas->updateDocumentoEmpresa(
                array(
                    'nombreDocumento' => $this->input->post('nombreDocumento'),
                    'observaciones' => $this->input->post('observaciones')), $idDocumento);
        }

    }
    //Nombre del campo es el post del file
    function subirDocumento($nombreCampo)
    {
        if(!file_exists("assets/fileUpload/documentoEmpresa") && !is_dir("assets/fileUpload/documentoEmpresa"))
        {
            mkdir("assets/fileUpload/documentoEmpresa");
        }
        $success = null;
        if(!empty($_FILES[$nombreCampo]))
        {
            $images = $_FILES[$nombreCampo];
            $filenames = $images['name'];
        }
        else
            $filenames = false;
        if($filenames)
        {
            for($i=0; $i < count($filenames); $i++)
            {
                $ext = explode('.', basename($filenames));
                $nombre=DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
                $target = "assets/fileUpload/documentoEmpresa" . $nombre;
                if(move_uploaded_file($images['tmp_name'], $target))
                {
                    return $nombre;
                }
                return null;
            }
        }
    }
	
	function descargarArchivo($idDocumento)
	{	
		//Datos sobre el archivo
		$documento=$this->EmpresasInternas->getUnDocumentoEmpresaInterna($idDocumento);
		$datos=$this->EmpresasInternas->getDatosBitacora($idDocumento);
		
		//Insertar en la bitacora 
		$this->load->model("Bitacora");
		$idUsuario=$this->session->userdata("iduser");
		$fecha=date("Y-m-d");
		$hora=date("H:i:s");
		$idModulo=15;
		$accion="Descarga";
		$texto="Empresa Interna ".$datos['idEmpresaInterna']." ".$datos['nombreEmpresa'].
		" / Documento ".$datos['idDocumentoEmpresa']." ".$datos['nombreDocumento'];
		
		
		$data=array(
			'idUsuario'=>$idUsuario,
			'fechaAccion'=>$fecha,
			'horaAccion'=>$hora,
			'idModulo'=>$idModulo,
			'accion'=>$accion,
			'texto'=>$texto
		);
		$this->Bitacora->insertar($data);
		
		//Descargar archivo
		$this->load->helper('download');
		echo $documento['documento'];
		force_download('assets/fileUpload/documentoEmpresa/'.$documento['documento'], NULL);
	}
}