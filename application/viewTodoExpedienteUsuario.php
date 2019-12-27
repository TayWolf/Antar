
<?php
if(!empty($permisos))
{
    ?>
    <div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s12"><h4 class="header">Expediente del usuario</h4></div>
        </div>
        <div align="center">
            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('Crudusuarios/')" data-target='dropdown1'>Regresar</a>          
        </div>
    </div>
	
	<div class="col s12">
		<div class="col s12 ">
			<div class="card-panel">
				<div class="row">
					<?=form_open('', 'class="col s12" id="formDocumentos"')?>
					</form>
					<?=form_open('', 'class="col s12" id="formulario"')?>
					<div class="row">
						<div class="col s12 " id="otrosDocumentos" style='margin-bottom: 20px'>
							<?php
							$numeroDocumentos=0;
							foreach($documentos as $documento)
							{
								$nombreArchivo = $documento['nombreDocumento'];
								$nombreDocumento = $documento['documento'];
								$observaciones = $documento["observaciones"];

							?>
							 <div class="col s6 center">
								<input value='<?=$nombreArchivo?>' placeholder='Nombre del documento' name="nombreDocumentoUsuario<?=$numeroDocumentos?>" id="nombreDocumentoUsuario<?=$numeroDocumentos?>" class="input-field" type="text" readonly></input>
								<input data-default-file='<?=base_url('assets/img/fotoUsuarios/'.$nombreDocumento)?>' type="file" class="dropify" id="DocumentoUsuario<?=$numeroDocumentos?>" name="DocumentoUsuario<?=$numeroDocumentos?>"  />
								<input value='<?=$observaciones?>' placeholder='Observaciones' name="observacionDocumentoUsuario<?=$numeroDocumentos?>" id="observacionDocumentoUsuario<?=$numeroDocumentos?>" class="input-field">
								<a href='<?=base_url('assets/img/fotoUsuarios/'.$nombreDocumento)?>' download>Descargar</a>
							 </div>
							 
							<?php
							 $numeroDocumentos++;
							}
							?>
							
						</div>
						<div class="col s12">
							<a onclick="agregarOtrosDocumentos()" class="btn waves-light waves-effect"><i class="material-icons">add_box</i> Agregar nuevo documento</a>
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

    <div id="modalObservaciones" class="modal">
        <div class="modal-content">
            <div class="col s12">
            <h4>Observaciones del documento</h4>
            <div class="col s10 offset-s1 input-field">
                <textarea id="observaciones" class="materialize-textarea input-field" readonly="readonly"></textarea>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
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
                    url: '<?=base_url('index.php/Crudusuarios/nuevoDocumento/'.$idUser)?>/'+numeroDocumentos,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (response)
                    {
                        swal("Éxito!", "Se han subido los documentos!", "success");
                        loadUrl('Crudusuarios')
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
		function editarDocumentos(idEmpresa)
		{
			$.ajax({
				url:'<?=base_url('index.php/CrudEmpresas/traerDocumentos/')?>'+idEmpresa,
				contentType: false,
				cache: false,
				processData: false,
				dataType: 'JSON',
				data: { [csrfName]: csrfHash},
				success: function (response)
				{
					numeroDocumentos=0;
					$("#contenidoModal").html("<form class=\"col s12\" id=\"formulario\">" +
							"<input type=\"hidden\" name=\"<?=$csrf['name'];?>\" value=\"<?=$csrf['hash'];?>\" />\n"+
						"<input type=\"hidden\" id=\"idEmpresaSeleccionada\" name=\"idEmpresa\" value=\""+idEmpresa+"\">" +
						"</form>");
					var link='<?=base_url('assets/img/fotoEmpresas/')?>';
					var observaciones;
					for(i=0; i<response.length; i++)
					{
						observaciones=(response[i]['observaciones'])?"<p>Observaciones: "+response[i]['observaciones']+"</p>":"";
						//documentos actuales
						$("#formulario").append("<div class='col s6' align='center'>" +
							"<b>"+response[i]['nombreDocumento']+"</b>" +
							"<div class='col s12' align='center'>" +
							"<input class='dropify' name='documentoEmpresa"+i+"' name='documentoEmpresa"+i+"' data-default-file='"+link+response[i]['documento']+"' onChange=\"cambiarDocumento('"+response[i]['idClienteDocumento']+"', this)\">" +
							observaciones+
							"<a download href='"+link+response[i]['documento']+"'>Descargar</a>" +
							"</div>" +
							"</div>");
					}
				}
			});
		}
		
        var numeroDocumentos=0;
        function agregarOtrosDocumentos()
        {
            window.scrollTo(0,document.body.scrollHeight);
            $("#otrosDocumentos").append("<div class=\"col s6\">" +
                "        <input placeholder='Nombre del documento' name=\"nombreOtroDocumento"+numeroDocumentos+"\" id=\"nombreOtroDocumento"+numeroDocumentos+"\" class=\"input-field\" type=\"text\" ></input>" +
                "        <input type=\"file\" class=\"dropify\" id=\"otroDocumento"+numeroDocumentos+"\" name=\"otroDocumento"+numeroDocumentos+"\" />" +
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
<?php
}
?>