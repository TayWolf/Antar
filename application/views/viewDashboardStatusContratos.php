<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s4"><h4 class="header">Contratos</h4></div>
        </div>
        <div class="col s12" style="margin-bottom: 1rem;">
            <div align="center">
                <a class='dropdown-trigger btn' href="#" onclick="limpiarSecciones(); loadUrl('CrudDashboard/index/<?=$fechaInicial.'/'.$fechaFinal.'/'.$idEmpresaInterna?>')" data-target='dropdown1'>Regresar</a>
            </div>
        </div>
        <div class="col s12" align="center">
            <?php
            foreach ($tarjetas as $tarjeta)
            {
                ?>
                <a style="margin: 1rem; " onclick="visualizarTabla(<?=$tarjeta['idStatusContrato']?>)" class="btn btn-large waves-effect waves-light <?=$tarjeta['clase']?>"><?=$tarjeta['cuenta']." - ".$tarjeta['etiqueta']?></a>
                <?php
            }
            ?>
        </div>
        <div class="col s12" align="center" id="tablaTarjeta">

        </div>


    </div>
    <script>
        function visualizarTabla(idStatus)
        {
            loadUrl('CrudDashboard/visualizarTablaStatusContrato/<?=urlencode($fechaInicial).'/'.urlencode($fechaFinal)?>/'+idStatus+'/<?=$idEmpresaInterna?>', "tablaTarjeta")
        }
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>