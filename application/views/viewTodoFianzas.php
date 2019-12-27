<?php if(!empty($permisos))
{
    ?>
    <div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s11"><h4 class="header">Fianzas / Garantía</h4></div>
            <div class="col s1">
                <div class="col s8 offset-s2">
                    <a class="tooltipped js-video-button" data-video-id='lVNPnGXkocY' data-position="left" data-delay="30" data-tooltip="¿Necesitas ayuda?" style="padding: 0px !important;"><i class="medium material-icons">ondemand_video</i></a>
                </div>
            </div>

        </div>

        <?php
        if(($permisos['alta']))
        {
            ?>

            <div class="col s12">
                <div align="center">
                    <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudFianzas/altaNuevaFianza')" data-target='dropdown1'>Nueva fianza / garantía</a>
                </div>
            </div>

            <?php
        }
        ?>

        <div class="col s12">
            <div class="col s12 ">
                <table class="display dataTable" id="tabla">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de la fianza / garantía</th>

                        <?php
                        if(($permisos['eliminar']))
                        {
                            ?>
                            <th>Eliminar</th>
                            <?php
                        }?>

                    </tr>
                    </thead>
                    <tbody>

                    <?php
					$contador=0;
                    foreach ($CatalogoFianzas as $row)
                    {	$clase=($contador%2==0)?'odd':'even';
						$idCatalogoFianza = $row['idCatalogoFianza'];
						//$nombre = $row['nombre'];

                        //print "<li class='ordenacion'><input id='item".$contador."' name='item".$contador."' type='hidden' value='".$idCatalogoFianza."'>".$nombre."</li>";
						print "<tr class='$clase' role='row'>
                                <td id='indice".$idCatalogoFianza."'>".$idCatalogoFianza."</td>
                                <td>".$row['nombre']."</td>";


                        if($permisos['eliminar'])
                        {
                            print "<td><a href='#' onclick='confirmaDeleteFianza($idCatalogoFianza, this)'>Eliminar</a></td>";
                        }
                        print "</tr>";
                    }
                    ?>

                    </tbody>

                    <tfoot>

                    </tfoot>

                </table>

            </div>
			<div class="row">
                <div class="col s4 offset-s4" align="center">
                    <a href="#" class="btn" onClick="ordenarFianzas()">Ordenar</a>
                </div>
            </div>


        </div>

    </div>
	
	<!-- Modal -->
    <div id="modalOrdenacionFianzas" class="modal">
        <div class="modal-content">
            <h4>Arrastra y suelta para ordenar</h4>
            <div id="ordenFianzas">
                <ul id="listaOrdenacion" style="cursor:pointer;">
                    <?php

                    $contador=0;
                    foreach ($CatalogoFianzas as $row)
                    {
						$idCatalogoFianza = $row['idCatalogoFianza'];
						$nombre = $row['nombre'];

                        print "<li class='ordenacion'><input id='item".$contador."' name='item".$contador."' type='hidden' value='".$idCatalogoFianza."'>".$nombre."</li>";
						$contador++;
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" onClick="guardarOrden()" class="modal-close waves-effect waves-green btn-flat">Guardar & cerrar</a>
			<a href="#" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        </div>
    </div>

<script>
	function guardarOrden()
	{
		var array=[];
		$( ".ordenacion" ).each(function( index ) {
			array.push($(this).children("input").val());
		});

		$.ajax({
			url: '<?=base_url('index.php/CrudFianzas/ordenarFianzas')?>',
			data: {arreglo: array,  [csrfName]: csrfHash },
			type: 'POST',
			dataType: 'JSON',
			success: function (data)
			{
				swal("Éxito!", "Se ordenaron las fianzas correctamente!", "success");
				loadUrl("CrudFianzas");
			}
		});
	}

	function ordenarFianzas() 
	{
		$("#modalOrdenacionFianzas").modal('open');
	}


        $(document).ready( function (){
            $(".js-video-button").modalVideo({
                youtube:{
                    controls:1,
                    nocookie: true
                }
            });
            $('.tooltipped').tooltip({delay: 30});
		$('.modal').modal();
		$("#listaOrdenacion").sortable();
            tabla=$("#tabla").DataTable({
                AutoWidth: true,
                responsive: true,
				ordering: false,
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

            <?php
            if($permisos['editar'])
            {
            ?>

            $('#tabla').Tabledit({
                editButton: false,
                deleteButton: false,
                restoreButton: false,
                buttons: {
                    confirm: {
                        class: 'btn btn-sm btn-default',
                        html: 'Confirmar'
                    }
                },
                url: "<?=base_url('index.php/CrudFianzas/actualizarDatosFianza')?>",
                columns: {
                    identifier: [0, 'idFianza'],
                    editable: [ [1, 'nombre'] ]
                }, onFail: function (jqXHR, status, error) {
                    try{
                        let jsonError=JSON.parse(jqXHR['responseText']);
                        Swal.fire({
                            title: "Error",
                            type: 'error',
                            html: jsonError['message'],
                            showCloseButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Ok!'

                        });
                    }catch (e) {

                    }
                }
            });
            <?php
            }

            ?>

        });

        <?php
        if($permisos['eliminar'])
        {
        ?>

        function confirmaDeleteFianza(id, elemento)
        {
            swal({
                title: "Aviso",
                text: "¿Desea borrar esta fianza / garantía?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.value) {
                    $.post(
                        '<?=base_url("index.php/CrudFianzas/eliminarDatosFianza")?>',
                        { idFianza : id,  [csrfName]: csrfHash }
                    ).fail(function (jqXHR, status, error) {
                        try{
                            let jsonError=JSON.parse(jqXHR['responseText']);
                            Swal.fire({
                                title: "Error",
                                type: 'error',
                                html: jsonError['message'],
                                showCloseButton: false,
                                showCancelButton: false,
                                confirmButtonText: 'Ok!'

                            });
                        }catch (e) {

                        }
                    });
                    tabla.row($(elemento).closest('tr')).remove().draw();
                    Swal(
                        'Borrado!',
                        'El registro fue eliminado',
                        'success'
                    );
                }
            });
        }

        <?php
        }
        ?>
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>

    <?php
}
?>
