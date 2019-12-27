<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12"><h4 class="header">Nueva área</h4></div>

        </div>

        <div align="center">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudAreas/')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">

                        <?=form_open('', 'class="col s12" id="formulario"')?>

                            <div class="row">

                                <div class="input-field col s12">

                                    <input id="nombreArea" name="nombre" type="text" required>

                                    <label for="nombreArea">Nombre del área</label>

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
                nombreArea: {
                    required: true,
                    minlength: 1,
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
            $.post("<?=base_url('index.php/CrudAreas/insertarNuevaArea')?>",
                { nombreArea: $("#nombreArea").val(),  [csrfName]: csrfHash },
                function(response){
                    swal('Éxito', 'Se guardó el área', 'success');
                    loadUrl('CrudAreas')
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



