<?php
if(!empty($permisos))
{
    ?>

    <div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s12"><h4 class="header">Tipos de <?php foreach ($tipoContr as $row){echo $row["nombre"]; break;}?> registrados</h4></div>
        </div>
        <div align="center">
            <?php
            if($permisos['alta'])
            {
                ?>
                <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudContratos/altatipoContrato/<?php echo $idContrato; ?>')" data-target='dropdown1'>Nuevo  Tipo documento</a>
                <?php
            }
            ?>

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudContratos/')" data-target='dropdown1'>Regresar</a>
        </div>
        <div class="col s12">
            <div class="col s12 ">
                <table class="striped bordered" id="tabla">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo de documento </th>
                        <th>Clave</th>
                        <?php
                        if($permisos['detalle'])
                        {
                            ?>
                            <th>Template</th>
                            <?php
                        }
                        ?>
                        <?php
                        if($permisos['eliminar'])
                        {
                            ?>
                            <!-- <th>Observaciones</th> -->
                            <th>Eliminar</th>
                            <?php
                        }?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $contador=1;
                    foreach ($tipoContr as $row)
                    {
                        $clase=($contador++%2==0)?'odd':'even';
                        echo "<tr class='$clase' role='row'>
                                    <td id='indice".$row['idTipoC']."'>".$row['idTipoC']."</td>
                                    <td>".$row['nombreTipo']."</td><td>".$row['claveContrato']."</td>";
                        if($permisos['detalle'])
                            echo "<td><a href='#' onclick='loadUrl(\"CrudContratos/tipoTemplate/".$row['idTipoC']."/".$idContrato."\")'>Ver</a></td>";
                        if($permisos['eliminar'])
                            echo " <td><a href='#' onclick='borrar(".$row['idTipoC'].",".$row['idContrato'].", this)'>Eliminar</a></td>";
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
        var tabla;
        $(document).ready( function ()
        {
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

                url: '<?=base_url('index.php/CrudContratos/editartiposContrato')?>',

                columns: {

                    identifier: [0, 'idT'],

                    editable: [[1, 'nombreTipC'], [2, 'claveCo']]

                },onFail: function (jqXHR, status, error) {
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

            });
            <?php
            }?>

        } );

    </script>

    <script>
        <?php
        if($permisos['eliminar'])
        {
        ?>
        function borrar(identificador, idC, elemento) {

            Swal({

                title: 'Eliminar este registro?',

                text: "No se podran revertir los cambios!",

                type: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Aceptar',
				
				cancelButtonText: 'Cancelar',

            }).then((result) => {

                if (result.value) {

                    $.post('<?=base_url('index.php/CrudContratos/borrarTipoContrato')?>',

                        {id: identificador, idC: idC,  [csrfName]: csrfHash },

                        function (response) {

                            //console.log(response);

                            tabla.row($(elemento).closest('tr')).remove().draw();

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