<br>
<form action="{{ route('tpContratoAgregarDB') }}" class="allcp-form" method="POST">
    @csrf
    <div class="panel m4">
        <div class="panel-header p5 text-white text-center" style="background-color:#39405a">
            Crear tipo de contrato
        </div>
        <div class="nano-content p20">
            <div class="container-fluid contenedor-tipos-contrato d-flex flex-column" style="gap: 20px;">
                <div class="row d-flex align-items-center">
                    <div class="col-md-1 text-center">
                        <label class="form-label">#</label>
                        <p class="text-dark numero_tipo_contrato">{{ $TipoContratoCant }} </p>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="descripcion_tipo_contrato[]"
                            placeholder="Ingresa la descripción del tipo de contrato" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select class="gui-input" name="estado_tipo_contrato[]" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary agregar-contrato">Agregar</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Crear tipo de contrato</button>
                </div>
            </div>
        </div>
    </div>
    <br>
</form>

<br>



<a id="editar_tipo_contrato" style="float: right; margin-bottom: 10px" class="btn btn-primary mb-2">
    <img style="height: 35px" width="35px" src="{{ $server }}/images/editar-info.png">
    </img>
</a>
<br>
<br>
<form action="{{ route('tpContratoUpdateDB') }}" method="post">
    @csrf

    <table id="table-tipo-contrato" class="table table-bordered allcp-form" style="width: 100%">
        <thead>
            <tr style="background-color:#39405a; color: black">
                <th colspan="3" style="text-align:center">Tipos de contrato</th>
            </tr>
            <tr style="background-color:#39405a; color: black">
                <th scope="col" style="text-align:center">#</th>
                <th scope="col" style="text-align:center">Descripción</th>
                <th scope="col" style="text-align:center">Estado</th>
                <th scope="col" style="text-align:center">Estado value</th>
            </tr>
        </thead>
        <tbody class="listado-tipo-contrato">
            @foreach ($DatosContratos as $contrato)
                <tr>
                    <td>
                        <p style="text-align: center; color:black">{{ $contrato->id_tpcontrato }}</p>
                        <input type="text" name="id_tpcontrato[]" value="{{ $contrato->id_tpcontrato }}" hidden>
                    </td>
                    <td>
                        <p style="text-align: center; color:black">{{ $contrato->descripcion }}</p>
                    </td>
                    <td>
                        <select class="gui-input" name="estado_tpcontrato[]" required disabled>
                            <option value="1" {{ $contrato->estado == '1' ? 'selected' : '' }}>
                                Activo
                            </option>
                            <option value="2" {{ $contrato->estado == '2' ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>
                    </td>
                    <td>
                        <p>{{ $contrato->name_estado }}</p>
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>

    <br>
    <div class="buttons" style="display: flex; justify-content: space-between;">
        <button class="btn btn-primary" type="submit" id="actualizar_tipo_contrato" style="display: none";>Guardar
            Cambios</button>
    </div>
</form>


{{-- Plantila utilizada para agregar dinamicamente los motivos --}}

<template id="template-tipos-contrato">
    <br>
    <div class="row d-flex align-items-center">
        <div class="col-md-1 text-center">
            <label class="form-label">#</label>
            <p class="text-dark numero_tipo_contrato"></p>
        </div>
        <div class="col-md-7">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" name="descripcion_tipo_contrato[]"
                placeholder="Ingresa la descripción del tipo de contrato" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Estado</label>
            <select class="gui-input" name="estado_tipo_contrato[]" required>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
            </select>
        </div>

        <div class="col-md-1">
            <br>
            <a style="color:red; cursor:pointer;" id="eliminar-tipos-contrato"><i
                    class="fa-regular fa-trash-can fa-xl"></i></a>
        </div>
    </div>

</template>

{{-- --------------------------------- --}}
