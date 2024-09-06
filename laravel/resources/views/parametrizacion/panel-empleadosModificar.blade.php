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
            Intranet | Modificar empleado
        </title>
        @include('includes-CDN/include-head')
        <link rel="stylesheet" href="{{asset('css/parametrizacion/panel-empleadosModificar.css')}}">
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
                                <a href="<?= $server ?>/panel/parametrizacion/empleados"
                                    title="Parametrización > Empleados">
                                    <font color="#34495e">
                                        Parametrización > Empleados >
                                    </font>
                                    <font color="#b4c056">
                                        Modificar
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/parametrizacion/empleados" class="btn btn-primary btn-sm ml10"
                            title="Parametrización > Empleados">
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
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Actualice los datos del empleado
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        <form
                                                            action="{{ route('empleadoModificarDB')}}"
                                                            class="form" id="form-wizard" method="POST"
                                                            enctype="multipart/form-data">

                                                            @csrf

                                                            <input type="hidden" name="login"
                                                                value="{{ $DatLog->login }}">
                                                            <input type="hidden" name="id_empleado"
                                                                value="{{ $datosEmpleado[0]->id_empleado }}">


                                                            <div
                                                                class="row d-flex align-items-center justify-content-center">
                                                                <div class="col-md-1">
                                                                    <img src="/Berhlan/public/archivos/Empleados/sinimagen.jpg?"
                                                                        class="img-responsive mauto"
                                                                        style="width: 90px; border-radius:6px; border:1;" />
                                                                </div>
                                                                <br>

                                                                <div class="col-md-3">
                                                                    <label style="color: #4ECCDB">
                                                                        Primer nombre
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <input type="text" name="primer_nombre"
                                                                            id="primer_nombre" class="gui-input"
                                                                            placeholder="* Primer nombre"
                                                                            value="{{ $datosEmpleado[0]->primer_nombre }}"
                                                                            required>

                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-file"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label style="color: #4ECCDB">
                                                                        Segundo nombre
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <input type="text" name="ot_nombre"
                                                                            id="ot_nombre" class="gui-input"
                                                                            placeholder="Segundo nombre"
                                                                            value="{{ $datosEmpleado[0]->ot_nombre }}">
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-file"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label style="color: #4ECCDB">
                                                                        Primer apellido
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <input type="text" name="primer_apellido"
                                                                            id="primer_apellido" class="gui-input"
                                                                            placeholder="* Primer apellido"
                                                                            value="{{ $datosEmpleado[0]->primer_apellido }}"
                                                                            required>

                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-files-o"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label style="color: #4ECCDB">
                                                                        Segundo apellido
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <input type="text" name="ot_apellido"
                                                                            id="ot_apellido" class="gui-input"
                                                                            placeholder="Segundo apellido"
                                                                            value="{{ $datosEmpleado[0]->ot_apellido }}">
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-files-o"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <hr style="margin: 30px 25px 30px 25px;">

                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <label style="color: #4ECCDB">
                                                                        Estado
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="estado" id="estado"
                                                                            style="{{ $datosEmpleado[0]->estado == 1 ? 'color:green;' : 'color:red;' }}"
                                                                            required>
                                                                            <option value="1"
                                                                                style="color:green;"
                                                                                {{ $datosEmpleado[0]->estado == 1 ? 'selected' : '' }}>
                                                                                Activo
                                                                            </option>

                                                                            <option value="0" style="color:red;"
                                                                                {{ $datosEmpleado[0]->estado == 0 ? 'selected' : '' }}>
                                                                                Inactivo
                                                                            </option>
                                                                        </select>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <label style="color: #4ECCDB">
                                                                        Identificación
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <input type="text" name="identificacion"
                                                                            id="identificacion" class="gui-input"
                                                                            placeholder="* Identificación"
                                                                            value="{{ $datosEmpleado[0]->identificacion }}"
                                                                            required>
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-tag"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>



                                                                <div class="col-md-3">
                                                                    <label style="color: #4ECCDB">
                                                                        Email
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <input type="email" name="correo"
                                                                            id="correo" class="gui-input"
                                                                            placeholder="* Email"
                                                                            value="{{ $datosEmpleado[0]->correo }}"
                                                                            required>
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-envelope"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label style="color: #4ECCDB">
                                                                        Centro de operación
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="centro_op" id="centro_op"
                                                                            required>
                                                                            @foreach ($centrosOp as $centroOp)
                                                                                <option
                                                                                    value="{{ $centroOp->id_centro }}" {{ $centroOp->id_centro == $datosEmpleado[0]->centro_op ? 'selected' : '' }}>
                                                                                    {{ $centroOp->descripcion }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <label style="color: #4ECCDB">
                                                                        Teléfono
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <input type="number" name="numtel"
                                                                            id="numtel" class="gui-input"
                                                                            placeholder="* Teléfono"
                                                                            value="{{ $datosEmpleado[0]->numtel }}"
                                                                            required>
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-phone-square"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                            </div>

                                                            <hr style="margin: 30px 25px 30px 25px;">

                                                            <div class="row">
                                                                <div class="col-md-7">

                                                                    <label style="color: #4ECCDB">
                                                                        Cargo
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="cargo" id="cargo"
                                                                            required>
                                                                            @foreach ($cargos as $cargo)
                                                                                <option
                                                                                    value="{{ $cargo->id_cargo }}" {{$datosEmpleado[0]->cargo == $cargo->id_cargo ? 'selected' : ''}}>
                                                                                    {{ $cargo->descripcion }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-2">

                                                                    <label style="color: #4ECCDB">
                                                                        Fecha de nacimiento
                                                                    </label>
                                                                    <label class="field select">
                                                                        <input type="date" name="fecha_nacimiento"
                                                                            class="gui-input"
                                                                            value="{{ $datosEmpleado[0]->fecha_nacimiento }}">
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-2 d-flex flex-column align-items-center">

                                                                    <label style="color: #4ECCDB">
                                                                        Tipo creación empleado
                                                                    </label>
                                                                    <label class="field select">
                                                                        @if ($datosEmpleado[0]->empleado_siesa == 1)
                                                                            <p class="text-center" style="font-size: 16px;">Siesa</p>
                                                                        @else
                                                                            <p class="text-center" style="font-size: 16px;">Manual</p>
                                                                        @endif
                                                                    </label>
                                                                </div>


                                                            </div>
                                                            <br>
                                                            <div class="row d-flex" style="justify-content: flex-end;">
                                                                <div class="col-md-3">
                                                                    <br><br>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Modificar
                                                                        empleado</button>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </form>
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

        @include('includes-CDN/include-script')
        <script type="module" src="{{ asset('js/parametrizacion/panel-empleadosModificar.js') }}"></script>
    </body>

    </html>
@endforeach
