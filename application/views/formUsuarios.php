<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s4"><h4 class="header">Nuevo usuario</h4></div>

        </div>

        <div class="col s3 offset-s10">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('Crudusuarios/')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">

                        <?=form_open('', 'class="col s12" id="formulario"')?>

                        <div class="row">

                            <div class="input-field col s4">
                                <input id="nameUser" name="nameUser" type="text" required>
                                <label for="name">Nombre del usuario</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="nickName" name="nickName" type="text" required>
                                <label for="nickName">Nickname</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="passwordUs" name="passwordUs" type="password" required>
                                <label for="passwordUs">Password</label>
                            </div>

                        </div>
                        <div class="row">
                            <div class="input-field col s4">
                                <input id="correoDesti" name="correoDesti" type="email" required>
                                <label for="correoDesti">Correo de notificación</label>
                            </div>

                            <div class="col s12 m4">
                                <label for="idAre">Áreas</label>
                                <select class="browser-default" id="idAre" name="idAre" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <?php
                                    foreach ($areaUs as $row) {
                                        $idAres=$row["idArea"];
                                        $nombreAre=$row["nombreArea"];
                                        echo "<option value='$idAres'>$nombreAre</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col s12 m4">
                                <label for="idTip">Tipo</label>
                                <select class="browser-default" id="idTip" name="idTip" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <?php
                                    foreach ($TipoU as $row) {
                                        $idTipo=$row["idTipo"];
                                        $nombreTipo=$row["nombreTipo"];
                                        echo "<option value='$idTipo'>$nombreTipo</option>";
                                    }
                                    ?>
                                </select>
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
        $("#formulario").submit(function (e)
        {
            e.preventDefault();
            formData=new FormData(document.getElementById("formulario"));
            $.ajax({
                url:'<?=base_url('index.php/Crudusuarios/nuevoUser')?>',
                data: formData,
                contentType:false,
                processData: false,
                type: 'POST',
                dataType: 'html',
                success:function (data) {
                    swal('Éxito', 'Se guardó el nuevo usuario', 'success');
                    loadUrl('Crudusuarios')
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    try {
                        let jsonError=JSON.parse(jqXHR['responseText']);
                        Swal.fire({
                            title: "Error",
                            type: 'error',
                            html: jsonError['message'],
                            showCloseButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Ok!'

                        });
                    }
                    catch (e) {

                    }
                }
            });


        });
        $("#formulario").validate({
            rules: {
                nameUser: {
                    required: true,
                    minlength: 3,
                    letterswithbasicpunc: true
                },
                nickName: {
                    required: true,
                    minlength: 3
                },
                passwordUs: {
                    required: true,
                    minlength: 8
                },
                idAre:{
                    required: true
                },
                correoDesti: {
                        required: true,
                        email: true,
                    minlength: 4
                    },
                idTip: {
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


        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>



