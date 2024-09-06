<br>
<div class="panel m4">
    <div class="nano-content">
        <div class="table-responsive">
            <table id="message-table" class="table allcp-form theme-warning br-t">

                <thead>
                    <tr style="background-color:#39405a">
                        <th>
                            Informacion solicitud
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <div class="allcp-form">

                                <div class="row">

                                    <div class="col-md-4">
                                        <label style="color:#34495e;">
                                            <b>
                                                Salario
                                            </b>
                                        </label>
                                        <label class="field prepend-icon">
                                            <input type="number" id="salario" class="gui-input"
                                                value="{{ $DatosSolicitud[0]->salario }}" disabled>

                                            <label for="username" class="field-icon">
                                                <i class="fa fa-dollar"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="col-md-4">
                                        <label style="color:#34495e;">
                                            <b>
                                                Tipo de contrato
                                            </b>
                                        </label>
                                        <label class="field select">
                                            <select id="contrato" disabled>
                                                <option value="">
                                                    * Tipo de contrato
                                                </option>
                                                @foreach ($Tpcontratos as $DatTpc)
                                                    <option value="{{ $DatTpc->id_tpcontrato }}"
                                                        {{ $DatosSolicitud[0]->tpcontrato === $DatTpc->id_tpcontrato ? 'selected' : '' }}>
                                                        <?= $DatTpc->descripcion ?>
                                                    </option>
                                                @endforeach
                                            </select>

                                        </label>
                                    </div>

                                    <div class="col-md-4">

                                        <label style="color: #34495e">
                                            <b>
                                                Condiciones
                                            </b>
                                        </label>
                                        <label class="field prepend-icon">

                                            <textarea style="height: 60px;" class="gui-input" disabled>{{ $DatosSolicitud[0]->condiciones }}</textarea>
                                            <label for="username" class="field-icon">
                                                <i class="fa fa-reorder"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <br>
                                        <label style="color:#34495e;">
                                            <b>
                                                Responsable del proceso
                                            </b>
                                        </label>
                                        <label class="field select">

                                            <select disabled>
                                                @if ($DatosSolicitud[0]->estado == '1')
                                                    <option value="">
                                                        Seleccione una opción
                                                    </option>
                                                @endif

                                                <option value="Berhlan de Colombia SAS"
                                                    {{ $DatosSolicitud[0]->responsable_proceso === 'Berhlan de Colombia SAS' ? 'selected' : '' }}>
                                                    Berhlan
                                                    de Colombia SAS</option>
                                                <option value="Temporal"
                                                    {{ $DatosSolicitud[0]->responsable_proceso === 'Temporal' ? 'selected' : '' }}>
                                                    Temporal</option>
                                            </select>

                                        </label>
                                    </div>

                                    <div class="col-md-4">
                                        <br>
                                        <label style="color:#34495e;">
                                            <b>
                                                Nivel Cargo
                                            </b>
                                        </label>
                                        <label class="field select">

                                            <select disabled id="nivel_cargo">
                                                @if ($DatosSolicitud[0]->estado == '1')
                                                    <option value="">
                                                        Seleccione una opción
                                                    </option>
                                                @endif
                                                @foreach ($niveles_cargos as $nivel_cargo)
                                                    <option value="{{ $nivel_cargo->id_nivel_cargo }}"
                                                        {{ $DatosSolicitud[0]->fk_nivel_cargo === $nivel_cargo->id_nivel_cargo ? 'selected' : '' }}>
                                                        {{ $nivel_cargo->nombre_nivel_cargo }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </label>
                                    </div>

                                    @if ($DatosSolicitud[0]->estado != '1')
                                        <div class="col-md-4 fecha_aprox_ingreso">
                                            <br>
                                            <label style="color:#34495e;">
                                                <b>
                                                    Fecha estimada de ingreso
                                                </b>
                                            </label>
                                            <label class="field select">
                                                @php
                                                    $fechaAproxIngreso = \Carbon\Carbon::parse(
                                                        $DatosSolicitud[0]->fecha_aprox_ingreso,
                                                    )->format('Y-m-d');
                                                @endphp
                                                <input class="gui-input" type="date" value="{{ $fechaAproxIngreso }}"
                                                    readonly disabled>
                                            </label>
                                        </div>
                                    @endif


                                    <br>


                                </div>

                                <div class="row">
                                    <br>
                                    <br>
                                    <div class="col-md-8">

                                        <label style="color: #34495e; display:flex; justify-content:center">
                                            <b>Requiere activos:</b>
                                        </label>
                                        <br>
                                        <div class="d-flex" style="gap: 10px;">
                                            @foreach ($herramientas as $herramienta)
                                                <div class="checkbox-wrapper-19 d-flex align-items-center">
                                                    <input id="{{ $herramienta->id_herramienta }}" type="checkbox"
                                                        value="{{ $herramienta->id_herramienta }}" disabled
                                                        {{ $soliRequiere->contains($herramienta->nombre_herramienta) ? 'checked' : '' }}>
                                                    <label style="min-height: 0px" class="check-box"
                                                        for="{{ $herramienta->id_herramienta }}"></label>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <p class="text-dark" style="margin: 0px">
                                                        {{ $herramienta->nombre_herramienta }}</p>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <br>
                                        <label style="color: #34495e; display:flex; justify-content:center">
                                            <b>Requiere dotacion:</b>
                                        </label>

                                        <div class="d-flex justify-content-center" style="gap: 10px">
                                            <div class="checkbox-wrapper-19 d-flex align-items-center" style="gap:14px">
                                                <p class="text-dark" style="margin: 0px">
                                                    Si
                                                </p>
                                                <input id="si" type="radio" value="Si"
                                                    name="requiere_dotacion" disabled {{ $DatosSolicitud[0]->requiere_dotacion == 'Si' ? 'checked' : '' }}>
                                                <label style="min-height: 0px" class="check-box" for="si"></label>

                                              
                                            </div>

                                            <div class="checkbox-wrapper-19 d-flex align-items-center" style="gap:14px">
                                                <p class="text-dark" style="margin: 0px">
                                                    No
                                                </p>
                                                <input id="no" type="radio" value="No"
                                                    name="requiere_dotacion" disabled {{ $DatosSolicitud[0]->requiere_dotacion == 'No' ? 'checked' : '' }}>
                                                <label style="min-height: 0px" class="check-box" for="no"></label>
                                               
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<br>


{{-- <div class="row">
            <div class="panel-header p5 text-white text-center" style="background-color:#39405a">
                Requiere dotaciones
            </div>
            <div class="nano-content p20">
                <table class="table table-hover text-dark text-center" id="dotaciones">
                    <thead>
                        <tr>
                            <th class="text-center">Nombre dotación</th>
                            <th class="text-center">Talla</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($soliDotaciones as $dotacion)
                            <tr>
                                <td>{{ $dotacion->nombre_dotacion }}</td>
                                <td>{{ $dotacion->nombre_talla_dotacion }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <br> --}}



