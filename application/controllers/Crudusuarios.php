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
        $idUsuario = $this->session->userdata("iduser");
        if (empty($idUsuario)) {
            die($this->load->view("viewSesionCaducada", null, true));
        } else if ((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 0))) {
            die($this->load->view("viewErrorPermiso", null, true));

        }
    }

    public function index()
    {

        $data['Usuario'] = $this->usuarios->getDatos();
        $data['areaUs'] = $this->usuarios->getAreaUs();
        $data['TipoU'] = $this->usuarios->getTipa();

        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'),0);
        $data['permisosExpediente']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'),25);
        $data['empresas']=$this->usuarios->getEmpresasInternas();
        $data['tiposContrato']=$this->usuarios->getTiposContrato();

        $data = $this->security->xss_clean($data);
        print $string = $this->load->view('viewTodoUsuarios', $data, TRUE);

    }

    function editaDatos()
    {
        $idUser = $this->input->post('idUser');
        $this->form_validation->set_rules('idUser', 'identificador', 'trim|required|numeric');
        $password = $this->input->post('password');
        $nombrUs = $this->input->post('nombrUs');
        $nickN = $this->input->post('nickN');

        $correoD = $this->input->post('correoD');
        $idAre = $this->input->post('idAre');
        $idTip = $this->input->post('idTip');
        if (!empty($password)) {
            $password = $this->encryption->encrypt($password);
            $data = array(
                'passwordUser' => $password
            );
            $this->usuarios->modificaDatos($data, $idUser);
        }
        if (!empty($nombrUs)) {
            $this->form_validation->set_rules('nombrUs', 'Usuario', 'trim|required|min_length[2]|max_length[300]');
            if ($this->form_validation->run() == FALSE) {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'nombreUser' => $nombrUs
            );
            $this->usuarios->modificaDatos($data, $idUser);
        }
        if (!empty($nickN)) {
            $this->form_validation->set_rules('nickN', 'Nickname', 'trim|required|min_length[2]|is_unique[Usuarios.nickName]');
            if ($this->form_validation->run() == FALSE) {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'nickName' => $nickN
            );
            $this->usuarios->modificaDatos($data, $idUser);
        }

        if (!empty($correoD)) {
            $this->form_validation->set_rules('correoD', 'Email', 'trim|required|min_length[2]|valid_email');
            if ($this->form_validation->run() == FALSE) {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'correoDestino' => $correoD
            );
            $this->usuarios->modificaDatos($data, $idUser);
        }
        if (!empty($idAre)) {
            $this->form_validation->set_rules('idAre', 'Área de usuario', 'trim|required|numeric');
            if ($this->form_validation->run() == FALSE) {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'idArea' => $idAre
            );
            $this->usuarios->modificaDatos($data, $idUser);
        }
        if (!empty($idTip)) {
            $this->form_validation->set_rules('idTip', 'Tipo de usuario', 'trim|required|numeric');
            if ($this->form_validation->run() == FALSE) {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'idTipo' => $idTip
            );
            $this->usuarios->modificaDatos($data, $idUser);
        }
    }

    function altaUsuarios()
    {
        $data['areaUs'] = $this->usuarios->getAreaUs();
        $data['TipoU'] = $this->usuarios->getTipa();
        $data = $this->security->xss_clean($data);
        print $this->load->view('formUsuarios', $data, TRUE);
    }

    function nuevoUser()
    {

        $this->form_validation->set_rules('nameUser', 'Usuario', 'trim|required|min_length[2]|max_length[300]');
        $this->form_validation->set_rules('nickName', 'Nickname', 'trim|required|min_length[2]|is_unique[Usuarios.nickName]');
        $this->form_validation->set_rules('passwordUs', 'Password', 'trim|required|min_length[2]|max_length[64]');
        $this->form_validation->set_rules('correoDesti', 'Email', 'trim|required|min_length[2]|valid_email');
        $this->form_validation->set_rules('idTip', 'Tipo de usuario', 'trim|required|numeric');
        $this->form_validation->set_rules('idAre', 'Área de usuario', 'trim|required|numeric');


        $nameUser = $this->input->post('nameUser');
        $nickName = $this->input->post('nickName');
        $passwordUs = $this->encryption->encrypt($this->input->post('passwordUs'));
        $correoDesti = $this->input->post('correoDesti');
        $idAre = $this->input->post('idAre');
        $idTip = $this->input->post('idTip');

        if ($this->form_validation->run() == FALSE) {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $datos = array(
            'nombreUser' => $nameUser,
            'nickName' => $nickName,
            'passwordUser' => $passwordUs,
            'correoDestino' => $correoDesti,
            'idArea' => $idAre,
            'idTipo' => $idTip,
            'Status' => 0
        );
        $this->usuarios->insertaDatos($datos);
    }

    function verExpendienteUsuario($idUser)
    {

      
        $usuario=$this->usuarios->getDatosUsuario($idUser);
        $data['usuario']=$usuario['nombreUser'];
        

        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 25);
		$data['idUser']=$idUser;
        $data['documentos']=$this->usuarios->getDocumentosUsuarios($idUser);

        $data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoExpedienteUsuarios", $data, TRUE);
    }

    function descargarExpediente($idDocumentoUsuario, $idUsuario)
    {

        $documentoUsuario=$this->usuarios->getDocumento($idDocumentoUsuario, $idUsuario);
        $usuario=$this->usuarios->getDatosUsuario($idUsuario);

        $this->load->model("Bitacora");


        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $idModulo=25;
        $accion="Descarga";
        $texto="Usuario $idUsuario - ".$usuario['nickName']." / Expediente de usuario ".$idDocumentoUsuario." - ".$documentoUsuario['nombreDocumento'];

        $idUsuario=$this->session->userdata("iduser");
        $data=array(
            'idUsuario'=>$idUsuario,
            'fechaAccion'=>$fecha,
            'horaAccion'=>$hora,
            'idModulo'=>$idModulo,
            'accion'=>$accion,
            'texto'=>$texto
        );
        $this->Bitacora->insertar($data);

        $this->load->helper("download");
        force_download('assets/img/fotoUsuarios/'.$documentoUsuario['documento'], null);
    }
	function nuevoDocumento($idUser, $numeroDocumentos,$numeroAntDocmentos)
    {		
		for ($i=0; $i<$numeroDocumentos; $i++){  
			$this->form_validation->set_rules('nombreOtroDocumento'.$i, 'nombre del archivo nuevo con número '.($i+1), 'trim|required|max_length[200]');
			$this->form_validation->set_rules('observacionOtroDocumento'.$i, 'de observaciones del archivo nuevo con número '.($i+1), 'trim');
		}
		for($i=0; $i<$numeroAntDocmentos; $i++)
		{
			

			$this->form_validation->set_rules('documento'.$i, 'identificador del documento '.($i+1), 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('docBandera'.$i, 'bandera del documento '.($i+1), 'trim|required|is_natural|greater_than_equal_to[0]|less_than_equal_to[1]');
			$this->form_validation->set_rules('nombreDocumentoUsuario'.$i, 'nombre del documento ya registrado con número '.($i+1), 'trim|required|max_length[200]');
			$this->form_validation->set_rules('observacionDocumentoUsuario'.$i, 'de observaciones del archivo ya registrado con número '.($i+1), 'trim');
		}
		if($this->form_validation->run()){
			//Aqui se hace la insersión de nuevos documentos
			for ($i=0; $i<$numeroDocumentos; $i++){           
					if($this->input->post('nombreOtroDocumento'.$i))
						$this->usuarios->insertDocumentoUsuario(
							array(
								'idUser' => $idUser,
								'nombreDocumento' => $this->input->post('nombreOtroDocumento'.$i),
								'documento' => $this->subirDocumento('otroDocumento'.$i),
								'observaciones' => $this->input->post('observacionOtroDocumento'.$i)));
			}//Aqui se hace la actualización de documentos ya existentes
			for($j=0; $j<$numeroAntDocmentos; $j++)
			{
				
				$idDocument=$this->input->post('documento'.$j);
				$valBandera=$this->input->post('docBandera'.$j);
				
				if($valBandera==1)
				{
					$documentoBD=$this->usuarios->getDocumento($idDocument,$idUser);
					unlink("assets/img/fotoUsuarios/".$documentoBD['documento']);
					$nuevoDoc = $this->subirDocumento('DocumentoUsuario'.$j);
					$this->usuarios->modificaDocumentoUsuarios($idDocument,
						array('documento' => $nuevoDoc));
					
				}
				
				$this->usuarios->modificaDocumentoUsuarios($idDocument,
						array(
							'nombreDocumento' => $this->input->post('nombreDocumentoUsuario'.$j),
							'observaciones' => $this->input->post('observacionDocumentoUsuario'.$j)));
							
			}
		}
		else{
				header('HTTP/1.1 500 Internal Server ');
				header('Content-Type: application/json; charset=UTF-8');
				die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
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
        $permisos=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 15);
		if($permisos['eliminar'])
		{	
			$expresionRegular="[A-Za-z0-9]{31,33}\.[A-Za-z]{2,5}";
			$this->form_validation->set_rules('nombre', 'nombre del archivo', 'trim|required|min_length[35]|max_length[150]');
			if($this->form_validation->run()){
				
				$archivo=$this->input->post("nombre");
				$this->usuarios->borrarArchivo($archivo);
				unlink('assets/img/fotoUsuarios/'.$archivo);
			}
			else{
				header('HTTP/1.1 500 Internal Server ');
				header('Content-Type: application/json; charset=UTF-8');
				die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
			}	
		}
    }

	
	function traerDocumentos($idUser)
    {
        echo json_encode($this->usuarios->traerDocumentos($idUser));
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

     function activarStatusUsuario($idUsuario)
    {
        $this->usuarios->modificaDatos(array('Status' => 0), $idUsuario);
    }

    function desactivarStatusUsuario($idUsuario)
    {
        $this->usuarios->modificaDatos(array('Status' => 1), $idUsuario);
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