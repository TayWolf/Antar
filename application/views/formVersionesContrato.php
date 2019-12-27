<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s4"><h4 class="header">Nueva redición del contrato</h4></div>
        </div>
        <div align="center">
            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudProyectos/verVersiones/<?=$idContratoProyecto?>')" data-target='dropdown1'>Regresar</a>
        </div>
        <div class="col s12">
            <div class="col s12 ">
                <div class="card-panel">
                    <div class="row">
                        <?=form_open('', 'id="formDocumentos"')?></form>
                        <?=form_open('', 'class="col s12" id="formulario"')?>



                            <div class="row">
                                <div class="input-field col offset-s3 s6">
                                    <b for="archivo">Archivo</b>
                                    <input type="file" class="dropify" id="archivo" name="archivo" required/>
                                </div>
                                <div class="input-field col offset-s3 s6">
                                    <b for="observaciones">Observaciones</b>
                                    <textarea class="materialize-textarea" id="observaciones" name="observaciones"></textarea>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right" type="submit" name="action">Guardar
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>


                        </form>


                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>



        $('.dropify').dropify({
            messages: {
                'default': 'Arrastra y suelta un archivo o haz clic',
                'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                'remove':  'Remover',
                'error':   'Ooops, ocurrió un error.'
            }
        });
        $("#formulario").on('submit', function (e)
        {
            e.preventDefault();
            Swal.fire({
                title: 'Guardando...',
                onBeforeOpen: () => {
                    Swal.showLoading();
                }});
            formData=new FormData(document.getElementById("formulario"));
            $.ajax(
                {
                    url: '<?=base_url('index.php/CrudProyectos/nuevaVersionContrato/'.$idContratoProyecto)?>',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'HTML',
                    success: function (response)
                    {

                        swal("Éxito!", "Se ha subido la nueva redición!", "success");
                        loadUrl('CrudProyectos/verVersiones/<?=$idContratoProyecto?>');
                    }
                }
            );
        });


        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>



