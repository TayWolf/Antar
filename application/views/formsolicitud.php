<?php
$idU=$this->session->userdata('iduser');
foreach ($getPr as $key) {
    $nombreProyecto=$key["nombreProyecto"];
}
?>

<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s12"><h4 class="header">Nueva solicitud (<?php echo "$nombreProyecto"; ?>)</h4></div>
        </div>
        <div align="center">
            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudProyectos/Solicitudes/<?php echo $idProyecto; ?>')" data-target='dropdown1'>Regresar</a>
        </div>
        <div class="col s12">
            <div class="col s12 ">
                <div class="card-panel">
                    <div class="row">
                        <?=form_open('', 'class="col s12" id="formulario" enctype="multipart/form-data"')?>

                        <div class="row">
                            <?php $hoy=date("Y-m-d");?>
                            <div class="col s12 m4">
                                <input type="checkbox" onclick="verificarContra()" id="permisFec" name="permisFec" value="0"  />

                                <label for="permisFec">Fecha Solicitud</label>
                                <input name="fechaServi" id="fechaServi" type="date" value="<?php echo $hoy; ?>" readonly>
                                <input name="fechaBd" id="fechaBd" type="hidden" value="<?php echo $hoy; ?>" >
                                <input name="idPro" id="idPro" type="hidden" value="<?php echo $idProyecto; ?>" >
                                <input name="idUs" id="idUs" type="hidden" value="<?php echo $idU; ?>" >
                            </div>
                            <div class="col s12 m8">
                                <label>Nomenclatura *</label>
                                <input name="nomenclatura" id="nomenclatura" type="text" required>
                            </div>
                        </div>
                        <div class="row">


                            <div class="col s12 m4">
                                <label>Proyecto</label>
                                <input name="nombrePr" id="nombrePr" type="text" value="<?php echo $nombreProyecto; ?>" readonly>


                            </div>
                            <div class="col s12 m4">
                                <label>Contrato *</label>
                                <select class="browser-default" id="idContrao" onchange="traerTipoContr();" name="idContrao" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <?php
                                    foreach ($contrato as $row) {
                                        $idContraro=$row["idContrato"];
                                        $nombreCont=$row["nombre"];
                                        echo "<option value='$idContraro'>$nombreCont</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="visualTipoc" style="display: none;">
                                <div class="col s12 m4">
                                    <label>Tipo Contrato *</label>
                                    <select class="browser-default" id="idTipoCon" name="idTipoCon" required >

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m2">
                                <p>
                                    <input type="checkbox" id="contMrc" name="contMrc" value="0" onclick="selectedCheck();" />
                                    <label for="contMrc">Contrato principal</label>
                                </p>
                            </div>
                            <div class="row">
                                

                            <div class="col s12 m4">
                                <label>Objeto Contrato</label>
                                <input name="objContr" id="objContr" type="text" />

                            </div>
                            <div class="col s12 m6">
                                <label>Clientes *</label>
                                <select class="browser-default" id="idEmpresa" name="idEmpresa" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
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
                                <label>Monto contratado *</label>
                                <input name="montoContrata" id="montoContrata" type="text" required/>

                            </div>
                            <div class="col s12 m3">
                                <label>Vigencia *</label>
                                <input name="vigenciaBd" id="vigenciaBd" type="date" required/>
                            </div>
                            <div class="input-field col s6">
                                <textarea id="obserVigenc" name="obserVigenc" class="materialize-textarea" data-length="120"></textarea>
                                <label for="obserVigenc">Observaciones</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m6">
                                    <label>Período de ejecución</label>
                                    <input name="plazoEjec" id="plazoEjec" type="text" />
								</div>
                            <div class="col s12 m6">
                                <label>Programa entrega</label>
                                <input name="prograEntre" id="prograEntre" type="file" />

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m12">
                                <label>Lugar entrega *</label>
                                <input name="lugarEntrea" id="lugarEntrea" type="text" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m6">
                                <label>Representante obra *</label>
                                <input name="repreObra" id="repreObra" type="text" required/>

                            </div>
                            <div class="input-field col s6">
                                <textarea id="testigosBd" name="testigosBd" class="materialize-textarea" data-length="120"></textarea>
                                <label for="obserVigenc">Testigos</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m3">
                                <label>Plazo garantía</label>
                                <input name="plazoGarant" id="plazoGarant" type="date" />

							</div>
							<div class="col s12 m3">
								<label>Correo cliente</label>
								<input name="correoContacto" id="correoContacto" type="email" placeholder="Ingrese correo eléctronico" />
							</div>
							
							<div class="col s12 m3">
							
								<label>Contacto interno</label>
								
								<input name="contactoInterno" id="contactoInterno" type="text" placeholder="Ingrese contacto interno" />
								
							</div>
							
							<div class="col s12 m3">
							
								<label>Correo interno</label>
								
								<input name="correoInterno" id="correoInterno" type="email" placeholder="Ingrese correo eléctronico" />
								
							</div>

						</div>
						<div class="row">

							
							<div class="col s12 m6">

								<label>Notas</label>

								<input name="notasBd" id="notasBd" type="text" />

							</div>

						</div>
                        
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light right" type="submit" name="action">Guardar
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m5">
                            <label>NOTA: Los campos marcados con un asterisco son obligatorios</label>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(function(){
            $("#formulario").validate({
                rules: {
                    nomenclatura: {
                        required: true,
                        minlength: 3
                    },
                    fechaServi: {
                        required: true,
                        date: true
                    },
                    fechaBd: {
                        required: true,
                        date: true
                    },
                    idPro:{
                        required: true,
                        digits: true
                    },
                    idUs:{
                        required: true,
                        digits: true
                    },
                    idContrao:{
                        digits: true,
                        required: true
                    },
                    idTipoCon:{
                        digits: true,
                        required: true
                    },
                    idEmpresa:{
                        digits: true,
                        required: true
                    },
                    montoContrata:{
                        required: true,
                        maxlength: 250
                    },
                    vigenciaBd:{
                        required: true,
                        date: true
                    },
                    plazoEjec:{
                        maxlength: 250
                    },
                    lugarEntrea:{
                        maxlength: 300,
                        required: true
                    },
                    repreObra:{
                        maxlength: 250,
                        required: true
                    },
                    plazoGarant:{
                        date: true
                    },
                    correoContacto: {
                        email: true,
                    }

                },
                errorElement : 'div',
                errorPlacement: function(error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            $("#formulario").on("submit", function(e){
                var url;
                var idCCC=$("#idPro").val();
                //$('#cargando').html('<img src="https://bnmcontadorespublicos.com.mx/Fiscal/Content/assets/images/loading.gif"/>');
                url= "<?php echo base_url().'index.php/CrudProyectos/nuevaSolicitud/'?>";
                e.preventDefault();
                //inicio de swal
                Swal.fire({
                    title: 'Guardando...',
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    }});
                var f = $(this);
                var formData = new FormData(document.getElementById("formulario"));
                $.ajax({
                    url: url,
                    type: "post",
					data: formData,
                    dataType: "html",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        Swal.close();
                        Swal.fire(
                            'HECHO!',
                            'Registrado éxitosamente..',
                            'success'
                        );
                        loadUrl('CrudProyectos/Solicitudes/'+idCCC)
                    },
                    error: function (jqXHR, status, error) {
                        try{
                            Swal.close();
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
        function verificarContra()
        {
            if ($('#permisFec').is(':checked'))
            {
                $("#permisFec").prop("checked", false);
                Swal.fire({
                    title: 'Ingrese la contraseña de un administrador',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch(`//api.github.com/users/${login}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `Ingrese Contraseña`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        var parametros={
                            "password" : result.value.login,  [csrfName]: csrfHash  };
                        $.ajax({
                            url : "<?=base_url('index.php/CrudProyectos/getContras/')?>",
                            type: "POST",
                            data:parametros,
                            dataType: "JSON",
                            success: function(data)
                            {
                                if (data!=null)
                                {
                                    Swal.fire(
                                        'Autorizado',
                                        'Permiso autorizado',
                                        'success'
                                    );
                                    $("#permisFec").prop("checked", true);
                                    $('#fechaServi').prop('disabled', false);
                                }
                                else
                                {
                                    Swal.fire(
                                        'Error',
                                        'Contraseña incorrecta',
                                        'error'
                                    )
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
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
                })
            }else{
                $('#fechaServi').prop('disabled', true);
            }
        }
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>
