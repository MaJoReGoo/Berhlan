<br>
<form action="{{ route('tpContratoAgregarDB') }}" class="allcp-form" method="POST">
    @csrf
    <div class="panel m4">
        <div class="panel-header p5 text-white text-center" style="background-color:#39405a">
            Crear motivo
        </div>
        <div class="nano-content p20">
            <div class="container-fluid contenedor-motivos d-flex flex-column" style="gap: 20px">
                <div class="row d-flex align-items-center">
                    <div class="col-md-1 text-center">
                        <label class="form-label">#</label>
                        <p class="text-dark numero_motivo">{{ $MotivosCant }}</p>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="descripcion_motivo[]"
                            placeholder="Ingresa la descripción del motivo de rechazo" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select class="gui-input" name="estado_motivo[]" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary agregar-motivo">Agregar</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Crear motivo rechazo</button>
                </div>
            </div>
        </div>
    </div>
    <br>
</form>

<br>




<a id="editar_motivo" style="float: right; margin: 13px 13px;" class="btn btn-primary mb-2">
    <img style="height: 35px" width="35px" src="{{ $server }}/images/editar-info.png">
    </img>
</a>
<br>
<br>
<form action="{{ route('motivosUpdateDB') }}" method="POST">
    @csrf
    <table id="table-motivos" class="table table-bordered allcp-form" style="width: 100%">
        <thead>
            <tr style="background-color:#39405a; color:black">
                <th colspan="4" style="text-align:center">Motivos de rechazo</th>
            </tr>
            <tr style="background-color:#39405a; color: black">
                <th scope="col" style="text-align:center">#</th>
                <th scope="col" style="text-align:center">Descripción</th>
                <th scope="col" style="text-align:center">Estado</th>
                <th scope="col" style="text-align:center">Estado value</th>
            </tr>
        </thead>
        <tbody class="listado-motivos">
            @foreach ($DatosMotivos as $motivo)
                <tr>
                    <td>
                        <p style="text-align: center; color:black">{{ $motivo->id_motivo }}</p>
                        <input type="text" name="id_motivo[]" value="{{ $motivo->id_motivo }}" hidden>
                    </td>
                    <td>
                        <p style="color: black; text-align: center"> {{ $motivo->descripcion }}</p>
                    </td>
                    <td>
                        <select class="gui-input" name="estado_motivo[]" required disabled>
                            <option value="1" {{ $motivo->estado == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="2" {{ $motivo->estado == '2' ? 'selected' : '' }}>Inactivo</option>
                        </select>

                    </td>
                    <td>
                        <p>{{ $motivo->name_estado }}</p>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <br>
    <div class="buttons" style="display: flex; justify-content: space-between;">
        <button class="btn btn-primary" type="submit" id="actualizar_motivo" style="display: none;">Guardar
            Cambios</button>
    </div>
</form>

    


    {{-- Plantila utilizada para agregar dinamicamente los motivos --}}

    <template id="template-motivos">
        <div class="row d-flex align-items-center">
            <div class="col-md-1 text-center">
                <label class="form-label">#</label>
                <p class="text-dark numero_motivo"></p>
            </div>
            <div class="col-md-7">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" name="descripcion_motivo[]"
                    placeholder="Ingresa la descripción del motivo de rechazo" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select class="gui-input" name="estado_motivo[]" required>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                </select>
            </div>

            <div class="col-md-1">
                <br>
                <a style="color:red; cursor:pointer;" id="eliminar_motivo"><i
                        class="fa-regular fa-trash-can fa-xl"></i></a>
            </div>
        </div>

    </template>

    {{-- --------------------------------- --}}
