<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s4"><h4 class="header">Nueva fianza / garantía</h4></div>

        </div>

        <div align="center">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudProyectos/verFianzasContratoProyecto/<?=$idContratoProyecto?>')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">

                        <?=form_open('', 'class="col s12" id="formulario"')?>

                            <div class="row">
                                <div class="col s4 ">
                                    <label for="fianza">Fianza / Garantía</label>
                                    <select class="browser-default" name="fianza" id="fianza" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        foreach ($fianzas as $fianza)
                                        {
                                            echo "<option value='".$fianza['idCatalogoFianza']."'>".$fianza['nombre']."</option>";
                                        }?>
                                    </select>

                                </div>
                                <div class="col s4">
                                    <label for="monto">Monto</label>
                                    <input type="number" step="0.01" name="monto" id="monto">
                                </div>
                                <div class="col s4">
                                    <label for="monto">Vigencia</label>
                                    <input type="date" name="vigencia" id="vigencia">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <label for="condiciones">Condiciones</label>
                                    <textarea id="condiciones" name="condiciones" class="materialize-textarea" data-length="120"></textarea>

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

        $("#formulario").on('submit', function (e)
        {
            e.preventDefault();
            $.post("<?=base_url('index.php/CrudProyectos/insertarNuevaFianza/'.$idContratoProyecto)?>",
                { idFianza: $("#fianza").val(), monto: $("#monto").val(), condiciones: $("#condiciones").val(), vigencia: $("#vigencia").val(), [csrfName]: csrfHash },
                function(response){
                    swal('Éxito', 'Se guardó la fianza / garantía', 'success');
                    loadUrl('CrudProyectos/verFianzasContratoProyecto/<?=$idContratoProyecto?>')
                }
            );
        });
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>



