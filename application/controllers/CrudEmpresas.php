<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudEmpresas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Empresas');
        $this->load->library('session');
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 11)))
        {
            die($this->load->view("viewErrorPermiso", null, true));
        }

    }
    function index()
    {
        $data['infoEmpresa']=$this->Empresas->getDatos();

        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 11);
        $data['permisosDocumento']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 23);
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoEmpresas', $data, TRUE);

    }
    function altaEmpresa()
    {

        print $this->load->view('formEmpresa', '', TRUE);

    }

    function nuevaEmpresa($numeroDocumentosOpcionales)
    {
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('RFC', 'RFC', 'trim|required|min_length[12]|max_length[13]');
        $this->form_validation->set_rules('razon_social', 'razón social', 'trim|required|min_length[3]|max_length[100]');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $idEmpresa=$this->Empresas->nuevaEmpresa(array('nombre' => $this->input->post('nombre'), 'RFC' => $this->input->post('RFC'), 'razon_social' => $this->input->post('razon_social')));
        //sube los documentos requeridos:
        $nombreActa=$this->subirDocumento('acta_constitutiva');
        if(!empty($nombreActa))
            $this->Empresas->insertDocumentoCliente(array('idCliente' => $idEmpresa, 'nombreDocumento' => 'Acta constitutiva','documento' => $nombreActa, 'observaciones' => ''));
        $nombrePoderRepLegal=$this->subirDocumento('poder_rep_legal');
        if(!empty($nombrePoderRepLegal))
            $this->Empresas->insertDocumentoCliente(array('idCliente' => $idEmpresa, 'nombreDocumento' => 'Poder del representante legal','documento' => $nombrePoderRepLegal, 'observaciones' => ''));
        $nombreCedula=$this->subirDocumento('cedula_fiscal');
        if(!empty($nombreCedula))
            $this->Empresas->insertDocumentoCliente(array('idCliente' => $idEmpresa, 'nombreDocumento' => 'Cédula fiscal','documento' => $nombreCedula, 'observaciones' => ''));
        $nombreComprobante=$this->subirDocumento('comprobante_domicilio');
        if(!empty($nombreComprobante))
            $this->Empresas->insertDocumentoCliente(array('idCliente' => $idEmpresa, 'nombreDocumento' => 'Comprobante domicilio','documento' => $nombreComprobante, 'observaciones' => ''));
        $ine=$this->subirDocumento('INERepresentanteLegal');
        if(!empty($ine))
            $this->Empresas->insertDocumentoCliente(array('idCliente' => $idEmpresa, 'nombreDocumento' => 'INE del representante legal','documento' => $ine, 'observaciones' => ''));
        //sube los documentos opcionales:
        for ($i=0; $i<$numeroDocumentosOpcionales; $i++)
        {
            //si no esta vacio, inserta el nuevo documento
            if($this->input->post('nombreOtroDocumento'.$i))
                $this->Empresas->insertDocumentoCliente(array('idCliente' => $idEmpresa,
                    'nombreDocumento' => $this->input->post('nombreOtroDocumento'.$i),
                    'documento' => $this->subirDocumento('otroDocumento'.$i),
                    'observaciones' => $this->input->post('observacionOtroDocumento'.$i)));
        }

    }

    function editarEmpresa()
    {
        $this->form_validation->set_rules('id', 'identificador', 'required|numeric|trim');

        $id=$this->input->post('id');

        if ($this->input->post('action') == 'edit')
        {
            $nombre=$this->input->post('nombre');
            $RFC=$this->input->post('RFC');
            $razon_social=$this->input->post('razon_social');

            if(!empty($nombre))
            {

                $this->form_validation->set_rules('nombre', 'nombre', 'trim|required|min_length[3]|max_length[100]');
                if($this->form_validation->run()==false)
                {
                    header('HTTP/1.1 500 Internal Server ');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
                }
                $this->Empresas->editarEmpresa(array('nombre' => $nombre), $id);
            }

            else if(!empty($RFC))
            {

                $this->form_validation->set_rules('RFC', 'RFC', 'trim|required|min_length[12]|max_length[13]');
                if($this->form_validation->run()==false)
                {
                    header('HTTP/1.1 500 Internal Server ');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
                }
                $this->Empresas->editarEmpresa(array('RFC' => $RFC), $id);
            }

            else if(!empty($razon_social))
            {

                $this->form_validation->set_rules('razon_social', 'razón social', 'trim|required|min_length[3]|max_length[100]');
                if($this->form_validation->run()==false)
                {
                    header('HTTP/1.1 500 Internal Server ');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
                }
                $this->Empresas->editarEmpresa(array('razon_social' => $razon_social), $id);
            }



        }

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
        $id=$this->input->post('id');

        $this->Empresas->borrarEmpresa($id);
        echo $id;

    }

    function subirDocumento($nombreCampo)
    {

        if(!file_exists("assets/img/fotoEmpresas") && !is_dir("assets/img/fotoEmpresas")) {

            mkdir("assets/img/fotoEmpresas");

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

                $target = "assets/img/fotoEmpresas" . $nombre;

                if(move_uploaded_file($images['tmp_name'], $target))

                {

                    return $nombre;

                }

                else

                {

                    echo "no se pudo mover la imagen";

                    return null;

                }

            }

        }



    }

    function traerDocumentos($idEmpresa)
    {
        echo json_encode($this->Empresas->traerDocumentos($idEmpresa));

    }

    function descargarDocumento($documento="")
    {

        $this->load->helper('download');

        if(!empty($documento))

            force_download('assets/img/fotoEmpresas/'.$documento, NULL);

    }

    function borrarArchivo($archivo)
    {

        $this->Empresas->borrarArchivo($archivo);
        unlink('assets/img/fotoEmpresas/'.$archivo);
    }

    function cambiarDocumento($idClienteDocumento)
    {

        $nombreDoc=$this->subirDocumento($this->input->post("documento"));
        if(!empty($nombreDoc))
        {
            unlink('assets/img/fotoEmpresas/'.$this->Empresas->getNombreDocumento($idClienteDocumento));
            $this->Empresas->editarClienteDocumento(array("documento" => $nombreDoc), $idClienteDocumento);
            echo "ok";
        }

    }
    function subirDocumentoOpcional($idEmpresa, $numeroDocumentosOpcionales)
    {
        for ($i=0; $i<$numeroDocumentosOpcionales; $i++)
        {
            $this->form_validation->set_rules('nombreOtroDocumento'.$i, 'nombre del documento '.$i, 'required');
        }
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        //sube los documentos opcionales:
        for ($i=0; $i<$numeroDocumentosOpcionales; $i++)
        {
            //si no esta vacio, inserta el nuevo documento
            if($this->input->post('nombreOtroDocumento'.$i))
                $this->Empresas->insertDocumentoCliente(array('idCliente' => $idEmpresa,
                    'nombreDocumento' => $this->input->post('nombreOtroDocumento'.$i),
                    'documento' => $this->subirDocumento('otroDocumento'.$i),
                    'observaciones' => $this->input->post('observacionOtroDocumento'.$i)));
        }

    }
	
	function descargarDocumentoEmpresa($idDocumento)
	{	
		//Datos sobre el archivo
		$documento=$this->Empresas->getUnDocumento($idDocumento);
		$datos=$this->Empresas->getDatosBitacora($idDocumento);

		//Insertar en la bitacora 
		$this->load->model("Bitacora");
		$idUsuario=$this->session->userdata("iduser");
		$fecha=date("Y-m-d");
		$hora=date("H:i:s");
		$idModulo=23;
		$accion="Descarga";
		$texto="Cliente ó proveedor ".$datos['idEmpresa']." - ".$datos['nombre'].
		" / Documento ".$datos['idClienteDocumento']." - ".$datos['nombreDocumento'];
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
		force_download('assets/img/fotoEmpresas/'.$documento['documento'], NULL);

	}

}