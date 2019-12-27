

<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12"><h4 class="header">Nueva empresa</h4></div>

        </div>

        <div align="center">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudEmpresasInternas/')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">

                        <?=form_open('', 'class="col s12" id="formulario"')?>

                        <div class="row">

                            <div class="input-field col s12">

                                <input id="nombre" name="nombre" type="text" required>

                                <label for="nombre">Nombre de la empresa</label>

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
                nombre: {
                    required: true,
                    minlength: 3,
                    maxlength: 200
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


        $("#formulario").on('submit', function (e)
        {
            e.preventDefault();
            formData=new FormData(document.getElementById("formulario"));

            $.ajax(
                {

                    url: '<?=base_url('index.php/CrudEmpresasInternas/nuevaEmpresaInterna/')?>',

                    type: 'POST',

                    data: formData,

                    cache: false,

                    processData: false,

                    contentType: false,

                    success: function (response)
                    {

                        swal("Éxito!", "Se ha registrado la empresa!", "success");
                        loadUrl('CrudEmpresasInternas')
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

                }

            );

        });

        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    </script>



