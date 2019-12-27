<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Crudusuarios extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("usuarios");
        $this->load->library('session');
		$this->load->library('encryption');
        $this->key = bin2hex($this->encryption->create_key(16));
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 0)))
        {
            die($this->load->view("viewErrorPermiso", null, true));

        }
    }
    public function index()
    {

        $data['Usuario'] = $this->usuarios->getDatos();
        $data['areaUs'] = $this->usuarios->getAreaUs();
        $data['TipoU'] = $this->usuarios->getTipa();
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'),0);
        $data['empresas']=$this->usuarios->getEmpresasInternas();
        $data['tiposContrato']=$this->usuarios->getTiposContrato();
        $data = $this->security->xss_clean($data);
        print $string = $this->load->view('viewTodoUsuarios',$data, TRUE);

    }

    function editaDatos()
    {
        $idUser=$this->input->post('idUser');
        $this->form_validation->set_rules('idUser', 'identificador', 'trim|required|numeric');
		$password = $this->encryption->encrypt($this->input->post('password'));
        $nombrUs=$this->input->post('nombrUs');
        $nickN=$this->input->post('nickN');

        $correoD=$this->input->post('correoD');
        $idAre=$this->input->post('idAre');
        $idTip=$this->input->post('idTip');
		if (!empty($password)) {
			
			//echo "data ".$password;
			
            $data = array(
                'passwordUser' => $password
            );
            $this->usuarios->modificaDatos($data,$idUser);
		}
        if (!empty($nombrUs)) {
            $this->form_validation->set_rules('nombrUs', 'Usuario', 'trim|required|min_length[2]|max_length[300]');
            if ($this->form_validation->run() == FALSE)
            {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'nombreUser' => $nombrUs
            );
            $this->usuarios->modificaDatos($data,$idUser);
        }
        if (!empty($nickN)) {
            $this->form_validation->set_rules('nickN', 'Nickname', 'trim|required|min_length[2]|is_unique[Usuarios.nickName]');
            if ($this->form_validation->run() == FALSE)
            {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'nickName' => $nickN
            );
            $this->usuarios->modificaDatos($data,$idUser);
        }

        if (!empty($correoD)) {
            $this->form_validation->set_rules('correoD', 'Email', 'trim|required|min_length[2]|valid_email');
            if ($this->form_validation->run() == FALSE)
            {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'correoDestino' => $correoD
            );
            $this->usuarios->modificaDatos($data,$idUser);
        }
        if (!empty($idAre)) {
            $this->form_validation->set_rules('idAre', 'Área de usuario', 'trim|required|numeric');
            if ($this->form_validation->run() == FALSE)
            {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'idArea' => $idAre
            );
            $this->usuarios->modificaDatos($data,$idUser);
        }
        if (!empty($idTip)) {
            $this->form_validation->set_rules('idTip', 'Tipo de usuario', 'trim|required|numeric');
            if ($this->form_validation->run() == FALSE)
            {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'idTipo' => $idTip
            );
            $this->usuarios->modificaDatos($data,$idUser);
        }
    }

    function altaUsuarios()
    {
        $data['areaUs'] = $this->usuarios->getAreaUs();
        $data['TipoU'] = $this->usuarios->getTipa();
        $data = $this->security->xss_clean($data);
        print $this->load->view('formUsuarios',$data, TRUE);
    }

    function nuevoUser()
    {

        $this->form_validation->set_rules('nameUser', 'Usuario', 'trim|required|min_length[2]|max_length[300]');
        $this->form_validation->set_rules('nickName', 'Nickname', 'trim|required|min_length[2]|is_unique[Usuarios.nickName]');
        $this->form_validation->set_rules('passwordUs', 'Password', 'trim|required|min_length[2]|max_length[64]');
        $this->form_validation->set_rules('correoDesti', 'Email', 'trim|required|min_length[2]|valid_email');
        $this->form_validation->set_rules('idTip', 'Tipo de usuario', 'trim|required|numeric');
        $this->form_validation->set_rules('idAre', 'Área de usuario', 'trim|required|numeric');


		$nameUser=$this->input->post('nameUser');
        $nickName=$this->input->post('nickName');
		$passwordUs = $this->encryption->encrypt($this->input->post('passwordUs'));
        $correoDesti=$this->input->post('correoDesti');
        $idAre=$this->input->post('idAre');
        $idTip=$this->input->post('idTip');

        if ($this->form_validation->run() == FALSE)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $datos=array(
            'nombreUser' => $nameUser,
            'nickName' => $nickName,
            'passwordUser' => $passwordUs,
            'correoDestino' => $correoDesti,
            'idArea' => $idAre,
            'idTipo' => $idTip
        );
        $this->usuarios->insertaDatos($datos);
    }
	
	function verExpendienteUsuario($idUser)
    {
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 15);
		$data['idUser']=$idUser;
		$data['idDocumentoUser']=$this->usuarios->getDocumentosUsuarios($idUser);
		$data['nombreDocumento']=$this->usuarios->getDocumentosUsuarios($idUser);
		$data['observaciones']=$this->usuarios->getDocumentosUsuarios($idUser);
        $data['documentos']=$this->usuarios->getDocumentosUsuarios($idUser);
        $data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoExpedienteUsuarios", $data, TRUE);
    }
	
	function nuevoDocumento($idUser, $numeroDocumentos)
    {	
        for ($i=0; $i<$numeroDocumentos; $i++)
        {
			$data['nombreDocumento']=$this->usuarios->getDocumentosUsuarios($idUser);
			foreach($nombredoc as $key1){
					$nombredoc1=$key1['nombreDocumento'];
					
				}
            if($nombredoc1=='')
			{
				if($this->input->post('nombreOtroDocumento'.$i))
					$this->usuarios->insertDocumentoUsuario(
						array(
							'idUser' => $idUser,
							'nombreDocumento' => $this->input->post('nombreOtroDocumento'.$i),
							'documento' => $this->subirDocumento('otroDocumento'.$i),
							'observaciones' => $this->input->post('observacionOtroDocumento'.$i)));
			}else{
				
				$data['idDocumentoUser']=$this->usuarios->getDocumentosUsuarios($idUser);
				foreach($idDocument as $key){
					$idDocumento=$key['idDocumentoUser'];
					
				}
				//echo "dato ".$idDocumento;
				
				$this->usuarios->modificaDocumentoUsuarios($idDocumento,
					array(
						'idUser' => $idUser,
						'nombreDocumento' => $this->input->post('nombreOtroDocumento'.$i),
						'observaciones' => $this->input->post('observaciones'.$i)));
			}
		}
    }
	
	function subirDocumento($nombreCampo)
    {
        if(!file_exists("assets/img/fotoUsuarios") && !is_dir("assets/img/fotoUsuarios")) {
            mkdir("assets/img/fotoUsuarios");
        }
        $success = null;
        $paths= array();
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
                $target = "assets/img/fotoUsuarios/" . $nombre;
				echo json_encode($images)." -> ".$target;
                if(move_uploaded_file($images['tmp_name'], $target))
                {
                    return $nombre;
                }
                else
                {
                    echo "<br>no se pudo mover la imagen";
					header('HTTP/1.1 500 Internal Server ');
					header('Content-Type: application/json; charset=UTF-8');
					die(json_encode(array('message' => 'No se pudieron guardar los archivos.', 'code' => 1337)));
                    return null;
                }
            }
        }
    }
	
	function borrarArchivo()
    {
		$archivo=$this->input->post("nombre");
        $this->usuarios->borrarArchivo($archivo);
        unlink('assets/img/fotoUsuarios/'.$archivo);
    }

	
	function traerDocumentos($idUser)
    {
        echo json_encode($this->usuarios->traerDocumentos($idEmpresa));

    }

    function borrarUser()
    {
        $this->form_validation->set_rules('id', 'identificador', 'trim|required|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $id=$this->input->post('id');

        $this->usuarios->borrarDatos($id);
        echo $id;
    }
    function cargarEmpresasUsuario($idUsuario)
    {
        echo json_encode($this->usuarios->cargarEmpresasUsuario($idUsuario));
    }
    function eliminarEmpresaUsuario($idEmpresa, $idUsuario)
    {
        $this->usuarios->borrarEmpresaUsuario($idEmpresa, $idUsuario);
    }
    function asignarEmpresaUsuario($idEmpresa, $idUsuario)
    {
        $this->usuarios->asignarEmpresaUsuario(array('idUsuario' => $idUsuario,'idEmpresaInterna' =>$idEmpresa));
    }

// funciones para tipoContrato
//
    function cargarTiposContrato($idUsuario)
    {
        echo json_encode($this->usuarios->cargarTiposContrato($idUsuario));
    }
    function asignarTiposContrato($idTipoC, $idUsuario)
    {
        $this->usuarios->asignarTiposContrato(array('idUsuario' => $idUsuario,'idTipoContrato' =>$idTipoC));
    }
    function eliminarTiposContrato($idtipo, $idUsuario)
    {
        $this->usuarios->borrarTiposContrato($idtipo, $idUsuario);
    }
}