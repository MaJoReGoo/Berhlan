<br>
<form action="{{ route('herramientasAgregarDB') }}" method="POST" class="allcp-form">
    @csrf
    <div class="panel m4">
        <div class="panel-header p5 text-white text-center" style="background-color:#39405a">
            Crear activo
        </div>
        <div class="nano-content p20">
            <div class="container-fluid contenedor-activos d-flex flex-column" style="gap: 20px;">
                <div class="row d-flex align-items-center">
                    <div class="col-md-1 text-center">
                        <label class="form-label">#</label>
                        <p class="text-dark numero_activo">{{ $ActivosCant }}</p>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="nombre_herramienta[]"
                            placeholder="Ingresa la descripción del activo" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Area encargada</label>
                        <select class="gui-input" name="area_encargada[]" required>
                            <option value="">Seleccione una area</option>
                            <option value="10" >
                                TIC
                            </option>
                            <option value="17">
                                SOPORTE ADMINISTRATIVO
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Estado</label>
                        <select class="gui-input" name="estado_herramienta[]" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary agregar_activo">Agregar</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Crear activo</button>
                </div>
            </div>
        </div>
    </div>
    <br>
</form>

<br>

<form action="{{route('herramientasUpdateDB')}}" method="post">
    @csrf

    <a id="editar_activo" style="float: right; margin-bottom: 10px" class="btn btn-primary mb-2">
        <img style="height: 35px" width="35px" src="{{ $server }}/images/editar-info.png">
        </img>
    </a>
    <br>
    <br>

    <table id="table-activos" class="table table-bordered allcp-form" style="width: 100%">
        <thead>
            <tr style="background-color:#39405a; color: black">
                <th colspan="4" style="text-align:center">Activos</th>
            </tr>
            <tr style="background-color:#39405a; color: black">
                <th scope="col" style="text-align:center">#</th>
                <th scope="col" style="text-align:center">Descripción</th>
                <th scope="col" style="text-align:center">Area encargada</th>
                <th scope="col" style="text-align:center">Estado</th>
                <th scope="col" style="text-align:center">Area value</th>
                <th scope="col" style="text-align:center">Estado value</th>
            </tr>
        </thead>
        <tbody class="listado-activo">
            @foreach ($DatosActivos as $activo)
                <tr>
                    <td>
                        <p style="text-align: center; color:black">{{ $activo->id_herramienta }}</p>
                        <input type="text" name="id_herramienta[]" value="{{ $activo->id_herramienta }}" hidden>
                    </td>
                    <td>
                        <p style="text-align: center; color:black">{{ $activo->nombre_herramienta }}</p>
                    </td>
                    <td>
                        <select class="gui-input" name="area_encargada[]" required disabled>
                            <option value="10" {{ $activo->area_encargada == '10' ? 'selected' : '' }}>
                                TIC
                            </option>
                            <option value="17" {{ $activo->area_encargada == '17' ? 'selected' : '' }}>
                                SOPORTE ADMINISTRATIVO
                            </option>
                        </select>
                    </td>
                    <td>
                        <select class="gui-input" name="estado_herramienta[]" required disabled>
                            <option value="1" {{ $activo->estado == '1' ? 'selected' : '' }}>
                                Activo
                            </option>
                            <option value="2" {{ $activo->estado == '2' ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>
                    </td>
                    <td>
                        <p>{{$activo->area_name}}</p>
                    </td>
                    <td>
                        <p>{{$activo->name_estado}}</p>
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>

    <br>
    <div class="buttons" style="display: flex; justify-content: space-between;">
        <button class="btn btn-primary" type="submit" id="actualizar_activo" style="display: none";>Guardar Cambios</button>
    </div>
</form>

{{-- Plantila utilizada para agregar dinamicamente los motivos --}}

<template id="template-activo">
    <div class="row d-flex align-items-center">
        <div class="col-md-1 text-center">
            <label class="form-label">#</label>
            <p class="text-dark numero_activo"></p>
        </div>
        <div class="col-md-5">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" name="nombre_herramienta[]"
                placeholder="Ingresa la descripción del activo" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Area encargada</label>
            <select class="gui-input" name="area_encargada[]" required>
                <option value="">Seleccione una area</option>
                <option value="10" >
                    TIC
                </option>
                <option value="17">
                    SOPORTE ADMINISTRATIVO
                </option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Estado</label>
            <select class="gui-input" name="estado_herramienta[]" required>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
            </select>
        </div>


        <div class="col-md-1">
            <br>
            <a style="color:red; cursor:pointer;" id="eliminar_herramienta"><i class="fa-regular fa-trash-can fa-xl"></i></a>
        </div>
    </div>

</template>

{{-- --------------------------------- --}}
