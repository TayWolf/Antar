<div class="container">

    <div class="row">

        <div class="col s12">


            <div class="col s12"><h4 class="header">Nuevo tipo de documento</h4></div>


        </div>

        <div align="center">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudContratos/todoTiposContratos/<?php echo $idContrato;?>')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">
                        <?=form_open('', 'class="col s12" id="formulario" enctype="multipart/form-data"')?>

                        <div class="row">

                            <div class="input-field col s6">

                                <input id="name" name="nombre" type="text" required>
                                <input type="hidden" id="idContrato" name="idContrato" value="<?php echo $idContrato;?>" required>
                                <label for="name">Tipo de documento</label>

                            </div>
                            <div class="input-field col s6">

                                <input id="claveC" name="claveC" type="text" required>

                                <label for="name">Clave</label>

                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col offset-s3 s6">

                                <input class="dropify" id="templateN" name="templateN"  style="padding-top: 20px;" type="file">

                                <label for="name" class="active">Template</label>

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

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        $("#formulario").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 250
                },
                claveC: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
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

        $(function(){
            $(".dropify").dropify({
                messages: {
                    'default': 'Arrastra y suelta un archivo o haz clic',
                    'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                    'remove':  'Remover',
                    'error':   'Ooops, ocurrió un error.'
                }
            });

            $("#formulario").on("submit", function(e){
                var url;
                var idCCC=$("#idContrato").val();
                //$('#cargando').html('<img src="https://bnmcontadorespublicos.com.mx/Fiscal/Content/assets/images/loading.gif"/>');
                url= "<?php echo base_url().'index.php/CrudContratos/nuevoTipoContrato/';?>";
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
                    processData: false,
                    error: function (jqXHR, status, error) {
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

                        loadUrl("CrudContratos/todoTiposContratos/"+idCCC)

                    });

            });
        });
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>



