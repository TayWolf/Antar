<!-- START FOOTER -->



<script>

    var dataJson = { [csrfName]: csrfHash};

    function loadUrl(URL, mismaPagina)
    {

        $("#content").html(
            "<div class = \"progress\">" +
            "         <div class = \"indeterminate\"></div>" +
            "      </div>");
        if(mismaPagina)
        {
            $("#content").remove();
            $("#seccionGeneral").append("<section id='content'>"+
                "<div class = \"progress\">" +
                "         <div class = \"indeterminate\"></div>" +
                "      </div>"+
                "</section>");
        }
        $.post(
            {
                url: '<?=base_url('index.php/')?>'+URL,
                dataType: 'HTML',
                data: dataJson,
                success: function (informacion)
                {
                    $("#content").html(informacion);

                }, error: function (jqXHR, status, error)
                {
                    $("#content").html(jqXHR['responseText']);
                }

            }

        );


    }

    function loadEmbedUrl(URL)
    {
        $("#content").html("");
        $.post(
            {
                url: '<?=base_url('index.php/')?>'+URL,
                dataType: 'HTML',
                data: dataJson,
                success: function (informacion)
                {
                    $("#contenido").html(informacion);
                }, error: function (jqXHR, status, error) {
                    let vista=JSON.parse(JSON.stringify(jqXHR));
                    vista=vista['responseText'];
                    $("#content").html(vista);
                }
            }
        );
    }
</script>
</main>
<footer class="page-footer gradient-45deg-purple-deep-orange">

    <div class="footer-copyright">

        <div class="container">

            <span>©

              <script type="text/javascript">

                document.write(new Date().getFullYear());

              </script> <a class="grey-text text-lighten-4" href="https://www.cointic.com.mx" target="_blank">Sistema de gestión documental.</a> Todos los derechos reservados.</span>

            <span class="right hide-on-small-only"> Diseñado y desarrollado por <a class="grey-text text-lighten-4" target="_blank" href="https://www.cointic.com.mx">Cointic</a></span>

        </div>

    </div>

</footer>



<!-- END FOOTER -->

<!-- ================================================

Scripts

================================================ -->



<!-- jQuery Library -->
<script type="text/javascript" src="<?=base_url('assets/')?>vendors/jquery-3.2.1.min.js"></script>

<script type="text/javascript" src="<?=base_url('assets/')?>js/datatables.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/')?>js/materialize.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/')?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/')?>js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/')?>js/jquery-modal-video.min.js"></script>

<!--prism-->
<script type="text/javascript" src="<?=base_url('assets/')?>vendors/prism/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="<?=base_url('assets/')?>vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!-- chartjs -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?=base_url('assets/')?>js/plugins.js"></script>
<script type="text/javascript" src="<?=base_url('assets/')?>js/scripts/advanced-ui-modals.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="<?=base_url('assets/')?>js/custom-script.js"></script>
<!--<script type="text/javascript" src="<?=base_url('assets/')?>js/scripts/dashboard-ecommerce.js"></script>-->
<script type="text/javascript" src="<?=base_url('assets/')?>js/jquery.tabledit.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.all.min.js"></script>
<!--Fileinput-->
<script type="text/javascript" src="<?=base_url('assets/')?>vendors/dropify/js/dropify.min.js"></script>
</body>

</html>
