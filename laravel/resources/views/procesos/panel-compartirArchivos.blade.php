<?php
$server = '/Berhlan/public';
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Procesos | Compartir Archivos
        </title>

        <meta name="keywords" content="panel, cms, usuarios, servicio" />
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link
            href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'rel='stylesheet'
            type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/skin/default_skin/css/theme.css">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.min.css">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

        <!-- -------------- DataTables -------------- -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.0/css/fixedColumns.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/select/2.0.0/css/select.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

        <!-- -------------- Theme Scripts -------------- -->
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>


        <!-- -------------- DataTables -------------- -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/dataTables.fixedColumns.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/fixedColumns.dataTables.js"></script>
        <script src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.js"></script>
        <script src="https://cdn.datatables.net/select/2.0.0/js/select.dataTables.js"></script>

        <!-- Importar script select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Importar style select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>

    <body class="sales-stats-page">
        <!-- -------------- Body Wrap  -------------- -->
        <div id="main">
            <!-- -------------- Header  -------------- -->
            <header class="navbar navbar-fixed-top bg-dark">
                @include('includes-panel/headerInterno-panel')
            </header>
            <!-- -------------- /Header  -------------- -->

            <!-- -------------- Sidebar  -------------- -->
            <aside id="sidebar_left" class="nano nano-light affix">
                <!-- -------------- Sidebar Left Wrapper  -------------- -->
                <div class="sidebar-left-content nano-content">
                    <!-- -------------- Sidebar Menu  -------------- -->
                    @include('includes-panel/menuModulosEscritorio-panel')
                    <!-- -------------- /Sidebar Menu  -------------- -->

                    <!-- -------------- Sidebar Hide Button -------------- -->
                    <div class="sidebar-toggler">
                        <a href="#">
                            <span class="fa fa-arrow-circle-o-left"></span>
                        </a>
                    </div>
                    <!-- -------------- /Sidebar Hide Button -------------- -->
                </div>
                <!-- -------------- /Sidebar Left Wrapper  -------------- -->
            </aside>

            <!-- -------------- Main Wrapper -------------- -->
            <section id="content_wrapper">

                <header id="topbar" class="ph10">
                    <div class="topbar-left">
                      <ul class="nav nav-list nav-list-topbar pull-left">
                        <li class="active">
                          <a href="<?=$server?>/panel/menu/6" title="Procesos internos">
                            <font color="#34495e">
                              Procesos internos > Compartir archivos
                            </font>
                          </a>
                        </li>
                      </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                      <a href="<?=$server?>/panel/menu/6" class="btn btn-primary btn-sm ml10" title="Procesos internos">
                        REGRESAR &nbsp;
                        <span class="fa fa-arrow-left"></span>
                      </a>
                    </div>
                  </header>

                <section id="content" class="table-layout animated fadeIn">

                    <div class="chute chute-center pt30">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m10">
                            <!-- -------------- Message Body -------------- -->
                            <div class="table-responsive">
                                <table class="table theme-warning br-t">
                                    <thead>
                                        <tr style="background-color:#39405a">
                                            <th>
                                                <font color="white">
                                                    Compartir Documentos
                                                </font>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tr>



                                        <td>
                                            <div class="buttons"
                                                style="display: flex;justify-content: center; align-items: center; gap:20px;">
                                                <button id="macroprocesos" class="btn btn-success onclick">Macro
                                                    procesos</button>
                                                <button id="procesos" class="btn btn-primary onclick">Procesos</button>
                                                <button id="subprocesos" class="btn btn-primary onclick">Sub
                                                    procesos</button>
                                            </div>
                                            <div id="macroprocesos" class="onclick">
                                                @include('procesos.templates.comp_macro_procesos')
                                            </div>

                                            <div hidden id="procesos" class="onclick">
                                                @include('procesos.templates.comp_procesos')
                                            </div>

                                            <div hidden id="subprocesos" class="onclick">
                                                @include('procesos.templates.comp_subprocesos')
                                            </div>



                                        </td>

                                    </tr>
                                </table>


                            </div>
                        </div>
                        <!-- -------------- /Column Center -------------- -->
                    </div>
                </section>




            </section>
        </div>


        <script src="<?= $server ?>/panelfiles/assets/js/utility/utility.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/demo/demo.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/main.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/pages/allcp_forms-elements.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>

        <script>
            $('select').select2();

            $('button.onclick').on('click', function() {
                var dynamicID = $(this).attr('id');
                $('button.onclick').not(this).addClass('btn-primary');
                $('button.onclick').not(this).removeClass('btn-success');
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-success');
                $('div.onclick').hide();
                $('div #' + dynamicID).show();
            });
        </script>

    </body>

    </html>
@endforeach
