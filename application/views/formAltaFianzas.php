<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12"><h4 class="header">Nueva fianza / garantía</h4></div>

        </div>

        <div align="center">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudFianzas/')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">
                        <?=form_open('', 'class="col s12" id="formulario"')?>

                            <div class="row">

                                <div class="input-field col s6">

                                    <input id="nombre" name="nombre" type="text" required>

                                    <label for="nombre">Nombre de la fianza / garantía</label>

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
                    maxlength: 150
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
            $.post("<?=base_url('index.php/CrudFianzas/insertarNuevaFianza')?>",
                { nombre: $("#nombre").val(),  [csrfName]: csrfHash },
                function(response){
                    swal('Éxito', 'Se guardó la fianza / garantía', 'success');
                    loadUrl('CrudFianzas')
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
        });
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>



