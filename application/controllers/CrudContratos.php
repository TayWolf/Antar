<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class CrudContratos extends CI_Controller

{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Contratos');
        $this->load->library('session');
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 3)))
        {
            die($this->load->view("viewErrorPermiso", null, true));
        }

    }

    function index()
    {
        $data['infoContrato']=$this->Contratos->getDatos();

        $data['permisosContrato']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 3);
        $data['permisosTiposContrato']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 4);
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoContratos', $data, TRUE);
    }
    function altaContrato()
    {
        print $this->load->view('formContrato', '', TRUE);
    }

    function altatipoContrato($idContrato)
    {
        $data ['idContrato'] = $idContrato;
        $data = $this->security->xss_clean($data);
        print $this->load->view('formTipoContrato', $data, TRUE);
    }

    function tipoTemplate($idTipoco,$idContrato)
    {
        $data ['idContrato'] = $idContrato;
        $data ['idTipoco'] = $idTipoco;
        $data['nombreTipoCon']=$this->Contratos->getNombreCt($idTipoco);
        $data = $this->security->xss_clean($data);
        print $this->load->view('formTemplateTipoContrato', $data, TRUE);
    }

    function descargarPlantilla($idTipoContrato)
    {
        #assets/fileUpload/plantillasTipos/
        $this->load->helper("download");
        $contrato=$this->Contratos->getTipoContrato($idTipoContrato);

        $this->load->model("Bitacora");
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $idModulo=4;
        $accion="Descarga";
        $texto="Contrato ".$contrato['idContrato']." - ".$contrato['nombre']." / Tipo de contrato ".$contrato['idTipoC']." - ".$contrato['nombreTipo'];
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

        force_download('assets/fileUpload/plantillasTipos/'.$contrato['template'], null);
    }
    function nuevoContrato()
    {
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required|min_length[3]|max_length[150]');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $nombre=$this->input->post('nombre');
        $carpetaId=$this->Contratos->nuevoContrato(array('nombre' => $nombre));
        if (mkdir("assets/fileUpload/".$carpetaId, 07777,true))
            echo "se creo";
    }

    function nuevoTipoContrato()
    {
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required|min_length[3]|max_length[250]');
        $this->form_validation->set_rules('claveC', 'clave de contrato', 'trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('idContrato', 'id', 'trim|required|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }

        $nombre=$this->input->post('nombre');
        $claveC=$this->input->post('claveC');
        $idContrato=$this->input->post('idContrato');
        $nombre_archivoima = $_FILES['templateN']['name'];
        $tipo_archivoima = $_FILES['templateN']['type'];
        $tamano_archivoima = $_FILES['templateN']['size'];
        $temp_archivoima = $_FILES['templateN']['tmp_name'];
        $ext = explode('.', basename($nombre_archivoima));
        $foto=DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
        if(!file_exists("assets/fileUpload/plantillasTipos/") && !is_dir("assets/fileUpload/plantillasTipos/"))
        {
            mkdir("assets/fileUpload/plantillasTipos/");
        }
        if($nombre_archivoima==""){
            $data=array(
                'nombreTipo' => $nombre,
                'claveContrato' => $claveC,
                'template' => "",
                'idContrato' => $idContrato
            );
            $llavePrimaria=$this->Contratos->nuevoTipContrato($data);
        }
        else
        {
            $ruta="assets/fileUpload/plantillasTipos/".$foto;
            $data = array(
                'nombreTipo' => $nombre,
                'claveContrato' => $claveC,
                'template' => $foto,
                'idContrato' => $idContrato
            );
            $llavePrimaria=$this->Contratos->nuevoTipContrato($data);
            move_uploaded_file($temp_archivoima, $ruta);
        }



    }

    function todoTiposContratos($idContrato)
    {

        $data ['idContrato'] = $idContrato;
        $data['tipoContr']=$this->Contratos->getTiposContratos($idContrato);
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 4);
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewtodotipocontratos',$data, TRUE);
    }

    function editarContrato()
    {
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required|min_length[3]|max_length[150]');
        $this->form_validation->set_rules('id', 'id', 'trim|required|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $id=$this->input->post('id');
        if ($this->input->post('action') == 'edit')

        {
            $nombre=$this->input->post('nombre');
            $this->Contratos->editarContrato(array('nombre' => $nombre), $id);
        }
    }

    function editartiposContrato()
    {
        $this->form_validation->set_rules('idT', 'identificador', 'trim|required|numeric');
        $idT=$this->input->post('idT');
        $nombreTipC=$this->input->post('nombreTipC');
        $claveCo=$this->input->post('claveCo');

        if (!empty($nombreTipC)) {
            $this->form_validation->set_rules('nombreTipC', 'nombre', 'trim|required|min_length[3]|max_length[250]');

            if($this->form_validation->run()==false)
            {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'nombreTipo' => $nombreTipC
            );
            $this->Contratos->modificaTipoc($data,$idT);
        }
        if (!empty($claveCo)) {
            $this->form_validation->set_rules('claveCo', 'clave de contrato', 'trim|required|min_length[2]|max_length[100]');
            if($this->form_validation->run()==false)
            {
                header('HTTP/1.1 500 Internal Server ');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
            }
            $data = array(
                'claveContrato' => $claveCo
            );
            $this->Contratos->modificaTipoc($data,$idT);
        }

    }

    function borrarTipoContrato()
    {
        $this->form_validation->set_rules('id', 'identificador', 'trim|required|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $id=$this->input->post('id');
        //Código para borrar el archivo anterior
        $archivoAnterior=$this->Contratos->borrarPlantilla($id);
        unlink("assets/fileUpload/plantillasTipos/".$archivoAnterior);
        //Fin del código de borrar archivos anteriores
        $this->Contratos->borrarTipoContrato($id);
    }

    function borrarContrato()
    {
        $this->form_validation->set_rules('id', 'identificador', 'trim|required|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $id=$this->input->post('id');

        $this->Contratos->borrarContrato($id);

        echo $id;

    }

    function subirTemplate()
    {
        $nombre_archivoima = $_FILES['plantillaTip']['name'];
        $tipo_archivoima = $_FILES['plantillaTip']['type'];
        $tamano_archivoima = $_FILES['plantillaTip']['size'];
        $temp_archivoima = $_FILES['plantillaTip']['tmp_name'];
        $foto=$nombre_archivoima;
        $ext = explode('.', basename($nombre_archivoima));
        $nombreArchi=DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
        if(!file_exists("assets/fileUpload/plantillasTipos/") && !is_dir("assets/fileUpload/plantillasTipos/"))
        {
            mkdir("assets/fileUpload/plantillasTipos/");
        }
        $idTipoc = $this->input->post('idTipP');
        $ruta="assets/fileUpload/plantillasTipos/".$nombreArchi;

        //Código para borrar el archivo anterior
        $archivoAnterior=$this->Contratos->borrarPlantilla($idTipoc);
        unlink("assets/fileUpload/plantillasTipos/".$archivoAnterior);
        //Fin del código de borrar archivos anteriores

        move_uploaded_file($temp_archivoima, "assets/fileUpload/plantillasTipos/".$nombreArchi);
        $data = array(
            'template' => $nombreArchi
        );
        $this->Contratos->updatePlantilla($data,$idTipoc);
        echo "1";
    }

}