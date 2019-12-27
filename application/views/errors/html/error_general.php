<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Error</title>
<style type="text/css">
/*
::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }
*/
#bodyError {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

#linkError {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

#h1Error {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}
/*
code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}
*/
#containerError {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body id="bodyError">
	<div id="containerError">
		<h1 id="h1Error"><?php /*echo $heading;*/ ?>Un error ha ocurrido</h1>
		<?php /*echo $message;*/ ?>
        <div class="row">
            <div align="center">
                <br>
                <img src="http://localhost/Cointic_Antar/assets/error.svg" width='300px' align=middle><br><br>
                <br><br><a id="linkError" href="http://localhost/Cointic_Antar/" class='btn waves-effect waves-light'>Ingresar de nuevo</a>
            </div>
        </div>
	</div>
</body>
</html>

