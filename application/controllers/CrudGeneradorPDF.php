<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use tcpdf\tcpdf;
class CrudGeneradorPDF extends CI_Controller
{
    private $pdf;
    function __construct()
    {
        parent::__construct();
        $this->load->model("GeneradorPDF");
        $this->load->helper("download");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        $this->pdf=new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // Información del documento
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor('Constructora Antar');
        $this->pdf->SetTitle('Contratos');
        // Establecer margenes
        $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // Auto breaks de página
        $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $this->load->model("Bitacora");
    }
    function generarContratos($fechaInicial=null, $fechaFinal=null, $statusSeleccionado=null, $idEmpresaInterna=null, $idProyecto=null)
    {
        $data['arregloContratos']=$this->GeneradorPDF->obtenerContratos($fechaInicial, $fechaFinal, $statusSeleccionado, $idEmpresaInterna, $idProyecto);
        $this->pdf->SetSubject('Contratos');
        $this->pdf->SetKeywords('Contratos, Proyectos');
        $this->pdf->AddPage('L', 'LETTER');
        $data = $this->security->xss_clean($data);
        $datosDocumentoPDF=$this->load->view('exportacionContratosPDF', $data, TRUE);
        // Escribir el contenido
        // output the HTML content
        $this->pdf->writeHTML($datosDocumentoPDF, true, false, true, false, '');
        $this->pdf->Output(FCPATH.'Contratos.pdf', 'F');

        $texto="Exportación a PDF de contratos.";
        if(!empty($fechaInicial)&&$fechaInicial!="1950-01-01")
        {
            $texto.=" Fecha inicial: ".$fechaInicial.".";
        }
        if(!empty($fechaFinal)&&$fechaFinal!="2032-12-31")
        {
            $texto.=" Fecha final: ".$fechaFinal.".";
        }
        if(!empty($statusSeleccionado))
        {
            $status=$this->GeneradorPDF->getStatus($statusSeleccionado);
            $texto.=" Status: ".$status['etiqueta'].".";
        }
        if(!empty($idEmpresaInterna))
        {
            $empresa=$this->GeneradorPDF->getEmpresaInterna($idEmpresaInterna);
            $texto.=" Empresa: ".$empresa['nombreEmpresa'].".";
        }
        if(!empty($idProyecto))
        {
            $proyecto=$this->GeneradorPDF->getProyecto($idProyecto);
            $texto.=" Proyecto: ".$proyecto['nombreProyecto'].".";
        }

        //Insertar en la bitacora
        $this->insertarDescargaBitacora($texto, 7);
        force_download(FCPATH.'Contratos.pdf', null);
    }
    function generarContratosVencimiento($diasTolerancia, $status)
    {

        $data['arregloContratos']=$this->GeneradorPDF->obtenerContratosVencimiento($diasTolerancia, $status);
        $this->pdf->SetSubject('Contratos');
        $this->pdf->SetKeywords("Contratos, Proyectos, Vencimiento, Dias, $diasTolerancia");
        $this->pdf->AddPage('L', 'LETTER');
        $data = $this->security->xss_clean($data);
        $datosDocumentoPDF=$this->load->view('exportacionContratosPDF', $data, TRUE);
        // Escribir el contenido
        // output the HTML content
        $this->pdf->writeHTML($datosDocumentoPDF, true, false, true, false, '');
        $this->pdf->Output(FCPATH.'Contratos.pdf', 'F');

        $texto="Exportación a PDF de contratos a punto de vencer.";
        if(!empty($status))
        {
            $status=$this->GeneradorPDF->getStatus($status);
            $texto.=" Status: ".$status['etiqueta'].".";
        }
        if(!empty($diasTolerancia))
        {
            $texto.=" Días antes de vencer: ".$diasTolerancia.".";
        }
        //Insertar en la bitacora
        $this->insertarDescargaBitacora($texto, 7);
        force_download(FCPATH.'Contratos.pdf', null);
    }
    function generarFianzas($idContratoProyecto, $fechaInicial="1950-01-01", $fechaFinal="2032-12-31", $idVigencia=null, $idPago=null, $idEmpresaInterna=null)
    {

        $data['arregloFianzas']=$this->GeneradorPDF->obtenerFianzas($idContratoProyecto, $fechaInicial, $fechaFinal, $idVigencia, $idPago, $idEmpresaInterna, 0);

        $this->pdf->SetSubject('Fianzas');
        $this->pdf->SetKeywords('Fianzas, Proyectos, Contratos');
        $this->pdf->AddPage('L', 'LETTER');
        $data = $this->security->xss_clean($data);
        $datosDocumentoPDF=$this->load->view('exportacionFianzasPDF', $data, TRUE);
        // Escribir el contenido
        // output the HTML content
        $this->pdf->writeHTML($datosDocumentoPDF, true, false, true, false, '');
        $this->pdf->Output(FCPATH.'Fianzas.pdf', 'F');

        $texto="Exportación a PDF de fianzas de contratos.";
        if(!empty($idContratoProyecto))
        {
            $contrato=$this->GeneradorPDF->getContrato($idContratoProyecto);
            $texto.=" Contrato: ".$contrato['nomenclatura'].".";
        }
        if(!empty($fechaInicial)&&$fechaInicial!="1950-01-01")
        {
            $texto.=" Fecha inicial: ".$fechaInicial.".";
        }
        if(!empty($fechaFinal)&&$fechaFinal!="2032-12-31")
        {
            $texto.=" Fecha final: ".$fechaFinal.".";
        }
        if($idVigencia==1)
        {
            $texto.=" Vigencia de fianza: Vigentes.";
        }
        else if($idVigencia===null)
        {

        }
        else if($idVigencia==0)
        {
            $texto.=" Vigencia de fianza: No vigentes.";
        }
        if($idPago==1)
        {
            $texto.=" Status: Pagadas.";
        }
        else if($idPago===null)
        {

        }
        else if($idPago==0)
        {
            $texto.=" Status: No pagadas.";
        }

        if(!empty($idEmpresaInterna))
        {
            $empresa=$this->GeneradorPDF->getEmpresaInterna($idEmpresaInterna);
            $texto.=" Empresa: ".$empresa['nombreEmpresa'].".";
        }

        $this->insertarDescargaBitacora($texto, 8);
        force_download(FCPATH.'Fianzas.pdf', null);

    }
    function generarFianzasVencimiento($diasTolerancia, $idContratoProyecto=null, $fechaInicial="1950-01-01", $fechaFinal="2032-12-31", $idVigencia=null, $idPago=null, $idEmpresaInterna=null)
    {

        $data['arregloFianzas']=$this->GeneradorPDF->obtenerFianzas($idContratoProyecto,  $fechaInicial, $fechaFinal, $idVigencia, $idPago, $idEmpresaInterna, 1);

        $this->pdf->SetSubject('Fianzas');
        $this->pdf->SetKeywords('Fianzas, Proyectos, Contratos');
        $this->pdf->AddPage('L', 'LETTER');
        $data = $this->security->xss_clean($data);
        $datosDocumentoPDF=$this->load->view('exportacionFianzasPDF', $data, TRUE);
        // Escribir el contenido
        // output the HTML content
        $this->pdf->writeHTML($datosDocumentoPDF, true, false, true, false, '');
        $this->pdf->Output(FCPATH.'Fianzas.pdf', 'F');

        $texto="Exportación a PDF de fianzas de contratos.";
        if(!empty($idContratoProyecto))
        {
            $contrato=$this->GeneradorPDF->getContrato($idContratoProyecto);
            $texto.=" Contrato: ".$contrato['nomenclatura'].".";
        }
        if(!empty($fechaInicial)&&$fechaInicial!="1950-01-01")
        {
            $texto.=" Fecha inicial: ".$fechaInicial.".";
        }
        if(!empty($fechaFinal)&&$fechaFinal!="2032-12-31")
        {
            $texto.=" Fecha final: ".$fechaFinal.".";
        }
        if($idVigencia==1)
        {
            $texto.=" Vigencia de fianza: Vigentes.";
        }
        else if($idVigencia===null)
        {

        }
        else if($idVigencia==0)
        {
            $texto.=" Vigencia de fianza: No vigentes.";
        }
        if($idPago==1) {
            $texto.=" Status: Pagadas.";
        }
        else if($idPago===null)
        {

        }
        else if($idPago==0)
        {
            $texto.=" Status: No pagadas.";
        }

        if(!empty($idEmpresaInterna))
        {
            $empresa=$this->GeneradorPDF->getEmpresaInterna($idEmpresaInterna);
            $texto.=" Empresa: ".$empresa['nombreEmpresa'].".";
        }
        if(!empty($diasTolerancia))
        {
            $texto.=" Días antes de vencer: ".$diasTolerancia.".";
        }

        //Insertar en la bitacora
        $this->insertarDescargaBitacora($texto, 8);
        force_download(FCPATH.'Fianzas.pdf', null);
    }
    function generarContratosFinalizados()
    {

        $data['arregloContratos']=$this->GeneradorPDF->cargarContratosTerminados($this->session->userdata("iduser"));
		$this->pdf->SetSubject('Contratos');
        $this->pdf->SetKeywords('Contratos, Proyectos');
        $this->pdf->AddPage('L', 'LETTER');
        $data = $this->security->xss_clean($data);
        $datosDocumentoPDF=$this->load->view('exportacionContratosPDF', $data, TRUE);
        // Escribir el contenido
        // output the HTML content
        $this->pdf->writeHTML($datosDocumentoPDF, true, false, true, false, '');
        $this->pdf->Output(FCPATH.'Contratos.pdf', 'F');

        $texto="Exportación a PDF de contratos finalizados.";
        //Insertar en la bitacora
        $this->insertarDescargaBitacora($texto, 7);
        force_download(FCPATH.'Contratos.pdf', null);
    }
	function generarBitacora()
    {

        $data['Bitacora']=$this->GeneradorPDF->obtenerBitacora($this->session->userdata("iduser"));
        $this->pdf->SetSubject('Bitacora');
        $this->pdf->SetKeywords('Bitacora');
        $this->pdf->AddPage('L', 'LETTER');
        $data = $this->security->xss_clean($data);
		$datosDocumentoPDF=$this->load->view('exportacionBitacoraPDF', $data, TRUE);
        // Escribir el contenido
        // output the HTML content
        $this->pdf->writeHTML($datosDocumentoPDF, true, false, true, false, '');
<<<<<<< HEAD
		$this->pdf->Output(FCPATH.'Bitacora.pdf', 'F'); 
        force_download(FCPATH.'Bitacora.pdf', null); 
=======
		$this->pdf->Output(FCPATH.'Bitacora.pdf', 'F');
        $this->guardarDescargaBitacora();
        force_download(FCPATH.'Bitacora.pdf', null);
>>>>>>> 53b85af5f4d8cbadd315fc890faf1de994f6ffe5
    }
    function guardarDescargaBitacora()
    {
        //Insertar en la bitacora

        $idUsuario=$this->session->userdata("iduser");
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $idModulo=17;
        $accion="Descarga";
        $texto="Bitácora";
        $data=array(
            'idUsuario'=>$idUsuario,
            'fechaAccion'=>$fecha,
            'horaAccion'=>$hora,
            'idModulo'=>$idModulo,
            'accion'=>$accion,
            'texto'=>$texto
        );
        $this->Bitacora->insertar($data);
    }
    function generarFianzasFinalizadas($idContratoProyecto, $fechaInicial="1950-01-01", $fechaFinal="2032-12-31", $idVigencia=null, $idPago=null, $idEmpresaInterna=null)
    {
        $data['arregloFianzas']=$this->GeneradorPDF->obtenerFianzasFinalizadas($idContratoProyecto, $fechaInicial, $fechaFinal, $idVigencia, $idPago, $idEmpresaInterna);
        $this->pdf->SetSubject('Fianzas');
        $this->pdf->SetKeywords('Fianzas, Proyectos, Contratos');
        $this->pdf->AddPage('L', 'LETTER');
        $data = $this->security->xss_clean($data);
        $datosDocumentoPDF=$this->load->view('exportacionFianzasPDF', $data, TRUE);
        // Escribir el contenido
        // output the HTML content
        $this->pdf->writeHTML($datosDocumentoPDF, true, false, true, false, '');
        $this->pdf->Output(FCPATH.'Fianzas.pdf', 'F');

        $texto="Exportación a PDF de fianzas finalizadas.";
        if(!empty($idContratoProyecto))
        {
            $contrato=$this->GeneradorPDF->getContrato($idContratoProyecto);
            $texto.=" Contrato: ".$contrato['nomenclatura'].".";
        }
        if(!empty($fechaInicial)&&$fechaInicial!="1950-01-01")
        {
            $texto.=" Fecha inicial: ".$fechaInicial.".";
        }
        if(!empty($fechaFinal)&&$fechaFinal!="2032-12-31")
        {
            $texto.=" Fecha final: ".$fechaFinal.".";
        }
        if($idVigencia==1) {
            $texto.=" Vigencia de fianza: Vigentes.";
        }
        else if($idVigencia===null)
        {

        }
        else if($idVigencia==0)
        {
            $texto.=" Vigencia de fianza: No vigentes.";
        }

        if($idPago==1) {
            $texto.=" Status: Pagadas.";
        }
        else if($idPago===null)
        {

        }
        else if($idPago==0)
        {
            $texto.=" Status: No pagadas.";
        }

        if(!empty($idEmpresaInterna))
        {
            $empresa=$this->GeneradorPDF->getEmpresaInterna($idEmpresaInterna);
            $texto.=" Empresa: ".$empresa['nombreEmpresa'].".";
        }


        $this->insertarDescargaBitacora($texto, 8);
        force_download(FCPATH.'Fianzas.pdf', null);
    }
    function insertarDescargaBitacora($texto, $idModulo)
    {
        //Insertar en la bitacora
        $idUsuario=$this->session->userdata("iduser");
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $accion="Descarga";

        $data=array(
            'idUsuario'=>$idUsuario,
            'fechaAccion'=>$fecha,
            'horaAccion'=>$hora,
            'idModulo'=>$idModulo,
            'accion'=>$accion,
            'texto'=>$texto
        );
        $this->Bitacora->insertar($data);
    }
}