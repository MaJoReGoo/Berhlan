<div class="modal fade" id="exportarExcelModal" tabindex="-1" aria-labelledby="exportarExcelModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exportar solicitudes en excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="chute chute-center allcp-form">

                    <form action="{{route('exportarSolicitudes')}}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-md-3" style="text-align: center;">
                                <label style="color:#34495e;">
                                    <b>
                                        Fecha solicitud inicial
                                    </b>
                                </label>
                                <label class="field">
                                    <input style="text-align: center;" type="date" class="gui-input"
                                        name="fecha_solicitud_inicial" id="fecha_solicitud_inicial" max="{{ date('Y-m-d') }}">
                                </label>
                            </div>
                            <div class="col-md-3" style="text-align: center;">
                                <label style="color:#282c31;">
                                    <b>
                                        Fecha solicitud final
                                    </b>
                                </label>
                                <label class="field">
                                    <input style="text-align: center;" type="date" class="gui-input"
                                        name="fecha_solicitud_final" id="fecha_solicitud_final" max="{{ date('Y-m-d') }}" disabled>
                                </label>
                            </div>

                            @if ($nivelPermiso[0] == 2)

                            <div class="col-md-3">
                                <label style="color:#34495e;">
                                    <b>
                                        Centro operacion:
                                    </b>
                                </label>
                                <label class="field select">
                                    <select class="gui-input" name="centro_operacion">
                                        <option value="">Seleccione una opción</option>
                                        @foreach ($centros_operacion as $centro_operacion)
                                        <option value="{{$centro_operacion->id_centro}}">{{$centro_operacion->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>

                            @endif

                            <div class="col-md-3">
                                <label style="color:#34495e;">
                                    <b>
                                        Estado:
                                    </b>
                                </label>
                                <label class="field select">
                                    <select class="gui-input" name="estado">
                                        <option value="">Seleccione una opción</option>
                                        <option value="3,5">En proceso</option>
                                        <option value="9">Aplazado</option>
                                        <option value="6">Cerrado</option>
                                        <option value="7,8">Cancelada</option>
                                        <option value="2,4">Rechazada</option>
                                        <option value="10">Finalizado</option></option>
                                    </select>
                                </label>
                            </div>

                            <div class="row">

                                <div class="col-md-4 ">
                                    <br>
                                    <br>
                                    <button class="btn btn-primary m8">Exportar</button>
                                </div>

                            </div>

                        </div>

                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
