<div class="section">
    <div class="row">
        <div class="col s6" align="center">
            <a style="position: center !important;" onclick="loadUrl('CrudNotificacion/verContratos')" class="btn purple">Contratos</a>
            <small id="btnTotalContratos" class="notification-badge red"></small>
        </div>
        <div class="col s6" align="center">
            <a style="position: center !important;" onclick="loadUrl('CrudNotificacion/verFianzas')" class="btn purple">Fianzas / garantías</a>
            <small id="btnTotalFianzas" class="notification-badge red"></small>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#btnTotalContratos").html($("#totalContratosPorVencer").val());
        $("#btnTotalFianzas").html($("#totalFianzasPorVencer").val());
    })
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
</script>