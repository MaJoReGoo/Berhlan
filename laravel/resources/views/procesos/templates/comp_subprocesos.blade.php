<?php
$server = '/Berhlan/public';

use App\Models\Procesos\PanelPerfiles;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpleados;
?>



<div class="table-responsive">
    <table id="subproc-table" class="table allcp-form theme-warning br-t " style="width:100%">
        <thead>
            <tr style="background-color: #F8F8F8" data-id-doc_sub_proc="{{ json_encode($DatosSubProcesos->pluck('id_subproceso')->toArray()) }}">
                <th align="center">

                </th>
                <th style="text-align: center">
                    Sub Proceso
                </th>
                <th style="text-align: center">
                    Proceso
                </th>
                <th style="text-align: center">
                    Macro Proceso
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($DatosSubProcesos as $datosSubProcesos)
                <tr data-id-doc_sub_proc="{{ $datosSubProcesos->id_subproceso }}">
                    <td align="center">

                    </td>

                    <td align="center">
                        {{ $datosSubProcesos->subproceso }}
                    </td>

                    <td align="center">

                        {{ $datosSubProcesos->proceso }}

                    </td>

                    <td align="center" style="color:#{{ $datosSubProcesos->fondo }};">

                        {{ $datosSubProcesos->macroproceso }}

                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>
</div>




<form method="POST" action="{{ route('asociarDocSubProceso') }}" enctype="multipart/form-data" class="form-inline">
    @csrf
    <br>
    <div style="display: flex;flex-direction: column;align-items: center;justify-content: center;gap: 17px;">
        <input type="hidden" id="documentosSubProc" name="documentosSubProc[]" value="">

        <label for="staticEmail2">
            <font style="color: black">Seleccione un Perfil:</font>
        </label>


        <select name="perfilSubProc[]" multiple="multiple" style="width: 400px">
            <option value="">
                * Perfil
            </option>
            @foreach ($Perfiles as $DatPer)
                <option value="<?= $DatPer->id_perfil ?>">
                    <?= $DatPer->descripcion ?>
                </option>
            @endforeach
        </select>

        <label for="staticEmail2">
            <font style="color: black">Seleccione un usuario:</font>
        </label>
        <select name="usuarioSubProc[]" multiple="multiple" style="width: 400px">
            <option value="">
                * Usuario
            </option>
            @foreach ($Usuarios as $DatUsr)
                @php
                    $Empleado = PanelEmpleados::getEmpleado($DatUsr->empleado);
                    $Cargo = PanelCargos::getCargo($Empleado[0]->cargo);
                    $Area = PanelAreas::getArea($Cargo[0]->area);
                @endphp
                <option value="<?= $DatUsr->id_usuario ?>">
                    {{ $Empleado[0]->primer_nombre . ' ' . $Empleado[0]->primer_apellido }}
                    {{ ' - ' }}
                    {{ $Cargo[0]->descripcion }}
                </option>
            @endforeach
        </select>

        <label for="staticEmail2">
            <font style="color: black">Seleccione un tipo de documento:</font>
        </label>
        <select name="tipoSubProc[]" multiple="multiple" style="width: 400px">
            <option value="">
                * Tipo
            </option>
            @foreach ($TiposDocumentos as $tiposDocumentos)
                <option value="<?= $tiposDocumentos->id_tipo ?>">
                    {{ $tiposDocumentos->descripcion }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-success mb-2">
            <font style="color: black">Asociar perfil</font>
        </button>
    </div>
</form>
<br>


<script>
    let sub_proc_table = $("#subproc-table").DataTable({
        columnDefs: [{
            orderable: false,
            render: DataTable.render.select(),
            targets: 0
        }],
        paging: true,
    });

    let valuesSubProc = [];

    $('#subproc-table').on('change', 'input[type="checkbox"]', function() {
        let checkbox = $(this);
        let isChecked = checkbox.prop('checked');
        let row = checkbox.closest('tr');
        let idDocumento = row.data('id-doc_sub_proc');

        if (isChecked) {
            if (Array.isArray(idDocumento)) {
                valuesSubProc.push(...idDocumento);
            } else {
                if (!valuesSubProc.includes(idDocumento)) {
                    valuesSubProc.push(idDocumento);
                }
            }
        } else {
            if (Array.isArray(idDocumento)) {
                valuesSubProc = valuesSubProc.filter(item => !idDocumento.includes(item));
            } else {
                let index = valuesSubProc.indexOf(idDocumento);
                if (index !== -1) {
                    valuesSubProc.splice(index, 1);
                }
            }
        }
        $('#documentosSubProc').val(valuesSubProc);

    });
</script>
