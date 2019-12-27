
<?php
if(!empty($permisos))
{
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );
    ?>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="col s11"><h4 class="header">Clientes / Proveedores</h4></div>
                <div class="col s1">
                    <div class="col s8 offset-s2">
                        <a class="tooltipped js-video-button" data-video-id='m7dOZCXQPrA' data-position="left" data-delay="30" data-tooltip="¿Necesitas ayuda?" style="padding: 0px !important;"><i class="medium material-icons">ondemand_video</i></a>
                    </div>
                </div>
            </div>
            <div align="center">
                <?php
                if($permisos['alta'])
                {
                    ?>
                    <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudEmpresas/altaEmpresa')"
                       data-target='dropdown1'>Nuevo cliente / Proveedor</a>
                    <?php
                }?>
            </div>
            <div class="col s12">
                <div class="col s12 ">

                    <table class="striped bordered" id="tabla">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del cliente / Proveedor</th>
                            <th>RFC</th>
                            <th>Razón social</th>
                            <?php
                            if($permisosDocumento['mostrar'])
                            {
                                ?>
                            <th>Documentos</th>
                            <?php
                            }
                            ?>
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
                        foreach ($infoEmpresa as $row)
                        {
                            $clase=($contador++%2==0)?'odd':'even';
                            echo "<tr class='$clase' role='row'>
                                <td id='indice".$row['idEmpresa']."'>".$row['idEmpresa']."</td>
                                <td>".$row['nombre']."</td>
                                <td>".$row['RFC']."</td>
                                <td>".$row['razon_social']."</td>";
                                 if($permisosDocumento['mostrar'])
                            echo "<td><a href='#' onclick='editarDocumentos(".$row['idEmpresa'].")'>Documentos</a></td>";

                            if($permisos['eliminar'])
                                echo "<td><a href='#' onclick='borrar(".$row['idEmpresa'].", this)'>Eliminar</a></td>";
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
                    responsive: true,
                    AutoWidth: true,
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
                    url: '<?=base_url('index.php/CrudEmpresas/editarEmpresa')?>',
                    columns: {
                        identifier: [0, 'id'],
                        editable: [[1, 'nombre'], [2, 'RFC'], [3, 'razon_social']]
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
                }?>
                $("#modalDocumentos").modal();
            } );
        </script>
        <script>
            var numeroDocumentos=0;
            function editarDocumentos(idEmpresa)
            {
                $.ajax({
                    url:'<?=base_url('index.php/CrudEmpresas/traerDocumentos/')?>'+idEmpresa,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    data: { [csrfName]: csrfHash},
                    success: function (response)
                    {
                        numeroDocumentos=0;
                        $("#contenidoModal").html("<form class=\"col s12\" id=\"formulario\">" +
                                "<input type=\"hidden\" name=\"<?=$csrf['name'];?>\" value=\"<?=$csrf['hash'];?>\" />\n"+
                            "<input type=\"hidden\" id=\"idEmpresaSeleccionada\" name=\"idEmpresa\" value=\""+idEmpresa+"\">" +
                            "</form>");
                        var link='<?=base_url('assets/img/fotoEmpresas/')?>';

                        var observaciones;
                        for(i=0; i<response.length; i++)
                        {
                            observaciones=(response[i]['observaciones'])?"<p>Observaciones: "+response[i]['observaciones']+"</p>":"";
                            //documentos actuales
                            $("#formulario").append("<div class='col s6' align='center'>" +
                                "<b>"+response[i]['nombreDocumento']+"</b>" +
                                "<div class='col s12' align='center'>" +
                                "<input class='dropify' name='documentoEmpresa"+i+"' data-default-file='"+link+response[i]['documento']+"' onChange=\"cambiarDocumento('"+response[i]['idClienteDocumento']+"', this)\">" +
                                observaciones+
                                "<a download href='"+'<?=base_url('index.php/CrudEmpresas/descargarDocumentoEmpresa/')?>'+response[i]['idClienteDocumento']+"'>Descargar "+response[i]['nombreDocumento']+"</a>" +
                                "</div>" +
                                "</div>");
                        }
                        //nuevos documentos
                        //alert(<?php $permisosDocumento['alta']; ?>)
                        <?php
                            if($permisosDocumento['alta'])
                            {
                        ?>
                        $("#contenidoModal").append("<div class='row' id=\"otrosDocumentos\"></div>" +
                            "<div class='col s6' align='center'>" +
                            "<a href=\"#\" onclick=\"agregarOtrosDocumentos()\" class=\"btn waves-light waves-effect\">" +
                            "<i class=\"material-icons\">add_box</i> Agregar otros documentos</a>" +
                            "</div>");
                        <?php
                            }
                            ?>
                        $('.dropify').dropify({
                            messages: {
                                'default': 'Arrastra y suelta un archivo o haz clic',
                                'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                                'remove':  'Remover',
                                'error':   'Ooops, ocurrió un error.'
                            }
                        }).on('dropify.beforeClear', function(event, element)
                        {
                            <?php
                            if($permisosDocumento['eliminar'])
                            {
                            ?>
                            if (confirm("Realmente quiere borrar el archivo? \"" + element.filename + "\" ?"))
                                $.ajax({
                                    url: '<?=base_url('index.php/CrudEmpresas/borrarArchivo/')?>' + element.filename,
                                    contentType: false,
                                    processData: false,
                                    cache: false,
                                    dataType: 'HTML',
                                    data: { [csrfName]: csrfHash},
                                    success: function () {
                                        $(element).remove();
                                    }
                                });
                            <?php
                            }
                            ?>
                        });
                        $("#modalDocumentos").modal('open');
                    }, error: function (jqXHR, status, error) {
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
            }
            <?php
            if($permisos['editar'])
            {
            ?>
            function agregarOtrosDocumentos()
            {
                $("#otrosDocumentos").append("<div class=\"col s6\">" +
                    "        <input form='documentos' placeholder='Nombre del documento' name=\"nombreOtroDocumento"+numeroDocumentos+"\" id=\"nombreOtroDocumento"+numeroDocumentos+"\" class=\"input-field\" type=\"text\">" +
                    "        <input form='documentos' type=\"file\" class=\"dropify\" id=\"otroDocumento"+numeroDocumentos+"\" name=\"otroDocumento"+numeroDocumentos+"\" />" +
                    "        <input form='documentos' placeholder='Observaciones' name=\"observacionOtroDocumento"+numeroDocumentos+"\" id=\"observacionOtroDocumento"+numeroDocumentos+"\" class=\"input-field\">" +
                    "    </div>");
                $('#otroDocumento'+numeroDocumentos).dropify({
                    messages: {
                        'default': 'Arrastra y suelta un archivo o haz clic',
                        'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                        'remove':  'Remover',
                        'error':   'Ooops, ocurrió un error.'}});
                numeroDocumentos++;
            }
            function guardarNuevosDocumentos()
            {
                formdata=new FormData(document.getElementById("documentos"));
                $.ajax({
                    url: '<?=base_url('index.php/CrudEmpresas/subirDocumentoOpcional/')?>'+$("#idEmpresaSeleccionada").val()+"/"+numeroDocumentos,
                    data: formdata,
                    type: 'POST',
                    processData: false,
                    contentType: false
                });
            }
            function cambiarDocumento(idClienteDocumento, elemento)
            {
                formData = new FormData();
                formData.append("documento", $(elemento)[0].files[0]);
                form.append('<?=$csrf['name']?>','<?=$csrf['hash']?>');
                $.ajax({
                    url: '<?=base_url('index.php/CrudEmpresas/cambiarDocumento/')?>'+idClienteDocumento,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false
                });
            }
            <?php
            }
            if($permisos['eliminar'])
            {?>
            function borrar(identificador, elemento) {
                Swal({
                    title: 'Eliminar este registro?',
                    text: "No se podran revertir los cambios!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.value) {
                        $.post('<?=base_url('index.php/CrudEmpresas/borrarEmpresa')?>',
                            {id: identificador, [csrfName]: csrfHash},
                            function (response) {
                                tabla.row($(elemento).closest('tr')).remove().draw();
                                Swal(
                                    'Borrado!',
                                    'El registro fue eliminado',
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
        <?=form_open('', 'id="documentos"')?>
        </form>
        <!-- Modal Structure -->
        <div id="modalDocumentos" class="modal">
            <div class="modal-content">
                <h4>Documentos del cliente/proveedor</h4>
                <div class="row">
                    <div id="contenidoModal" class="col s12">

                    </div>
                </div>
            </div>
            
            <?php

              if($permisosDocumento['editar'])
                {
            ?>
            <div class="modal-footer">
                <a href="#"  onclick="guardarNuevosDocumentos()" class="modal-action modal-close waves-effect waves-green btn-flat">Guardar</a>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
    <?php
}
?>