<?php

$server_api= env('APP_URL_API');
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Despachos
        </title>
        <meta name="keywords" content="panel, cms, usuarios, servicio" />
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
            rel='stylesheet' type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            function submitForm() {
                var formData = new FormData(document.getElementById('myForm'));

                axios.put('{{ asset_api('api1/api/cargararchivo')}}, formData)
                    .then(response => {
                        // Handle the response
                        console.log(response.data.body);
                        $.ajax({
                            type: 'GET',
                            url: '{{ asset ('/panel/despachos/cargardespacho/')}} + response.data
                                .body,
                            success: function(response) {
                                /*alert(response);
                                alert(valor);*/
                                //Cuando la interacción sea exitosa, se ejecutará esto.
                                console.log(response)
                                location.reload();
                            },
                            error: function(response) {
                                alert('Falso');
                                //Cuando la interacción retorne un error, se ejecutará esto.
                            }
                        })
                    })
                    .catch(error => {
                        // Handle errors
                        console.error(error);
                    });
            }

            function submitFile(id, archivo) {


                axios.put('{{ asset_api('api2/api/hacerdispatch/')}} + archivo)
                    .then(response => {
                        // Handle the response
                        console.log(response.data.body);
                        $.ajax({
                            type: 'GET',
                            url: '{{ asset ('/panel/despachos/editardespacho/')}} + id,
                            success: function(response) {

                                console.log(response)
                                location.reload();
                            },
                            error: function(response) {
                                alert('Falso');

                            }
                        })
                    })
                    .catch(error => {
                        // Handle errors
                        console.error(error);
                    });
            }
        </script>
    </head>

    <body>
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
                <!-- -------------- Topbar -------------- -->
                <header id="topbar" class="ph10">
                    <div class="topbar-left">
                        <ul class="nav nav-list nav-list-topbar pull-left">
                            <li class="active">
                                <a href="{{ asset ('/panel/noticias/noticias')}}" title="Inicio">
                                    <font color="#34495e">
                                        Cambio de contraseña
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/noticias/noticias')}}" class="btn btn-primary btn-sm ml10"
                            title="Inicio">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <!-- -------------- Content -------------- -->
                <section id="content" class="table-layout animated fadeIn">
                    <div class="chute chute-center pt30">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m4">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Listar ordenes de compra documentos
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        <div class="row">
                                                            <form id="myForm" class="form">
                                                                @csrf
                                                                <!-- Your form fields go here -->

                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="submitForm()">Cargar Archivo</button>
                                                            </form>
                                                        </div>
                                                            <!-- Your form fields go here -->


                                                            <a class="btn btn-primary"
                                                                href="{{ asset ('/panel/despachos/enviardespachos')}}"
                                                                type="button">Enviar Todos</a>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                    <table id="message-table"
                                        class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                        <thead>
                                            <tr style="background-color: #F8F8F8">
                                                <th style="text-align: center;">
                                                    <font color="#444444"> # </font>
                                                </th>
                                                <th style="text-align: left">
                                                    <font color="#444444"> Nombre</font>
                                                </th>
                                                <th style="text-align: left">
                                                    <font color="#444444"> Fecha Creado</font>
                                                </th>
                                                <th style="text-align: left">
                                                    <font color="#444444"> Fecha Enviado</font>
                                                </th>
                                                <th style="text-align: left">
                                                    <font color="#444444"> Accion</font>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($DatosDespachos as $dataDespa)
                                                <tr style="">
                                                    <td style="text-align: center;">
                                                        <font color="#444444"> {{ $dataDespa->id }}</font>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <font color="#444444"> {{ substr($dataDespa->nombre, 0, 36) }}
                                                        </font>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <font color="#444444"> {{ $dataDespa->fecha }}</font>
                                                    </td>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <font color="#444444"> {{ $dataDespa->fecha_dispatch }}</font>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <?php if ($dataDespa->estado == 0) {
                                        $nombreFile = substr($dataDespa->nombre,0,36);
                                        ?>
                                                        <button class="btn btn-primary"
                                                            onclick="submitFile(<?= $dataDespa->id ?>, '<?= $nombreFile ?>')">Enviar</button>
                                                        <?php } else { ?>
                                                        <a class="btn btn-primary" style="background-color: #b8b8b8"
                                                            target="_blank">Enviado</a>
                                                        <?php } ?>
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>

                                    <script language="javascript" type="text/javascript">
                                        function VALIDAR() {
                                            frm = document.forms["frmenvio"];
                                            var id1 = frm.pwd1.value;
                                            var id2 = frm.pwd2.value;
                                            var id3 = frm.pwd3.value;

                                            if (id1 == "") {
                                                alert("Debe ingresar la contraseña actual.");
                                                frm.pwd1.focus();
                                                return false;
                                            }

                                            if (id2.length < 6) {
                                                alert("La nueva contraseña debe tener mínimo 6 caracteres.");
                                                frm.pwd2.focus();
                                                return false;
                                            }

                                            if (id2 != id3) {
                                                alert("La nueva contraseña no coincide.");
                                                frm.pwd3.focus();
                                                return false;
                                            }
                                            document.frmenvio.submit();
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                        <!-- -------------- /Column Center -------------- -->
                    </div>
                </section>
                <!-- -------------- /Content -------------- -->
            </section>
        </div>
        <!-- -------------- /Body Wrap  -------------- -->

        <!-- -------------- Scripts -------------- -->

        <!-- -------------- jQuery -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js')}}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/utility/utility.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/demo.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/main.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/pages/dashboard2.js')}}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

        <!-- -------------- /Scripts -------------- -->
    </body>

    </html>
@endforeach
