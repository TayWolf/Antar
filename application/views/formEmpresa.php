

<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12"><h4 class="header">Nuevo cliente</h4></div>

        </div>

        <div align="center">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudEmpresas/')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">
                        <?=form_open('', 'class="col s12" id="formDocumentos"')?>
                        </form>
                        <?=form_open('', 'class="col s12" id="formulario"')?>


                        <div class="row">

                            <div class="input-field col s12">

                                <input id="nombre" name="nombre" type="text" required>

                                <label for="nombre">Nombre del cliente</label>

                            </div>

                        </div>

                        <div class="row">

                            <div class="input-field col s12">

                                <input id="RFC" name="RFC" type="text" required>

                                <label for="RFC">RFC del cliente</label>

                            </div>

                        </div>

                        <div class="row">

                            <div class="input-field col s12">

                                <input id="razon_social" name="razon_social" type="text" required>

                                <label for="razon_social">Razón social del cliente</label>

                            </div>

                        </div>

                        <div class="row">
                            <div class="input-field col s6">
                                <b for="acta_constitutiva">Acta constitutiva</b>
                                <input type="file" class="dropify" id="acta_constitutiva" name="acta_constitutiva" />
                            </div>
                            <div class="input-field col s6">
                                <b for="poder_rep_legal">Poder rep. legal</b>
                                <input type="file" class="dropify" id="poder_rep_legal" name="poder_rep_legal" />
                            </div>
                        </div>

                        <div class="row">

                            <div class="input-field col s6">

                                <b for="cedula_fiscal">Cédula fiscal</b>

                                <input type="file" class="dropify" id="cedula_fiscal" name="cedula_fiscal" />
                            </div>
                            <div class="input-field col s6">
                                <b for="comprobante_domicilio">Comprobante de domicilio</b>
                                <input type="file" class="dropify" id="comprobante_domicilio" name="comprobante_domicilio" />
                            </div>
                            <div class="input-field col s6">
                                <b for="INERepresentanteLegal">INE del representante legal</b>
                                <input type="file" class="dropify" id="INERepresentanteLegal" name="INERepresentanteLegal" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12" id="otrosDocumentos">

                            </div>
                            <div class="col s12">
                                <a onclick="agregarOtrosDocumentos()" class="btn waves-light waves-effect"><i class="material-icons">add_box</i> Agregar otros documentos</a>
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
                nombre: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                RFC: {
                    required: true,
                    minlength: 12,
                    maxlength: 13
                },
                razon_social: {
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
                    url: '<?=base_url('index.php/CrudEmpresas/nuevaEmpresa/')?>'+numeroDocumentos,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (response)
                    {
                        swal("Éxito!", "Se han subido los documentos!", "success");
                        loadUrl('CrudEmpresas')
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
        var numeroDocumentos=0;
        function agregarOtrosDocumentos()
        {
            window.scrollTo(0,document.body.scrollHeight);
            $("#otrosDocumentos").append("<div class=\"col s6\">" +
                "        <input placeholder='Nombre del documento' name=\"nombreOtroDocumento"+numeroDocumentos+"\" id=\"nombreOtroDocumento"+numeroDocumentos+"\" class=\"input-field\" type=\"text\" ></input>" +
                "        <input type=\"file\" class=\"dropify\" id=\"otroDocumento"+numeroDocumentos+"\" name=\"otroDocumento"+numeroDocumentos+"\"  />" +
                "        <input placeholder='Observaciones' name=\"observacionOtroDocumento"+numeroDocumentos+"\" id=\"observacionOtroDocumento"+numeroDocumentos+"\" class=\"input-field\">" +
                "    </div>");
            $('#otroDocumento'+numeroDocumentos).dropify({
                messages: {
                    'default': 'Arrastra y suelta un archivo o haz clic',
                    'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                    'remove':  'Remover',
                    'error':   'Ooops, ocurrió un error.'}});
            numeroDocumentos++;
            console.log(numeroDocumentos+" documento agregado");
        }
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    </script>





