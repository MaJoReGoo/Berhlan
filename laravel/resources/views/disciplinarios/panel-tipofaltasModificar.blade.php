<?php

use App\Models\Parametrizacion\PanelEmpleados;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosTipofalta as $DatTpf)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Procesos disciplinarios | Tipos de faltas
        </title>

        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO" >
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>
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
                    <a href="{{ asset ('/panel/disciplinarios/tipofaltas')}}" title="Proceso disciplinario > Tipos de faltas">
                      <font color="#34495e">
                        Proceso disciplinario > Tipos de faltas >
                      </font>
                      <font color="#b4c056">
                        Modificar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="{{ asset ('/panel/disciplinarios/tipofaltas')}}" class="btn btn-primary btn-sm ml10" title="Proceso disciplinario > Tipos de faltas">
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
                <div class="panel m3">
                  <!-- -------------- Message Body -------------- -->
                  <div class="nano-content">
                    <div class="table-responsive">
                      <table id="message-table" class="table allcp-form theme-warning br-t">
                        <thead>
                          <tr>
                            <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                              Actualice los datos del tipo de falta
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'Disciplinarios\TipofaltasDisciplinariosPanelController@TipofaltasModificarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                  {!! Form::hidden('tipofalta', $DatTpf->id_tipofalta) !!}

                                  <div class="row">
                                    <div class="col-md-7">
                                      <label style="color: #34495e">
                                        <b>
                                          Descripción
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('descripcion', $DatTpf->descripcion, array('required', 'id'=>'descripcion', 'class'=>'gui-input', 'placeholder'=>'* Tipo de falta')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-tag"></i>
                                        </label>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <br>
                                    <div class="col-md-7">
                                      <label style="color: #34495e">
                                        <b>
                                          Detalle
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::textarea('detalle', $DatTpf->detalle, array('', 'id'=>'detalle', 'class'=>'gui-input', 'style'=>'height: 80px; resize: vertical;', 'placeholder'=>'Detalle en que casos se debe seleccionar este tipo de falta')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-bars"></i>
                                        </label>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <br>
                                    <div class="col-md-7">
                                      <label style="color: #34495e">
                                        <b>
                                          Estado
                                        </b>
                                      </label>
                                      <label class="field select">
                                        <select name="estado" id="estado" required>
                                          <option value="1" style="color:green;"
                                          <?php
                                          if($DatTpf->estado == 1)
                                            echo " selected ";
                                          ?>
                                          >Activo</option>

                                          <option value="0" style="color:red;"
                                          <?php
                                          if($DatTpf->estado == 0)
                                            echo " selected ";
                                          ?>
                                          >Inactivo</option>
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <br>
                                    <div class="col-md-7">
                                      <label style="color: #34495e">
                                        <b>
                                          Plantilla
                                        </b>
                                        &nbsp;
                                        <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('{{ asset ('/archivos/Disciplinarios/')}}<?=$DatTpf->id_tipofalta?>.docx?<?=date('i:s')?>','_blank')" title="Plantilla">
                                          <i class="fa fa-file-word-o fa-lg" style="color:#226dbd;"></i>
                                        </button>
                                      </label>
                                      <label class="field prepend-icon append-button file">
                                        <span class="button">
                                          Archivo
                                        </span>
                                        {!! Form::file('file1',
                                            array('', 'id'=>'file1', 'accept'=>'.docx',
                                            'class'=>'gui-file',
                                            'onChange'=>"document.getElementById('uploader1').value = this.value;")) !!}
                                        {!! Form::text('uploader1', null,
                                            array('id'=>'uploader1',
                                            'class'=>'gui-input',
                                            'placeholder'=>'Adjunte el archivo en Word para plantilla')) !!}
                                        <label class="field-icon">
                                          <i class="fa fa-cloud-upload"></i>
                                        </label>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <br>
                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Para
                                        </b>
                                        <br>
                                        Fecha actual:
                                        <br>
                                        Fecha actual menos 1 día (Sin S-D):&nbsp;&nbsp;
                                        <br>
                                        Nombre del empleado:
                                        <br>
                                        Identificación del empleado:
                                        <br>
                                        Número telefónico del empleado:
                                      </label>

                                      <label style="color: #34495e">
                                        <b>
                                          Use
                                          <br>
                                          ${fechactual}
                                          <br>
                                          ${fechactualmenosuno}
                                          <br>
                                          ${nombreempleado}
                                          <br>
                                          ${identificacionempleado}
                                          <br>
                                          ${telefonoempleado}
                                        </b>
                                      </label>
                                    </div>

                                    <div class="col-md-3">
                                      <label style="color: #34495e">
                                        <b>
                                          Para
                                        </b>
                                        <br>
                                        Email del empleado:
                                        <br>
                                        Cargo del empleado:
                                        <br>
                                        Fecha reportada del suceso:
                                        <br>
                                        Usuario que realizó la solicitud:&nbsp;&nbsp;
                                        <br>
                                        Indicar la causa de la solicitud:
                                        <br>
                                      </label>

                                      <label style="color: #34495e">
                                        <b>
                                          Use
                                          <br>
                                          ${correoempleado}
                                          <br>
                                          ${cargoempleado}
                                          <br>
                                          ${fechasuceso}
                                          <br>
                                          ${nombresolicitante}
                                          <br>
                                          ${causa}
                                        </b>
                                        <br>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <br><br>
                                    <div class="col-md-12">
                                      {!! Form::submit('Modificar tipo de falta', array('class'=>'button')) !!}
                                      <br><br>
                                      <label style="color: #34495e">
                                        <b>
                                          Última modificación:
                                        </b>
                                        <?php
                                        $empleado = PanelEmpleados::getEmpleado($DatTpf->usrmod);
                                        echo $empleado[0]->primer_nombre;
                                        echo " ";
                                        echo $empleado[0]->ot_nombre;
                                        echo " ";
                                        echo $empleado[0]->primer_apellido;
                                        echo " ";
                                        echo $empleado[0]->ot_apellido;
                                        echo " ";
                                        echo "(".$DatTpf->fechamod.")";
                                        ?>
                                      </label>
                                    </div>
                                  </div>
                                {!! Form::close() !!}
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
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
        <script src="{{ asset ('/panelfiles/assets/js/pages/allcp_forms-elements.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

        <!-- -------------- /Scripts -------------- -->
      </body>
    </html>
  @endforeach
@endforeach
