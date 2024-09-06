<?php
$server = '/Berhlan/public';

use App\Models\Procesos\PanelPerfiles;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpleados;
?>



<div class="table-responsive">
    <table id="macro-proc-table" class="table allcp-form theme-warning br-t " style="width:100%">
        <thead>
            <tr style="background-color: #F8F8F8" data-id-doc_macro="{{ json_encode($DatosMacroProcesos->pluck('id_macroproceso')->toArray()) }}">
                <th align="center">

                </th>
                <th style="text-align: center">
                    Macro Proceso
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($DatosMacroProcesos as $datosMacroProcesos)
                <tr data-id-doc_macro="{{ $datosMacroProcesos->id_macroproceso }}">
                    <td align="center">

                    </td>

                    <td align="center" style="color:#{{ $datosMacroProcesos->fondo }};">

                        {{ $datosMacroProcesos->descripcion }}

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<form method="POST" action="{{ route('asociarDocMacroProceso') }}" enctype="multipart/form-data" class="form-inline">
    @csrf
    <br>
    <div style="display: flex;flex-direction: column;align-items: center;justify-content: center;gap: 17px;">
        <input type="hidden" id="documentosMacroProc" name="documentosMacroProc[]" value="">

        <label for="staticEmail2">
            <font style="color: black">Seleccione un Perfil:</font>
        </label>


        <select name="perfilMacroProc[]" multiple="multiple" style="width: 400px">
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
        <select name="usuarioMacroProc[]" multiple="multiple" style="width: 400px">
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
    let macro_proc_table = $("#macro-proc-table").DataTable({
        columnDefs: [{
            orderable: false,
            render: DataTable.render.select(),
            targets: 0
        }],
        paging: true,
    });
    let valuesMacroProc = [];

    $('#macro-proc-table').on('change', 'input[type="checkbox"]', function() {
        let checkbox = $(this);
        let isChecked = checkbox.prop('checked');
        let row = checkbox.closest('tr');
        let idDocumento = row.data('id-doc_macro');

        if (isChecked) {
            if (Array.isArray(idDocumento)) {
                valuesMacroProc.push(...idDocumento);
            } else {
                if (!valuesMacroProc.includes(idDocumento)) {
                    valuesMacroProc.push(idDocumento);
                }
            }
        } else {
            if (Array.isArray(idDocumento)) {
                valuesMacroProc = valuesMacroProc.filter(item => !idDocumento.includes(item));
            } else {
                let index = valuesMacroProc.indexOf(idDocumento);
                if (index !== -1) {
                    valuesMacroProc.splice(index, 1);
                }
            }
        }
        $('#documentosMacroProc').val(valuesMacroProc);
    });
</script>
