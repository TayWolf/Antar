<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudArchivoMuerto extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("ArchivoMuerto");
        $this->load->model("Proyectos");
        $this->load->model("Permisos");

        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 16)))
        {
            die($this->load->view("viewErrorPermiso", null, true));
        }


    }

    function index()
    {

        $data['solicitudes']=$this->ArchivoMuerto->cargarContratosTerminados($this->session->userdata("iduser"));
        $data['getPr'] = $this->Proyectos->getPr();
        $data['proyectoIndividual']=0;
        $data['posiblesEstados']=$this->Proyectos->getAllStatus();

        //permisos de contratos de proyecto
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 16);
        //permisos de fianzas
        $data['permisosFianzas']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 8);
        //permisos de versiones
        $data['permisosVersiones']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 10);
        //permisos de versiones
        $data['permisosStatusContrato']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 5);

        $data['idProyecto']=null;
        //No tiene valor porque se quieren ver todos los contratos
        $data['idEmpresaInterna']=null;
        //Código para exportar la tabla
        $data['fechaInicial']=null;
        $data['fechaFinal']=null;
        $data['statusSeleccionado']=null;



        $data['exportarTerminados']=1;
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoArchivoMuerto', $data, TRUE);
    }

    function verFianzasContratoProyecto($idContratoProyecto, $verBoton=true)
    {

        $data['idContratoProyecto'] = $idContratoProyecto;
        $data['sinContratoProyecto']=$idContratoProyecto;

        $data['idProyecto'] = $this->Proyectos->getIdProyecto($idContratoProyecto);
        $data['idProyecto'] = $data['idProyecto']['idProyecto'];
        $data['fianzasContratos'] = $this->Proyectos->getFianzasContratos($idContratoProyecto);
        $data['fianzaIndividual']=true;
        $data['verbotonregresar']=$verBoton;

        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 8);
        $data['permisosDocumentosFianza']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 9);

        //Estos campos no son necesarios, pero los requiere la vista pues se comparte con el CrudDashboard

        $data['fechaInicial']=null;
        $data['fechaFinal']=null;
        $data['idVigencia']=null;
        $data['idPago']=null;
        $data['idEmpresaInterna']=null;
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoFianzasContratoArchivoMuerto', $data, TRUE);
    }
    function verDetalleContrato($idContratoProyecto, $verBoton=true)
    {

        $data = array('idContratoProyecto' => $idContratoProyecto);
        $data['idProyecto'] = $this->Proyectos->getIdProyecto($idContratoProyecto);
        $data['idProyecto'] = $data['idProyecto']['idProyecto'];
        $data['contrato'] = $this->Proyectos->getContrato();
        $data['idContrato'] = $this->Proyectos->getContratoProyecto($idContratoProyecto);
        $idContratoSeleccionado = $data['idContrato']['idContrato'];
        $data['tiposContrato'] = $this->Proyectos->getTiposContrato($idContratoSeleccionado);
        $data['getPr'] = $this->Proyectos->getPr($data['idProyecto']);
        $data['EmpreGet'] = $this->Proyectos->getEmpresas();
        $data['verbotonregresar']=$verBoton;
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewSolicitudArchivoMuerto', $data, TRUE);
    }


    function verVersiones($idContratoProyecto, $verBoton=true)
    {
        $data['idContratoProyecto']=$idContratoProyecto;
        $data['idProyecto'] = $this->Proyectos->getIdProyecto($idContratoProyecto);
        $data['idProyecto'] = $data['idProyecto']['idProyecto'];
        $data['versiones']=$this->Proyectos->getAllVersiones($idContratoProyecto);
        $data['verbotonregresar']=$verBoton;

        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 10);
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoVersionesContratoArchivoMuerto', $data, TRUE);
    }
    function verDocumentos($idFianza, $idContratoProyecto, $verBoton=true)
    {
        $this->load->model("FianzaDocumento");
        $data['idFianza']=$idFianza;
        $data['idContratoProyecto']=$idContratoProyecto;
        $data['documentos']=$this->FianzaDocumento->getAllDocumentos($idFianza);
        $data['verbotonregresar']=$verBoton;

        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 9);
        $data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoFianzaDocumentoArchivoMuerto', $data, TRUE);
    }
    function descargarArchivoRel($idDocumento)
    {
        //Datos sobre el archivo
        $documento=$this->Proyectos->getDocumentoRelicion($idDocumento);
        $datos=$this->Proyectos->getDatosBitacoraRel($idDocumento);

        //Insertar en la bitacora
        $this->load->model("Bitacora");
        $idUsuario=$this->session->userdata("iduser");
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $idModulo=16;
        $accion="Descarga";
        $texto="Proyecto ".$datos['idProyecto']." ".$datos['nombreProyecto'].
            " / Contrato ".$datos['idContratoProyecto']." ".$datos['nomenclatura'].
            " / Redición ".$datos['idVersionContrato']." ".$datos['nomenclatura'];


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
        force_download('assets/fileUpload/contratoProyecto/'.$datos['idContratoProyecto'].'/'.$documento['archivo'], NULL);
    }
    function descargarArchivoDetalles($idDocumento)
    {
        //Datos sobre el archivo
        $documento=$this->Proyectos->getDocumentoDetalles($idDocumento);
        $datos=$this->Proyectos->getDatosBitacoraDetalles($idDocumento);

        //Insertar en la bitacora
        $this->load->model("Bitacora");
        $idUsuario=$this->session->userdata("iduser");
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $idModulo=16;
        $accion="Descarga";
        $texto="Proyecto ".$datos['idProyecto']." ".$datos['nombreProyecto'].
            " / Contrato ".$datos['idContratoProyecto']." ".$datos['nomenclatura'].
            " / Detalles ".$datos['nomenclatura'];


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
        force_download('assets/fileUpload/contratoProyecto/'.$documento['idContratoProyecto'].'/'.$documento['programaEntrega'], NULL);
    }
    function descargarArchivoFianzaDocumento($idDocumento)
    {
        $this->load->model("FianzaDocumento");
        //Datos sobre el archivo
        $documento=$this->FianzaDocumento->getDocumento($idDocumento);
        $datos=$this->FianzaDocumento->getDatosBitacora($idDocumento);

        //Insertar en la bitacora
        $this->load->model("Bitacora");
        $idUsuario=$this->session->userdata("iduser");
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $idModulo=16;
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