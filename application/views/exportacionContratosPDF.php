
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

<h1>Contratos</h1>
<div style="overflow-x:auto;">
    <table class="tabla">
        <thead>
        <tr>
            <th>#</th>
            <th align="center">Nombre del proyecto</th>
            <th align="center">Tipo de contrato</th>
            <th align="center">Objeto del contrato</th>
            <th align="center">Vigencia del contrato</th>
            <th align="center">Nomenclatura</th>
            <th align="center">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $contador=1;
        foreach ($arregloContratos as $contrato)
        {
            print ("
                <tr>
                    <td>".$contador++."</td>
                    <td>".$contrato['nombreProyecto']."</td>
                    <td>".$contrato['nombreTipo']."</td>
                    <td> ".$contrato['objetoContrato']."</td>
                    <td>".$contrato['vigencia']."</td>
                    <td>".$contrato['nomenclatura']."</td>
                    <td>".$contrato['status']."</td>
                </tr>");
        }
        ?>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>

