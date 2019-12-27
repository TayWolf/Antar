<?php if(!empty($permisos))
{
    ?>
    <div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s11"><h4 class="header">Status de contratos</h4></div>
            <div class="col s1">
                <div class="col s8 offset-s2">
                    <a class="tooltipped js-video-button" data-video-id='iZ-hA3ABn84' data-position="left" data-delay="30" data-tooltip="¿Necesitas ayuda?" style="padding: 0px !important;"><i class="medium material-icons">ondemand_video</i></a>
                </div>
            </div>
        </div>

        <?php
        if($permisos['alta'])
        {
        ?>

        <div class="col s12" >

            <div align="center">

                <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudStatusContratos/nuevoStatus/')" data-target='dropdown1'>Nuevo status</a>

            </div>

            <?php
            }
            ?>

        </div>

        <div class="col s12">

            <div class="col s12" id="contenedorTabla">

                <table class="display dataTable" id="tabla">

                    <thead>

                    <tr>

                        <th>ID</th>

                        <th>Color</th>

                        <th>Etiqueta</th>

                        <?php
                        if($permisos['editar'])
                        {
                            ?>
                            <th>Editar</th>
                            <?php
                        }
                        ?>

                        <?php
                        if($permisos['eliminar'])
                        {
                            ?>
                            <th>Eliminar</th>
                            <?php
                        }
                        ?>



                    </tr>

                    </thead>

                    <tbody>

                    <?php

                    $contador=1;



                    foreach ($status as $row)

                    {

                        //ESTA VARIABLE ES LA CLASE DE LA TABLA

                        $clase=($contador%2==0)?'odd':'even';

                        $idStatusContrato= $row['idStatusContrato'];

                        $color=$row['clase'];

                        $etiqueta=$row['etiqueta'];

                        //ESTA VARIABLE ES LA CLASE DEL STATUS

                        $botonStatus="<a class='".$color." padding-5 medium-small' id='botonStatus".$idStatusContrato."'> </a>";

                        print "<tr class='$clase' role='row'>

                                <td id='indice".$idStatusContrato."'>".$idStatusContrato."</td>

                                <td>".$botonStatus."</td>

                                <td>".$etiqueta."</td>";


                        if($permisos['editar'])
                        {
                            print "<td><a href='#' onclick='loadUrl(\"CrudStatusContratos/editarStatus/$idStatusContrato\")'>Editar</a></td>";
                        }

                        if($permisos['eliminar'])
                        {
                            print "<td><a href='#' onclick='confirmaDeleteStatusContrato($idStatusContrato, this)'>Eliminar</a></td>";
                        }
                        print"</tr>";
                    }
                    ?>

                    </tbody>

                    <tfoot>

                    </tfoot>

                </table>


            </div>
            <div class="row">
                <div class="col s4 offset-s4" align="center">
                    <a href="#" class="btn" onClick="ordenarStatus()">Ordenar</a>
                </div>
            </div>

        </div>

    </div>

    <!-- Modal Structure -->
    <div id="modalOrdenacion" class="modal">
        <div class="modal-content">
            <h4>Arrastra y suelta para ordenar</h4>
            <div id="statusProyectos">
                <ul id="listaOrdenacion" style="cursor:pointer;">
                    <?php

                    $contador=0;
                    foreach ($status as $row)
                    {


                        $idStatusContrato= $row['idStatusContrato'];

                        $color=$row['clase'];

                        $etiqueta=$row['etiqueta'];

                        $botonStatus="<a class='".$color." padding-5 medium-small' id='botonStatus".$idStatusContrato."'> </a>";

                        print "<li class='ordenacion'><input id='item".$contador."' name='item".$contador."' type='hidden' value='".$idStatusContrato."' >".$etiqueta."</li>";
                        $contador++;
                    }

                    ?>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" onClick="guardarOrden()" class="modal-close waves-effect waves-green btn-flat">Guardar & cerrar</a>
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
        url: '<?=base_url('index.php/CrudStatusContratos/ordenarStatus')?>',
        data: {arreglo: array,  [csrfName]: csrfHash },
        type: 'POST',
        dataType: 'JSON',
        success: function (data)
        {
            swal("Éxito!", "Se ordenaron los status!", "success");
            loadUrl("CrudStatusContratos");
        }
    });

}

function ordenarStatus() {
    $("#modalOrdenacion").modal('open');
}


    <?php
if($permisos['eliminar'])
{
    ?>

function confirmaDeleteStatusContrato(id, elemento)

{

    swal({

        title: "Aviso",

        text: "¿Desea borrar este status?",

        type: "warning",

        showCancelButton: true,

        confirmButtonClass: "btn-danger",

        confirmButtonText: "Aceptar",
		
		cancelButtonText: "Cancelar",

    }).then((result) => {

        if (result.value) {

            $.post(

                '<?=base_url("index.php/CrudStatusContratos/eliminarDatosStatus")?>',

                { idStatusContrato: id,  [csrfName]: csrfHash }

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

                'El status fue eliminado',

                'success'

            );

        }

    });

}

    <?php
}
    ?>


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
        ordering: false,
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


});

var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    <?php
}
?>