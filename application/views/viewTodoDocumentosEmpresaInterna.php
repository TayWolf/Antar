
<?php
if(!empty($permisos))
{
    ?>
    <div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s12"><h4 class="header">Documentos de la empresa <?=trim($nombreEmpresa)?></h4></div>
        </div>
        <div align="center">
            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudEmpresasInternas/')" data-target='dropdown1'>Regresar</a>
            <?php
            if($permisos['alta'])
            {
                ?>
                <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudEmpresasInternas/altaDocumentoEmpresaInterna/<?=$idEmpresaInterna?>')"
                   data-target='dropdown1'>Nuevo documento</a>
                <?php
            }?>
        </div>
        <div class="col s12">
            <div class="col s12 ">

                <table class="striped bordered" id="tabla">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del documento</th>
                        <th>Observaciones del documento</th>
                        <th>Documento</th>
                        <?php
                        if($permisos['editar'])
                        {
                            ?>
                            <th>Editar</th>
                            <?php
                        }
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
                    foreach ($documentos as $row)
                    {
                        $clase=($contador++%2==0)?'odd':'even';
                        echo "<tr class='$clase' role='row'>
                                <td id='indice".$row['idEmpresaInterna']."'>".$row['idDocumentoEmpresa']."</td>
                                <td>".$row['nombreDocumento']."</td>
                                <td><a href='#' onclick=\"verObservaciones('".rawurlencode($row['observaciones'])."')\">Observaciones</a></td>
                                <td><a href='".base_url('index.php/CrudEmpresasInternas/descargarArchivo/'.$row['idDocumentoEmpresa'])."' download>Descargar</a></td>";
                        if($permisos['editar'])
                            echo "<td><a href='#' onclick=\"loadUrl('CrudEmpresasInternas/editarDocumento/".$row['idDocumentoEmpresa']."')\">Editar</a></td>";
                        if($permisos['eliminar'])
                            echo "<td><a href='#' onclick=\"borrar(".$row['idDocumentoEmpresa'].",'".$row['documento']."' ,this)\">Eliminar</a></td>";
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

    <div id="modalObservaciones" class="modal">
        <div class="modal-content">
            <div class="col s12">
            <h4>Observaciones del documento</h4>
            <div class="col s10 offset-s1 input-field">
                <textarea id="observaciones" class="materialize-textarea input-field" readonly="readonly"></textarea>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <script>

        var tabla;
        $(document).ready( function ()
        {
            $('.modal').modal();
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

        } );
    </script>
    <script>

        function verObservaciones(observaciones)
        {
            $("#observaciones").html(decodeURIComponent(observaciones));
            $("#modalObservaciones").modal('open');
        }
        <?php

        if($permisos['eliminar'])
        {?>
        function borrar(identificador, nombreDocumento, elemento) {
            Swal({
                title: '¿Eliminar este documento?',
                text: "No se podrán revertir los cambios!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
				cancelmButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value) {
                    $.post('<?=base_url('index.php/CrudEmpresasInternas/borrarDocumentoEmpresa')?>',
                        {id: identificador, documento: nombreDocumento,  [csrfName]: csrfHash },
                        function (response) {
                            //console.log(response);
                            tabla.row($(elemento).closest('tr')).remove().draw();
                            Swal(
                                'Borrado!',
                                'El documento fue eliminado',
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