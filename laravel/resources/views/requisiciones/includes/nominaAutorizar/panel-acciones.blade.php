<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Requisiciones\PanelTpcontratos;
use App\Models\Requisiciones\PanelMotivos;

?>
<br>
<div class="panel m4">
    <div class="nano-content">
        <div class="table-responsive">
            <table id="message-table" class="table allcp-form theme-warning br-t">
                <thead>
                    <tr style="background-color:#34495e">
                        <th style="color:white; text-align:left;">
                            Autorizar
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <div class="allcp-form">

                                {!! Form::open([
                                    'action' => 'Requisiciones\SolRequisicionesPanelController@NominaAutorizarDB',
                                    'class' => 'form',
                                    'id' => 'autorizar_soli',
                                ]) !!}
                                {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label style="color:#34495e;">
                                            <b>
                                                Cargo
                                            </b>
                                        </label>
                                        <label class="field select">
                                            <select name="cargo" id="cargo" required>
                                                <?php
                                                $Cargo = PanelCargos::getCargo($DatosSolicitud[0]->cargo);
                                                $Area = PanelAreas::getArea($Cargo[0]->area);
                                                $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                                ?>
                                                <option value="<?= $Cargo[0]->id_cargo ?>">
                                                    <?php
                                                    echo $Cargo[0]->descripcion;
                                                    echo ' - ';
                                                    echo $Area[0]->descripcion;
                                                    echo ' - ';
                                                    echo $Empresa[0]->nombre;
                                                    ?>
                                                </option>
                                                <?php
                                                $Cargos = PanelCargos::getCargos();
                                                ?>
                                                @foreach ($Cargos as $DatCrg)
                                                    <?php
                                                    $Area = PanelAreas::getArea($DatCrg->area);
                                                    foreach ($Area as $DatArea) {
                                                        $Empresa = PanelEmpresas::getEmpresa($DatArea->empresa);
                                                        $NombreArea = $DatArea->descripcion;
                                                        foreach ($Empresa as $DatEmpresa) {
                                                            $NombreEmpresa = $DatEmpresa->nombre;
                                                        }
                                                    }
                                                    ?>
                                                    <option value="<?= $DatCrg->id_cargo ?>">
                                                        <?= $DatCrg->descripcion . ' - ' . $NombreArea . ' - ' . $NombreEmpresa ?>
                                                    </option>
                                                @endforeach
                                            </select>

                                        </label>
                                    </div>

                                    <div class="col-md-4">
                                        <label style="color:#34495e;">
                                            <b>
                                                Salario
                                            </b>
                                        </label>
                                        <label class="field prepend-icon">
                                            {!! Form::number('salario', null, [
                                                'required',
                                                'id' => 'salario',
                                                'class' => 'gui-input',
                                                'placeholder' => '* Salario',
                                                'min' => '0',
                                            ]) !!}
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
                                            <select name="contrato" id="contrato" required>
                                                <option value="">
                                                    * Tipo de contrato
                                                </option>
                                                @foreach ($Tpcontratos as $DatTpc)
                                                    <option value="<?= $DatTpc->id_tpcontrato ?>">
                                                        <?= $DatTpc->descripcion ?>
                                                    </option>
                                                @endforeach
                                            </select>

                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <br>
                                        <label style="color: #34495e">
                                            <b>
                                                Condiciones
                                            </b>
                                        </label>
                                        <label class="field prepend-icon">
                                            {!! Form::textarea('condiciones', '', [
                                                '',
                                                'id' => 'condiciones',
                                                'class' => 'gui-input',
                                                'style' => 'height: 60px;',
                                                'placeholder' => 'Condiciones del contrato.',
                                            ]) !!}
                                            <label for="username" class="field-icon">
                                                <i class="fa fa-reorder"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="col-md-3">
                                        <br>
                                        <label style="color:#34495e;">
                                            <b>
                                                Empresa responsable
                                            </b>
                                        </label>
                                        <label class="field select">
                                            <select name="respon_proceso" required>
                                                <option value="">Seleccione un
                                                    responsable</option>
                                                <option value="Berhlan de Colombia SAS">Berhlan
                                                    de Colombia SAS</option>
                                                <option value="Temporal">Temporal</option>
                                                <option value="Bpack SAS">Bpack</option>
                                                <option value="Limarba SAS">Limarba SAS</option>
                                            </select>

                                        </label>
                                    </div>

                                    <div class="col-md-3">
                                        <br>
                                        <label style="color:#34495e;">
                                            <b>
                                                Nivel Cargo
                                            </b>
                                        </label>
                                        <label class="field select">

                                            <select name="nivel_cargo" id ="nivel_cargo" required>
                                                <option value="">Seleccione un nivel
                                                </option>
                                                @foreach ($niveles_cargos as $nivel_cargo)
                                                    <option value="{{ $nivel_cargo->id_nivel_cargo }}">
                                                        {{ $nivel_cargo->nombre_nivel_cargo }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </label>
                                    </div>


                                    <div class="col-md-2">
                                        <br>
                                        <label style="color:#34495e;">
                                            <b>
                                                Fecha estimada de ingreso
                                            </b>
                                        </label>
                                        <label class="field select">
                                            <input class="gui-input" type="date" name="fecha_aprox_ingreso"
                                                id = 'fecha_estimada' readonly>
                                        </label>
                                    </div>


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
                                                        value="{{ $herramienta->id_herramienta }}"
                                                        {{ $soliRequiere->contains($herramienta->nombre_herramienta) ? 'checked' : '' }} name="requiere[]">
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
                                                <input id="si" type="radio" value="Si"
                                                    name="requiere_dotacion" {{ $DatosSolicitud[0]->requiere_dotacion == 'Si' ? 'checked' : '' }}>
                                                <label style="min-height: 0px" class="check-box" for="si"></label>

                                                <p class="text-dark" style="margin: 0px">
                                                    Si
                                                </p>
                                            </div>

                                            <div class="checkbox-wrapper-19 d-flex align-items-center" style="gap:14px">
                                                <input id="no" type="radio" value="No"
                                                    name="requiere_dotacion" {{ $DatosSolicitud[0]->requiere_dotacion == 'No' ? 'checked' : '' }}>
                                                <label style="min-height: 0px" class="check-box" for="no"></label>
                                                <p class="text-dark" style="margin: 0px">
                                                    No
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <br>
                                            <br>
                                            <div style="display: flex;justify-content:center; padding-top: 23px;">
                                                <button type="submit" class="btn btn-primary">Autorizar
                                                    solicitud</button>
                                            </div>
                                            <br>
                                        </div>
                                    </div>


                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<br>

<div class="panel m4">
    <!-- -------------- Message Body -------------- -->
    <div class="nano-content">
        <div class="table-responsive">
            <table id="message-table" class="table allcp-form theme-warning br-t">
                <thead>
                    <tr style="background-color:#34495e">
                        <th style="color:white; text-align:left;">
                            Rechazar
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <div class="allcp-form">
                                {!! Form::open([
                                    'action' => 'Requisiciones\SolRequisicionesPanelController@NominaRechazarDB',
                                    'class' => 'form',
                                    'id' => 'form-wizard',
                                    'onsubmit' => 'return confirm("¡Confirme el rechazo!")',
                                ]) !!}
                                {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label style="color: #34495e">
                                            <b>
                                                Observaciones
                                            </b>
                                        </label>
                                        <label class="field prepend-icon">
                                            {!! Form::textarea('observaciones', '', [
                                                'required',
                                                'id' => 'observaciones',
                                                'class' => 'gui-input',
                                                'style' => 'height: 60px;',
                                                'placeholder' => '* Observaciones.',
                                            ]) !!}
                                            <label for="username" class="field-icon">
                                                <i class="fa fa-reorder"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="col-md-4">
                                        <label style="color:#34495e;">
                                            <b>
                                                Motivo de rechazo
                                            </b>
                                        </label>
                                        <label class="field select">
                                            <label class="field select">
                                                <select name="motivo" id="motivo" required>
                                                    <option value="">
                                                        * Motivo de rechazo
                                                    </option>
                                                    <?php
                                                    $Motivos = PanelMotivos::where('estado', '1')->get();
                                                    ?>
                                                    @foreach ($Motivos as $DatMov)
                                                        <option value="<?= $DatMov->id_motivo ?>">
                                                            <?= $DatMov->descripcion ?>
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </label>
                                    </div>

                                    <div class="col-md-4">
                                        <br><br>
                                        {!! Form::submit('Rechazar solicitud', ['class' => 'btn btn-primary']) !!}
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



