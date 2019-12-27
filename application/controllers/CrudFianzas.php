<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudFianzas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("CatalogoFianzas");
        $this->load->library('session');
        $this->load->model("Permisos");
        $idUsuario=$this->session->userdata("iduser");
        if(empty($idUsuario))
        {
            die($this->load->view("viewSesionCaducada", null, true));
        }
        else if((!$this->Permisos->tienePermisosUsuarioModulo($idUsuario, 12)))
        {
            die($this->load->view("viewErrorPermiso", null, true));

        }
    }

    public function index()
    {

        $data['CatalogoFianzas'] = $this->CatalogoFianzas->getTodosFianzas();
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'),12);
        $data = $this->security->xss_clean($data);
        $this->load->view('viewTodoFianzas', $data);
    }
	
	function ordenarFianzas()
    {
        $arreglo=$this->input->post("arreglo");
        for($i=0; $i<sizeof($arreglo); $i++)
        {
            $idCatalogoFianza=$arreglo[$i];
            $this->CatalogoFianzas->updateDatosFianza($idCatalogoFianza, array("orden" => $i));
        }
        echo json_encode($this->CatalogoFianzas->getTodosFianzas());
    }
	

    function actualizarDatosFianza()
    {

        //PARA ACTUALIZAR DATOS CON TABLEDIT: GENERAR UN ARREGLO DE LOS POSIBLES VALORES DE LA TABLA
        //Y SUS POSIBLES POST. SI EL POST ESTA VACIO NO ACTUALIZARÁ ESE CAMPO
        //SI EL POST TIENE VALOR, ACTUALIZARÁ ESE CAMPO
        $this->form_validation->set_rules('nombre', 'nombre', 'required|max_length[150]|min_length[3]|trim');
        $this->form_validation->set_rules('idFianza', 'identificador', 'required|numeric|trim');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $arreglo = array(

            array('nombre' => $this->input->post('nombre'))

        );

        $idFianza = $this->input->post('idFianza');

        foreach ($arreglo as $item)
        {
            while($nombre_item = current($item))
            {
                if(!empty($nombre_item))
                {
                    $this->CatalogoFianzas->updateDatosFianza($idFianza, $item);
                    break;
                }
                next($item);
            }
        }
    }

    function eliminarDatosFianza()
    {
        $this->form_validation->set_rules('idFianza', 'identificador', 'required|numeric|trim');

        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $idFianza = $this->input->post("idFianza");
        $this->CatalogoFianzas->deleteDatosFianza($idFianza);
    }


    function altaNuevaFianza()
    {

        $this->load->view('formAltaFianzas');

    }



    function insertarNuevaFianza()
    {
        $this->form_validation->set_rules('nombre', 'nombre', 'required|max_length[150]|min_length[3]');
        if($this->form_validation->run()==false)
        {
            header('HTTP/1.1 500 Internal Server ');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => validation_errors(), 'code' => 1337)));
        }
        $data = array(
            "nombre" => $this->input->post("nombre")
        );
        $this->CatalogoFianzas->insertDatosFianza($data);
    }
    function getpendienteF()
    {
        $pruebaF = $this->CatalogoFianzas->traerPendientesF();
        echo json_encode($pruebaF);
    }

    function envioCorreoF($idFianza,$diasA,$idCon){

        $datosF = $this->CatalogoFianzas->getDatosEnvioF($idFianza);
        foreach ($datosF as $key) {

            $proyectoNo = $key["nombreProyecto"];
            $nombreCon = $key["nombreContrato"];
            $claveContrato = $key["claveContrato"];
            $nombreTipo = $key["nombreTipo"];
            $razonSocial = $key["razon_social"];
            $fianza = $key["nombreFianza"];
            $montoFianza= $key["monto"];

            $vig = $key["vigencia"];
            $diasAvisoNew = $key["diasAviso"];
            $envioCorreo = $key["statusCorreo"];
        }
        $this->load->model("Proyectos");
        $pruebaid = $this->Proyectos->getlistaCorreos($idCon);
        foreach ($pruebaid as $row) {
            $correoNotificado = $row['correoDestino'];
            $mensaje = "
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>Aviso de vencimiento de Fianza / garantía</title>
<style type='text/css'>
body {
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

</head>
<body paddingwidth='0' paddingheight='0' style='padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;' offset='0' toppadding='0' leftpadding='0'>
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
<div class='movableContent'>
<table width='520' border='0' cellspacing='0' cellpadding='0' align='center'>
<tr>
<td valign='top' align='center'>
<div class='contentEditableContainer contentTextEditable'>
<div class='contentEditable'>
<p style='text-align:center;margin:0;font-family:Futura-Condensed-regular;font-size:26px;color:#000949;line-height: 25px;padding-bottom: 10px;'>Próxima fianza a vencer. Constructora - <span style='color:#FFB600;'>Antar</span></p>
<img class='logo' src='http://www.constructora-antar.com.mx/wp-content/uploads/2018/10/antar-sitelogo.png' alt='logo' width='200' height='70'/>
</div>
</div>
</td>
</tr>
</table>
</div>
<div class='movableContent'>
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
<p><font color='#FFB600'>Fianza / garantía: </font>$fianza <br/></p>
<p><font color='#FFB600'>Monto de fianza / garantía: </font>$ $montoFianza <br/></p>
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
<div class='movableContent'>
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
    $hoy=date("Y-m-d");
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
            $TituloCorreo = "Próxima Fianza / garantía a vencer";
            $this->load->library("email");
            $this->email->from("sistema@constructora-antar.com", $TituloCorreo);
            $this->email->to($correoNotificado);
            $this->email->subject($fianza. ' - Contrato de ' . $razonSocial);
            $this->email->message($mensaje);
            $this->email->set_mailtype('html');
            if ($this->email->send()) {
                 $data = array(
                    'statusCorreo' => $sta,
                    'diasAviso' => $diasAv,
                    'fechaNotificado' => $hoy
                );
                $this->CatalogoFianzas->updateStatusFianza($data, $idFianza);
                
                echo "1";
            } else {
                echo "2";
            }
           
               // echo "dia restan $diasAvisoNew sta $sta";
        }


    }


}