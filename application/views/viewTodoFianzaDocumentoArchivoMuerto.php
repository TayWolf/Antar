<?php
if(!empty($permisos))
{
    ?>
    <div class="container">

    <div class="row">
        <div class="col s12">
            <div class="col s12"><h4 class="header">Documentos de la fianza / garantía</h4></div>
        </div>


            <div class="col s12">
                <div align="center">
                    <a class='dropdown-trigger btn' href="#"
                       onclick="loadUrl('CrudArchivoMuerto/verFianzasContratoProyecto/<?php echo $idContratoProyecto; ?>')"
                       data-target='dropdown1'>Regresar</a>
                </div>
            </div>

            <div class="col s12">
                <div class="col s12 ">
                    <?=form_open('', 'id="formFinales"')?>
                    <table class="display dataTable" id="tabla">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Documento</th>
                            <th>Observaciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        //Este código muestra una tabla de todas los los documentos de una fianza.
                        // La consulta es FianzaDocumento->getAllDocumentos($idFianza)
                        $contador = 1;

                        foreach ($documentos as $row)
                        {
                            $clase = ($contador % 2 == 0) ? 'odd' : 'even';
                            $idDocumento = $row['idFianzaDocumento'];
                            $archivo = $row['documento'];
                            $observaciones = $row['observaciones'];

                            print "<tr class='$clase' role='row'>
                                <td id='indice" . $idDocumento . "'>" . $idDocumento . "</td>
                                <td><a href='" . base_url("index.php/CrudArchivoMuerto/descargarArchivoFianzaDocumento/" . $idDocumento ). "' download>Descargar</a></td>
                                <td><a href='#' onclick='verObservaciones($idDocumento, \"" . rawurlencode($observaciones) . "\")' id='clickObservacion" . $idDocumento . "'>Ver observaciones</a></td>";
                            print"</tr>";
                            $contador++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    </form>
                </div>
            </div>
        </div>
        <?=form_open('', 'id="formObservaciones"')?>
        <div id="modalObservaciones" class="modal">
            <div class="modal-content">
                <h4>Observaciones del documento</h4>
                <div id="contenidoModal">
                    <div class="row">
                        <div class="s12">
                            <textarea id="observaciones" name="observaciones" class="materialize-textarea"></textarea>
                            <input type="hidden" id="idDocumento" name="id">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#"
                   class="modal-action modal-close waves-effect waves-green btn-flat">Guardar y cerrar</a>
            </div>
        </div>
        </form>

        <script>

            $(document).ready(function () {

                tabla = $("#tabla").DataTable({
                    AutoWidth: true,
                    responsive: true,
                    language: {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });
                $("#modalObservaciones").modal();
            });
            <?php
            if($permisos['eliminar'])
            {
            ?>
            function confirmaDeleteDocumento(idVersion, nombreArchivo, elemento) {
                swal({
                    title: "Aviso",
                    text: "¿Desea borrar este documento?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.value) {
                        $.post(
                            '<?=base_url("index.php/CrudFianzaDocumento/eliminarDatosDocumento")?>',
                            {idDocumento: idVersion, archivo: nombreArchivo}
                        );
                        tabla.row($(elemento).closest('tr')).remove().draw();
                        Swal(
                            'Borrado!',
                            'El documento fue eliminado',
                            'success'
                        );
                    }
                });
            }
            <?php
            }?>
            function verObservaciones(idDocumento, observacion) {
                $("#observaciones").val(decodeURIComponent(observacion));
                $("#idDocumento").val(idDocumento);
                $("#modalObservaciones").modal('open');
            }
            <?php
            if($permisos['editar'])
            {
            ?>
            function actualizarObservacion() {
                formdata = new FormData(document.getElementById("formObservaciones"));
                $.ajax({
                    url: '<?=base_url('index.php/CrudFianzaDocumento/editarDocumento')?>',
                    data: formdata,
                    contentType: false,
                    processData: false,
                    cache: false,
                    type: 'post',
                    dataType: 'JSON',
                    success: function (data) {
                        //actualiza la observación hecha
                        $("#clickObservacion" + $("#idDocumento").val()).attr("onClick", "verObservaciones(" + $("#idDocumento").val() + ",'" + encodeURIComponent(data['observaciones']) + "');");
                    }

                });
            }
            <?php
            }?>
            var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>


    </div>
    <?php
}?>