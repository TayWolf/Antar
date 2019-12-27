<?php if(!empty($permisos))
{
    ?>

    <div class="container">

        <div class="row">

            <div class="col s12">

                <div class="col s11"><h4 class="header">Áreas</h4></div>
                <div class="col s1">
                    <div class="col s8 offset-s2">
                        <a class="tooltipped js-video-button" data-video-id='m3QKx6q3-fA' data-position="left" data-delay="30" data-tooltip="¿Necesitas ayuda?" style="padding: 0px !important;"><i class="medium material-icons">ondemand_video</i></a>
                    </div>
                </div>
            </div>

            <?php
            if($permisos['alta'])
            {
                ?>

                <div class="col s12">
                    <div align="center">
                        <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudAreas/altaNuevaArea')" data-target='dropdown1'>Nueva área</a>
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
                            <th>Nombre del área</th>

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

                        foreach ($areas as $row)
                        {
                            $clase=($contador%2==0)?'odd':'even';
                            $idArea = $row['idArea'];
                            print "<tr class='$clase' role='row'>
                                <td id='indice".$idArea."'>".$idArea."</td>
                                <td>".$row['nombreArea']."</td>";
                            if($permisos['eliminar'])
                            {
                                print "<td><a href='#' onclick='confirmaDeleteArea($idArea, this)'>Eliminar</a></td>";
                            }
                            print "</tr>";
                        }

                        ?>

                        </tbody>
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
                        confirm: {
                            class: 'btn btn-sm btn-default',
                            html: 'Confirmar'
                        }
                    },
                    url: "<?=base_url('index.php/CrudAreas/actualizarDatosArea')?>",
                    columns: {
                        identifier: [0, 'idArea'],
                        editable: [ [1, 'nombreArea'] ]
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

            function confirmaDeleteArea(id, elemento)
            {
                swal({
                    title: "Aviso",
                    text: "¿Desea borrar está área?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.value) {
                        $.post(
                            '<?=base_url("index.php/CrudAreas/eliminarDatosArea")?>',
                            { idArea : id,  [csrfName]: csrfHash }
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

    </div>
    <?php
}
?>