
<?php
if(!empty($permisos))
{
    ?>
    <div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">Empresas internas</h4></div>
            <div class="col s1">
                <div class="col s8 offset-s2">
                    <a class="tooltipped js-video-button" data-video-id='g6EAof4MqeU' data-position="left" data-delay="30" data-tooltip="¿Necesitas ayuda?" style="padding: 0px !important;"><i class="medium material-icons">ondemand_video</i></a>
                </div>
            </div>
        </div>
        <div align="center">
            <?php
            if($permisos['alta'])
            {
                ?>
                <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudEmpresasInternas/altaEmpresaInterna')"
                   data-target='dropdown1'>Nueva empresa</a>
                <?php
            }?>
        </div>
        <div class="col s12">
            <div class="col s12 ">

                <table class="striped bordered" id="tabla">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de la empresa</th>
                        <?php
                        if($permisosDocumentos['mostrar'])
                        {
                            ?>
                            <th>Documentos</th>
                            <?php
                        }?>
                        <?php
                        if($permisos['eliminar'])
                        {
                            ?>
                            <th>Eliminar</th>
                            <?php
                        }?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $contador=1;
                    foreach ($empresas as $row)
                    {
                        $clase=($contador++%2==0)?'odd':'even';
                        echo "<tr class='$clase' role='row'>
                                <td id='indice".$row['idEmpresaInterna']."'>".$row['idEmpresaInterna']."</td>
                                <td>".$row['nombreEmpresa']."</td>";
                        if($permisosDocumentos['mostrar'])
                        {
                            echo "<td><a href='#' onclick=\"loadUrl('CrudEmpresasInternas/verDocumentosEmpresa/".$row['idEmpresaInterna']."')\">Ver documentos</a></td>";
                        }
                        if($permisos['eliminar'])
                            echo "<td><a href='#' onclick='borrar(".$row['idEmpresaInterna'].", this)'>Eliminar</a></td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script>

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
            tabla=$("#tabla").DataTable({
                AutoWidth: true,
                responsive: true,

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
                    delete: {
                        class: 'btn btn-sm btn-danger',
                        html: '<i class="material-icons">delete</i>',
                        action: 'delete'
                    },
                    confirm: {
                        class: 'btn btn-sm btn-default',
                        html: 'Confirmar'
                    }
                },
                url: '<?=base_url('index.php/CrudEmpresasInternas/editarEmpresaInterna')?>',
                columns: {
                    identifier: [0, 'id'],
                    editable: [[1, 'nombre']]
                },onFail: function (jqXHR, status, error) {
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
            }?>
            $("#modalDocumentos").modal();
        } );
    </script>
    <script>

        <?php

        if($permisos['eliminar'])
        {?>
        function borrar(identificador, elemento) {
            Swal({
                title: 'Eliminar esta empresa?',
                text: "No se podrán revertir los cambios!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
				cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value) {
                    $.post('<?=base_url('index.php/CrudEmpresasInternas/borrarEmpresa')?>',
                        {id: identificador,  [csrfName]: csrfHash },
                        function (response) {
                            //console.log(response);
                            tabla.row($(elemento).closest('tr')).remove().draw();
                            Swal(
                                'Borrada!',
                                'La empresa fue eliminada',
                                'success'
                            );
                        }
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

                }
            });

        }
        <?php
        }?>
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>
    <?php
}
?>