

<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s12"><h4 class="header">Nuevo documento para <?=$nombreEmpresa?></h4></div>
        </div>
        <div align="center">
            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudEmpresasInternas/verDocumentosEmpresa/<?=$idEmpresaInterna?>')" data-target='dropdown1'>Regresar</a>
        </div>

        <div class="col s12">
            <div class="col s12 ">
                <div class="card-panel">
                    <div class="row">
                        <?php
                        echo form_open("", 'class="col s12" id="formulario"');
                        ?>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="nombreDocumento" name="nombreDocumento" type="text" required>
                                    <label for="nombreDocumento">Nombre del documento</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="observaciones" name="observaciones" type="text">
                                    <label for="observaciones">Observaciones</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6 offset-s3">
                                    <input id="documento" name="documento" type="file" class="dropify" required>
                                    <label class="active" for="documento">Documento</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn  waves-effect waves-light right" type="submit" name="action">Guardar
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

        $('.dropify').dropify({
            messages: {
                'default': 'Arrastra y suelta un archivo o haz clic',
                'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                'remove':  'Remover',
                'error':   'Ooops, ocurrió un error.'
            }
        });
        $("#formulario").validate({
            rules: {
                nombreDocumento: {
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
            Swal.fire({
                title: 'Guardando...',
                onBeforeOpen: () => {
                    Swal.showLoading();
                }});
            formData=new FormData(document.getElementById("formulario"));

            $.ajax(
                {
                    url: '<?=base_url('index.php/CrudEmpresasInternas/nuevoDocumentoEmpresaInterna/'.$idEmpresaInterna)?>',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (response)
                    {
                        Swal.close();

                        swal("Éxito!", "Se ha registrado el documento!", "success");
                         loadUrl('CrudEmpresasInternas/verDocumentosEmpresa/<?=$idEmpresaInterna?>')
                    }, error: function (jqXHR, status, error) {
                        try{
                            let jsonError=JSON.parse(jqXHR['responseText']);
                            Swal.close();
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



