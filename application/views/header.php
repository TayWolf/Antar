<?php

defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

?>

<!DOCTYPE html>

<html lang="es">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="msapplication-tap-highlight" content="no">

    <meta name="description" content="Constructora antar.">

    <title>Sistema de gestión documental</title>

    <!-- Favicons-->

    <link rel="icon" href="<?=base_url('assets/images/favicon/favico.png')?>">

    <!-- Favicons-->

    <link rel="apple-touch-icon-precomposed" href="<?=base_url('assets/')?>images/favicon/apple-touch-icon-152x152.png">

    <!-- For iPhone -->

    <meta name="msapplication-TileColor" content="#00bcd4">

    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

    <!-- For Windows Phone -->

    <!-- CORE CSS-->

    <link href="<?=base_url('assets/')?>css/themes/collapsible-menu/materialize.css" type="text/css" rel="stylesheet">

    <link href="<?=base_url('assets/')?>css/themes/collapsible-menu/style.css" type="text/css" rel="stylesheet">


    <!--Videos-->
    <link href="<?=base_url('assets/')?>css/modal-video.min.css" type="text/css" rel="stylesheet">
    <!-- Custome CSS-->


    <link href="<?=base_url('assets/')?>css/custom/custom.css" type="text/css" rel="stylesheet">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->

    <link href="<?=base_url('assets/')?>vendors/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet">

    <link href="<?=base_url('assets/')?>vendors/jvectormap/jquery-jvectormap.css" type="text/css" rel="stylesheet">

    <link href="<?=base_url('assets/')?>vendors/flag-icon/css/flag-icon.min.css" type="text/css" rel="stylesheet">

    <link href="<?=base_url('assets/')?>vendors/sweetalert/dist/sweetalert.css" type="text/css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.18/datatables.min.css"/>

    <link href="<?=base_url('assets/')?>vendors/dropify/css/dropify.min.css" type="text/css" rel="stylesheet">
    <input type="hidden" id="fechaCompar" name="fechaCompar" value="<?php $hoybase=date('Y-m-d'); echo $hoybase; ?>">
    <script type="text/javascript">
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        // INICIA ENVIO DE CORREO VENCIMIENTO FIANZA

        function CorreoFianza()
        {
            var ComparFianza=$("#ComparFianza").val();
            $.ajax({
                url : "<?php echo site_url('CrudFianzas/getpendienteF/')?>/",
                type: "get",
                dataType: "json",
                data: { [csrfName]: csrfHash},
                success: function(data)
                {
                    if(data.length > 0)
                    {
                        var fechaComparF=$("#fechaCompar").val();
                        for(i=0; i<data.length; i++)
                        {
                            var proxFeF=data[i]["vigencia"];
                            // var envioco=data[i]["enviocorreo"];
                            var fechaNotificado=data[i]["fechaNotificado"];
                            var fechaActualsistemal=$("#fechaActualsistemal").val();
                            //var diasAvisoF=7;
                            var diasAvisoF=data[i]["diasAviso"];
                            var idConF=data[i]["idFianza"];
                            var idContratoProyecto=data[i]["idContratoProyecto"];

                            var hoyF = new Date(fechaComparF).getTime();
                            var proxFechF = new Date(proxFeF).getTime();
                            var diferciaDiasF=proxFechF-hoyF;
                            var difereF=diferciaDiasF/(1000*60*60*24);
                            //alert(difere)
                            //alert(difereF+" <= "+diasAvisoF +" && "+ difereF +" >=0")
                            if (difereF<=diasAvisoF && difereF >=0)
                            {
                            //alert("entra")
                                if (fechaNotificado!=fechaActualsistemal)
                                {
                                    //alert("mandara correo ")
                                    envioCorreoF(idConF,difereF,idContratoProyecto)
                                }
                                //
                            }
                        }
                    }
                }
            });
        }
        function envioCorreoF(idF,diasAviso,idContratoProyecto)
        {

            $.ajax({
                url : "<?php echo site_url('CrudFianzas/envioCorreoF/')?>"+idF+"/"+diasAviso+"/"+idContratoProyecto,
                type: "get",
                dataType: "html",
                data: { [csrfName]: csrfHash},
                success: function(data)
                {
                   // alert(data)
                }
            });

        }
        // FINALIZA ENVIO DE CORREO VENCIMIENTO FIANZA

        window.onload=pendienteCorreo;
        function pendienteCorreo()
        {
            CorreoFianza();
            var fechaCompar=$("#fechaCompar").val();
            $.ajax({
                url : "<?php echo site_url('CrudProyectos/getpendiente/')?>/",
                type: "get",
                dataType: "json",
                data: { [csrfName]: csrfHash},
                success: function(data)
                {
                    if(data.length > 0)
                    {
                        for(i=0; i<data.length; i++)
                        {
                            var proxFe=data[i]["vigencia"];
                           
                             var fechaNotificado=data[i]["fechaNotificado"];
                             var fechaActualsistemal=$("#fechaActualsistemal").val();
                            //var diasAviso=30;
                           

                            var idCon=data[i]["idContratoProyecto"];
                            var hoy = new Date(fechaCompar).getTime();
                            var proxFech = new Date(proxFe).getTime();
                            var diferciaDias=proxFech-hoy;
                            var difere=diferciaDias/(1000*60*60*24);
                             var diasAviso=data[i]["diasAviso"];
                            //alert(proxFe)
                            //alert(difere+" <= "+diasAviso+" && "+difere +">=0")
                            if (difere<=diasAviso && difere >=0)
                            {
                               if (fechaNotificado!=fechaActualsistemal)
                                {
                                    //alert(fechaNotificado+" != "+fechaActualsistemal)
                                    envioCorreo(idCon,difere)
                                }
                               
                            }
                        }
                    }
                }
            });
        }

        function envioCorreo(idC,diasAviso)
        {

            $.ajax({
                url : "<?php echo site_url('CrudProyectos/envioCorreoo/')?>"+idC+"/"+diasAviso,
                type: "get",
                dataType: "html",
                data: { [csrfName]: csrfHash},
                success: function(data)
                {
                    //alert(data)
                }
            });

        }

    </script>

    <style>
        a{
            cursor: pointer;
        }
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }

    </style>
</head>

<body>

<!-- Start Page Loading -->

<div id="loader-wrapper">

    <div id="loader"></div>

    <div class="loader-section section-left"></div>

    <div class="loader-section section-right"></div>

</div>

<!-- End Page Loading -->

<!-- //////////////////////////////////////////////////////////////////////////// -->

<!-- START HEADER -->

<header id="header" class="page-topbar">

    <!-- start header nav-->

    <div class="navbar-fixed">

        <nav class="navbar-color gradient-45deg-purple-deep-orange gradient-shadow">

            <div class="nav-wrapper">

                <input type="hidden" id="totalContratosPorVencer" value="<?=$totalContratos?>">
                <input type="hidden" id="totalFianzasPorVencer" value="<?=$totalFianzas?>">
                <input type="hidden" id="fechaActualsistemal" name="fechaActualsistemal" value="<?php  echo $hoy=date("Y-m-d"); ?>">
                <ul class="right hide-on-med-and-down">
                    <li>
                        <a class="waves-effect waves-block waves-light notification-button" href="#" onclick="loadEmbedUrl('CrudNotificacion/cargarNotificaciones')"  >
                            <i class="material-icons">notifications_none
                                <small class="notification-badge red"><?=($totalContratos+$totalFianzas)?></small>
                            </i>
                        </a>

                    <li>

                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">

                      <span class="avatar-status avatar-online">

                        <img src="<?=base_url('assets/')?>images/avatar/avatar-7.png" alt="avatar">

                        <i></i>

                      </span>

                        </a>

                    </li>

                    <!-- <li>

                        <a href="#" data-activates="chat-out" class="waves-effect waves-block waves-light chat-collapse">

                            <i class="material-icons">format_indent_increase</i>

                        </a>

                    </li> -->

                </ul>

                <!-- translation-button -->

                <ul id="translation-dropdown" class="dropdown-content">

                    <li>

                        <a href="#!" class="grey-text text-darken-1">

                            <i class="flag-icon flag-icon-gb"></i> English</a>

                    </li>

                    <li>

                        <a href="#!" class="grey-text text-darken-1">

                            <i class="flag-icon flag-icon-fr"></i> French</a>

                    </li>

                    <li>

                        <a href="#!" class="grey-text text-darken-1">

                            <i class="flag-icon flag-icon-cn"></i> Chinese</a>

                    </li>

                    <li>

                        <a href="#!" class="grey-text text-darken-1">

                            <i class="flag-icon flag-icon-de"></i> German</a>

                    </li>

                </ul>

                <!-- notifications-dropdown -->

                <ul id="notifications-dropdown" class="dropdown-content">

                    <li>

                        <h6>NOTIFICATIONS

                            <span class="new badge">5</span>

                        </h6>

                    </li>

                    <li class="divider"></li>

                    <li>

                        <a href="#!" class="grey-text text-darken-2">

                            <span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> A new order has been placed!</a>

                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>

                    </li>

                    <li>

                        <a href="#!" class="grey-text text-darken-2">

                            <span class="material-icons icon-bg-circle red small">stars</span> Completed the task</a>

                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>

                    </li>

                    <li>

                        <a href="#!" class="grey-text text-darken-2">

                            <span class="material-icons icon-bg-circle teal small">settings</span> Settings updated</a>

                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>

                    </li>

                    <li>

                        <a href="#!" class="grey-text text-darken-2">

                            <span class="material-icons icon-bg-circle deep-orange small">today</span> Director meeting started</a>

                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>

                    </li>

                    <li>

                        <a href="#!" class="grey-text text-darken-2">

                            <span class="material-icons icon-bg-circle amber small">trending_up</span> Generate monthly report</a>

                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>

                    </li>

                </ul>

                <!-- profile-dropdown -->

                <ul id="profile-dropdown" class="dropdown-content">

                    <!--  <li>

                         <a href="#" class="grey-text text-darken-1">

                             <i class="material-icons">face</i> Profile</a>

                     </li>

                     <li>

                         <a href="#" class="grey-text text-darken-1">

                             <i class="material-icons">settings</i> Settings</a>

                     </li>

                     <li>

                         <a href="#" class="grey-text text-darken-1">

                             <i class="material-icons">live_help</i> Help</a>

                     </li>

                     <li class="divider"></li>

                     <li>

                         <a href="#" class="grey-text text-darken-1">

                             <i class="material-icons">lock_outline</i> Lock</a>

                     </li>-->

                    <li>

                        <a href="<?=base_url()?>" class="grey-text text-darken-1">

                            <i class="material-icons">keyboard_tab</i> Salir</a>

                    </li>

                </ul>

            </div>

        </nav>

    </div>

</header>
<!-- END HEADER -->
<main>