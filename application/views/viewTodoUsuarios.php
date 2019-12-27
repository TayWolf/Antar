<?php if(!empty($permisos)) {
    $this->load->library('encryption');
    $this->key = bin2hex($this->encryption->create_key(16));

    ?>

    <!-- START WRAPPER -->
    <div class="wrapper">

        <section id="content">
            <!--breadcrumbs start-->
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen -->
                <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
                    <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="">
                </div>

            </div>
            <!--breadcrumbs end-->
            <!--start container-->
            <div class="container">

                <div class="divider"></div>
                <!--editableTable-->
                <div id="editableTable" class="section">
                    <div class="row">
                        <div class="col s11">
                            <h4 class="header">Usuarios registrados</h4>
                            
                        </div>
                        <div class="col s1">
                            <div class="col s8 offset-s2">
                                <a class="tooltipped js-video-button" data-video-id='Z90WBJMrias' data-position="left" data-delay="30" data-tooltip="¿Necesitas ayuda?" style="padding: 0px !important;"><i class="medium material-icons">ondemand_video</i></a>
                            </div>
                        </div>

                        <?php
                        if($permisos['alta'])
                        {
                            ?>

                            <div align="center">
                                <a class='dropdown-trigger btn' href="#" onclick="loadUrl('Crudusuarios/altaUsuarios')" data-target='dropdown1'>Nuevo usuario</a>
                            </div>

                            <?php
                        }
                        ?>

                        <div class="col s12">
                            <table id="mainTable" class="display">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Usuario</th>
                                    <th>NickName</th>
                                    <th>Correo</th>
                                    <th>Área</th>
                                    <th>Tipo</th>
                                    <?php
                                    if($permisos['editar'])
                                    {
                                        ?>
                                        
										<th>Empresas</th>
                                        <th>Tipos de contrato</th>
										
										<th>Cambiar Contraseña</th>
                                        <?php
                                    }
                                    if($permisosExpediente['mostrar'])
                                    {
                                        ?>
                                        <th>Expediente</th>
                                        <?php
                                    }
                                    if($permisos['eliminar'])
                                    {
                                        ?>
                                        <th>Status</th>
                                        <?php
                                    }?>


                                </tr>

                                </thead>
                                <tbody>
								
                                <?php
                                $contador=1;
                                foreach ($Usuario as $row) {
                                    $idUser=$row["idUser"];
                                    $nombreUser=$row["nombreUser"];
                                    $nickName=$row["nickName"];
									$correoDestino=$row["correoDestino"];
                                    $nombreArea=$row["nombreArea"];
                                    $nombreTipo=$row["nombreTipo"];
                                    $Status = $row['Status'];
                                    $status = ($Status==0)?'checked':'';

                                    $clase=($contador%2==0)?'odd':'even';
                                    echo "<tr  class='$clase' role='row'>
											<td id='indice".$row['idUser']."'>$idUser</td>
											<td>$nombreUser</td>
											<td>$nickName</td>

											<td>$correoDestino</td>
											<td>$nombreArea</td>
											<td>$nombreTipo</td>";
								
                                    if($permisos['editar'])
                                    {
										echo"<td><a onclick='editarEmpresas(".$row['idUser'].")'>Empresas</a></td>";
										echo"<td><a onclick='editarTipos(".$row['idUser'].")'>Tipos de contratos</a></td>";
										
										echo"<td><a onclick='editarContra(".$row['idUser'].")'>Editar</a></td>";
                                    }
                                    if($permisosExpediente['mostrar'])
                                    {
                                        echo"<td><a onclick=\"loadUrl('Crudusuarios/verExpendienteUsuario/".$row['idUser']."')\">Ver/Editar</a></td>";
                                    }

                                    if($permisos['eliminar'])
                                        //echo"<td><a onclick='borrar(".$row['idUser'].", this)'>Eliminar</a></td>";
                                        echo"<td>
                                            <div class=\"switch\">
                                                <label>
                                                  <input type=\"checkbox\" id='activado".$row['idUser']."' ".$status." onclick='activarUsuario(" .$row['idUser']. ")'>
                                                  <span class=\"lever\"></span>
                                                </label>
                                            </div>
                                            </td> ";
                                    echo"</tr>";
                                    $contador++;
                                }
                                ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="divider"></div>
                </div>
            </div>
            <!--end container-->
        </section>
    </div>
	
    <!-- END WRAPPER -->
    <input type="hidden" id="usuarioSeleccionado">
    <!-- Modal Structure -->
    <div id="modalEmpresas" class="modal bottom-sheet">
        <div class="modal-content">

            <h4>Empresas a las que pertenece el usuario</h4>
            <div class="col s12" id="contenidoEmpresas">
                <?php
                foreach ($empresas as $empresa)
                {
                    echo "<div class='col s12'><input type=\"checkbox\" onChange='cambiarStatusEmpresaUsuario(".$empresa['idEmpresaInterna'].")' id=\"cboxEmpresa".$empresa['idEmpresaInterna']."\" value=\"".$empresa['idEmpresaInterna']."\"><label for=\"cboxEmpresa".$empresa['idEmpresaInterna']."\">".$empresa['nombreEmpresa']."</label></div>";
                }
                ?>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Hecho</a>
        </div>
    </div>
    <!-- Modal Structure -->
    <div id="modalTiposContratos" class="modal bottom-sheet">
        <div class="modal-content">
            <h4>Tipos de contrato que maneja el usuario</h4>
            <div class="col s12" id="contenidoTiposContrato">
                <?php
                foreach ($tiposContrato as $tipo)
                {
                    echo "<div class='col s6'><input type=\"checkbox\" onChange='cambiarStatusTiposContrato(".$tipo['idTipoC'].")' id=\"cboxContrato".$tipo['idTipoC']."\" value=\"".$tipo['idTipoC']."\"><label for=\"cboxContrato".$tipo['idTipoC']."\">".$tipo['nombreTipo']."</label></div>";
                }
                ?>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Hecho</a>
        </div>
    </div>
	<!-- Modal Structure -->
    <div id="modalContra" class="modal">
		<div class="modal-content">
			<h4>Cambiar contraseña</h4>
			
			<div class="row">
				<div class="input-field col s6">
					<input id="passwordUs" name="passwordUs" type="password" required>
					<input type="hidden" id="userId" name="userId">
					<label for="name">Nueva contraseña</label>
				</div>
				<div class="input-field col s6">
					<input id="passwordConfirm" name="passwordConfirm" type="password" required>
					<label for="name">Confirmar contraseña</label>
				</div>
			</div>
			
			<div class="modal-footer">
				<a href="#" onclick="modPassword()" class="modal-action modal-close waves-effect waves-green btn-flat">Guardar</a>
				<a href="#"  class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
			</div>
		</div>
	</div>

    <!--  <script src="https://cointic.com.mx/preveer/sistema/assets/js/jquerymo.min.js"></script>
 <script src="https://cointic.com.mx/preveer/sistema/assets/js/jquery.tabledit.js"></script>
     <script src="https://cointic.com.mx/CDI/Panel/content/plugins/jquery-datatable/jquery.dataTables.js"></script> -->
    <script type="text/javascript">
        var tabla;
        $(document).ready( function ()
        {
            $(".js-video-button").modalVideo({
                youtube:{
                    controls:1,
                    nocookie: true
                }
            });
            $('.tooltipped').tooltip({delay: 30});
            tabla=$("#mainTable").DataTable({
                responsive: true,
                AutoWidth: true,
                autoFill: true,
                language: {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
            $('.modal').modal();
            $('input').attr("autocomplete", "new-password");
        } );
        var areaUs = <?php print json_encode($areaUs); ?>;
        var are = '{ "0" : "Seleccione una opción...", ';
        areaUs.forEach(function (element) {
            are += '"'+element.idArea+'": "'+element.nombreArea+'",';
        });
        var lastIndex = are.lastIndexOf(",");
        var JSONArea = are.substring(0,lastIndex)+"}";

        var TipoU = <?php print json_encode($TipoU); ?>;
        var tip = '{ "0" : "Seleccione una opción...", ';
        TipoU.forEach(function (element) {
            tip += '"'+element.idTipo+'": "'+element.nombreTipo+'",';
        });
        var lastIndexT = tip.lastIndexOf(",");
        var JSONTip = tip.substring(0,lastIndexT)+"}";

        <?php
        if(($permisos['editar']))
        {
        ?>

        $('#mainTable').Tabledit({
            url: '<?=base_url()?>index.php/Crudusuarios/editaDatos/',
            editButton: false,
            deleteButton:false,
            columns: {
                identifier: [0, 'idUser'],
                editable: [[1, 'nombrUs'],[2, 'nickN'],[3, 'correoD'],[4, 'idAre',JSONArea],[5, 'idTip',JSONTip]]
            },
            onFail: function(jqXHR, textStatus, errorThrown)
            {
                try {
                    let jsonError=JSON.parse(jqXHR['responseText']);
                    Swal.fire({
                        title: "Error",
                        type: 'error',
                        html: jsonError['message'],
                        showCloseButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'Ok!'

                    });
                }
                catch (e) {

                }

            }
        })

        function establecerUsuarioSeleccionado(idUser)
        {
            $( "input[type='checkbox']" ).prop({
                checked: false
            });

            $("#usuarioSeleccionado").val(idUser);
            console.log("limpiar");
        }
        function editarEmpresas(idUser)
        {
            establecerUsuarioSeleccionado(idUser);
            $.ajax({
                url: '<?=base_url('index.php/Crudusuarios/cargarEmpresasUsuario/')?>'+idUser,
                dataType: 'JSON',
                data: { [csrfName]: csrfHash},
                success: function (data)
                {
                    for(i=0; i<data.length; i++)
                    {
                        $("#cboxEmpresa"+data[i]['idEmpresaInterna']).prop({
                            checked: true
                        });
                    }
                },
                complete: function () {
                    $('#modalEmpresas').modal('open');
                }
            });

        }
		
		function editarContra(idUser)
        {
			$('#modalContra').modal('open');
			$("#userId").val(idUser);
			$("#passwordUs").val("");
			$("#passwordConfirm").val("");
        }
		
		function modPassword()
		{
			var password=$("#passwordUs").val();
			var passConfirm=$("#passwordConfirm").val();
			var idUser=$('#userId').val();
			var parametros={password:password,passConfirm:passConfirm,idUser:idUser, [csrfName]: csrfHash};

			if(password!="" && passConfirm!="")
			{
				if(password==passConfirm)
				{
				    if(password.length>=8)
                    {
                        $.ajax({
                            url: '<?=base_url('index.php/Crudusuarios/editaDatos')?>',
                            data: parametros,
                            type: 'POST',
                            dataType: 'HTML',
                            success: function (data)
                            {
                                Swal(
                                    'Hecho!',
                                    'La contraseña ha sido actualizada',
                                    'success'
                                );
                            }
                        });
                    }
                    else
                    {
                        Swal(
                            'Alerta!',
                            'Las contraseñas deben tener 8 caracteres como mínimo',
                            'warning'
                        );
                    }

				}else{
					Swal(
						'Alerta!',
						'Las contraseñas no coinciden',
						'warning'
                    );
				}
			}else{
				Swal(
					'Alerta!',
					'Llene el formulario vacio',
					'warning'
                );
			}

		}

        function activarUsuario(idUser)
    {
        if($("#activado"+idUser).prop("checked"))
            $.ajax({url: '<?=base_url('index.php/Crudusuarios/activarStatusUsuario')?>/'+idUser});
        else
            $.ajax({url: '<?=base_url('index.php/Crudusuarios/desactivarStatusUsuario')?>/'+idUser});
    }

        function editarTipos(idUser)
        {
            establecerUsuarioSeleccionado(idUser);
            $.ajax({
                url: '<?=base_url('index.php/Crudusuarios/cargarTiposContrato/')?>'+idUser,
                dataType: 'JSON',
                data: { [csrfName]: csrfHash},
                success: function (data)
                {
                    for(i=0; i<data.length; i++)
                    {
                        $("#cboxContrato"+data[i]['idTipoContrato']).prop({
                            checked: true
                        });
                    }
                },
                complete: function () {
                    $('#modalTiposContratos').modal('open');
                }
            });
        }
        function cambiarStatusEmpresaUsuario(idEmpresa)
        {
            if($("#cboxEmpresa"+idEmpresa).prop("checked"))
                $.ajax({url: '<?=base_url('index.php/Crudusuarios/asignarEmpresaUsuario')?>/'+idEmpresa+'/'+$("#usuarioSeleccionado").val(), data: { [csrfName]: csrfHash}});
            else
                $.ajax({url: '<?=base_url('index.php/Crudusuarios/eliminarEmpresaUsuario')?>/'+idEmpresa+'/'+$("#usuarioSeleccionado").val(), data: { [csrfName]: csrfHash}});
        }

        function cambiarStatusTiposContrato(idtipo)
        {
            if($("#cboxContrato"+idtipo).prop("checked"))
                $.ajax({url: '<?=base_url('index.php/Crudusuarios/asignarTiposContrato')?>/'+idtipo+'/'+$("#usuarioSeleccionado").val(), data:{ [csrfName]: csrfHash}});
            else
                $.ajax({url: '<?=base_url('index.php/Crudusuarios/eliminarTiposContrato')?>/'+idtipo+'/'+$("#usuarioSeleccionado").val(), data:{ [csrfName]: csrfHash}});
        }

        <?php
        }
        if(($permisos['eliminar']))
        {
        ?>
        function borrar(identificador, elemento)
        {
            Swal({
                title: 'Eliminar este registro?',
                text: "No se podran revertir los cambios!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
				cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value)
                {
                    $.post('<?=base_url('index.php/Crudusuarios/borrarUser')?>',
                        {id: identificador, [csrfName]: csrfHash},
                        function(response)
                        {
                            //console.log("dato "+response);
                            tabla.row($(elemento).closest('tr')).remove().draw();
                            //location.reload();
                            Swal(
                                'Borrado!',
                                'El registro fue eliminado',
                                'success'
                            );
                        }
                    ).fail(function (jqXHR, status, error) {
                        try {
                            let jsonError=JSON.parse(jqXHR['responseText']);
                            Swal.fire({
                                title: "Error",
                                type: 'error',
                                html: jsonError['message'],
                                showCloseButton: false,
                                showCancelButton: false,
                                confirmButtonText: 'Ok!'

                            });
                        }
                        catch (e) {

                        }
                    });
                }
            })
        }
        <?php
        }?>
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>

    <?php
}
?>