<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s12"><h4 class="header">Nuevo proyecto</h4></div>
        </div>
        <div align="center">
            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudProyectos/')" data-target='dropdown1'>Regresar</a>
        </div>
        <div class="col s12">
            <div class="col s12 ">
                <div class="card-panel">
                    <div class="row">
                        <?=form_open('', 'class="col s12" id="formulario"')?>
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="nombreProyecto" name="nombre" type="text" required>
                                <label for="nombreProyecto">Nombre del proyecto</label>
                            </div>
                            <div class="col s6 input-field">
                                <select type="text" id="empresaInterna" name="empresaInterna">
                                    <?php
                                    foreach ($empresasInternas as $empresa)
                                    {
                                        print "<option value='".$empresa['idEmpresaInterna']."'>".$empresa['nombreEmpresa']."</option>";
                                    }
                                    ?>
                                </select>
                                <label for="empresaInterna">Empresa interna</label>
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
                nombreProyecto: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                empresaInterna:{
                    required: true
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
            $.post("<?=base_url('index.php/CrudProyectos/insertarNuevoProyecto')?>",
                {nombreProyecto: $("#nombreProyecto").val(), empresaInterna: $("#empresaInterna").val(), [csrfName]: csrfHash },
                function(response){

                    swal('Éxito', 'Se guardó el proyecto', 'success');
                    loadUrl('CrudProyectos')
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

        $(document).ready(function () {
            $('select').material_select();
        });
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>



