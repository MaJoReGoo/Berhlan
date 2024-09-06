<br>
<form action="{{ route('tallasAgregarDB') }}" method="POST" class="allcp-form">
    @csrf
    <div class="panel m4">
        <div class="panel-header p5 text-white text-center" style="background-color:#39405a">
            Crear tallas de las dotaciones
        </div>
        <div class="nano-content p20">
            <div class="container-fluid contenedor-tallas d-flex flex-column" style="gap: 20px;">
                <div class="row d-flex align-items-center">
                    <div class="col-md-1 text-center">
                        <label class="form-label">#</label>
                        <p class="text-dark numero_activo">{{ $tallasCant }}</p>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="nombre_talla_dotacion[]"
                            placeholder="Ingresa la descripción de la talla" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo de dotacion </label>
                        <select class="gui-input" name="id_tipo_dotacion[]" required>
                            <option value="">Seleccione un tipo de dotacion</option>
                            @foreach ($tiposDotaciones as $tipoDotacion)
                                <option value="{{ $tipoDotacion->id_tipo_dotacion }}">
                                    {{ $tipoDotacion->nombre_tipo_dotacion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Estado</label>
                        <select class="gui-input" name="estado_talla_dotacion[]" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary agregar_talla">Agregar</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Crear talla</button>
                </div>
            </div>
        </div>
    </div>
    <br>
</form>

<br>



<a id="editar_talla" style="float: right; margin-bottom: 10px" class="btn btn-primary mb-2">
    <img style="height: 35px" width="35px" src="{{ $server }}/images/editar-info.png">
    </img>
</a>
<br>
<br>
<form action="{{ route('tallasUpdateDB') }}" method="post">
    @csrf
    <table id="table-tallas" class="table table-bordered allcp-form" style="width: 100%">
        <thead>
            <tr style="background-color:#39405a; color: black">
                <th colspan="4" style="text-align:center">Tallas de las dotaciones</th>
            </tr>
            <tr style="background-color:#39405a; color: black">
                <th scope="col" style="text-align:center">#</th>
                <th scope="col" style="text-align:center">Descripción</th>
                <th scope="col" style="text-align:center">Tipo de dotacion</th>
                <th scope="col" style="text-align:center">Estado</th>
                <th scope="col" style="text-align:center">Tipo value</th>
                <th scope="col" style="text-align:center">Estado value</th>
            </tr>
        </thead>
        <tbody class="listado-tallas">
            @foreach ($datosTallas as $talla)
                <tr>
                    <td>
                        <p style="text-align: center; color:black">{{ $talla->id_talla_dotacion }}</p>
                        <input type="text" name="id_talla_dotacion[]" value="{{ $talla->id_talla_dotacion }}" hidden>
                    </td>
                    <td>
                        <p style="text-align: center; color:black">{{ $talla->nombre_talla_dotacion }}</p>

                    </td>
                    <td>
                        <select class="gui-input" name="tipo_dotacion[]" required disabled>
                            @foreach ($tiposDotaciones as $tipoDotacion)
                                <option value="{{ $tipoDotacion->id_tipo_dotacion }}"
                                    {{ $talla->fk_id_tipo_dotacion == $tipoDotacion->id_tipo_dotacion ? 'selected' : '' }}>
                                    {{ $tipoDotacion->nombre_tipo_dotacion }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="gui-input" name="estado_talla_dotacion[]" required disabled>
                            <option value="1" {{ $talla->estado_talla_dotacion == '1' ? 'selected' : '' }}>
                                Activo
                            </option>
                            <option value="2" {{ $talla->estado_talla_dotacion == '2' ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>
                    </td>
                    <td>
                        @foreach ($tiposDotaciones as $tipoDotacion)
                            <p>{{ $talla->fk_id_tipo_dotacion == $tipoDotacion->id_tipo_dotacion ? $tipoDotacion->nombre_tipo_dotacion : '' }}
                            </p>
                        @endforeach
                    </td>
                    <td>
                        <p>{{ $talla->name_estado }}</p>
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>

    <br>
    <div class="buttons" style="display: flex; justify-content: space-between;">
        <button class="btn btn-primary" type="submit" id="actualizar_talla" style="display: none";>Guardar
            Cambios</button>
    </div>
</form>

{{-- Plantila utilizada para agregar dinamicamente los tallas de dotaciones --}}

<template id="template-talla">
    <div class="row d-flex align-items-center">
        <div class="col-md-1 text-center">
            <label class="form-label">#</label>
            <p class="text-dark numero_talla"></p>
        </div>
        <div class="col-md-5">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" name="nombre_talla_dotacion[]"
                placeholder="Ingresa la descripción de la talla" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tipo de dotacion </label>
            <select class="gui-input" name="id_tipo_dotacion[]" required>
                <option value="">Seleccione un tipo de dotacion</option>
                @foreach ($tiposDotaciones as $tipoDotacion)
                    <option value="{{ $tipoDotacion->id_tipo_dotacion }}">
                        {{ $tipoDotacion->nombre_tipo_dotacion }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Estado</label>
            <select class="gui-input" name="estado_talla_dotacion[]" required>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
            </select>
        </div>

        <div class="col-md-1">
            <br>
            <a style="color:red; cursor:pointer;" id="eliminar_talla"><i
                    class="fa-regular fa-trash-can fa-xl"></i></a>
        </div>
    </div>

</template>

{{-- --------------------------------- --}}
