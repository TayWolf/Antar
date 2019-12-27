<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">Dashboard</h4></div>
            <div class="col s1">
                <div class="col s8 offset-s2">
                    <a class="tooltipped js-video-button" data-video-id='0PRm19yccrY' data-position="left" data-delay="30" data-tooltip="¿Necesitas ayuda?" style="padding: 0px !important;"><i class="medium material-icons">ondemand_video</i></a>
                </div>
            </div>
        </div>


        <div class="col s12">
            <ul class="collapsible popout" data-collapsible="accordion">
                <li>

                    <div class="collapsible-header active"><i class="material-icons">adjust</i> Seleccione un rango de fecha a visualizar</div>
                    <div class="collapsible-body">
                        <?=form_open('', 'id="formFiltro"')?>
                            <div class="row">
                                <div class="col s6">
                                    <label for="fechaInicial">Fecha inicial</label>
                                    <input type="text" class="datepicker" id="fechaInicial" name="fechaInicial" value="<?=$fechaInicial?>">
                                </div>
                                <div class="col s6">
                                    <label for="fechaInicial">Fecha final</label>
                                    <input type="text" class="datepicker" id="fechaFinal" name="fechaFinal" value="<?=$fechaFinal?>">
                                </div>
                                <div class="col offset-s3 s6 input-field">
                                    <select type="text" id="empresaInterna" name="empresaInterna">
                                        <option value="">Todas las empresas</option>
                                        <?php
                                        foreach ($empresasInternas as $empresa)
                                        {
                                            if($empresa['idEmpresaInterna']==$idEmpresaInterna)
                                                print "<option value='".$empresa['idEmpresaInterna']."' selected>".$empresa['nombreEmpresa']."</option>";
                                            else
                                                print "<option value='".$empresa['idEmpresaInterna']."'>".$empresa['nombreEmpresa']."</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="empresaInterna">Empresa interna</label>
                                </div>
                                <div class="col offset-s4 s4" align="center">
                                    <input type="submit" name="btnFiltrar" id="btnFiltrar" value="Filtrar" class="btn waves-effect waves-light red accent-2">
                                </div>
                            </div>
                        </form>

                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">today</i>A punto de vencer</div>
                    <div class="collapsible-body">

                        <div class="row">
                            <?=form_open('', 'id="formContratosVencer"')?>
                                <div class="col s6 input-field" align="center">
                                    <input type="number" name="diasContratoVencimiento" id="diasContratoVencimiento" required>
                                    <label for="diasVencimiento">Días antes de que el contrato venza</label>
                                    <input type="submit" name="btnFiltrar" id="btnFiltrar" value="Filtrar" class="btn waves-effect waves-light blue accent-2">
                                </div>
                            </form>
                            <?=form_open('', 'id="formFianzasVencer"')?>
                                <div class="col s6 input-field" align="center">
                                    <input type="number" name="diasFianzaVencimiento" id="diasFianzaVencimiento" required>
                                    <label for="diasVencimiento">Días antes de que la fianza / garantía venza</label>
                                    <input type="submit" name="btnFiltrar" id="btnFiltrar" value="Filtrar" class="btn waves-effect waves-light blue accent-2">
                                </div>
                            </form>
                        </div>

                    </div>
                </li>
                <li>

                    <div class="collapsible-header active"><i class="material-icons">arrow_forward</i> Vea las gráficas</div>
                    <div class="collapsible-body">
                        <?=form_open('', 'id="formFiltro"')?>
                            <div class="row">
                                <div class="col s12 m12 l6">
                                    <div id="canvasContratos">
                                        <canvas class="col s12" id="contratosStatus">

                                        </canvas>
                                    </div>
                                    <div class="col s12" align="center">
                                        <a href="#" onclick="verDetalle('CrudDashboard/verStatusContratos/')" class="btn waves-effect waves-light red accent-2">Detalles de los contratos</a>
                                    </div>
                                </div>
                                <div class="col s12 m12 l6">
                                    <div id="canvasFianzas">
                                        <canvas class="col s12" id="fianzasStatus">

                                        </canvas>
                                    </div>

                                    <div class="col s12" align="center">
                                        <a href="#" onclick="verDetalle('CrudDashboard/verStatusFianzas/')" class="btn waves-effect waves-light red accent-2">Detalles de las fianzas / garantías</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </li>

            </ul>
        </div>
    </div>

    <script>

        var labels=<?=json_encode($status)?>;
        $(document).ready( function (){
            $(".js-video-button").modalVideo({
                youtube:{
                    controls:1,
                    nocookie: true
                }
            });
            $('.tooltipped').tooltip({delay: 30});
            $('select').material_select();
            $('.datepicker').pickadate({
                format: 'yyyy-mm-dd',
                monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                selectMonths: true,
                selectYears: 200, // Puedes cambiarlo para mostrar más o menos años
                today: 'Hoy',
                clear: 'Limpiar',
                close: 'Ok',
                labelMonthNext: 'Siguiente mes',
                labelMonthPrev: 'Mes anterior',
                labelMonthSelect: 'Selecciona un mes',
                labelYearSelect: 'Selecciona un año',

                closeOnSelect: false // Close upon selecting a date,
            });
            $('.datepicker').on('mousedown',function(event){
                event.preventDefault();
            })
            $('.collapsible').collapsible();

            $("#formFiltro").submit();

        });
        $("#formFiltro").submit(function (e) {
            e.preventDefault();
            limpiarCanvas();
            fechaInicial=($("#fechaInicial").val())?$("#fechaInicial").val(): "1950-01-01";
            fechaFinal=($("#fechaFinal").val())?$("#fechaFinal").val(): "2032-12-31";

            empresaInterna=$("#empresaInterna").val();
            //ESTE AJAX GENERA LA PRIMER GRÁFICA
            $.ajax({
                url: '<?=base_url('/index.php/CrudDashboard/getGraficasContratos/')?>'+encodeURIComponent(fechaInicial)+"/"+encodeURIComponent(fechaFinal)+"/"+empresaInterna,
                type: 'POST',
                dataType: 'JSON',
                data: { [csrfName]: csrfHash},
                success: function (data)
                {
                    var fechas=data[0];

                    var arregloDatos=data[1];
                    var conjuntos=[];
                    for(i=0; i<arregloDatos.length; i++)
                    {
                        //El color de la clase degradada. Cada status tiene su propia clase y de ahí se genera el color
                        color=$("."+arregloDatos[i][2]).css("background-image").split(" 0%")[0].substring(23);

                        var conjunto={
                            label: arregloDatos[i][0],
                            stack: 'Stack 0',
                            backgroundColor: color,
                            data: arregloDatos[i][1]
                        };
                        conjuntos.push(conjunto);
                    }

                    var graphTarget = $("#contratosStatus");
                    var chartData={
                        labels: fechas,
                        datasets: conjuntos
                    };
                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            scales: {
                                yAxes: [{
                                    stacked: true,
                                    ticks: {
                                        suggestedMin: 0
                                    }
                                }],
                                xAxes: [{
                                    stacked: true,
                                    ticks: {
                                        autoSkip: false,
                                        maxRotation: 60,
                                        minRotation: 60
                                    }
                                }]
                            }
                        }

                    });

                }
            });
            //FIN DE LA PRIMERA GRÁFICA
            //AJAX DE LA SEGUNDA GRÁFICA
            $.ajax({
                url: '<?=base_url('/index.php/CrudDashboard/getGraficasFianzas/')?>'+encodeURIComponent(fechaInicial)+"/"+encodeURIComponent(fechaFinal)+"/"+empresaInterna,
                type: 'POST',
                dataType: 'JSON',
                data: { [csrfName]: csrfHash},
                success: function (data)
                {
                    var config={
                        type: 'pie',
                        data: {
                            datasets:[{
                                data:[
                                    data[0], //vigente pagado
                                    data[1], //vigente no pagado
                                    data[2], //expirado pagado
                                    data[3]  //expirado no pagado
                                ],
                                backgroundColor: [
                                    '#004d40',
                                    '#039be5',
                                    '#4a148c',
                                    '#E53935'
                                ],
                                label: 'Fianzas / garantía'
                            }],
                            labels:[
                                'Vigente pagado',
                                'Vigente no pagado',
                                'Expirado pagado',
                                'Expirado no pagado'
                            ]
                        },
                        options: {
                            responsive: true
                        }
                    };
                    var ctx = document.getElementById('fianzasStatus').getContext('2d');
                    window.myPie = new Chart(ctx, config);

                }
            });
            //FIN DE LA SEGUNDA GRÁFICA


            $('.collapsible').collapsible('close', 0);
            $('.collapsible').collapsible('open', 2);
        });
        function limpiarCanvas()
        {
            $("#contratosStatus").remove();
            $("#canvasContratos").append("<canvas id=\"contratosStatus\" ></canvas>");
            $("#fianzasStatus").remove();
            $("#canvasFianzas").append("<canvas id=\"fianzasStatus\" ></canvas>");
        }
        function verDetalle(url)
        {
            var fechaInicial=($("#fechaInicial").val()) ? $("#fechaInicial").val() : "1950-01-01";
            var fechaFinal=($("#fechaFinal").val()) ?  $("#fechaFinal").val():"2032-12-31";
            var idEmpresaInterna=$("#empresaInterna").val();
            loadEmbedUrl(url+encodeURIComponent(fechaInicial)+"/"+encodeURIComponent(fechaFinal)+"/"+idEmpresaInterna);
        }
    </script>
    <script>
        $("#formContratosVencer").submit(function (e) {
            e.preventDefault();
            loadEmbedUrl('CrudDashboard/verTarjetasContratosPorVencer/'+$("#diasContratoVencimiento").val());
        });
        $("#formFianzasVencer").submit(function (e) {
            e.preventDefault();
            loadEmbedUrl('CrudDashboard/verTarjetasFianzasPorVencer/'+$("#diasFianzaVencimiento").val());
        });
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>


<div style="display: none;">
    <?php
    foreach ($status as $estado)
    {
        echo "<div class='".$estado['clase']."'></div>";
    }?>
</div>