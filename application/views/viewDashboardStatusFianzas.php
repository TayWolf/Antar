<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s4"><h4 class="header">Fianzas / garantías</h4></div>
        </div>
        <div class="col s12" style="margin-bottom: 1rem;">
            <div align="center">
                <a class='dropdown-trigger btn' href="#" onclick="limpiarSecciones(); loadUrl('CrudDashboard/index/<?=$fechaInicial.'/'.$fechaFinal.'/'.$idEmpresaInterna?>')" data-target='dropdown1'>Regresar</a>
            </div>
        </div>
        <div class="col s12" align="center">
            <a style="margin: 1rem; " onclick="visualizarTabla(1, 1)" class="btn btn-large waves-effect waves-light teal darken-4 center-align"><?=$tarjetas[0]?> - Vigente pagado</a>
            <a style="margin: 1rem; " onclick="visualizarTabla(1, 0)" class="btn btn-large waves-effect waves-light light-blue darken-1 center-align"><?=$tarjetas[1]?> - Vigente no pagado</a>
            <a style="margin: 1rem; " onclick="visualizarTabla(0, 1)" class="btn btn-large waves-effect waves-light purple darken-4 center-align"><?=$tarjetas[2]?> - Expirado pagado</a>
            <a style="margin: 1rem; " onclick="visualizarTabla(0, 0)" class="btn btn-large waves-effect waves-light red darken-1 center-align"><?=$tarjetas[3]?> - Expirado no pagado</a>
        </div>


    </div>
    <script>
        function visualizarTabla(idVigencia, idPago)
        {
            //Status - IDS
            /*
            * 1 1 - Vigente pagado
            * 1 0 - Vigente no pagado
            * 0 1 - expirado pagado
            * 0 0 - Expirado no pagado
            * */

            loadUrl('CrudDashboard/visualizarTablaStatusFianza/<?=urlencode($fechaInicial).'/'.urlencode($fechaFinal)?>/'+idVigencia+'/'+idPago+'/<?=$idEmpresaInterna?>', "tablaTarjeta")
        }
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>