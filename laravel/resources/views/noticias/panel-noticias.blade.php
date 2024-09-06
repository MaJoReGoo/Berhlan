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
            Intranet | Noticias
        </title>

        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
            rel='stylesheet' type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/skin/default_skin/css/theme.css">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.min.css">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.png">
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
                <!-- -------------- /Topbar -------------- -->
                <!-- -------------- Content -------------- -->
                <!-- -------------- Column Center -------------- -->
                <div class="chute chute-center">

                    <table align="center" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                        <tr>
                            <td style="background-color:white">
                                <a href="https://berhlan.speakap.com" target="_blank" title="Somos Berhlan">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/somos.png"
                                        width="70px" alt="Somos Berhlan"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>



                                <a href="http://190.14.237.174:8900/AuthAG/LoginFormAG?IdCia=1&NroConexion=1"
                                    target="_blank" title="Autogestión">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/autogestion.png"
                                        width="70px" alt="Autogestión"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>



                                <a href="https://outlook.office.com" target="_blank" title="Outlook">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/outlook.png"
                                        width="70px" alt="Outlook"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>



                                <a href="http://192.168.1.206:8008/siesa/jsp/index.jsp?idE=m8&s=Real" target="_blank"
                                    title="Siesa Web">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/nominaweb.png"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;"
                                        width="70px" alt="Siesa Web" />
                                </a>



                                <a href="https://powerbi.microsoft.com/es-es/" target="_blank" class="steps label"
                                    title="Power Bi">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/powerbi.png"
                                        width="70px" alt="Power Bi"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>



                                <a href="https://recaudos.berhlan.com/login" target="_blank" title="AGR">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/agr.png"
                                        width="70px" alt="AGR"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>

                                <a href="https://retailpro.berhlan.com" target="_blank" title="Retail Pro">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/retail_pro.png"
                                        width="70px" alt="Retail Pro"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>
								
								<a href="https://bgo.berhlan.com" target="_blank" title="Bgo">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/bgo.png"
                                        width="70px" alt="Bgo"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>


                                <a href="https://berhlan.com/" target="_blank" style="transform: scale(1.5);"
                                    title="www.berhlan.com">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/berhlanweb.png"
                                        width="100px" alt="www.berhlan.com" />
                                </a>



                                <a href="https://clientes.berhlan.com/landing" target="_blank" title="B2B">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/b2b.png"
                                        width="70px" alt="B2B"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>



                                <a href="https://accounts.zoho.com/signin?servicename=ZohoCRM&signupurl=https://www.zoho.com/crm/signup.html&serviceurl=https%3A%2F%2Fcrm.zoho.com%2Fcrm%2FShowHomePage.do%3Fref_value%3Dgoogle%253Acrm%257Cgoogle%253Acrm%257Cgoogle%253Acrm%252Chttps%253A%252F%252Fwww.zoho.com%252Fcrm%252Flogin.html%252C%252CDesktop%252Chttps%253A%252F%252Fwww.zoho.com%252Fcrm%252Flogin.html"
                                    target="_blank" class="steps label" title="CRM">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/crm.png"
                                        width="70px" alt="CRM"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>



                                <a href="https://portalfe.siesacloud.com/smart4b/" target="_blank"
                                    title="Facturación electrónica">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/facturacione.png"
                                        width="70px" alt="Facturación electrónica"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>



                                <a href="http://192.168.1.207/login" target="_blank" title="Control de piso">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/controldepiso.png"
                                        width="70px" alt="Control de piso"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>



                                <a href="https://www.bpack.com.co/" target="_blank" title="www.bpack.com.co">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/bpack.png"
                                        width="70px" alt="www.bpack.com.co"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>



                                <a href="https://escuelaberhlan.com/login/index.php" target="_blank"
                                    title="Escuela Berhlan">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/escuela.png"
                                        width="70px" alt="Escuela Berhlan"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>

                                <a href="https://bpackcloud.com/" target="_blank"
                                    title="Bcloud">
                                    <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/bcloud.png"
                                        width="70px" alt="Bloud"
                                        style="border: 1px solid #000; border-radius:50px; border-color:#232F76;" />
                                </a>
								

                            </td>
                        </tr>
                    </table>

                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-6 title" style="padding-top: 30px">
                            <img src="<?= $server ?>/panelfiles/assets-nl/images/login-images/noticia.jpg?<?= date('i:s') ?>"
                                width="800" alt="Berhlan" />
                        </div>
                    </div>
                </div>
                <!-- -------------- /Column Center -------------- -->
            </section>
            <!-- -------------- /Content -------------- -->
        </div>
        <!-- -------------- /Body Wrap  -------------- -->
        <!-- -------------- Scripts -------------- -->
        <!-- -------------- jQuery -------------- -->

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
        <script src="<?= $server ?>/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="<?= $server ?>/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js"></script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="<?= $server ?>/panelfiles/assets/js/plugins/highcharts/highcharts.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/d3.min.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.js"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="<?= $server ?>/panelfiles/assets/js/utility/utility.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/demo/demo.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/main.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/pages/dashboard2.js"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="<?= $server ?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>
        <!-- -------------- /Scripts -------------- -->
    </body>
    {{--      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Aviso Importante!!!</h5>
              </div>
              <div class="modal-body">
                  <span style="text-align: justify">

                      Con el propósito de mejorar la atención de <b style="color: #000">TIC</b>, para emergencias, atención fuera del horario de
                      oficina, fines de semanas o días festivos, compartimos el número único de atención. <b style="color: #000">3185358797</b>.

                  </span>
                  <br>
                  <div style=" display: flex;
                  justify-content: center;">
                      <img src="{{ $server }}/images/what.png" alt="">
                  </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
          </div>
      </div>
  </div>

  <script>
      $(document).ready(function() {
          $('#exampleModal').modal('show');
      });
  </script> --}}

    </html>
@endforeach
