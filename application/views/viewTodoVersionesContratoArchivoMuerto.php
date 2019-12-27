<?php
if(!empty($permisos)) {
    ?>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="col s12"><h4 class="header">Rediciones del contrato</h4></div>
            </div>

            <div class="col s12">
                <div align="center">
                    <a class='dropdown-trigger btn' href="#"
                       onclick="loadUrl('CrudArchivoMuerto')"
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
                            <th>Número de redición</th>
                            <th>Archivo</th>
                            <?php
                            if($permisos['detalle'])
                            {
                                ?>
                                <th>Ver observaciones</th>
                                <?php
                            }?>
                            <th>¿Redición Final?</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $contador = 1;

                        foreach ($versiones as $row) {
                            $clase = ($contador % 2 == 0) ? 'odd' : 'even';
                            $idVersion = $row['idVersionContrato'];
                            $archivo = $row['archivo'];
                            $observaciones = $row['observaciones'];
                            $final = ($row['final']) ? 'checked' : '';

                            print "<tr class='$clase' role='row'>
                                <td id='indice" . $idVersion . "'>" . $idVersion . "</td>
                                <td>" . $contador++ . "</td>
                                <td><a href='" . base_url("index.php/CrudArchivoMuerto/descargarArchivoRel/" . $idVersion) . "' download>Descargar</a></td>";
                            if($permisos['detalle'])
                                print"<td><a href='#' onclick='verObservaciones($idVersion, \"" . rawurlencode($observaciones) . "\")' id='clickObservacion" . $idVersion . "'>Ver observaciones</a></td>";
                            print"<td><p><input " . $final . " value='" . $idVersion . "' name='versionFinal' disabled type='radio' id='versionFinal" . $idVersion . "' disabled><label for='versionFinal" . $idVersion . "'> </label></p></td>";
                            print"</tr>";
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
                <h4>Observaciones de la redición</h4>
                <div id="contenidoModal">
                    <div class="row">
                        <div class="s12">
                            <textarea id="observaciones" name="observaciones" class="materialize-textarea"></textarea>
                            <input type="hidden" id="idVersion" name="id">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Guardar y cerrar</a>
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

            function verObservaciones(idVersion, observacion) {
                $("#observaciones").val(decodeURIComponent(observacion));
                $("#idVersion").val(idVersion);
                $("#modalObservaciones").modal('open');
            }
            <?php
            if($permisos['editar'])
            {
            ?>
            function actualizarObservacion() {
                formdata = new FormData(document.getElementById("formObservaciones"));
                $.ajax({
                    url: '<?=base_url('index.php/CrudProyectos/editarVersion')?>',
                    data: formdata,
                    contentType: false,
                    processData: false,
                    cache: false,
                    type: 'post',
                    dataType: 'JSON',
                    success: function (data) {
                        //actualiza la observación hecha
                        $("#clickObservacion" + $("#idVersion").val()).attr("onClick", "verObservaciones(" + $("#idVersion").val() + ",'" + encodeURIComponent(data['observaciones']) + "');");
                    }

                });
            }
            <?php
            }
            if($permisos['eliminar'])
            {
            ?>

            function confirmaDeleteVersionContrato(idVersion, idContratoProyecto, nombreArchivo, elemento) {
                swal({
                    title: "Aviso",
                    text: "¿Desea borrar esta redición del contrato?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.value) {
                        $.post(
                            '<?=base_url("index.php/CrudProyectos/eliminarDatosVersionContrato")?>',
                            {idVersion: idVersion, idContratoProyecto: idContratoProyecto, archivo: nombreArchivo,  [csrfName]: csrfHash }
                        );
                        tabla.row($(elemento).closest('tr')).remove().draw();
                        Swal(
                            'Borrado!',
                            'La redición fue eliminada',
                            'success'
                        );
                    }
                });
            }
            <?php
            }
            if($permisos['editar']){?>

            function cambiarVersionFinal(idVersion, idContratoProyecto) {
                if ($("#versionFinal" + idVersion).is(":checked")) {
                    $.ajax({
                        url: '<?=base_url('index.php/CrudProyectos/establecerVersionFinal/')?>' + idVersion + "/" + idContratoProyecto,
                        type: 'POST',
                        dataType: 'HTML',
                        data: { [csrfName]: csrfHash},
                        success: function (data) {
                            swal('Éxito', 'Se ha establecido la nueva redición del contrato', 'success');
                        }

                    })
                }
            }
            <?php
            }?>
            var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
    </div>
    <?php

}?>