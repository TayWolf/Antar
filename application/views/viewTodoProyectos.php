<?php
if(!empty($permisos))
{
    ?>

    <div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">Proyectos</h4></div>
            <div class="col s1">
                <div class="col s8 offset-s2">
                    <a class="tooltipped js-video-button" data-video-id='yv1b7so0lGw' data-position="left" data-delay="30" data-tooltip="¿Necesitas ayuda?" style="padding: 0px !important;"><i class="medium material-icons">ondemand_video</i></a>
                </div>
            </div>
        </div>
        <div class="col s12" >
            <?php
            if($permisos['alta'])
            {
                ?>
                <div align="center">
                    <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudProyectos/altaNuevoProyecto')" data-target='dropdown1'>Nuevo proyecto</a>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="col s12">
            <div class="col s12 ">
                <table class="display dataTable" id="tabla">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del proyecto</th>
                        <th>Empresa</th>
                       
                        <?php
                        if(!empty($permisosContratos)&&$permisosContratos['mostrar'])
                        {
                            ?>
                            <th>Contratos</th>
                            <?php
                        }
                        ?>
                        <?php
                        if($permisos['eliminar'])
                        {?>
                            <th>Eliminar</th>
                            <?php
                        }?>
                    </tr>

                    </thead>
                    
                    <tbody>

                    <?php

                    $contador=1;

                    foreach ($proyectos as $row)
                    {
                        $clase=($contador%2==0)?'odd':'even';
                        $idProyecto = $row['idProyecto'];

                        print "<tr class='$clase' role='row'>
                                <td id='indice".$idProyecto."'>".$idProyecto."</td>
                                <td>".$row['nombreProyecto']."</td>";
                        foreach ($empresasInternas as $empresa)
                        {
                            if($row['idEmpresaInterna']==$empresa['idEmpresaInterna'])
                            {
                                echo "<td>".$empresa['nombreEmpresa']."</td>";
                                break;
                            }
                        }
                        
                        if(!empty($permisosContratos)&&$permisosContratos['mostrar'])
                            echo "<td><a href='#' onclick='loadUrl(\"CrudProyectos/Solicitudes/".$row['idProyecto']."\")'>Ver</a></td>";
                        if($permisos['eliminar'])
                            echo"<td><a href='#' onclick='confirmaDeleteProyecto($idProyecto, this)'>Eliminar</a></td>";
                        echo"</tr>";
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

        $(document).ready( function (){
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
                    confirm: {
                        class: 'btn btn-sm btn-default',
                        html: 'Confirmar'
                    }
                },
                url: "<?=base_url('index.php/CrudProyectos/actualizarDatosProyecto')?>",
                columns: {
                    identifier: [0, 'idProyecto'],
                    editable: [[1, 'nombreProyecto'],[2, 'idEmpresaInterna', '{<?php $stringJSON=""; foreach ($empresasInternas as $empresa) $stringJSON.= "\"".$empresa['idEmpresaInterna']."\" : \"".$empresa['nombreEmpresa']."\", "; echo rtrim($stringJSON, ", ");?>}']]
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
        });
        <?php
        if($permisos['eliminar'])
        {?>
        function confirmaDeleteProyecto(id, elemento) {
            swal({
                title: "Aviso",
                text: "¿Desea borrar este proyecto?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.value) {
                    $.post(
                        '<?=base_url("index.php/CrudProyectos/eliminarDatosProyecto")?>',
                        {idProyecto: id,  [csrfName]: csrfHash }
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
        }?>
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

            
    </script>



    <?php
}

?>