<?php
if(!empty($permisos))
{
    ?>


    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="col s12"><h4 class="header">Fianzas / garantías del contrato</h4></div>
            </div>

            <div class="col s12" >
                <div align="center">

                    <a class='dropdown-trigger btn' href="#"
                       onclick="loadUrl('CrudArchivoMuerto')"
                       data-target='dropdown1'>Regresar</a>

                </div>
            </div>

            <div class="col s12">
                <div class="col s12 ">
                    <table class="display dataTable" id="tabla">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fianza / garantía</th>
                            <th>Condiciones</th>
                            <th>Monto (MXN)</th>
                            <th>Vigencia (AAAA-MM-DD)</th>
                            <th>Terminado</th>

                            <?php
                            if($permisos['detalle'])
                            {
                                ?>
                                <th>Status</th>
                                <?php
                            }
                            if(!empty($permisosDocumentosFianza)&&$permisosDocumentosFianza['mostrar'])
                            {
                                ?>
                                <th>Documentos</th>
                                <?php
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $contador=1;
                        $posiblesEstadosVigentes=array(
                            array("value" =>"Vigente no pagado",  "class" =>"btn light-blue darken-1 center-align","style" =>"font-size: 10px; padding: 0; width: 100%;"),
                            array("value" =>"Vigente pagado",   "class" =>"btn teal darken-4 center-align", "style" =>"font-size: 10px;  padding: 0; width: 100%;" )
                        );
                        $posiblesEstadosExpirados=array(
                            array("value" =>"Expirado no pagado",  "class" =>"btn red darken-1 center-align","style" =>"font-size: 10px; padding: 0; width: 100%;"),
                            array("value" =>"Expirado pagado",   "class" =>"btn purple darken-4 center-align", "style" =>"font-size: 10px;  padding: 0; width: 100%;" )
                        );
                        foreach ($fianzasContratos as $row)
                        {

                            $idContratoProyecto=$row['idContratoProyecto'];
                            $clase=($contador%2==0)?'odd':'even';
                            $idFianza = $row['idFianza'];
                            $status=$row['status'];
                            $statusFinalizado=$row['statusFinalizado'];
                            if ($statusFinalizado==1) {
                                $checkMarcado="checked";
                            }else{
                                $checkMarcado="";
                            }
                            $vigente=1;
                            if(strtotime($row['vigencia'])<strtotime(date("Y-m-d")))
                            {
                                $vigente=0;
                            }

                            $status=$row['status'];


                            if($vigente)
                                $botonStatus="<a value='".$posiblesEstadosVigentes[$status]["value"]."' class='".$posiblesEstadosVigentes[$status]["class"]."' style='".$posiblesEstadosVigentes[$status]["style"]."' id='botonStatus".$idFianza."'>".$posiblesEstadosVigentes[$status]["value"]."</a>";
                            else
                                $botonStatus="<a value='".$posiblesEstadosExpirados[$status]["value"]."' class='".$posiblesEstadosExpirados[$status]["class"]."' style='".$posiblesEstadosExpirados[$status]["style"]."' id='botonStatus".$idFianza."'>".$posiblesEstadosExpirados[$status]["value"]."</a>";

                            print "<tr class='$clase' role='row'>
                                <td id='indice".$idFianza."'>".$idFianza."</td>
                                <td>".$row['nombre']."</td>
                                <td><a onClick='verCondicion(".$row['idFianza'].", \"".rawurlencode($row['condiciones'])."\")' id='clickCondicion".$row['idFianza']."'>Ver condiciones</td>
                                <td>".$row['monto']."</td>
                                <td>".$row['vigencia']."</td>
                                <td><input type='checkbox' ".$checkMarcado." onClick='VerificarAntesF($idFianza)' id='finalZ".$idFianza."' name='finalZ".$idFianza."'  value='".$row['statusFinalizado']."'><label for='finalZ".$idFianza."'></label></td></td>";
                            if($permisos['detalle'])
                                print"<td>".$botonStatus."</td>";
                            if(!empty($permisosDocumentosFianza)&&$permisosDocumentosFianza['mostrar'])
                                print"<td><a href='#' onclick='loadUrl(\"CrudArchivoMuerto/verDocumentos/$idFianza/$idContratoProyecto/$fianzaIndividual\")'>Documentos</a></td>";

                            print"</tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    <?php
                    if($permisos['mostrar'])
                    {
                        ?>
                        <div class="row">
                            <div class="col offset-s4 s4" align="center">
                                <a class="btn waves-light gradient-45deg-red-pink"
                                   href="<?=base_url("index.php/CrudGeneradorPDF/generarFianzasFinalizadas/".$sinContratoProyecto."/".urlencode($fechaInicial)."/".urlencode($fechaFinal)."/$idVigencia/$idPago/$idEmpresaInterna")?>">Exportar</a>
                            </div>
                        </div>
                        <?php
                    }?>
                </div>

            </div>
        </div>
        <?=form_open("", 'id="formCondiciones"')?>

        <div id="modalCondiciones" class="modal">
            <div class="modal-content">
                <h4>Condiciones de la fianza / garantía</h4>
                <div id="contenidoModal">
                    <div class="row">
                        <div class="s12">
                            <textarea id="condicionesFianza" name="condicionesFianza" class="materialize-textarea"></textarea>
                            <input type="hidden" id="idCondicionFianza" name="id">
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

            $(document).ready( function (){

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
                /*$('#tabla').Tabledit({
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
                    url: '</?=base_url('index.php/CrudProyectos/editarFianzaContrato')?>',
                    columns: {
                        identifier: [0, 'id'],
                        editable: [[1, 'nombre'], [3, 'monto'], [4, 'vigencia']]
                    }
                });*/
                <?php
                }?>
                $("#modalCondiciones").modal();


            });
            <?php
            if($permisos['eliminar'])
            {
            ?>
            function confirmaDeleteFianzaContrato(id, elemento) {
                swal({
                    title: "Aviso",
                    text: "¿Desea borrar esta fianza?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.value) {
                        $.post(
                            '<?=base_url("index.php/CrudProyectos/eliminarDatosFianzaContrato")?>',
                            {idFianza: id,  [csrfName]: csrfHash }
                        );
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
            function enDesarrollo()
            {
                Swal(
                    'Opps!',
                    'Módulo en desarrollo',
                    'warning'
                );
            }

            function verCondicion(idFianza, condicion)
            {
                $("#condicionesFianza").val(decodeURIComponent(condicion));
                $("#idCondicionFianza").val(idFianza);
                $("#modalCondiciones").modal('open');

            }
            <?php
            if($permisos['editar'])
            {
            ?>
            function actualizarCondicion() {
                formdata = new FormData(document.getElementById("formCondiciones"));
                $.ajax({
                    url: '<?=base_url('index.php/CrudProyectos/editarFianzaContrato')?>',
                    data: formdata,
                    contentType: false,
                    processData: false,
                    cache: false,
                    type: 'post',
                    dataType: 'JSON',
                    success: function (data) {
                        $("#clickCondicion" + $("#idCondicionFianza").val()).attr("onClick", "verCondicion(" + $("#idCondicionFianza").val() + ",'" + encodeURIComponent(data['condiciones']) + "');");
                    }


                });
            }
            <?php
            }
            if($permisos['detalle'])
            {
            ?>
            var estados =<?=json_encode($posiblesEstadosVigentes)?>;
            var estadosExpirados =<?=json_encode($posiblesEstadosExpirados)?>;

            function siguienteStatus(estadoActual, idFianza, vigencia) {
                if (++estadoActual >= estados.length)
                    estadoActual = 0;
                //TODO: MANDAR AJAX para cambiar status de idContratoProyecto
                $.ajax({
                    url: '<?=base_url('index.php/CrudProyectos/cambiarEstadoFianzaContrato/')?>' + estadoActual + '/' + idFianza,
                    data: { [csrfName]: csrfHash}
                });
                if (vigencia == 1) {
                    $("#botonStatus" + idFianza).attr("value", estados[estadoActual]["value"]);
                    $("#botonStatus" + idFianza).attr("class", estados[estadoActual]["class"]);
                    $("#botonStatus" + idFianza).attr("style", estados[estadoActual]["style"]);
                    $("#botonStatus" + idFianza).html(estados[estadoActual]["value"]);
                }
                else {
                    $("#botonStatus" + idFianza).attr("value", estadosExpirados[estadoActual]["value"]);
                    $("#botonStatus" + idFianza).attr("class", estadosExpirados[estadoActual]["class"]);
                    $("#botonStatus" + idFianza).attr("style", estadosExpirados[estadoActual]["style"]);
                    $("#botonStatus" + idFianza).html(estadosExpirados[estadoActual]["value"]);
                }

                $("#botonStatus" + idFianza).attr("onClick", "siguienteStatus(" + estadoActual + ", " + idFianza + ", " + vigencia + ")");
            }
            <?php
            }?>

            function VerificarAntesF(idF)
            {
                $.ajax({
                    url : "<?=base_url('index.php/CrudProyectos/verificarStatusFinalizadoFianzas/')?>"+idF,
                    type: "post",
                    dataType: "JSON",
                    data: {[csrfName]: csrfHash},
                    success: function(data)
                    {
                        var status=data.statusFinalizado;

                        marcarFinalizadoFi(idF,status)
                    }
                });

            }

            function marcarFinalizadoFi(idF,finalZ)
            {
                //var finalZ=$("#finalZ"+idC).val();
                if (finalZ==0) {
                    finalZ=1;
                }else if (finalZ==1) {
                    finalZ=0;
                }

                $.ajax({
                    url : "<?=base_url('index.php/CrudProyectos/ActualizaDefinitivoF/')?>" + finalZ+"/"+idF,
                    type: "post",
                    dataType: "JSON",
                    data: { [csrfName]: csrfHash},
                    success: function(data)
                    {

                    }
                });

            }
            var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
    </div>

    <?php
}
?>