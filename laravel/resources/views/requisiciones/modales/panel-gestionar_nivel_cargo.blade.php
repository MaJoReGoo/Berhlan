<!-- Modal -->
<div class="modal fade" id="nivelCargoModal" aria-labelledby="nivelCargoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gestionar los niveles de los cargos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalCargosNiveles">
                <div class="chute chute-center">

                    <a id="editar_nivel_cargo" style="float: right; margin-bottom: 10px" class="btn btn-primary mb-2">
                        <img style="height: 35px" width="35px" src="{{ $server }}/images/editar-info.png">
                        </img>
                    </a>

                    <form action="{{ route('gestionarNivelesCargos') }}" method="post" id="nivelCargoForm">
                        @csrf

                        <table class="table table-bordered allcp-form">
                            <thead>
                                <tr style="background-color:#39405a; color: #FFFFFF">
                                    <th scope="col" style="text-align:center">Nivel cargo</th>
                                    <th scope="col" style="text-align:center">Dias esperados</th>
                                    <th scope="col" style="text-align:center">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="listado-cargos">
                                @foreach ($niveles_cargos as $nivel_cargo)
                                    <tr>
                                        <td>
                                            <input class="with_input" type="text" name="nombre_nivel_cargo[]"
                                                value="{{ $nivel_cargo->nombre_nivel_cargo }}" required disabled>
                                        </td>
                                        <td>
                                            <input class="with_input" type="number" name="dias_nivel_cargo[]"
                                                value="{{ $nivel_cargo->dias_nivel_cargo }}" required disabled>
                                        </td>
                                        <td>
                                            <select class="gui-input" name="estado_nivel_cargo[]" required disabled>
                                                <option value="1"
                                                    {{ $nivel_cargo->estado_nivel_cargo == '1' ? 'selected' : '' }}>
                                                    Activo
                                                </option>
                                                <option value="2"
                                                    {{ $nivel_cargo->estado_nivel_cargo == '2' ? 'selected' : '' }}>
                                                    Inactivo
                                                </option>
                                            </select>

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <br>
                        <div class="buttons" style="display: flex; justify-content: space-between;">
                            <a class="btn btn-primary agregar" id="agregar_nivel_cargo"
                                style="display: none";>Agregar</a>
                            <button class="btn btn-primary" type="submit" id="actualizar_nivel_cargo"
                                style="display: none";>Guardar Cambios</button>
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

<script type="module" src="{{asset('js/requisiciones/modales/panel-gestionar_nivel_cargo.js')}}"></script>
