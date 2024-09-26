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
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            function formatToCustomFormat(dateString) {
                const date = new Date(dateString);

                const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                const dayOfWeek = daysOfWeek[date.getUTCDay()];
                const dayOfMonth = date.getUTCDate();
                const month = months[date.getUTCMonth()];
                const year = date.getUTCFullYear();
                const hours = date.getUTCHours();
                const minutes = date.getUTCMinutes();
                const seconds = date.getUTCSeconds();

                // Formato personalizado "D, d M Y H:i:s T"
                return `${dayOfWeek}, ${dayOfMonth} ${month} ${year} ${hours}:${minutes}:${seconds} GMT`;
            }

            function submitForm() {
                let formData = new FormData(document.getElementById('myForm'));
                let fecha_inicio = formatToCustomFormat(document.getElementById('desde').value);
                let fecha_final = formatToCustomFormat(document.getElementById('hasta').value);


                axios.get('{{asset_api?>api3/api/listdocument/')}}' + fecha_inicio + '/' + fecha_final)
                    .then(response => {
                        console.log(response.data.documents);
                        for (let i = 0; i < response.data.documents.length; i++) {
                            if (response.data.documents[i].document_type.type == 'PURCHASE_ORDER') {
                                var tipo = 1;
                            } else {
                                var tipo = 0;
                            }

                            const ean = response.data.documents[i].properties.sender;
                            const documento = response.data.documents[i].document_id;
                            const orden = response.data.documents[i].properties.send_reference;
                            const fecha_created = response.data.documents[i].created_date;

                            var url = 'http://192.168.1.210/Berhlan/public/panel/despachos/cargardespacho/' + ean +
                                    '/' +documento + '/' + orden + '/' + fecha_created + '/' + tipo;

                            $.ajax({

                                url: url,
                                method: 'GET',

                                success: function(response) {
                                    console.log('exito');
                                    //Cuando la interacción sea exitosa, se ejecutará esto.


                                },
                                error: function(response) {
                                    console.log(response);

                                    //Cuando la interacción retorne un error, se ejecutará esto.
                                }

                            })

                        }
                        window.location.reload();
                    })
                    .catch(error => {
                        // Handle errors
                        console.error(error);
                    });

            }

            function submitFile(id, archivo) {


                axios.get('{{asset_api('api4/api/descargardocument/')}}' + archivo)
                    .then(response => {
                        // Handle the response

                        $.ajax({
                            type: 'GET',
                            url: '{{ asset ('/panel/despachos/listarorden/descargue/')}}' + id,
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
                                                    Cargue documentos para aviso despacho
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <td>
                                                <div class="row g-3 align-items-center">

                                                    <div class="col-md-4 " style="padding-top: 15px">
                                                        <form id="myForm" class="align-items-center text-center">
                                                            @csrf
                                                            <!-- Your form fields go here -->
                                                            <?php
                                                            if ($DocumentosSinEnviar != 0){


                                                            ?>
                                                            <a class="btn btn-primary "
                                                                style="width: 142,483px; height: 40px; text-align: center;"
                                                                href="{{ asset ('/panel/despachos/descargarordenes')}}"
                                                                type="button">Enviar Todos</a>
                                                            <?php
                                                            }else{
                                                                ?>
                                                                <a class="btn btn-primary " style="width: 142,483px; height: 40px; text-align: center; background-color: #b8b8b8"
                                                            type="button" >Enviar Todos</a>
                                                            <?php
                                                            }
                                                                ?>
                                                            <button class="btn btn-primary" type="button"
                                                                onclick="submitForm()">Listar Ordenes</button>


                                                        </form>

                                                    </div>

                                                    <div class="col-md-4">
                                                        <label style="color:#34495e;">
                                                            <b>
                                                                Fecha desde
                                                            </b>
                                                        </label>
                                                        <label class="field prepend-icon">
                                                            {!! Form::date('desde', null, ['', 'id' => 'desde', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label style="color:#34495e;">
                                                            <b>
                                                                Fecha hasta
                                                            </b>
                                                        </label>
                                                        <label class="field prepend-icon">
                                                            {!! Form::date('hasta', null, ['', 'id' => 'hasta', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                        </label>
                                                    </div>

                                                </div>
                                                <!-- Your form fields go here -->






                                </div>

                                </td>


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
                                                <font color="#444444"> EAN tercero</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> Id documento</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> Orden compra</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> Fecha creacion</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> Fecha descargue</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> Accion</font>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($DatosDocumentos as $dataDocu)
                                            <tr style="">
                                                <td style="text-align: center;">
                                                    <font color="#444444"> {{ $dataDocu->id }}</font>
                                                </td>
                                                <td style="text-align: left;">
                                                    <font color="#444444"> {{ $dataDocu->tercero }}
                                                    </font>
                                                </td>
                                                <td style="text-align: left;">
                                                    <font color="#444444"> {{ $dataDocu->document_id }}</font>
                                                </td>
                                                <td style="text-align: left;">
                                                    <font color="#444444"> {{ $dataDocu->orden_compra }}</font>
                                                </td>
                                                </td>
                                                <td style="text-align: left;">
                                                    <font color="#444444"> {{ $dataDocu->fecha_creacion }}</font>
                                                </td>
                                                </td>
                                                <td style="text-align: left;">
                                                    <font color="#444444"> {{ $dataDocu->fecha_descargue }}</font>
                                                </td>
                                                <td style="text-align: left;">
                                                    <?php if ($dataDocu->estado == 0) {
                                        $nombreFile = $dataDocu->document_id;
                                        ?>
                                                    <button class="btn btn-primary"
                                                        onclick="submitFile(<?= $dataDocu->id ?>, '<?= $nombreFile ?>')">Enviar</button>
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
