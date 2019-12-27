<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s4"><h4 class="header">Editar status</h4></div>

        </div>

        <div align="center">
            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudStatusContratos/')" data-target='dropdown1'>Regresar</a>
        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">
                        <?=form_open('', 'class="col s12" id="formulario"')?>

                            <div class="row">
                                <input id="idStatus" type="hidden" name="idStatus" value="<?=$status['idStatusContrato']?>">
                                <div class="input-field col s12">

                                    <input id="etiqueta" name="etiqueta" type="text" value="<?=$status['etiqueta']?>" required>
                                    <label class="active" for="etiqueta">Etiqueta del status</label>
                                </div>

                                <div class="col s12 m6 l4">


                                    <div class="gradient-45deg-amber-amber padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);">
                                        <input name="color" type="radio" id="color0"  class="with-gap" value="gradient-45deg-amber-amber"><label for="color0">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-blue-indigo padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color1"  class="with-gap" value="gradient-45deg-blue-indigo"><label for="color1">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-indigo-light-blue padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color2"  class="with-gap" value="gradient-45deg-indigo-light-blue"><label for="color2">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-red-pink padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color3"  class="with-gap" value="gradient-45deg-red-pink"><label for="color3">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-light-blue-teal padding-5 medium-small">
                                        <input name="color" type="radio" id="color4"  class="with-gap" value="gradient-45deg-light-blue-teal"><label for="color4">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-light-blue-indigo padding-5 medium-small">
                                        <input name="color" type="radio" id="color5"  class="with-gap" value="gradient-45deg-light-blue-indigo"><label for="color5">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-yellow-green padding-5 medium-small">
                                        <input name="color" type="radio" id="color6"  class="with-gap" value="gradient-45deg-yellow-green"><label for="color6">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-orange-deep-orange padding-5 medium-small">
                                        <input name="color" type="radio" id="color7"  class="with-gap" value="gradient-45deg-orange-deep-orange"><label for="color7">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-deep-purple-purple padding-5 medium-small">
                                        <input name="color" type="radio" id="color8"  class="with-gap" value="gradient-45deg-deep-purple-purple"><label for="color8">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-light-green-amber padding-5 medium-small">
                                        <input name="color" type="radio" id="color9"  class="with-gap" value="gradient-45deg-light-green-amber"><label for="color9">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-purple-pink padding-5 medium-small">
                                        <input name="color" type="radio" id="color10"  class="with-gap" value="gradient-45deg-purple-pink"><label for="color10">Escoger</label>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="gradient-45deg-indigo-blue padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color11"  class="with-gap" value="gradient-45deg-indigo-blue"><label for="color11">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-brown-brown padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color12"  class="with-gap" value="gradient-45deg-brown-brown"><label for="color12">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-blue-grey-blue padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color13"  class="with-gap" value="gradient-45deg-blue-grey-blue"><label for="color13">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-purple-deep-orange padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color14"  class="with-gap" value="gradient-45deg-purple-deep-orange"><label for="color14">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-green-teal padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color15"  class="with-gap" value="gradient-45deg-green-teal"><label for="color15">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-indigo-light-blue padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color16"  class="with-gap" value="gradient-45deg-indigo-light-blue"><label for="color16">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-teal-cyan padding-5 medium-small">
                                        <input name="color" type="radio" id="color17"  class="with-gap" value="gradient-45deg-teal-cyan"><label for="color17">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-blue-grey-blue-grey padding-5 medium-small">
                                        <input name="color" type="radio" id="color18"  class="with-gap" value="gradient-45deg-blue-grey-blue-grey"><label for="color18">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-cyan-light-green padding-5 medium-small">
                                        <input name="color" type="radio" id="color19"  class="with-gap" value="gradient-45deg-cyan-light-green"><label for="color19">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-orange-amber padding-5 medium-small">
                                        <input name="color" type="radio" id="color20"  class="with-gap" value="gradient-45deg-orange-amber"><label for="color20">Escoger</label>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="gradient-45deg-indigo-purple padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color21"  class="with-gap" value="gradient-45deg-indigo-purple"><label for="color21">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-deep-purple-blue padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color22"  class="with-gap" value="gradient-45deg-deep-purple-blue"><label for="color22">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-deep-orange-orange padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color23"  class="with-gap" value="gradient-45deg-deep-orange-orange"><label for="color23">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-light-blue-cyan padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color24"  class="with-gap" value="gradient-45deg-light-blue-cyan"><label for="color24">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-purple-amber padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color25"  class="with-gap" value="gradient-45deg-purple-amber"><label for="color25">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-purple-deep-purple padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color26"  class="with-gap" value="gradient-45deg-purple-deep-purple"><label for="color26">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-purple-light-blue padding-5 medium-small"
                                         style="color: rgba(255, 255, 255, 0.901961);"><input name="color" type="radio" id="color27"  class="with-gap" value="gradient-45deg-purple-light-blue"><label for="color27">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-cyan-cyan padding-5 medium-small">
                                        <input name="color" type="radio" id="color28"  class="with-gap" value="gradient-45deg-cyan-cyan"><label for="color28">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-yellow-teal padding-5 medium-small">
                                        <input name="color" type="radio" id="color29"  class="with-gap" value="gradient-45deg-yellow-teal"><label for="color29">Escoger</label>
                                    </div>
                                    <br>
                                    <div class="gradient-45deg-cyan-light-green padding-5 medium-small">
                                        <input name="color" type="radio" id="color30"  class="with-gap" value="gradient-45deg-cyan-light-green"><label for="color30">Escoger</label>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="row">

                                    <div class="input-field col s12">

                                        <button class="btn waves-effect waves-light right" type="submit" name="action">
                                            Guardar

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
        var color='<?=$status['clase']?>';
        $(document).ready(function () {
            $('input:radio').each(function () {
                value= $(this).attr('value');
                if(value==color)
                    $(this).prop("checked", true);
            });
        });
        $("#formulario").validate({
            rules: {
                etiqueta: {
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
        $("#formulario").on('submit', function (e) {

            e.preventDefault();


            $.post("<?=base_url('index.php/CrudStatusContratos/editarDatosStatus')?>",

                {clase: $("input[name=color]:checked").val(), etiqueta: $("#etiqueta").val(), idStatus: $("#idStatus").val(), [csrfName]: csrfHash },

                function (response)
                {
                    swal('Éxito', 'Se guardó el status', 'success');
                    loadUrl('CrudStatusContratos')
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


</div>