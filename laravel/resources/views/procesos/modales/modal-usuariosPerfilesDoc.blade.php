@php
    use App\Models\Procesos\PanelPerfiles;
    use App\Models\Parametrizacion\PanelEmpleados;
@endphp
<div class="modal fade" id="usuarioAsignados" aria-labelledby="exampleModalLabel"data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Consulta activos por usuario</h5>
            </div>
            <div class="modal-body">
                <br>
                <input type="hidden" id="documentos" name="documentos[]" value="">
                <div class="mx-sm-3 mb-2">
                    <label for="staticEmail2">
                        <font style="color: black">Seleccione un Perfil:</font>
                    </label>
                    <label class="">

                        @php
                            $DatosPerfiles = PanelPerfiles::getDocumentosPerfil($DatDoc->id_documento);
                        @endphp

                        @foreach ($DatosPerfiles as $DatPer)
                            (<?= $DatPer->descripcion ?>)
                        @endforeach

                    </label>
                </div>
                <div class="mx-sm-3 mb-2">
                    <label for="staticEmail2">
                        <font style="color: black">Seleccione un usuario:</font>
                    </label>
                    <label class="">
                        @php
                        $DatosUsuario = PanelPerfiles::getDocumentosUsuario($DatDoc->id_documento);
                    @endphp

                        @foreach ($DatosUsuario as $DatUsr)
                            @php
                                $Empleado = PanelEmpleados::getEmpleado($DatUsr->empleado);
                            @endphp

                            (<?= $Empleado[0]->primer_nombre . ' ' . $Empleado[0]->primer_apellido ?>)
                        @endforeach
                    </label>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</div>
