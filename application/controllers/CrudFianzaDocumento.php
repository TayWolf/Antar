<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudFianzaDocumento extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('FianzaDocumento');
        $this->load->library('session');
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 9)))
        {
            die($this->load->view("viewErrorPermiso", null, true));

        }
    }


    function verDocumentos($idFianza, $idContratoProyecto, $verBoton=true)
    {
        $data['idFianza']=$idFianza;
        $data['idContratoProyecto']=$idContratoProyecto;
        $data['documentos']=$this->FianzaDocumento->getAllDocumentos($idFianza);
        $data['verbotonregresar']=$verBoton;
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'),9);
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoFianzaDocumento', $data, TRUE);
    }
    function nuevoDocumento($idFianza, $idContratoProyecto)
    {
        $data['idFianza']=$idFianza;
        $data['idContratoProyecto']=$idContratoProyecto;
        $data = $this->security->xss_clean($data);
        print $this->load->view('formDocumentoFianza', $data, TRUE);
    }
    function altaDocumento($idFianza)
    {
        $data=array(
            'idFianza'=>$idFianza,
			'nombreDocumento' => $this->input->post("nombreDocumento"),
            'documento' => $this->subirDocumento("archivo"),
            'observaciones' => $this->input->post('observaciones'));
        echo $this->FianzaDocumento->insertarDocumento($data);
    }
    function subirDocumento($nombreCampo)
    {

        if(!file_exists("assets/fileUpload/FianzaDocumento/") && !is_dir("assets/fileUpload/FianzaDocumento/"))
        {
            mkdir("assets/fileUpload/FianzaDocumento/");
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
                $target = "assets/fileUpload/FianzaDocumento/" . $nombre;
                if(move_uploaded_file($images['tmp_name'], $target))
                {
                    return $nombre;
                }
                else
                {
                    echo "no se pudo mover el archivo";
                    return null;
                }
            }
        }
        return "";
    }
    function eliminarDatosDocumento()
    {
        $idDocumento=$this->input->post('idDocumento');
        $archivo=$this->input->post('archivo');
        $this->FianzaDocumento->borrarDocumento($idDocumento);
        unlink("assets/fileUpload/FianzaDocumento/$archivo");
    }

    function editarDocumento()
    {
        $this->form_validation->set_rules('observaciones', 'observaciones', 'trim');
        $this->form_validation->set_rules('id', 'identificador', 'trim|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $arreglo = array(array('observaciones' => $this->input->post('observaciones')));
        $idDocumento= $this->input->post('id');
        foreach ($arreglo as $item) {
            while ($nombre_item = current($item))
            {
                if (!empty($nombre_item))
                {
                    echo json_encode($item);
                    $this->FianzaDocumento->updateDocumento($idDocumento, $item);
                    break;
                }
                next($item);
            }
        }
    }
	
	function descargarArchivo($idDocumento)
	{
		//Datos sobre el archivo
		$documento=$this->FianzaDocumento->getDocumento($idDocumento);
		$datos=$this->FianzaDocumento->getDatosBitacora($idDocumento);
		
		//Insertar en la bitacora 
		$this->load->model("Bitacora");
		$idUsuario=$this->session->userdata("iduser");
		$fecha=date("Y-m-d");
		$hora=date("H:i:s");
		$idModulo=9;
		$accion="Descarga";
		$texto="Proyecto ".$datos['idProyecto']." ".$datos['nombreProyecto'].
		" / Contrato ".$datos['idContratoProyecto']." ".$datos['nomenclatura'].
		" / Fianza ".$datos['idFianza']." ".$datos['nombre'].
		" / Documento ".$datos['idFianzaDocumento']." ".$datos['nombreDocumento'];
		
		
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
		force_download('assets/fileUpload/FianzaDocumento/'.$documento['documento'], NULL);
		
	}
	

}