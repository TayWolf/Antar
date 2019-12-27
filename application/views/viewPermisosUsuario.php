<style>
    p{
        margin: 0px !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">Permisos para <?=$nombreTipoUsuario?></h4></div>
            <div class="col s1">
                <div class="col s8 offset-s2">
                    <a class="tooltipped js-video-button" data-video-id='wdDJhDuHzMU' data-position="left" data-delay="30" data-tooltip="¿Necesitas ayuda?" style="padding: 0px !important;"><i class="medium material-icons">ondemand_video</i></a>
                </div>
            </div>
        </div>
        <div class="col s12" align="center">
            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('Crudtipou/')" data-target='dropdown1'>Regresar</a>
        </div>
        <div class="col s12">
            <div class="col s12 ">
                <table class="display dataTable" id="tabla">
                    <thead>
                    <tr>
                        <!--<th>ID MODULO</th>-->
                        <th>Módulo</th>
                        <th>Mostrar</th>
                        <th>Alta</th>
                        <th>Detalles</th>
                        <th>Edición</th>
                        <th>Eliminación</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr><!--<td>0</td>-->
                        <td>Usuarios</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo0" name="mostrarModulo0" onChange="mostrar(0);" />
                                <label for="mostrarModulo0"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo0" name="altaModulo0" onChange="alta(0);" />
                                <label for="altaModulo0"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo0" name="detallesModulo0" onChange="detalles(0);" />
                                <label for="detallesModulo0"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo0" name="edicionModulo0" onChange="editar(0);" />
                                <label for="edicionModulo0"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo0" name="eliminacionModulo0" onChange="eliminar(0);" />
                                <label for="eliminacionModulo0"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Tipos de usuarios</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo1" name="mostrarModulo1" onChange="mostrar(1);" />
                                <label for="mostrarModulo1"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo1" name="altaModulo1" onChange="alta(1);" />
                                <label for="altaModulo1"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo1" name="detallesModulo1" onChange="detalles(1);" />
                                <label for="detallesModulo1"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo1" name="edicionModulo1" onChange="editar(1);" />
                                <label for="edicionModulo1"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo1" name="eliminacionModulo1" onChange="eliminar(1);" />
                                <label for="eliminacionModulo1"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Áreas</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo2" name="mostrarModulo2" onChange="mostrar(2);" />
                                <label for="mostrarModulo2"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo2" name="altaModulo2" onChange="alta(2);" />
                                <label for="altaModulo2"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo2" name="detallesModulo2" onChange="detalles(2);" />
                                <label for="detallesModulo2"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo2" name="edicionModulo2" onChange="editar(2);" />
                                <label for="edicionModulo2"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo2" name="eliminacionModulo2" onChange="eliminar(2);" />
                                <label for="eliminacionModulo2"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Contratos</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo3" name="mostrarModulo3" onChange="mostrar(3);" />
                                <label for="mostrarModulo3"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo3" name="altaModulo3" onChange="alta(3);" />
                                <label for="altaModulo3"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo3" name="detallesModulo3" onChange="detalles(3);" />
                                <label for="detallesModulo3"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo3" name="edicionModulo3" onChange="editar(3);" />
                                <label for="edicionModulo3"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo3" name="eliminacionModulo3" onChange="eliminar(3);" />
                                <label for="eliminacionModulo3"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Tipos de contrato</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo4" name="mostrarModulo4" onChange="mostrar(4);" />
                                <label for="mostrarModulo4"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo4" name="altaModulo4" onChange="alta(4);" />
                                <label for="altaModulo4"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo4" name="detallesModulo4" onChange="detalles(4);" />
                                <label for="detallesModulo4"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo4" name="edicionModulo4" onChange="editar(4);" />
                                <label for="edicionModulo4"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo4" name="eliminacionModulo4" onChange="eliminar(4);" />
                                <label for="eliminacionModulo4"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Status de contrato</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo5" name="mostrarModulo5" onChange="mostrar(5);" />
                                <label for="mostrarModulo5"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo5" name="altaModulo5" onChange="alta(5);" />
                                <label for="altaModulo5"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo5" name="detallesModulo5" onChange="detalles(5);" />
                                <label for="detallesModulo5"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo5" name="edicionModulo5" onChange="editar(5);" />
                                <label for="edicionModulo5"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo5" name="eliminacionModulo5" onChange="eliminar(5);" />
                                <label for="eliminacionModulo5"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Proyectos</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo6" name="mostrarModulo6" onChange="mostrar(6);" />
                                <label for="mostrarModulo6"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo6" name="altaModulo6" onChange="alta(6);" />
                                <label for="altaModulo6"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo6" name="detallesModulo6" onChange="detalles(6);" />
                                <label for="detallesModulo6"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo6" name="edicionModulo6" onChange="editar(6);" />
                                <label for="edicionModulo6"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo6" name="eliminacionModulo6" onChange="eliminar(6);" />
                                <label for="eliminacionModulo6"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Contratos de un proyecto</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo7" name="mostrarModulo7" onChange="mostrar(7);" />
                                <label for="mostrarModulo7"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo7" name="altaModulo7" onChange="alta(7);" />
                                <label for="altaModulo7"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo7" name="detallesModulo7" onChange="detalles(7);" />
                                <label for="detallesModulo7"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo7" name="edicionModulo7" onChange="editar(7);" />
                                <label for="edicionModulo7"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo7" name="eliminacionModulo7" onChange="eliminar(7);" />
                                <label for="eliminacionModulo7"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Fianzas / garantías de un contrato</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo8" name="mostrarModulo8" onChange="mostrar(8);" />
                                <label for="mostrarModulo8"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo8" name="altaModulo8" onChange="alta(8);" />
                                <label for="altaModulo8"></label>
                            </p>
                        </td>
                        <td>
                            <a href="#" class="btn-flat tooltipped" data-position="bottom" data-delay="30" data-tooltip="Se habilitará el cambio de status de la fianza / garantía" style="padding: 0px !important;">
                                <input type="checkbox" id="detallesModulo8" name="detallesModulo8" onChange="detalles(8);" />
                                <label for="detallesModulo8"></label>
                            </a>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo8" name="edicionModulo8" onChange="editar(8);" />
                                <label for="edicionModulo8"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo8" name="eliminacionModulo8" onChange="eliminar(8);" />
                                <label for="eliminacionModulo8"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Documentos de la fianza / garantía de un contrato</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo9" name="mostrarModulo9" onChange="mostrar(9);" />
                                <label for="mostrarModulo9"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo9" name="altaModulo9" onChange="alta(9);" />
                                <label for="altaModulo9"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo9" name="detallesModulo9" onChange="detalles(9);" />
                                <label for="detallesModulo9"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo9" name="edicionModulo9" onChange="editar(9);" />
                                <label for="edicionModulo9"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo9" name="eliminacionModulo9" onChange="eliminar(9);" />
                                <label for="eliminacionModulo9"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Rediciones de un contrato</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo10" name="mostrarModulo10" onChange="mostrar(10);" />
                                <label for="mostrarModulo10"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo10" name="altaModulo10" onChange="alta(10);" />
                                <label for="altaModulo10"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo10" name="detallesModulo10" onChange="detalles(10);" />
                                <label for="detallesModulo10"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo10" name="edicionModulo10" onChange="editar(10);" />
                                <label for="edicionModulo10"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo10" name="eliminacionModulo10" onChange="eliminar(10);" />
                                <label for="eliminacionModulo10"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Clientes</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo11" name="mostrarModulo11" onChange="mostrar(11);" />
                                <label for="mostrarModulo11"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo11" name="altaModulo11" onChange="alta(11);" />
                                <label for="altaModulo11"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo11" name="detallesModulo11" onChange="detalles(11);" />
                                <label for="detallesModulo11"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo11" name="edicionModulo11" onChange="editar(11);" />
                                <label for="edicionModulo11"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo11" name="eliminacionModulo11" onChange="eliminar(11);" />
                                <label for="eliminacionModulo11"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Fianzas / garantías</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo12" name="mostrarModulo12" onChange="mostrar(12);" />
                                <label for="mostrarModulo12"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo12" name="altaModulo12" onChange="alta(12);" />
                                <label for="altaModulo12"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo12" name="detallesModulo12" onChange="detalles(12);" />
                                <label for="detallesModulo12"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo12" name="edicionModulo12" onChange="editar(12);" />
                                <label for="edicionModulo12"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo12" name="eliminacionModulo12" onChange="eliminar(12);" />
                                <label for="eliminacionModulo12"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Gráficas</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo13" name="mostrarModulo13" onChange="mostrar(13);" />
                                <label for="mostrarModulo13"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo13" name="altaModulo13" onChange="alta(13);" />
                                <label for="altaModulo13"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo13" name="detallesModulo13" onChange="detalles(13);" />
                                <label for="detallesModulo13"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo13" name="edicionModulo13" onChange="editar(13);" />
                                <label for="edicionModulo13"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo13" name="eliminacionModulo13" onChange="eliminar(13);" />
                                <label for="eliminacionModulo13"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Empresas internas</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo14" name="mostrarModulo14" onChange="mostrar(14);" />
                                <label for="mostrarModulo14"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo14" name="altaModulo14" onChange="alta(14);" />
                                <label for="altaModulo14"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo14" name="detallesModulo14" onChange="detalles(14);" />
                                <label for="detallesModulo14"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo14" name="edicionModulo14" onChange="editar(14);" />
                                <label for="edicionModulo14"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo14" name="eliminacionModulo14" onChange="eliminar(14);" />
                                <label for="eliminacionModulo14"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Documentos de una empresa interna</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo15" name="mostrarModulo15" onChange="mostrar(15);" />
                                <label for="mostrarModulo15"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo15" name="altaModulo15" onChange="alta(15);" />
                                <label for="altaModulo15"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo15" name="detallesModulo15" onChange="detalles(15);" />
                                <label for="detallesModulo15"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo15" name="edicionModulo15" onChange="editar(15);" />
                                <label for="edicionModulo15"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo15" name="eliminacionModulo15" onChange="eliminar(15);" />
                                <label for="eliminacionModulo15"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Archivo muerto</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo16" name="mostrarModulo16" onChange="mostrar(16);" />
                                <label for="mostrarModulo16"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo16" name="altaModulo16" onChange="alta(16);" />
                                <label for="altaModulo16"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo16" name="detallesModulo16" onChange="detalles(16);" />
                                <label for="detallesModulo16"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo16" name="edicionModulo16" onChange="editar(16);" />
                                <label for="edicionModulo16"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo16" name="eliminacionModulo16" onChange="eliminar(16);" />
                                <label for="eliminacionModulo16"></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Expendiente de usuario</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo25" name="mostrarModulo25" onChange="mostrar(25);" />
                                <label for="mostrarModulo25"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo25" name="altaModulo25" onChange="alta(25);" />
                                <label for="altaModulo25"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo25" name="detallesModulo25" onChange="detalles(25);" />
                                <label for="detallesModulo25"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo25" name="edicionModulo25" onChange="editar(25);" />
                                <label for="edicionModulo25"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo25" name="eliminacionModulo25" onChange="eliminar(25);" />
                                <label for="eliminacionModulo25"></label>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>Documento de cliente/proveedor</td>
                        <td>
                            <p>
                                <input type="checkbox" id="mostrarModulo23" name="mostrarModulo23" onChange="mostrar(23);" />
                                <label for="mostrarModulo23"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="altaModulo23" name="altaModulo23" onChange="alta(23);" />
                                <label for="altaModulo23"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="detallesModulo23" name="detallesModulo23" onChange="detalles(23);" />
                                <label for="detallesModulo23"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="edicionModulo23" name="edicionModulo23" onChange="editar(23);" />
                                <label for="edicionModulo23"></label>
                            </p>
                        </td>
                        <td>
                            <p>
                                <input type="checkbox" id="eliminacionModulo23" name="eliminacionModulo23" onChange="eliminar(23);" />
                                <label for="eliminacionModulo23"></label>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script>

        $(document).ready( function (){
            $(".js-video-button").modalVideo({
                youtube:{
                    controls:1,
                    nocookie: true
                }
            });

            $.ajax({
                url: '<?=base_url('/index.php/CrudPermisos/getPermisosUsuario/'.$idTipo)?>',
                type:'POST',
                dataType: 'JSON',
                data: { [csrfName]: csrfHash},
                success: function (data)
                {
                    var tipoUsuario=<?=$idTipo?>;
                    for(i=0; i<data.length; i++)
                    {
                        $("#mostrarModulo"+data[i]['idModulo']).attr("checked",data[i]['mostrar']!="0");
                        $("#altaModulo"+data[i]['idModulo']).attr("checked", data[i]['alta']!="0");
                        $("#detallesModulo"+data[i]['idModulo']).attr("checked", data[i]['detalle']!="0");
                        $("#edicionModulo"+data[i]['idModulo']).attr("checked", data[i]['editar']!="0");
                        $("#eliminacionModulo"+data[i]['idModulo']).attr("checked", data[i]['eliminar']!="0");
                    }
                    if(tipoUsuario==1)
                    {
                        $('input').attr("disabled", "disabled");
                    }
                },
                complete: function () {
                    $('.tooltipped').tooltip({delay: 30});

                    tabla=$("#tabla").DataTable({
                        responsive: true,

                        AutoWidth: true,
                        language: {
                            "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ registros",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningún dato disponible en esta tabla",
                            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }
                        }
                    });
                }
            });


        });
        function mostrar(idModulo)
        {
            var url;
            if($("#mostrarModulo"+idModulo).prop("checked"))
                url="<?=base_url('/index.php/CrudPermisos/asignarPermiso/'.$idTipo)?>/1/mostrar/"+idModulo;
            else
                url="<?=base_url('/index.php/CrudPermisos/asignarPermiso/'.$idTipo)?>/0/mostrar/"+idModulo;
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'JSON',
                data: { [csrfName]: csrfHash},
                success: function (data)
                {
                    //console.log("Ahora el usuario tiene permisos de visualizar: "+data+" -> en el modulo"+idModulo)
                }
            });
        }
        function detalles(idModulo)
        {
            var url;
            if($("#detallesModulo"+idModulo).prop("checked"))
                url="<?=base_url('/index.php/CrudPermisos/asignarPermiso/'.$idTipo)?>/1/detalle/"+idModulo;
            else
                url="<?=base_url('/index.php/CrudPermisos/asignarPermiso/'.$idTipo)?>/0/detalle/"+idModulo;
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'JSON',
                data: { [csrfName]: csrfHash},
                success: function (data)
                {
                    //console.log("Ahora el usuario tiene permisos de ver detalles: "+data+" -> en el modulo"+idModulo);
                }
            });
        }
        function editar(idModulo)
        {
            var url;
            if($("#edicionModulo"+idModulo).prop("checked"))
                url="<?=base_url('/index.php/CrudPermisos/asignarPermiso/'.$idTipo)?>/1/editar/"+idModulo;
            else
                url="<?=base_url('/index.php/CrudPermisos/asignarPermiso/'.$idTipo)?>/0/editar/"+idModulo;
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'JSON',
                data: { [csrfName]: csrfHash},
                success: function (data)
                {
                    //console.log("Ahora el usuario tiene permisos de editar: "+data+" -> en el modulo"+idModulo);
                }
            });
        }
        function eliminar(idModulo)
        {
            var url;
            if($("#eliminacionModulo"+idModulo).prop("checked"))
                url="<?=base_url('/index.php/CrudPermisos/asignarPermiso/'.$idTipo)?>/1/eliminar/"+idModulo;
            else
                url="<?=base_url('/index.php/CrudPermisos/asignarPermiso/'.$idTipo)?>/0/eliminar/"+idModulo;
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'JSON',
                data: { [csrfName]: csrfHash},
                success: function (data)
                {
                    //console.log("Ahora el usuario tiene permisos de eliminar: "+data+" -> en el modulo"+idModulo)
                }
            });
        }
        function alta(idModulo)
        {
            var url;
            if($("#altaModulo"+idModulo).prop("checked"))
                url="<?=base_url('/index.php/CrudPermisos/asignarPermiso/'.$idTipo)?>/1/alta/"+idModulo;
            else
                url="<?=base_url('/index.php/CrudPermisos/asignarPermiso/'.$idTipo)?>/0/alta/"+idModulo;
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'JSON',
                data: { [csrfName]: csrfHash},
                success: function (data)
                {
                    //console.log("Ahora el usuario tiene permisos de alta: "+data+" -> en el modulo"+idModulo)
                }
            });
        }
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>


