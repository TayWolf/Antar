<!-- START LEFT SIDEBAR NAV-->
<?php
if(!empty($permisos)) {
    $arregloPermisos=array();
    foreach ($permisos as $permiso)
    {
        $arregloPermisos[intval($permiso['idModulo'])]=$permiso;
    }
    ?>
    <aside id="left-sidebar-nav" class="nav-expanded nav-lock nav-collapsible">

        <div class="brand-sidebar" align="center">

            <h1 class="logo-wrapper">

                <a href="tablero" class="brand-logo darken-1">

                    <!--<img src="http://www.constructora-antar.com.mx/wp-content/uploads/2018/10/antar-sitelogo.png"-->
					<img src="<?=base_url()?>/assets/images/logo/dna2_logo.png"
					
                         alt="materialize logo">

                    <!-- <span class="logo-text hide-on-med-and-down">Antar</span> -->

                </a>

                <a href="#" class="navbar-toggler">

                    <i class="material-icons">radio_button_checked</i>

                </a>

            </h1>

        </div>

        <ul id="slide-out" class="side-nav fixed leftside-navigation">

            <li class="no-padding">

                <ul class="collapsible" data-collapsible="accordion">

                    <li class="bold" id="listItemAdministracion">

                        <a class="collapsible-header waves-effect waves-cyan active">

                            <i class="material-icons">dashboard</i>

                            <span class="nav-text">Administración</span>

                        </a>

                        <div class="collapsible-body">

                            <ul>
                                <?php
                                if(isset($arregloPermisos[0]))
                                {
                                    if($arregloPermisos[0]['mostrar'])
                                    {
                                        ?>
                                        <li onclick="limpiarSecciones();loadUrl('Crudusuarios/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right people</i>

                                                <span>Usuarios</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }

                                if(isset($arregloPermisos[1]))
                                {
                                    if($arregloPermisos[1]['mostrar'])
                                    {
                                        ?>
                                        <li onclick="limpiarSecciones();loadUrl('Crudtipou/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right share</i>

                                                <span>Tipos de usuarios</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }

                                if(isset($arregloPermisos[2]))
                                {
                                    if($arregloPermisos[2]['mostrar']) {
                                        ?>

                                        <li onclick="limpiarSecciones();loadUrl('CrudAreas/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right storage</i>

                                                <span>Áreas</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }
                                if(isset($arregloPermisos[3]))
                                {
                                    if($arregloPermisos[3]['mostrar']) {
                                        ?>
                                        <li onclick="limpiarSecciones();loadUrl('CrudContratos/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right folder</i>

                                                <span>Gestión documental</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }
                                if(isset($arregloPermisos[5]))
                                {
                                    if($arregloPermisos[5]['mostrar'])
                                    {
                                        ?>
                                        <li onclick="limpiarSecciones();loadUrl('CrudStatusContratos/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right exposure</i>

                                                <span>Status de contratos</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }
                                if(isset($arregloPermisos[6]))
                                {
                                    if($arregloPermisos[6]['mostrar'])
                                    {
                                        ?>

                                        <li onclick="limpiarSecciones();loadUrl('CrudProyectos/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right business_center</i>

                                                <span>Proyectos</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }
                                if(isset($arregloPermisos[11]))
                                {
                                    if($arregloPermisos[11]['mostrar'])
                                    {
                                        ?>
                                        <li onclick="limpiarSecciones();loadUrl('CrudEmpresas/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right business</i>

                                                <span>Clientes / Proveedores</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }
                                if(isset($arregloPermisos[12]))
                                {
                                    if($arregloPermisos[12]['mostrar'])
                                    {
                                        ?>
                                        <li onclick="limpiarSecciones();loadUrl('CrudFianzas/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right attach_money</i>

                                                <span>Fianzas / Garantía</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }
                                if(isset($arregloPermisos[14]))
                                {
                                    if ($arregloPermisos[14]['mostrar'])
                                    {
                                        ?>

                                        <li onclick="limpiarSecciones();loadUrl('CrudEmpresasInternas/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right account_balance</i>

                                                <span>Empresas internas</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }
                                if(isset($arregloPermisos[16]))
                                {
                                    if ($arregloPermisos[16]['mostrar'])
                                    {
                                        ?>

                                        <li onclick="limpiarSecciones();loadUrl('CrudArchivoMuerto/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right layers_clear</i>

                                                <span>Archivo muerto</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }
                                
                                if(isset($arregloPermisos[17]))
                                {
                                    if ($arregloPermisos[17]['mostrar'])
                                    {
                                        ?>

                                        <li onclick="limpiarSecciones();loadUrl('CrudBitacora/')">

                                            <a href="#">

                                                <i class="material-icons">keyboard_arrow_right assignment</i>

                                                <span>Bitacora</span>

                                            </a>

                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>

                        </div>

                    </li>
                    <li class="bold" id="listItemAdministracion">
                        <a class="collapsible-header waves-effect waves-cyan active">
                            <i class="material-icons">donut_small</i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <?php
                                if(isset($arregloPermisos[13]))
                                {
                                    if($arregloPermisos[13]['mostrar'])
                                    {
                                        ?>
                                        <li onclick="limpiarSecciones(); loadUrl('CrudDashboard/')">
                                            <a href="#">
                                                <i class="material-icons">keyboard_arrow_right data_usage</i>
                                                <span>Gráficas</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </li>
                </ul>


            </li>

        </ul>

        <a href="#" data-activates="slide-out"
           class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only gradient-45deg-light-blue-cyan gradient-shadow">

            <i class="material-icons">menu</i>

        </a>

    </aside>
    <?php
}
?>


<script>

    elementoAnterior=document.getElementById("listItemAdministracion");

    function limpiarSecciones() {
        $("#content").html('');
        $("#contenido").html('');
    }
</script>

<!-- END LEFT SIDEBAR NAV-->