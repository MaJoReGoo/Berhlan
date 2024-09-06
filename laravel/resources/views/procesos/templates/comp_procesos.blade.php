<?php
$server = '/Berhlan/public';

use App\Models\Procesos\PanelPerfiles;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpleados;
?>



<div class="table-responsive">
    <table id="proc-table" class="table allcp-form theme-warning br-t " style="width:100%">
        <thead>
            <tr style="background-color: #F8F8F8" data-id-doc_proc = "{{ json_encode($DatosProcesos->pluck('id_proceso')->toArray()) }}">
                <th align="center">

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
            @foreach ($DatosProcesos as $datosProcesos)
                <tr data-id-doc_proc="{{ $datosProcesos->id_proceso }}">
                    <td align="center">

                    </td>

                    <td align="center">

                        {{ $datosProcesos->proceso }}

                    </td>

                    <td align="center" style="color:#{{ $datosProcesos->fondo }};">

                        {{ $datosProcesos->macroproceso }}

                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>
</div>




<form method="POST" action="{{ route('asociarDocProceso') }}" enctype="multipart/form-data" class="form-inline">
    @csrf
    <br>
    <div style="display: flex;flex-direction: column;align-items: center;justify-content: center;gap: 17px;">
        <input type="hidden" id="documentosProc" name="documentosProc[]" value="">

        <label for="staticEmail2">
            <font style="color: black">Seleccione un Perfil:</font>
        </label>


        <select name="perfilProc[]" multiple="multiple" style="width: 400px">
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
        <select name="usuarioProc[]" multiple="multiple" style="width: 400px">
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

        <button type="submit" class="btn btn-success mb-2">
            <font style="color: black">Asociar perfil</font>
        </button>
    </div>
</form>
<br>


<script>
    let proc_table = $("#proc-table").DataTable({
        columnDefs: [{
            orderable: false,
            render: DataTable.render.select(),
            targets: 0
        }],
        paging: true,
    });
    let valuesProc = [];

    $('#proc-table').on('change', 'input[type="checkbox"]', function() {
        let checkbox = $(this);
        let isChecked = checkbox.prop('checked');
        let row = checkbox.closest('tr');
        let idDocumento = row.data('id-doc_proc');

        if (isChecked) {
            if (Array.isArray(idDocumento)) {
                valuesProc.push(...idDocumento);
            } else {
                if (!valuesProc.includes(idDocumento)) {
                    valuesProc.push(idDocumento);
                }
            }
        } else {
            if (Array.isArray(idDocumento)) {
                valuesProc = valuesProc.filter(item => !idDocumento.includes(item));
            } else {
                let index = valuesProc.indexOf(idDocumento);
                if (index !== -1) {
                    valuesProc.splice(index, 1);
                }
            }
        }
        $('#documentosProc').val(valuesProc);

    });
</script>
