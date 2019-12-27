
<style>
    h1 {
        color: #000000;
        font-family: times;
        font-size: 24pt;
    }

    table.tabla {
        color: #003300;
        font-family: helvetica;
        font-size: 8pt;
        border: 1px solid #000000;
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
    }
    th {
        border: 1px solid #000000;
    }
    td {
        border: 1px solid #000000;
        background-color: #ffffee;
    }
</style>

<h1>Fianzas / garantías</h1>
<div style="overflow-x:auto;">
    <table class="tabla">
        <thead>
        <tr>
            <th>#</th>
            <th align="center">Fianza / Garantía</th>
            <th align="center">Proyecto</th>
            <th align="center">Objeto del contrato</th>
            <th align="center">Nomenclatura</th>
            <th align="center">Monto</th>
            <th align="center">Vigencia</th>
            <th align="center">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $posiblesEstadosVigentes=array(
            array("value" =>"Vigente no pagada"),
            array("value" =>"Vigente pagada")
        );
        $posiblesEstadosExpirados=array(
            array("value" =>"Expirada no pagada"),
            array("value" =>"Expirada pagada")
        );
        $contador=1;
        foreach ($arregloFianzas as $fianza)
        {
            $status=$fianza['status'];
            $vigente=1;
            if(strtotime($fianza['vigencia'])<strtotime(date("Y-m-d")))
            {
                $vigente=0;
            }
            if($vigente)
                $statusFinal=$posiblesEstadosVigentes[$status]["value"];
            else
                $statusFinal=$posiblesEstadosExpirados[$status]["value"];

            print ("
                <tr>
                    <td>".$contador++."</td>
                    <td>".$fianza['nombre']."</td>
                    <td>".$fianza['nombreProyecto']."</td>
                    <td>".$fianza['objetoContrato']."</td>
                    <td> ".$fianza['nomenclatura']."</td>
                    <td>$".$fianza['monto']."</td>
                    <td>".$fianza['vigencia']."</td>
                    <td>".$statusFinal."</td>
                </tr>");
        }
        ?>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>

