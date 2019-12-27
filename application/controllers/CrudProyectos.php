<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudProyectos extends CI_Controller
{
    private $idUsuario;
    function __construct()
    {
        parent::__construct();
        $this->load->model("Proyectos"); //cargamos el modelo
        $this->load->library("session");
        $this->idUsuario=$this->session->userdata('iduser');
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 6)))
        {
            die($this->load->view("viewErrorPermiso", null, true));
        }
    }

    public function index()
    {

        $data['permisosContratos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 7);
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 6);
        $data['proyectos'] = $this->Proyectos->getTodosProyectos($this->idUsuario);
        $data['empresasInternas']=$this->Proyectos->getTodasEmpresasInternas();
        $data = $this->security->xss_clean($data);
        $this->load->view('viewTodoProyectos', $data);
    }

    function formSolicitud($idProyecto)
    {

        $data['idProyecto']=$idProyecto;
        $data['contrato'] = $this->Proyectos->getContrato();
        $data['getPr'] = $this->Proyectos->getPr($idProyecto);
        $data['EmpreGet'] = $this->Proyectos->getEmpresas();
        $data = $this->security->xss_clean($data);
        print $this->load->view('formsolicitud', $data, TRUE);
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
        print $this->load->view('viewSolicitud', $data, TRUE);
    }

    function verEdicionContrato($idContratoProyecto,$verBoton=true)
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
        print $this->load->view('editarSolicitud', $data, TRUE);
    }

    function obtenerContratoProyecto($idContratoProyecto)
    {
        print json_encode($this->Proyectos->getContratoProyecto($idContratoProyecto));
    }

    function getpendiente()
    {
        $prueba = $this->Proyectos->traerPendientes();
        echo json_encode($prueba);
    }

    function envioCorreoo($idCont,$diasA)
    {
        $this->load->library("email");
        $datosE = $this->Proyectos->getDatosEnvio($idCont);
        foreach ($datosE as $key) {
            $proyectoNo = $key["nombreProyecto"];
            $nombreCon = $key["nombreContrato"];
            $claveContrato = $key["claveContrato"];
            $nombreTipo = $key["nombreTipo"];
            $razonSocial = $key["razon_social"];
            $vig = $key["vigencia"];
            $diasAvisoNew = $key["diasAviso"];
            $envioCorreo = $key["envioCorreo"];
        }

        $pruebaid = $this->Proyectos->getlistaCorreos($idCont);
        foreach ($pruebaid as $row) {
            $correoNotificado = $row['correoDestino'];
            $mensaje = "
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>Aviso de vencimiento de Contrato</title>
<style type='text/css'>
body {
padding-top: 0 !important;
padding-bottom: 0 !important;
padding-top: 0 !important;
padding-bottom: 0 !important;
margin:0 !important;
width: 100% !important;
-webkit-text-size-adjust: 100% !important;
-ms-text-size-adjust: 100% !important;
-webkit-font-smoothing: antialiased !important;
}
.tableContent img {
border: 0 !important;
display: block !important;
outline: none !important;
}
a{
color:#382F2E;
}
p, h1{
color:#382F2E;
margin:0;
}
p{
text-align:left;
color:#999999;
font-size:14px;
font-weight:normal;
line-height:19px;
}
a.link1{
color:#382F2E;
}
a.link2{
font-size:16px;
text-decoration:none;
color:#ffffff;
}
h2{
text-align:left;
color:#222222; 
font-size:19px;
font-weight:normal;
}
div,p,ul,h1{
margin:0;
}
.bgBody{
background: #ffffff;
}
.bgItem{
background: #ffffff;
}
</style>
<script type='colorScheme' class='swatch active'>
{
'name':'Default',
'bgBody':'ffffff',
'link':'382F2E',
'color':'999999',
'bgItem':'ffffff',
'title':'222222'
}
</script>
</head>
<body paddingwidth='0' paddingheight='0' style='padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;' offset='0' toppadding='0' leftpadding='0'>
<table width='100%' border='0' cellspacing='0' cellpadding='0' class='tableContent bgBody' align='center' style='font-family:Helvetica, Arial,serif;'>
<tr><td height='35'></td></tr>
<tr>
<td>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center' class='bgItem'>
<tr>
<td width='40'></td>
<td width='520'>
<table width='520' border='0' cellspacing='0' cellpadding='0' align='center'>
<!-- =============================== Header ====================================== --> 
<tr><td height='75'></td></tr>
<!-- =============================== Body ====================================== -->
<tr>
<td class='movableContentContainer' valign='top'>
<div lass='movableContent'>
<table width='520' border='0' cellspacing='0' cellpadding='0' align='center'>
<tr>
<td valign='top' align='center'>
<div class='contentEditableContainer contentTextEditable'>
<div class='contentEditable'>
<p style='text-align:center;margin:0;font-family:Futura-Condensed-regular;font-size:26px;color:#000949;line-height: 25px;padding-bottom: 10px;'>Próximo contrato a vencer Constructora - <span style='color:#FFB600;'>Antar</span></p>
<img class='logo' src='http://www.constructora-antar.com.mx/wp-content/uploads/2018/10/antar-sitelogo.png' alt='logo' width='200' height='70'/>
</div>
</div>
</td>
</tr>
</table>
</div>
<div lass='movableContent'>
<table width='520' border='0' cellspacing='0' cellpadding='0' align='center'>
<tr>
<td valign='top' align='center'>
<div class='contentEditableContainer contentImageEditable'>
<div class='contentEditable'>
</div>
</div>
</td>
</tr>
</table>
</div>
<div class='movableContent'>
<table width='520' border='0' cellspacing='0' cellpadding='0' align='center'>
<tr><td height='15'></td></tr>
<tr>
<td align='left'>
<div class='contentEditableContainer contentTextEditable'>
<div class='contentEditable' align='center'>
<h2></h2>
</div>
</div>
</td>
</tr>
<tr>
<div class='contentEditableContainer contentTextEditable'>
<div class='contentEditable' align='center'>
<p>
<font color='#FFB600'>Proyecto: </font>$proyectoNo <br/></p>
<p><font color='#FFB600'>Contrato: </font>$nombreCon <br/></p>
<p><font color='#FFB600'>Tipo de contrato: </font>$claveContrato $nombreTipo <br/></p> 
<p><font color='#FFB600'>Empresa: </font>$razonSocial <br/></p>
<p><font color='#FFB600'>Vigencia: </font>$vig <br/></p>
</div>
</div>
</tr> 

</tr>
<tr><td height='15'></td></tr>
<tr>
<td align='center'>
<table>
<tr>
<td align='center' bgcolor='#2d3920' style='background:#000949; padding:15px 18px;-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;'>
<div class='contentEditableContainer contentTextEditable'>
<div class='contentEditable' align='center' style='color:white;'>
Realice el seguimiento correspondiente.</a>
</div>
</div>
</td>
</tr>
</table>
</td>
</tr>
<tr><td height='20'></td></tr>
</table>
</div>
<div lass='movableContent'>
<table width='520' border='0' cellspacing='0' cellpadding='0' align='center'>
<tr><td height='65'></td></tr>
<tr><td style='border-bottom:1px solid #DDDDDD;'></td></tr>
<tr><td height='25'></td></tr>
<tr>
<td>
</td>
</tr>
</table>
</div>
</td>
</tr>
<!-- =============================== footer ====================================== -->
</table>
</td>
<td width='40'></td>
</tr>
</table>
</td>
</tr>
<tr><td height='88'></td></tr>
</table>
</body>
</html>
";
    
            $TituloCorreo = "Próximo contrato de vencimiento";
           
            $this->email->from("sistema@constructora-antar.com", $TituloCorreo);
            //$this->email->to($correoNotificado);
            $this->email->to($correoNotificado);
            $this->email->subject('Contrato de ' . $razonSocial);
            $this->email->message($mensaje);
            $this->email->set_mailtype('html');
            if ($this->email->send()) {
                echo "1 ";
            } else {
                echo "2";
            }

        }
        if ($diasAvisoNew==30) {
           $diasAv=15;
           $sta=$envioCorreo;
        }else if  ($diasAvisoNew<=15 && $diasAvisoNew>=1) {
           $diasAv=$diasA;
           
           $sta=$envioCorreo;

            //
        }else if  ($diasAvisoNew<=0 ) {
           $diasAv=$diasA;
           $sta=1;
        }
         $hoy=date("Y-m-d");
        $data = array(

            'envioCorreo' => $sta,
            'diasAviso' => $diasAv,
            'fechaNotificado' => $hoy
        );
//echo "dia restan $diasAvisoNew sta $sta";
       
        $this->Proyectos->updateStatus($data, $idCont);

    }

    //Las solicitudes son los contratos de un proyecto. viewtodocontratoproyecto
    function Solicitudes($idProyecto)
    {

        $data['idProyecto']=$idProyecto;
        $data['solicitudes'] = $this->Proyectos->getSolcitud($idProyecto);
        $data['getPr'] = $this->Proyectos->getPr($idProyecto);
        $data['proyectoIndividual']=true;
        $data['posiblesEstados']=$this->Proyectos->getAllStatus();

        //permisos de contratos de proyecto
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 7);
        //permisos de fianzas
        $data['permisosFianzas']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 8);
        //permisos de versiones
        $data['permisosVersiones']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 10);
        //permisos de versiones
        $data['permisosStatusContrato']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 5);

        //No tiene valor porque se quieren ver todos los contratos
        $data['idEmpresaInterna']=null;
        //Código para exportar la tabla
        $data['fechaInicial']=null;
        $data['fechaFinal']=null;
        $data['statusSeleccionado']=null;

        $data = $this->security->xss_clean($data);
        print $this->load->view('viewtodosolicitudes', $data, TRUE);
    }


    function actualizarDatosProyecto()
    {
        $this->form_validation->set_rules('nombreProyecto', 'nombre del proyecto', 'max_length[100]|min_length[3]|trim');
        $this->form_validation->set_rules('idEmpresaInterna', 'empresa', 'trim|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $arreglo = array(
            array('nombreProyecto' => $this->input->post('nombreProyecto')),
            array('idEmpresaInterna' =>$this->input->post('idEmpresaInterna') )
        );

        $idProyecto = $this->input->post('idProyecto');

        foreach ($arreglo as $item) {
            while ($nombre_item = current($item)) {
                if (!empty($nombre_item)) {
                    $this->Proyectos->updateDatosProyecto($idProyecto, $item);
                    break;
                }
                next($item);
            }
        }
    }

    function eliminarDatosProyecto()
    {
        $this->form_validation->set_rules('idProyecto', 'identificador', 'required|numeric|trim');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $idProyecto = $this->input->post("idProyecto");
        $this->Proyectos->deleteDatosProyecto($idProyecto);
    }

    function eliminarDatosContratoProyecto()
    {
        $this->form_validation->set_rules('idContratoProyecto', 'identificador', 'required|trim|numeric');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $idContratoProyecto = $this->input->post("idContratoProyecto");
        $this->Proyectos->deleteDatosContratoProyecto($idContratoProyecto);
    }
    function altaNuevoProyecto()
    {
        $data['empresasInternas']=$this->Proyectos->getTodasEmpresasInternas();
        $data = $this->security->xss_clean($data);
        print $this->load->view('formAltaProyecto', $data, TRUE);
    }

    function insertarNuevoProyecto()
    {
        $this->form_validation->set_rules('nombreProyecto', 'nombre del proyecto', 'required|max_length[100]|min_length[3]');
        $this->form_validation->set_rules('empresaInterna', 'empresa interna', 'trim|numeric|required');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $data = array(
            "nombreProyecto" => $this->input->post("nombreProyecto"),
            "idEmpresaInterna" => $this->input->post("empresaInterna")
        );
        $this->Proyectos->insertDatosProyecto($data);
    }

    function getTipoContr($idC)
    {
        $prueba = $this->Proyectos->getTodoTipos($idC);
        echo json_encode($prueba);
    }

    function nuevaSolicitud()
    {
        $this->form_validation->set_rules('idTipoCon', 'identificador del tipo de contrato', 'trim|required|numeric');
        $this->form_validation->set_rules('idEmpresa', 'identificador de la empresa', 'trim|required|numeric');
        $this->form_validation->set_rules('idPro', 'identificador del proyecto', 'trim|required|numeric');
        $this->form_validation->set_rules('fechaServi', 'fecha de solicitud', 'trim|required');
        $this->form_validation->set_rules('montoContrata', 'monto del contrato', 'trim|required|max_length[250]|min_length[1]');
        $this->form_validation->set_rules('idUs', 'identificador de usuario', 'trim|required|numeric');
        $this->form_validation->set_rules('nomenclatura', 'nomenclatura', 'trim|required|max_length[150]|min_length[3]');
        $this->form_validation->set_rules('vigenciaBd', 'vigencia', 'trim|required|exact_length[10]');
        $this->form_validation->set_rules('plazoEjec', 'período de ejecución', 'trim|max_length[250]');
        $this->form_validation->set_rules('lugarEntrea', 'lugar de entrega', 'trim|required|max_length[300]');
        $this->form_validation->set_rules('repreObra', 'representante de obra', 'trim|required|max_length[300]');
        $this->form_validation->set_rules('plazoGarant', 'plazo de garantía', 'trim|exact_length[10]');
        $this->form_validation->set_rules('correoContacto', 'correo de contacto', 'trim|valid_email');

        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $idPro = $this->input->post('idPro');
        $stat = 0;
        $nombre_archivoima = $_FILES['prograEntre']['name'];
        $tipo_archivoima = $_FILES['prograEntre']['type'];
        $tamano_archivoima = $_FILES['prograEntre']['size'];
        $temp_archivoima = $_FILES['prograEntre']['tmp_name'];
        $foto = $nombre_archivoima;
        if ($nombre_archivoima == "") {
            $data = array(
                'idProyecto' => $idPro,
                'idTipoContrato' => $this->input->post('idTipoCon'),
                'contratoMarco' => (empty($this->input->post('contMrc'))?0:1),
                'objetoContrato' => $this->input->post('objContr'),
                'idEmpresa' => $this->input->post('idEmpresa'),
                'fechaSolicitud' => $this->input->post('fechaServi'),
                'fechaFirma' => "0000-00-00",
                'montoContrato' => $this->input->post('montoContrata'),
                'vigencia' => $this->input->post('vigenciaBd'),
                'observacion' => $this->input->post('obserVigenc'),
                'plazoEjecucion' => $this->input->post('plazoEjec'),
                'programaEntrega' => "null",//evidencia
                'lugarEntrega' => $this->input->post('lugarEntrea'),
                'representanteObra' => $this->input->post('repreObra'),
                'testigos' => $this->input->post('testigosBd'),
                'garantia' => $this->input->post('plazoGarant'),
                'correoContacto' => $this->input->post('correoContacto'),
				'contactoInterno' => $this->input->post('contactoInterno'),
				'correoInterno' => $this->input->post('correoInterno'),
                'nota' => $this->input->post('notasBd'),
                'envioCorreo' => $stat,
                'diasAviso' => "30",
                'fechaNotificado' => "0000-00-00",
                'idSolicitante' => $this->input->post('idUs'),
                'nomenclatura' => $this->input->post('nomenclatura')
            );
            $llavePrimaria = $this->Proyectos->insertSolicitud($data);

            if (mkdir("assets/fileUpload/contratoProyecto/" . $llavePrimaria, 07777, true))
                echo "se creo";
        } else {
            $ruta = "assets/fileUpload/contratoProyecto/" . $nombre_archivoima;
            if ((file_exists($ruta) && $nombre_archivoima != "")) {
                echo "2";
            } else {
                $filenames = $_FILES['prograEntre']['name'];
                $ext = explode('.', basename($filenames));
                $nombre_archivoima=DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
                $data = array(
                    'idProyecto' => $idPro,
                    'idTipoContrato' => $this->input->post('idTipoCon'),
                    'contratoMarco' => (empty($this->input->post('contMrc'))?0:1),
                    'objetoContrato' => $this->input->post('objContr'),
                    'idEmpresa' => $this->input->post('idEmpresa'),
                    'fechaSolicitud' => $this->input->post('fechaServi'),
                    'fechaFirma' => "0000-00-00",
                    'montoContrato' => $this->input->post('montoContrata'),
                    'vigencia' => $this->input->post('vigenciaBd'),
                    'observacion' => $this->input->post('obserVigenc'),
                    'plazoEjecucion' => $this->input->post('plazoEjec'),
                    'programaEntrega' => $nombre_archivoima,//evidencia
                    'lugarEntrega' => $this->input->post('lugarEntrea'),
                    'representanteObra' => $this->input->post('repreObra'),
                    'testigos' => $this->input->post('testigosBd'),
                    'garantia' => $this->input->post('plazoGarant'),
                    'correoContacto' => $this->input->post('correoContacto'),
					'contactoInterno' => $this->input->post('contactoInterno'),
					'correoInterno' => $this->input->post('correoInterno'),
                    'nota' => $this->input->post('notasBd'),
                    'envioCorreo' => $stat,
                    'diasAviso' => "30",
                    'fechaNotificado' => "0000-00-00",
                    'idSolicitante' => $this->input->post('idUs'),
                    'nomenclatura' => $this->input->post('nomenclatura')
                );
                $llavePrimaria = $this->Proyectos->insertSolicitud($data);
                if (mkdir("assets/fileUpload/contratoProyecto/" . $llavePrimaria, 07777, true))
                    echo "se creo";

                move_uploaded_file($temp_archivoima, "assets/fileUpload/contratoProyecto/" . $llavePrimaria . "/" . $nombre_archivoima);
                echo "1";
            }
        }


    }
    function verificarStatusFinalizado($idC)
    {
        $prueba= $this->Proyectos->sacarStatus($idC);
        echo json_encode ($prueba);
    }

    function verificarStatusFinalizadoFianzas($idF)
    {
        $prueba= $this->Proyectos->sacarStatusFianza($idF);
        echo json_encode ($prueba);
    }

    function modificarStatus($id)
    {
         $datosE = $this->Proyectos->getDatosEnvio($id);
        foreach ($datosE as $key) {
            $envioCorreo = $key["envioCorreo"];
        }
        if ($envioCorreo==1) {
            $stat=0;
        }else if ($envioCorreo==0) {
            $stat=1;
        }

         $data = array(
                    'envioCorreo' => $stat
                );
        $this->Proyectos->updateStatus($data,$id);
    }

    function ActualizaDefinitivo($finalZ,$idC)
    {
         $data = array(
                    'statusFinalizado' => $finalZ
                );
        $this->Proyectos->editarSolicitud($data,$idC);
    }

    function ActualizaDefinitivoF($finalZ,$idF)
    {
         $data = array(
                    'statusFinalizado' => $finalZ
                );
        $this->Proyectos->editarSolicitudF($data,$idF);
    }

    function editarSolicitud($idContratoProyecto)
    {
        $this->form_validation->set_rules('idTipoCon', 'identificador del tipo de contrato', 'trim|required|numeric');
        $this->form_validation->set_rules('idEmpresa', 'identificador de la empresa', 'trim|required|numeric');

        $this->form_validation->set_rules('montoContrata', 'monto del contrato', 'trim|required|max_length[250]|min_length[1]');

        $this->form_validation->set_rules('nomenclatura', 'nomenclatura', 'trim|required|max_length[150]|min_length[3]');
        $this->form_validation->set_rules('vigenciaBd', 'vigencia', 'trim|required|exact_length[10]');
        $this->form_validation->set_rules('plazoEjec', 'período de ejecución', 'trim|max_length[250]');
        $this->form_validation->set_rules('lugarEntrea', 'lugar de entrega', 'trim|required|max_length[300]');
        $this->form_validation->set_rules('repreObra', 'representante de obra', 'trim|required|max_length[300]');
        $this->form_validation->set_rules('plazoGarant', 'plazo de garantía', 'trim|exact_length[10]');
        $this->form_validation->set_rules('correoContacto', 'correo de contacto', 'trim|valid_email');

        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $idPro = $this->input->post('idPro');
        $editado = $this->input->post('archivoEditado');
        $stat = 0;
        $nombre_archivoima = $_FILES['prograEntre']['name'];
        $tipo_archivoima = $_FILES['prograEntre']['type'];
        $tamano_archivoima = $_FILES['prograEntre']['size'];
        $temp_archivoima = $_FILES['prograEntre']['tmp_name'];
        $foto = $nombre_archivoima;
        if ($nombre_archivoima == "") {

            $data = array(
                'idProyecto' => $idPro,
                'idTipoContrato' => $this->input->post('idTipoCon'),
                'contratoMarco' => (empty($this->input->post('contMrc'))?0:1),
                'objetoContrato' => $this->input->post('objContr'),
                'idEmpresa' => $this->input->post('idEmpresa'),
                'montoContrato' => $this->input->post('montoContrata'),
                'vigencia' => $this->input->post('vigenciaBd'),
                'observacion' => $this->input->post('obserVigenc'),
                'plazoEjecucion' => $this->input->post('plazoEjec'),
                'lugarEntrega' => $this->input->post('lugarEntrea'),
                'representanteObra' => $this->input->post('repreObra'),
                'testigos' => $this->input->post('testigosBd'),
                'garantia' => $this->input->post('plazoGarant'),
                'correoContacto' => $this->input->post('correoContacto'),
				'contactoInterno' => $this->input->post('contactoInterno'),
				'correoInterno' => $this->input->post('correoInterno'),
                'nota' => $this->input->post('notasBd'),
                'nomenclatura' => $this->input->post('nomenclatura')
            );
            $this->Proyectos->editarSolicitud($data, $idContratoProyecto);
            $llavePrimaria = $idContratoProyecto;


            if (mkdir("assets/fileUpload/contratoProyecto/" . $llavePrimaria, 07777, true))
                echo "se creo";
        } else {
            $filenames = $_FILES['prograEntre']['name'];
            $ext = explode('.', basename($filenames));
            $nombre_archivoima=DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
            $ruta = "assets/fileUpload/contratoProyecto/" . $nombre_archivoima;
            if ((file_exists($ruta) && $nombre_archivoima != "")) {
                echo "2";
            } else {

                $data = array(
                    'idProyecto' => $idPro,
                    'idTipoContrato' => $this->input->post('idTipoCon'),
                    'contratoMarco' => (empty($this->input->post('contMrc'))?0:1),
                    'objetoContrato' => $this->input->post('objContr'),
                    'idEmpresa' => $this->input->post('idEmpresa'),
                    'montoContrato' => $this->input->post('montoContrata'),
                    'vigencia' => $this->input->post('vigenciaBd'),
                    'observacion' => $this->input->post('obserVigenc'),
                    'plazoEjecucion' => $this->input->post('plazoEjec'),
                    'programaEntrega' => $nombre_archivoima,//evidencia
                    'lugarEntrega' => $this->input->post('lugarEntrea'),
                    'representanteObra' => $this->input->post('repreObra'),
                    'testigos' => $this->input->post('testigosBd'),
                    'garantia' => $this->input->post('plazoGarant'),
                    'correoContacto' => $this->input->post('correoContacto'),
					'contactoInterno' => $this->input->post('contactoInterno'),
					'correoInterno' => $this->input->post('correoInterno'),
                    'nota' => $this->input->post('notasBd'),
                    'idSolicitante' => $this->input->post('idUs'),
                    'nomenclatura' => $this->input->post('nomenclatura')
                );
                $this->Proyectos->editarSolicitud($data, $idContratoProyecto);
                $llavePrimaria = $idContratoProyecto;
                if (mkdir("assets/fileUpload/contratoProyecto/" . $llavePrimaria, 07777, true))
                    echo "se creo";

                move_uploaded_file($temp_archivoima, "assets/fileUpload/contratoProyecto/" . $llavePrimaria . "/" . $nombre_archivoima);
                echo "1";
            }
        }


    }

    function descargarDocumento($ruta)
    {
        $this->load->helper('download');
        if (!empty($ruta))
            force_download($ruta, NULL);
    }

    function borrarArchivo($nombreArchivo, $idContratoProyecto)
    {
        $nombreArchivo = urldecode($nombreArchivo);
        unlink(('assets/fileUpload/contratoProyecto/' . $idContratoProyecto . '/' . $nombreArchivo));
        $this->Proyectos->editarSolicitud(array('programaEntrega' => 'null'), $idContratoProyecto);
    }

    function eliminarDatosFianzaContrato()
    {
        $idFianza = $this->input->post("idFianza");
        $this->Proyectos->deleteDatosFianza($idFianza);
    }

    function nuevaFianza($idContratoProyecto)
    {
        $data = array('idContratoProyecto' => $idContratoProyecto);
        $data['fianzas'] = $this->Proyectos->getAllFianzas();
        $data = $this->security->xss_clean($data);
        print $this->load->view('formAltaFianzasContrato', $data, TRUE);

    }

     function getContras()
    {
      $password=$this->input->post('password');
      $prueba= $this->Proyectos->verificAPassword($password);
      echo json_encode ($prueba);
    }

    function insertarNuevaFianza($idContratoProyecto)
    {
        $data = array(
            "idCatalogoFianza" => $this->input->post("idFianza"),
            "idContratoProyecto" => $idContratoProyecto,
            "condiciones" => $this->input->post("condiciones"),
            "monto" => $this->input->post("monto"),
            "status" => 0,
            "diasAviso" => "30",
            "fechaNotificado" => "0000-00-00",
            "vigencia" => $this->input->post("vigencia")
        );
        $this->Proyectos->insertDatosFianza($data);
        echo "1";
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
        $data['nombreFianzas']=$this->Proyectos->getAllFianzas();
        print $this->load->view('viewTodoFianzasContrato', $data, TRUE);
    }


    function editarFianzaContrato()
    {
        $this->form_validation->set_rules('monto', 'monto', 'trim|numeric');
        $this->form_validation->set_rules('condicionesFianza', 'condiciones', 'trim');
        $this->form_validation->set_rules('vigencia', 'vigencia', 'trim|exact_length[10]');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $arreglo = array(array('idCatalogoFianza' => $this->input->post('idCatalogoFianza')),array('monto' => $this->input->post('monto')), array('condiciones' => $this->input->post('condicionesFianza')), array('vigencia' => $this->input->post('vigencia')));

        $idFianzaContrato = $this->input->post('id');

        foreach ($arreglo as $item) {
            while ($nombre_item = current($item)) {
                if (!empty($nombre_item)) {
                    echo json_encode($item);
                    $this->Proyectos->updateFianzaContrato($idFianzaContrato, $item);
                    break;
                }
                next($item);
            }
        }
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
        print $this->load->view('viewTodoVersionesContrato', $data, TRUE);
    }
    function nuevaVersion($idContratoProyecto)
    {
        $data['idContratoProyecto']=$idContratoProyecto;
        $data = $this->security->xss_clean($data);
        print $this->load->view('formVersionesContrato', $data, TRUE);
    }
    function editarVersion()
    {
        $arregloEdicion=array('observaciones' => $this->input->post('observaciones'));
        $this->Proyectos->editarVersion($this->input->post('id'), $arregloEdicion);
        echo json_encode($arregloEdicion);

    }
    function nuevaVersionContrato($idContratoProyecto)
    {
        $data=array(
            'idContratoProyecto'=>$idContratoProyecto,
            'archivo' => $this->subirDocumento("archivo",$idContratoProyecto),
            'final' => 0,
            'observaciones'=> $this->input->post('observaciones')
            );
        echo $this->Proyectos->insertarVersion($data);
    }
    function subirDocumento($nombreCampo, $idContratoProyecto)
    {

        if(!file_exists("assets/fileUpload/contratoProyecto/$idContratoProyecto/") && !is_dir("assets/fileUpload/contratoProyecto/$idContratoProyecto/"))
        {
            mkdir("assets/fileUpload/contratoProyecto/$idContratoProyecto/");
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
                $target = "assets/fileUpload/contratoProyecto/$idContratoProyecto/" . $nombre;
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
    function establecerVersionFinal($idVersion, $idContratoProyecto)
    {
        $this->Proyectos->cambiarVersionesFinales($idVersion,$idContratoProyecto);
        echo "1";
    }
    function eliminarDatosVersionContrato()
    {
        $idVersion=$this->input->post('idVersion');
        $idContratoProyecto=$this->input->post('idContratoProyecto');
        $archivo=$this->input->post('archivo');
        $this->Proyectos->borrarVersion($idVersion);
        unlink("assets/fileUpload/contratoProyecto/$idContratoProyecto/$archivo");
    }
    function cambiarEstadoContratoProyecto($estadoActual, $idContratoProyecto)
    {
        $this->Proyectos->editarSolicitud(array('status' => $estadoActual), $idContratoProyecto);
    }
    function cambiarEstadoFianzaContrato($estadoActual, $idFianza)
    {
        $this->Proyectos->updateFianzaContrato($idFianza, array('status' => $estadoActual));
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
		$idModulo=10;
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
		$idModulo=7;
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
}


?>