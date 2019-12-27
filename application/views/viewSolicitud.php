<?php

$idU=$this->session->userdata('iduser');



foreach ($getPr as $key) {

    $nombreProyecto=$key["nombreProyecto"];

}

?>

<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12"><h4 class="header">Detalle de solicitud para (<?php echo "$nombreProyecto"; ?>)</h4></div>

        </div>

        <div align="center">

                <?php 

                if ($verbotonregresar){

                    ?>


            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudProyectos/Solicitudes/<?php echo $idProyecto; ?>')" data-target='dropdown1'>Regresar</a>

                    <?php
                }

                 ?>




        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">
                        <?=form_open('', 'class="col s12" id="formulario" enctype="multipart/form-data"')?>


                            <div class="row">

                                <?php $hoy=date("Y-m-d");?>

                                <div class="col s12 m2">

                                    <label>Fecha Solicitud</label>

                                    <input name="fechaServi" id="fechaServi" type="date" value="<?php echo $hoy; ?>" disabled>

                                    <input name="fechaBd" id="fechaBd" type="hidden" value="<?php echo $hoy; ?>"  readonly>

                                    <input name="idPro" id="idPro" type="hidden" value="<?php echo $idProyecto; ?>" readonly>

                                    <input name="idUs" id="idUs" type="hidden" value="<?php echo $idU; ?>" readonly>

                                </div>

                                <div class="col s12 m10">

                                    <label>Nomenclatura</label>

                                    <input name="nomenclatura" id="nomenclatura" type="text" readonly>

                                </div>

                            </div>

                            <div class="row">



                                <div class="col s12 m4">

                                    <label>Proyecto</label>

                                    <input name="nombrePr" id="nombrePr" type="text" value="<?php echo $nombreProyecto; ?>" readonly>



                                </div>

                                <div class="col s12 m4">

                                    <label>Contrato</label>

                                    <select class="browser-default" id="idContrao" onchange="traerTipoContr();" name="idContrao" required readonly>

                                        <option value="" readonly selected>Seleccione una opción </option>

                                        <?php

                                        foreach ($contrato as $row) {

                                            $idContraro=$row["idContrato"];

                                            $nombreCont=$row["nombre"];

                                            echo "<option value='$idContraro'>$nombreCont</option>";

                                        }

                                        ?>

                                    </select>

                                </div>

                                <div id="visualTipoc" style="">

                                    <div class="col s12 m4">

                                        <label>Tipo Contrato</label>

                                        <select class="browser-default" id="idTipoCon" name="idTipoCon" required readonly>

                                            <?php

                                            foreach ($tiposContrato as $row) {

                                                $idContraro=$row["idTipoC"];

                                                $nombreCont=$row["nombreTipo"];

                                                echo "<option value='$idContraro'>$nombreCont</option>";

                                            }

                                            ?>

                                        </select>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col s12 m2">

                                    <p>

                                        <input type="checkbox" id="contMrc" name="contMrc" value="0" onclick="selectedCheck();" disabled />

                                        <label for="contMrc">Contrato principal</label>

                                    </p>

                                </div>

                                <div class="col s12 m4">

                                    <label>Objeto Contrato</label>

                                    <input name="objContr" id="objContr" type="text" readonly/>



                                </div>

                                <div class="col s12 m6">

                                    <label>Empresas</label>

                                    <select class="browser-default" id="idEmpresa" name="idEmpresa" required readonly>

                                        <option value="" readonly selected>Seleccione una opción</option>

                                        <?php

                                        foreach ($EmpreGet as $rows) {

                                            $idEmpresa=$rows["idEmpresa"];

                                            $razon_social=$rows["razon_social"];

                                            echo "<option value='$idEmpresa'>$razon_social</option>";

                                        }

                                        ?>

                                    </select>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col s12 m3">

                                    <label>Monto contratado</label>

                                    <input name="montoContrata" id="montoContrata" type="text" required readonly/>



                                </div>

                                <div class="col s12 m3">

                                    <label>Vigencia</label>

                                    <input name="vigenciaBd" id="vigenciaBd" type="date" readonly/>

                                </div>

                                <div class="input-field col s6">

                                    <textarea id="obserVigenc" name="obserVigenc" class="materialize-textarea" data-length="120" readonly></textarea>

                                    <label for="obserVigenc">Observaciones</label>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col s12 m6">

                                    <label>Periodo de ejecución</label>

                                    <input name="plazoEjec" id="plazoEjec" type="text" readonly/>



                                </div>

                                <div class="col s12 m6" id="divProgramaEntrega">

                                    <label>Programa entrega</label>

                                    <!--<input name="prograEntre" id="prograEntre" type="file" readonly data-show-remove="false" data-default-file=""/>-->



                                </div>

                            </div>

                            <div class="row">

                                <div class="col s12 m12">

                                    <label>Lugar entrega</label>

                                    <input name="lugarEntrea" id="lugarEntrea" type="text" readonly/>



                                </div>



                            </div>

                            <div class="row">

                                <div class="col s12 m6">

                                    <label>Representante obra</label>

                                    <input name="repreObra" id="repreObra" type="text" readonly/>



                                </div>

                                <div class="input-field col s6">

                                    <textarea id="testigosBd" name="testigosBd" class="materialize-textarea" data-length="120" readonly></textarea>

                                    <label for="obserVigenc">Testigos</label>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col s12 m3">

                                    <label>Plazo garantía</label>

                                    <input name="plazoGarant" id="plazoGarant" type="date" readonly/>



                                </div>

                                <div class="col s12 m3">

                                    <label>Correo cliente</label>

                                    <input name="correoContacto" id="correoContacto" type="email" placeholder="Ingrese correo eléctronico" readonly/>

                                </div>
								
								<div class="col s12 m3">
								
                                    <label>Contacto interno</label>
									
                                    <input name="contactoInterno" id="contactoInterno" type="text" placeholder="Ingrese contacto interno" readonly/>
                                
								</div>

                                <div class="col s12 m3">
								
                                    <label>Correo interno</label>
									
                                    <input name="correoInterno" id="correoInterno" type="email" placeholder="Ingrese correo eléctronico" readonly/>
                               
							   </div>

                            </div>
							
							<div class="row">

							   <div class="col s12 m6">

                                    <label>Notas</label>

                                    <input name="notasBd" id="notasBd" type="text" readonly/>

                                </div>
								
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>

        $(function(){

            $("#formulario").on("submit", function(e){

                var url;

                var idCCC=$("#idPro").val();

                //$('#cargando').html('<img src="https://bnmcontadorespublicos.com.mx/Fiscal/Content/assets/images/loading.gif"/>');

                url= "<?php echo base_url().'index.php/CrudProyectos/nuevaSolicitud/';?>";

                e.preventDefault();

                var f = $(this);

                var formData = new FormData(document.getElementById("formulario"));



                $.ajax({

                    url: url,

                    type: "post",

                    dataType: "html",

                    data: formData,

                    cache: false,

                    contentType: false,

                    processData: false

                })

                    .done(function(res){

                        swal({

                                title: "HECHO",

                                text: "Registrado éxitosamente..",

                                type: "success",



                                confirmButtonClass: "btn-danger",

                                confirmButtonText: "Aceptar",

                                closeOnConfirm: false

                            },

                            function(){

                                // alert("CrudContratos/todoTiposContratos/")



                                //window.location.assign("https://cointic.com.mx/antar/admin/index.php/CrudContratos/")

                            });



                        loadUrl('CrudProyectos/Solicitudes/'+idCCC)



                    });



            });

        });



        function traerTipoContr()

        {

            var idContrao=$("#idContrao").val();

            $("#idTipoCon").html("");

            $.ajax({

                url : "<?=base_url('index.php/CrudProyectos/getTipoContr/')?>" + idContrao,

                type: "post",

                dataType: "JSON",

                data: { [csrfName]: csrfHash},

                success: function(data)

                {

                    if (data.length>0)

                    {

                        $("#visualTipoc").show();

                        $("#idTipoCon").append('<option value ="">Seleccione una Opción</option>');

                        for (i=0; i< data.length; i++) {

                            $("#idTipoCon").append(new Option(data[i]['claveContrato']+" "+data[i]['nombreTipo'],data[i]['idTipoC']));

                        }

                    } else{

                        $("#visualTipoc").hide();

                    }

                }

            });

        }

        function selectedCheck()

        {

            var contMrc=$("#contMrc").val();

            if ($("#contMrc").is(':checked'))

            {

                $("#contMrc").val('1');

            }else{

                $("#contMrc").val('0');

            }

        }

        $(document).ready(function ()

        {

            $("label").attr("class","active");

            $.ajax(

                {

                    url: '<?=base_url('/index.php/CrudProyectos/obtenerContratoProyecto/'.$idContratoProyecto)?>',

                    dataType: 'JSON',

                    type: 'POST',

                    data: { [csrfName]: csrfHash},

                    success: function (contratoProyecto)

                    {

                        $("#fechaServi").val(contratoProyecto['fechaSolicitud']);

                        $("#nomenclatura").val(contratoProyecto['nomenclatura']);

                        $("#idContrao").val(contratoProyecto['idContrato']);

                        $("#idTipoCon").val(contratoProyecto['idTipoContrato']);

                        $("#contMrc").prop("checked", (contratoProyecto['contratoMarco']==1)?true:false);

                        $("#objContr").val(contratoProyecto['objetoContrato']);

                        $("#idEmpresa").val(contratoProyecto['idEmpresa']);

                        $("#montoContrata").val(contratoProyecto['montoContrato']);

                        $("#vigenciaBd").val(contratoProyecto['vigencia']);

                        $("#obserVigenc").val(contratoProyecto['observacion']);

                        $("#plazoEjec").val(contratoProyecto['plazoEjecucion']);

                        $("#lugarEntrea").val(contratoProyecto['lugarEntrega']);

                        $("#repreObra").val(contratoProyecto['representanteObra']);

                        $("#testigosBd").val(contratoProyecto['testigos']);

                        $("#plazoGarant").val(contratoProyecto['garantia']);

                        $("#correoContacto").val(contratoProyecto['correoContacto']);
						
						$("#contactoInterno").val(contratoProyecto['contactoInterno']);
						
						$("#correoInterno").val(contratoProyecto['correoInterno']);

                        $("#notasBd").val(contratoProyecto['nota']);

                        /*$("#prograEntre").attr("class", "dropify");

                        $("#prograEntre").dropify();*/

                        if(contratoProyecto['programaEntrega']&&contratoProyecto['programaEntrega']!='null'&&contratoProyecto['programaEntrega']!=null&&contratoProyecto['programaEntrega']!=undefined)

                        {

                            /*$("#prograEntre").attr("data-default-file", '<//?=base_url("/assets/fileUpload/contratoProyecto/".$idContratoProyecto)?>/'+contratoProyecto['programaEntrega']);*/



                            //var base=('<?=base_url("/assets/fileUpload/contratoProyecto/".$idContratoProyecto)?>/'+contratoProyecto['programaEntrega']);
                            var base=('<?=base_url("index.php/CrudProyectos/descargarArchivoDetalles/".$idContratoProyecto)?>');

                            $("#divProgramaEntrega").append("<a href='"+base+"' target='_blank' download>Descargar</a>");

                        }







                    }

                }

            );

        });
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>

