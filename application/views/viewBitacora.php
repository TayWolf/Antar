<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12"><h4 class="header">Generar reporte de Bitácora</h4></div>

        </div>



        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">

                        <?=form_open('', 'class="col s12" id="formulario"')?>


                        <div class="row">
                            <div class="col s12 m3">
                                <label for="idAre">Empresas Internas</label>
                                <select class="browser-default" id="idEmpreInterna" onchange="getUser();" name="idEmpreInterna" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="0" >Todos</option>
                                    <?php
                                    foreach ($Ei as $row) {
                                        $idEmpresaInterna=$row["idEmpresaInterna"];
                                        $nombreEmpresa=$row["nombreEmpresa"];
                                        echo "<option value='$idEmpresaInterna'>$nombreEmpresa</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col s12 m3">
                                <label for="idAre">Usuarios</label>
                                <select class="browser-default" id="idUser" name="idUser" onchange="getModulos()" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="0" >Todos</option>
                                    <?php
                                    foreach ($User as $rowU) {
                                        $idUser=$rowU["idUser"];
                                        $nombreUser=$rowU["nombreUser"];
                                        echo "<option value='$idUser'>$nombreUser</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-field col s12 m2">
                                <input id="fechaIni" class="datepicker" name="fechaIni" type="date" required>
                                <label for="fechaIni" class="active">Fecha Inicial</label>
                            </div>
                            <div class="input-field col s12 m2">
                                <input id="fechaFin" class="datepicker" name="fechaFin" type="date" required>
                                <label for="fechaFin" class="active">Fecha Final</label>
                            </div>
                            <div class="col s12 m2">
                                <label for="idm">Módulos</label>
                                <select class="browser-default" id="idModulo"  name="idModulo" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="0" >Todos</option>
                                    <?php
                                    foreach ($modu as $rowM) {
                                        $idModulo=$rowM["idModulo"];
                                        $nombreModulo=$rowM["nombreModulo"];
                                        echo "<option value='$idModulo'>$nombreModulo</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">

                            <div class="row">

                                <div class="input-field col s12" align="center">

                                    <a href="<?=base_url('/CrudGeneradorPDF/generarBitacora')?>" class="btn  waves-effect">Reporte<i class="material-icons right">send</i>

                                    </a>
                                    <!-- onclick="loadUrl('')" -->
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
        function getUser()
        {
            var idEmpreInterna =$("#idEmpreInterna").val();
            $.ajax(

                {

                    url: '<?=base_url('/index.php/CrudBitacora/getUsuarios/')?>'+idEmpreInterna,
                    dataType: 'json',
                    type: 'POST',
                    data: { [csrfName]: csrfHash},
                    success: function (data)
                    {
                        //alert(data)
                        $("#idUser").html("");
                        $("#idUser").append("<option value=''>Seleccione Usuario</option>");
                        $("#idUser").append("<option value='0'>Todos</option>");
                        for(var i=0; i<data.length; i++)
                        {
                            $("#idUser").append("<option value='"+data[i]['idUser']+"'>"+data[i]['nombreUser']+"</option>");
                        }
                    }
                }
            );
        }

        function getModulos()
        {
            var idUser =$("#idUser").val();
            $.ajax(
                {
                    url: '<?=base_url('/index.php/CrudBitacora/getModulos/')?>'+idUser,
                    dataType: 'json',
                    type: 'POST',
                    data: { [csrfName]: csrfHash},
                    success: function (data)
                    {
                        $("#idModulo").html("");
                        $("#idModulo").append("<option value=''>Seleccione Opción</option>");
                        $("#idModulo").append("<option value='0'>Todos</option>");
                        for(var i=0; i<data.length; i++)
                        {
                            $("#idModulo").append("<option value='"+data[i]['idModulo']+"'>"+data[i]['nombreModulo']+"</option>");
                        }
                    }
                });
        }
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>



