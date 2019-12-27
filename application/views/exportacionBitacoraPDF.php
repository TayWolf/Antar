<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--<link href="<?=base_url('assets/')?>css/custom/custom.css" type="text/css" rel="stylesheet">-->
    <title>Reporte de Bitacora</title>
    
    <style>
    body {
        height: 100%;
    }
    table {     
        margin: 450px;     
        width: 100%;
		float: center;
		vertical-align: middle;
        text-align: center;    
        border-collapse: collapse; 
    }
    table th {
        background-color: #F9B522;
        border-left: 1px solid #f9da97;
        border-right: 1px solid #f9da97;
        border-top: 1px solid #f9da97;
        text-align: center;
        font-size: 1em;
        color: #000; 
    }
    table td {
        text-align: center;
        font-size: 1em;
        border-left: 1px solid #111111; 
        border-right: 1px solid #111111; 
        border-top: 1px solid #111111; 
        border-bottom: 1px solid #111111; 
    }
    .centrado{
        width: 100% !important;
        text-align: center ;
        padding-top: 0 !important;
        padding-left: 0 !important;
        padding-bottom: 0 !important;
        padding-right: 0 !important;
        margin-top: 0 !important;
        margin-left: 0 !important;
        margin-bottom: 0 !important;
        margin-right: 0 !important;
    }
    .justificado{
        width: 100% !important;
        text-align: justify !important;
        padding-top: 0 !important;
        padding-left: 0px !important;
        padding-bottom: 0 !important;
        padding-right: 0 !important;
        margin-top: 0 !important;
        margin-left: 0 !important;
        margin-bottom: 0 !important;
        margin-right: 0 !important;
    }
    .right{
        right: 20px;
        text-align: right !important;
        padding-top: 0 !important;
        padding-left: 0 !important;
        padding-bottom: 0 !important;
        padding-right: 0 !important;
        margin-top: 0 !important;
        margin-left: 0 !important;
        margin-bottom: 0 !important;
        margin-right: 0 !important;

    }
    .letraPequena{
        font-size: 6px !important;
        line-height: 6px !important;

    }
    .letraPequenaMediana{
        font-size: 7px !important;
        line-height: 6.5px !important;

    }
    .letraMediana{
        font-size: 8px;
        line-height: 12px !important;
    }
    .letraGrande{
        font-size: 12px;
        line-height: 6px !important;


    }
    .espacioXXPequeño
    {
        line-height: 0 !important;
        padding: 0 0 0 0 !important;
        margin: 0 0 0  0 !important;
    }
    .espacioExtraPequeño
    {
        line-height: 4px !important;
    }
    .espacioExtraPequeñoLabel
    {
        line-height: 6px !important;
    }
    .espacioPequeño
    {
        line-height: 8px !important;
    }
    .espacioMediano
    {
        line-height: 10px !important;
    }
    .espacioGrande
    {
        line-height: 12px !important;
    }
    h1{
        text-align: center;
        background: #223E8E;
        font-size: 2em;
        font-family: fantasy;
    }
    </style>
</head>
	<body>
	
		
	<label class="centrado" style="min-width: 100% !important;">
		<div class="centrado">
			<img src="<?=base_url('\assets\images\logo\dna2_logo.png')?>">
		</div>
		<br class="espacioExtraPequeñoLabel">
		<b class="letraGrande centrado">Sistema de gestión documental</b>
		<br class="espacioPequeño">
		<br class="espacioPequeño">
		<?php
			//$fechareporte=date("Y-m-d");
			date_default_timezone_set('America/Monterrey');
			$fecha = date('d-m-Y H:i:s');
			$fecha = substr($fecha, 0, 10);
			$numeroDia = date('d', strtotime($fecha));
			$dia = date('l', strtotime($fecha));
			$mes = date('F', strtotime($fecha));
			$anio = date('Y', strtotime($fecha));
			$dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
			$dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
			$nombredia = str_replace($dias_EN, $dias_ES, $dia);
			$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			$meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			$nombreMes = str_replace($meses_EN, $meses_ES, $mes);
			$fechafinal= $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
		?>
		<b class="letraMediana" align="center">FECHA DEL REPORTE: <?=$fechafinal?></b>
	</label>
		<h1>Reporte de bitacora</h1>
		<div style="overflow-x:auto; float: right">
			<table>
				<thead>
				<tr>
					<th align="center" style="width: 10%">Usuario</th>
					<th align="center" style="width: 10%">Fecha</th>
					<th align="center" style="width: 15%">Módulo</th>
					<th align="center" style="width: 10%">Acción</th>
					<th align="center" style="width: 15%">ID</th>
					<th align="center" style="width: 20%">Antes del cambio</th>
					<th align="center" style="width: 20%">Después del cambio</th>
				</tr>
				</thead>
				<tbody>
					<?php
<<<<<<< HEAD
							echo "  <tr>
								<td style=\"width: 15%\">Cointic</td>
								<td style=\"width: 10%\">11/07/2019 08:50 am</td>
								<td style=\"width: 15%\">Archivo Muerto</td>
								<td style=\"width: 10%\">Descarga</td>
								<td style=\"width: 10%\"></td>
								<td style=\"width: 20%\"></td>
								<td style=\"width: 20%\"></td>
							</tr>";
=======
								echo "  <tr>
									<td style=\"width: 10%\">Cointic</td>
									<td style=\"width: 10%\">11/07/2019 08:50 am</td>
									<td style=\"width: 15%\">Archivo Muerto</td>
									<td style=\"width: 10%\">Descarga</td>
									<td style=\"width: 15%\"></td>
									<td style=\"width: 20%\"></td>
									<td style=\"width: 20%\"></td>
								</tr>";
>>>>>>> 53b85af5f4d8cbadd315fc890faf1de994f6ffe5
						?>
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
	<body>
</html>
