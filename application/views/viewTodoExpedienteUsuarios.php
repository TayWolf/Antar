
<?php
if(!empty($permisos))
{
    ?>
    <div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s12"><h4 class="header">Expediente del usuario <?=$usuario?></h4></div>
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
								$idDoc = $documento['idDocumentoUser'];
								$idUser= $documento['idUser'];

								?>
								<div class="col s12 m6 center">
								<input style="font-weight: bold; center" value='<?=$nombreArchivo?>' placeholder='Nombre del documento' name="nombreDocumentoUsuario<?=$numeroDocumentos?>" id="nombreDocumentoUsuario<?=$numeroDocumentos?>" class="input-field" type="text"/>
								<input onChange="cambiarBandera(<?=$numeroDocumentos?>)" data-default-file='<?=base_url('assets/img/fotoUsuarios/'.$nombreDocumento)?>' type="file" class="dropify" id="DocumentoUsuario<?=$numeroDocumentos?>" name="DocumentoUsuario<?=$numeroDocumentos?>" />
								<input type="hidden" id="docBandera<?=$numeroDocumentos?>" name="docBandera<?=$numeroDocumentos?>" class="banderas" value="0" />
								<div class="col s12 valign-wrapper">
                                    <div class="input-field col m10 s12">
                                        <input value='<?=$observaciones?>' placeholder='Observaciones' name="observacionDocumentoUsuario<?=$numeroDocumentos?>" id="observacionDocumentoUsuario<?=$numeroDocumentos?>">
                                    </div>
									<a class="material-icons col m2 s12 btn center-align" style="line-height:inherit; padding: 0 !important;" href='<?=base_url('index.php/CrudUsuarios/descargarExpediente/'.$idDoc.'/'.$idUser)?>' download >file_download</a>
								</div>
								<input value='<?=$idDoc?>' type="hidden" id="documento<?=$numeroDocumentos?>" name="documento<?=$numeroDocumentos?>" />
								</div>
								 
								<?php
								$numeroDocumentos++;
							}
						?>
							
						</div>
						<?php
                        if($permisos['alta'])
                        {

                            ?>
						<div class="col s12">
							<a onclick="agregarOtrosDocumentos()" class="btn waves-light waves-effect"><i class="material-icons">add_box</i> Agregar nuevo documento</a>
						</div>
						<?php
                        }
                        ?>
					</div>
					<?php
                        if($permisos['editar'])
                        {
                    ?>
					<div class="row">
						<div class="row">
							<div class="input-field col s12">
								<button class="btn  waves-effect waves-light right" type="submit" name="action">Guardar
									<i class="material-icons right">send</i>
								</button>
							</div>
						</div>
					</div>
					<?php
                        }
                    ?>

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
	
		function cambiarBandera(numeroDocumento){
			$('#docBandera'+numeroDocumento).val(1);
		}
		
		$('.dropify').dropify({
			messages: {
				'default': 'Arrastra y suelta un archivo o haz clic',
				'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
				'remove':  'Remover',
				'error':   'Ooops, ocurrió un error.'
			}
		}).on('dropify.beforeClear', function(event, element)
		{
			console.log((event));
			<?php
			if($permisos['eliminar'])
			{
			?>
			if (confirm("Realmente quiere borrar el archivo? \"" + element.filename + "\" ?"))
			{
				$.ajax({
					url: '<?=base_url('index.php/Crudusuarios/borrarArchivo/')?>',
					dataType: 'HTML',
					type: 'POST',
					data: { [csrfName]: csrfHash, nombre: element.filename},
					success: function (data) {
						$("#"+element.element.id).parent().parent().remove();
						
					},
					error:function(jqXHR, status, error){
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
				});
			}else{
					event.preventDefault();
					$("#"+element.element.id).attr("data-default-file","<?=base_url('assets/img/fotoUsuarios/')?>"+element.filename);
			}
			<?php
			}
			?>
		});

        $("#formulario").on('submit', function (e)
        {
            e.preventDefault();
			let editado=0;
			let archivosEditados="<div class='collection'>";
			$('.banderas').each(function (index,value){
				if($(value).val()==1){
					editado=1;
					archivosEditados+="<a class='collection-item'>"+$("#nombreDocumentoUsuario"+index).val()+'</a>';
				}
			});
			archivosEditados+="</div>";
			
			if(editado==1){
				Swal.fire({
					  title: '¿Estas seguro de editar estos archivos?',
					  html: archivosEditados,
					  type: 'warning',
					  showCancelButton: true,
					  confirmButtonText: 'Si, quiero editarlos',
					  cancelButtonText: 'Cancelar'
					}).then((result) => {
					  if (result.value) {
						ejecutarAltaArchivos();
					  }
					})
			}
			else
			{
				ejecutarAltaArchivos();
			}	
        });
		
		function ejecutarAltaArchivos(){
			Swal.fire({
					title: 'Guardando...',
					onBeforeOpen: () => {
						Swal.showLoading();
					}});
				formData=new FormData(document.getElementById("formulario"));
				$.ajax(
					{
						url: '<?=base_url('index.php/Crudusuarios/nuevoDocumento/'.$idUser)?>/'+numeroDocumentos+'/<?=$numeroDocumentos?>',
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
							Swal.close();
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
		}
		
		function cerrarNuevoDoc(numeroDocumentos){
			$("#idArchivoDoc"+numeroDocumentos).html("");
		}
		
        var numeroDocumentos=0;
		<?php
		if($permisos['alta'])
			{
			?>
				function agregarOtrosDocumentos()
				{
					$("#otrosDocumentos").append("<div id=\"idArchivoDoc"+numeroDocumentos+"\"\> <div  class=\"col s12 m6\">" +
						"        <div class=\"col s12 valign-wrapper\"><div class='input-field col s12'><input placeholder='Nombre del documento' name=\"nombreOtroDocumento"+numeroDocumentos+"\" id=\"nombreOtroDocumento"+numeroDocumentos+"\" class=\"col s12 m12\" type=\"text\" required ></div>" +
						"        <a class=\"material-icons col s12 m2 btn center-align valign-wrapper \" style=\"line-height:inherit\" onclick='cerrarNuevoDoc("+numeroDocumentos+")'>delete_forever</a></div>" +
						"        <input type=\"file\" class=\"dropify\" id=\"otroDocumento"+numeroDocumentos+"\" name=\"otroDocumento"+numeroDocumentos+"\" />" +
						"        <div class='input-field col s12'><input placeholder='Observaciones' name=\"observacionOtroDocumento"+numeroDocumentos+"\" id=\"observacionOtroDocumento"+numeroDocumentos+"\"></div>" +
						"    </div></div>");
					$('#otroDocumento'+numeroDocumentos).dropify({
						messages: {
							'default': 'Arrastra y suelta un archivo o haz clic',
							'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
							'remove':  'Remover',
							'error':   'Ooops, ocurrió un error.'}});
					numeroDocumentos++;
				}
		<?php
			}
			?>
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    </script>
<?php
}
?>