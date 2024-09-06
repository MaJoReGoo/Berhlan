<?php
$server = '/Berhlan/public';
?>

<!doctype html>

<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta name="keywords" content="cms, jdata, login, panel, administrar, form" />
    <meta name="description" content="Intranet para grupo Berhlan">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--favicon-->
    <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets-nl/images/login-images/favicon.ico">

    <!-- Bootstrap CSS -->
    <link href="<?= $server ?>/panelfiles/assets-nl/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $server ?>/panelfiles/assets-nl/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?= $server ?>/panelfiles/assets-nl/css/app.css" rel="stylesheet">
    <link href="<?= $server ?>/panelfiles/assets-nl/css/icons.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">

    <!-- Sweetalert -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script src="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <title>
        Intranet
    </title>

    <style type="text/css">
        a {
            margin: 0;
            padding: 0;
            text-decoration: none;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            -ms-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        a:focus,
        a:hover {
            text-decoration: none;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            -ms-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .flx {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-flow: row wrap;
        }

        .steps {
            flex: 0 0 106px;
            height: 106px;
            margin: 0;
            color: #ffffff;
            padding: 0 !important;
            border-radius: 50%;
        }

        .label {
            width: 100%;
            font-size: 1.3rem;
            padding: 10px;
            border: solid 2px rgb(255 255 255 / 0%);
            position: relative;
            -webkit-transition: all 0.5s ease-in-out;
            -moz-transition: all 0.5s ease-in-out;
            -o-transition: all 0.5s ease-in-out;
            -ms-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
            cursor: pointer;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .label:hover {
            border: solid 2px #ffd300;
            transform: scale(1.1);
        }

        .label::before {
            background-color: white;
            color: white;
            content: " ";
            display: block;
            border-radius: 50%;
            border: 1px solid grey;
            position: absolute;
            top: -5px;
            left: -5px;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 28px;
            transition-duration: 0.4s;
            transform: scale(0);
        }

        .steps img {
            display: block;
            margin: 2px;
            width: 100px;
            max-width: inherit;
            height: 100px;
        }

        .page-heading-area {
            position: relative;
            padding: 160px 0px 0;
            height: 100%;
            display: inline-block;
            width: 100%;
            z-index: 1;
        }

        .container {
            position: relative;
        }

        @media only screen and (max-width:767px) {
            .title {
                margin-bottom: 70px;
            }

            .steps {
                flex: 0 0 70px;
                height: 70px;
            }

            .steps img {
                width: 65px;
                height: 65px;
                margin: 0;
            }

            .page-heading-area {
                padding: 100px 0px 0;
            }
        }
    </style>



</head>

<body class="bg-theme bg-theme3">
    <?php
  //Mensaje de error
  if (isset($ErrorValidacion) && ($ErrorValidacion != "")) { ?>
    <script>
        function infoSolicitud(texto) {
            Swal.fire({
                icon: 'info',
                title: "<i>Información de Solicitud</i>",
                html: texto,
                confirmButtonText: "Cerrar!",
            });
        }

        onload(infoSolicitud('Hola Mundo'));
    </script>
    <?php } ?>

    <?php
  //Mensaje de error
  if (isset($MensajeLogin)  && ($MensajeLogin != "")) { ?>
    <script>
        function infoSolicitud($MensajeLogin) {
            Swal.fire({
                icon: 'info',
                title: "<i>Información de Solicitud</i>",
                html: $MensajeLogin,
                confirmButtonText: "Cerrar!",
            });
        }
    </script>
    <?php } ?>

    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin loginFlex">
            <div class="logoLogin">
                <section class="page-heading-area"
                    style="background-image: url(<?= $server ?>/panelfiles/assets-nl/images/login-images/bg.png); object-fit: cover;">
                    <div class="col-md-12 text-center">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 title" style="padding-top: 30px">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/titulo.png"
                                    alt="Berlan" />
                            </div>
                        </div>

                        <br>

                        <div class="flx">
                            <a href="https://bpackcloud.com/" target="_blank" class="steps label" title="Bcloud">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/bcloud.png"
                                    alt="Bcloud" />
                            </a>
                            <a href="https://outlook.office.com" target="_blank" class="steps label" title="Outlook">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/outlook.png"
                                    alt="Outlook" />
                            </a>

                            <a href="https://escuelaberhlan.com/login/index.php" target="_blank" class="steps label"
                                title="Escuela Berhlan">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/escuela.png"
                                    alt="Escuela Berhlan" />
                            </a>

                            

                            <a href="https://berhlan.com/" target="_blank" class="steps label"
                                 title="www.berhlan.com">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/berhlanweb.png"
                                    alt="www.berhlan.com" />
                            </a>

                
                            <a href="https://powerbi.microsoft.com/es-es/" target="_blank" class="steps label"
                                title="Power Bi">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/powerbi.png"
                                    alt="Power Bi" />
                            </a>

                            <a href="https://www.bpack.com.co/" target="_blank" class="steps label"
                                title="www.bpack.com.co">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/bpack.png"
                                    alt="www.bpack.com.co" />
                            </a>
                            <a href="https://retailpro.berhlan.com" target="_blank" class="steps label" title="Retail Pro">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/retail_pro.png"
                                    alt="Retail Pro" />
                            </a>
  
  							<a href="https://bgo.berhlan.com" target="_blank" class="steps label"
                                title="Bgo">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/bgo.png"
                                    alt="Bgo" />
                            </a>
                            <a href="https://recaudos.berhlan.com/login" target="_blank" class="steps label"
                                title="AGR">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/agr.png"
                                    alt="AGR" />
                            </a>

                            <a href="https://clientes.berhlan.com/landing" target="_blank" class="steps label"
                                title="B2B">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/b2b.png"
                                    alt="B2B" />
                            </a>

                            <a href="https://accounts.zoho.com/signin?servicename=ZohoCRM&signupurl=https://www.zoho.com/crm/signup.html&serviceurl=https%3A%2F%2Fcrm.zoho.com%2Fcrm%2FShowHomePage.do%3Fref_value%3Dgoogle%253Acrm%257Cgoogle%253Acrm%257Cgoogle%253Acrm%252Chttps%253A%252F%252Fwww.zoho.com%252Fcrm%252Flogin.html%252C%252CDesktop%252Chttps%253A%252F%252Fwww.zoho.com%252Fcrm%252Flogin.html"
                                target="_blank" class="steps label" title="CRM">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/crm.png"
                                    alt="CRM" />
                            </a>

                            <a href="http://190.14.237.174:8900/AuthAG/LoginFormAG?IdCia=1&NroConexion=1"
                                target="_blank" class="steps label" title="Autogestión">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/autogestion.png"
                                    alt="Autogestión" />
                            </a>

                            <a href="https://portalfe.siesacloud.com/smart4b/" target="_blank" class="steps label"
                                title="Facturación electrónica">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/facturacione.png"
                                    alt="Facturación electrónica" />
                            </a>

                            <a href="http://192.168.1.206:8008/siesa/jsp/index.jsp?idE=m8&s=Real" target="_blank"
                                class="steps label" title="Siesa Web">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/nominaweb.png"
                                    alt="Siesa Web" />
                            </a>

                            <a href="http://192.168.1.207/login" target="_blank" class="steps label"
                                title="Control de piso">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/controldepiso.png"
                                    alt="Control de piso" />
                            </a>

                            <a href="https://berhlan.speakap.com" target="_blank" class="steps label"
                                title="Somos Berhlan">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/somos.png"
                                    alt="Somos Berhlan" />
                            </a>
                        </div>

                        <br>

                        {{-- <div class="flx">
                            <a href="https://recaudos.berhlan.com/login" target="_blank" class="steps label"
                                title="AGR">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/agr.png"
                                    alt="AGR" />
                            </a>

                            <a href="https://clientes.berhlan.com/landing" target="_blank" class="steps label"
                                title="B2B">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/b2b.png"
                                    alt="B2B" />
                            </a>

                            <a href="https://accounts.zoho.com/signin?servicename=ZohoCRM&signupurl=https://www.zoho.com/crm/signup.html&serviceurl=https%3A%2F%2Fcrm.zoho.com%2Fcrm%2FShowHomePage.do%3Fref_value%3Dgoogle%253Acrm%257Cgoogle%253Acrm%257Cgoogle%253Acrm%252Chttps%253A%252F%252Fwww.zoho.com%252Fcrm%252Flogin.html%252C%252CDesktop%252Chttps%253A%252F%252Fwww.zoho.com%252Fcrm%252Flogin.html"
                                target="_blank" class="steps label" title="CRM">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/crm.png"
                                    alt="CRM" />
                            </a>

                            <a href="http://190.14.237.174:8900/AuthAG/LoginFormAG?IdCia=1&NroConexion=1"
                                target="_blank" class="steps label" title="Autogestión">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/autogestion.png"
                                    alt="Autogestión" />
                            </a>

                            <a href="https://portalfe.siesacloud.com/smart4b/" target="_blank" class="steps label"
                                title="Facturación electrónica">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/facturacione.png"
                                    alt="Facturación electrónica" />
                            </a>

                            <a href="http://192.168.1.206:8008/siesa/jsp/index.jsp?idE=m8&s=Real" target="_blank"
                                class="steps label" title="Siesa Web">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/nominaweb.png"
                                    alt="Siesa Web" />
                            </a>

                            <a href="http://192.168.1.207/login" target="_blank" class="steps label"
                                title="Control de piso">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/controldepiso.png"
                                    alt="Control de piso" />
                            </a>

                            <a href="https://berhlan.speakap.com" target="_blank" class="steps label"
                                title="Somos Berhlan">
                                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/somos.png"
                                    alt="Somos Berhlan" />
                            </a>
                        </div> --}}

                    </div>
                </section>

                <div id="animate-area"
                    style="background-image: url(<?= $server ?>/panelfiles/assets-nl/images/login-images/bg.png);">
                </div>
            </div>

            <div class="card card-login">
                <div class="text-center">
                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/logoIntranet.png"
                        alt="Berhlan">
                </div>

                <div class="form-body">
                    {!! Form::open(['action' => 'HomePanelController@showLoginVerification', 'class' => 'row g-3']) !!}
                    <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">
                            <b>
                                Usuario*
                            </b>
                            <br>
                            <b>(Nro. Identificación)</b>
                        </label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Identificación" required>
                    </div>

                    <div class="col-12">
                        <label for="inputChoosePassword" class="form-label">
                            <b>
                                Contraseña
                            </b>
                        </label>
                        <div class="input-group" id="show_hide_password">
                            <input type="password" class="form-control border-end-0" id="secret" name="secret"
                                placeholder="Contraseña" required>
                            <a href="javascript:;" class="input-group-text bg-transparent">
                                <i class='bx bx-hide'></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-light">
                                <i class="bx bxs-lock-open"></i>
                                Ingresar
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/marcaberlan.png" class="minibrand"
                    alt="berlan" />
            </div>
        </div>
    </div>

    <!--end wrapper-->
    <!--plugins-->
    <script src="<?= $server ?>/panelfiles/assets-nl/js/jquery.min.js"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>

    <!-- -------------- jQuery -------------- -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>
