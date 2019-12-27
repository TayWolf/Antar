<?php
if(!empty($permisos))
{

    if($proyectoIndividual)
        foreach ($getPr as $key)
        {
            $nombreProyecto=$key["nombreProyecto"];
            break;
        }
    ?>
    <div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">Archivo muerto</h4></div>
            <div class="col s1">
                <div class="col s8 offset-s2">
                    <a class="tooltipped js-video-button" data-video-id='Rlpk6qhl3xc' data-position="left" data-delay="30" data-tooltip="¿Necesitas ayuda?" style="padding: 0px !important;"><i class="medium material-icons">ondemand_video</i></a>
                </div>
            </div>
        </div>
        <div class="col s12" >

        </div>
        <div class="col s12">
            <div class="col s12 ">
                <table class="display dataTable" id="tabla">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Proyecto</th>
                        <th>Tipo de contrato</th>
                        <th>Nomenclatura</th>

                        <?php
                        if(!empty($permisosStatusContrato)&&$permisosStatusContrato['editar'])
                        {
                            ?>
                            <th>Terminado</th>
                            <th>Status</th>
                            <?php
                        }?>

                        <?php
                        if(!empty($permisosFianzas)&&$permisosFianzas['mostrar'])
                        {
                            ?>
                            <th>Fianzas / garantías</th>
                            <?php
                        }
                        if(!empty($permisosVersiones)&&$permisosVersiones['mostrar'])
                        {
                            ?>
                            <th>Rediciones</th>
                            <?php
                        }
                        if($permisos['detalle'])
                        {
                            ?>
                            <th>Detalles</th>
                            <?php
                        }
                        ?>
                    </tr>

                    </thead>

                    <tbody>

                    <?php

                    $contador=1;
                    $arregloFaltantes=array();

                    foreach ($solicitudes as $row)
                    {
                        $clase=($contador%2==0)?'odd':'even';
                        $idContratoProyecto = $row['idContratoProyecto'];
                        $status=$row['status'];
                        $statusFinalizado=$row['statusFinalizado'];
                        if ($statusFinalizado==1) {
                            $checkMarcado="checked";
                        }else{
                            $checkMarcado="";
                        }
                        $i=0;
                        //For que sirve para saber en que posición se encuentra el estado actual del contrato
                        //Cuando coindice, se rompe y entonces se toma $i para sacar el estado actual y hacer los incrementos
                        for($i; $i<sizeof($posiblesEstados); $i++)
                        {
                            if($posiblesEstados[$i]['id']==$status)
                                break;
                        }
                        if($status!=null)
                            //define el boton del status
                            $botonStatus="<button value='".$posiblesEstados[$i]["value"]."' class='".$posiblesEstados[$i]["class"]."' style='".$posiblesEstados[$i]["style"].";line-height: normal;' id='botonStatus".$idContratoProyecto."' >".$posiblesEstados[$i]["value"]."</button>";
                        else
                        {
                            $botonStatus="<button value='".$posiblesEstados[0]["value"]."' class='".$posiblesEstados[0]["class"]."' style='".$posiblesEstados[0]["style"].";line-height: normal;' id='botonStatus".$idContratoProyecto."'>".$posiblesEstados[0]["value"]."</button>";
                            array_push($arregloFaltantes,array($idContratoProyecto,$posiblesEstados[0]['id']));
                        }

                        print "<tr class='$clase' role='row'>
                                <td id='indice".$idContratoProyecto."'>".$idContratoProyecto."</td>
                                <td>".$row['nombreProyecto']."</td>
                                <td>".$row['claveContrato']." ".$row['nombreTipo']."</td>
                                <td>".$row['nomenclatura']."</td>";

                        if(!empty($permisosStatusContrato)&&$permisosStatusContrato['editar'])
                            print"<td><input type='checkbox' ".$checkMarcado." onClick='VerificarAntes($idContratoProyecto)' id='finalZ".$idContratoProyecto."' name='finalZ".$idContratoProyecto."'  value='".$row['statusFinalizado']."'><label for='finalZ".$idContratoProyecto."'></label></td><td>".$botonStatus."</td>";

                        if(!empty($permisosFianzas)&&$permisosFianzas['mostrar'])
                            print"<td onclick='verFianzas($idContratoProyecto)'><a>Fianzas / garantías</a></td>";
                        if(!empty($permisosVersiones)&&$permisosVersiones['mostrar'])
                            print"<td onclick='verVersiones($idContratoProyecto)'><a>Rediciones</a></td>";
                        if($permisos['detalle'])
                            print"<td onclick='verDetalle($idContratoProyecto)'><a>Detalle</a></td>";
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
                    if(isset($exportarTerminados))
                    {
                        ?>
                        <div class="row">
                            <div class="col offset-s4 s4" align="center">
                                <a class="btn waves-light gradient-45deg-red-pink"
                                   href="<?=base_url("index.php/CrudGeneradorPDF/generarContratosFinalizados")?>">Exportar</a> <!-- -->
                            </div>
                        </div>
                        <?php
                    }
                }?>
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
            var arregloFaltantes=<?=json_encode($arregloFaltantes)?>;
            for(i=0; i<arregloFaltantes.length; i++)
            {
                $.ajax({
                    url: '<?=base_url('index.php/CrudProyectos/cambiarEstadoContratoProyecto/')?>'+arregloFaltantes[i][1]+'/'+arregloFaltantes[i][0],
                    data: { [csrfName]: csrfHash}
                });
            }

        });
        <?php
        if($permisos['eliminar'])
        {?>
        function confirmaDeleteContratoProyecto(id, elemento)
        {
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
                        '<?=base_url("index.php/CrudProyectos/eliminarDatosContratoProyecto")?>',
                        { idContratoProyecto : id,  [csrfName]: csrfHash }
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
        if($permisos['detalle'])
        {
        ?>
        function verDetalle(idContratoProyecto) {
            loadUrl('CrudArchivoMuerto/verDetalleContrato/' + idContratoProyecto + '/<?=$proyectoIndividual?>');
        }
        <?php
        }
        if($permisos['editar'])
        {
        ?>
        function verEdicion(idContratoProyecto) {
            loadUrl('CrudProyectos/verEdicionContrato/' + idContratoProyecto + '/<?=$proyectoIndividual?>');
        }
        <?php
        }
        if(!empty($permisosFianzas)&&$permisosFianzas['mostrar'])
        {
        ?>
        function verFianzas(idContratoProyecto)
        {
            loadUrl('CrudArchivoMuerto/verFianzasContratoProyecto/' + idContratoProyecto + '/<?=$proyectoIndividual?>');
        }
        <?php
        }
        if(!empty($permisosVersiones)&&$permisosVersiones['mostrar'])
        {
        ?>
        function verVersiones(idContratoProyecto)
        {
            loadUrl('CrudArchivoMuerto/verVersiones/' + idContratoProyecto + '/<?=$proyectoIndividual?>');
        }
        <?php
        }?>
        var estados=<?=json_encode($posiblesEstados)?>;
        <?php
        if(!empty($permisosStatusContrato)&&$permisosStatusContrato['editar'])
        {
        ?>
        function siguienteStatus(estadoActual, idContratoProyecto)
        {


            if(++estadoActual>=estados.length)
                estadoActual=0;
            //TODO: MANDAR AJAX para cambiar status de idContratoProyecto
            $.ajax({
                url: '<?=base_url('index.php/CrudProyectos/cambiarEstadoContratoProyecto/')?>'+estados[estadoActual]["id"]+'/'+idContratoProyecto,
                data: { [csrfName]: csrfHash}
            });
            $("#botonStatus"+idContratoProyecto).attr("value", estados[estadoActual]["value"]);
            $("#botonStatus"+idContratoProyecto).attr("class", estados[estadoActual]["class"]);
            $("#botonStatus"+idContratoProyecto).attr("style", estados[estadoActual]["style"]);
            $("#botonStatus"+idContratoProyecto).attr("onClick", "siguienteStatus("+estadoActual+", "+idContratoProyecto+")");
            $("#botonStatus"+idContratoProyecto).html(estados[estadoActual]["value"]);

        }
        <?php
        }?>

        function VerificarAntes(idC)
        {
            $.ajax({
                url : "<?=base_url('index.php/CrudProyectos/verificarStatusFinalizado/')?>"+idC,
                type: "post",
                dataType: "JSON",
                data: { [csrfName]: csrfHash},
                success: function(data)
                {
                    var status=data.statusFinalizado;

                    marcarFinalizado(idC,status)
                }
            });

        }

        function marcarFinalizado(idC,finalZ)
        {
            //var finalZ=$("#finalZ"+idC).val();
            if (finalZ==0) {
                finalZ=1;
            }else if (finalZ==1) {
                finalZ=0;
            }

            $.ajax({
                url : "<?=base_url('index.php/CrudProyectos/ActualizaDefinitivo/')?>" + finalZ+"/"+idC,
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




    <?php
}
?>