
<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12"><h4 class="header">Plantilla de <?php foreach ($nombreTipoCon as $key) {
                        $nombreTipo=$key["nombreTipo"];
                        $claveContrato=$key["claveContrato"];
                        $template=$key["template"];
                    } echo $claveContrato." ". $nombreTipo; ?></h4></div>

        </div>
        <div align="center">
            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudContratos/todoTiposContratos/<?php echo $idContrato; ?>')" data-target='dropdown1'>Regresar</a>
        </div>

        <div class="col s12 m12 l12">

            <div class="col s6 " align="center">
                <?php
                if ($template==null||$template=="null"||empty($template)) {
                    ?>

                    <?php
                } else {
                    ?>
                    <div class="input-field col s12">
                        <img class="dropdown-trigger btn" style="padding:0;" src="<?=base_url('assets/images/icon/icono-descarga.png')?>"><a class='dropdown-trigger btn'  href="<?=base_url('index.php/CrudContratos/descargarPlantilla/'.$idTipoco)?>" download>Descargar plantilla</a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="col s6 ">
                <div class="input-field col s12">
                    <img onclick="pruebaModal()" class="dropdown-trigger btn"  style="padding:0px;" src="<?=base_url('assets/images/icon/icono-subir-archivos.png')?>"><a class='dropdown-trigger btn' onclick="pruebaModal()" >Ingresar nueva plantilla</a>
                </div>
            </div>

        </div>

    </div>

    <script type="text/javascript">
        function pruebaModal(){
            $("#modal2").modal('open');
        }
    </script>

    <div id="modal2" class="modal ">
        <div class="modal-content">
            <h4>Examine el archivo para subir nueva plantilla</h4>
            <?=form_open('', 'method="post" id="form" enctype="multipart/form-data"')?>
            <div class="file-field input-field">
                <div class="btn">
                    <span>Examinar</span>
                    <input type="hidden" id="idTipP" name="idTipP" value="<?php echo $idTipoco; ?>">
                    <input type="file" id="plantillaTip" name="plantillaTip" required>
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>

            <div align="center">
                <input type="submit" class="btn" value="Subir">
            </div>
            </form>

            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cerrar</a>

            </div>
        </div>

    </div>

    <script type="text/javascript">
        /*
    * Modals - Advanced UI
    */
        $(function() {
            $('.modal').modal();

        });

        $(function(){
            $("#form").on("submit", function(e){
                var url;
                // $('#cargando').html('<img src="http://tureceptivo.com/itravel/Admin/assets/images/loading.gif"/>');
                url= "<?php echo base_url().'index.php/CrudContratos/subirTemplate/';?>";
                e.preventDefault();
                var f = $(this);
                var formData = new FormData(document.getElementById("form"));

                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function(res){

                    Swal.fire({
                        title: 'ÉXITO',
                        text: "Plantilla registrada",
                        type: 'success',

                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'

                    }).then((result) => {
                        if (result.value) {
                            $('.modal-overlay').css('display','none');
                            swal.close();
                            loadUrl("CrudContratos/todoTiposContratos/<?php echo $idContrato; ?>")
                        }
                    })
                });

            });
        });
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>
