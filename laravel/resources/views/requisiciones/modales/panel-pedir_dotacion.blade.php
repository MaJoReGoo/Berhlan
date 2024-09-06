<div class="modal fade allcp-form" id="modalPedirDotacion" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modalPedirDotacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-ingreso"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 20px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-3 text-center">
                        <label style="color: #34495e;">
                            <b>Nombre</b>
                        </label>
                        <p class="text-dark" id="nombre_completo"></p>
                    </div>

                    <div class="col-md-3 text-center">
                        <label style="color: #34495e;">
                            <b>Genero</b>
                        </label>
                        <p class="text-dark" id="genero_soli_ingreso"></p>
                    </div>

                    <div class="col-md-3 text-center">
                        <label style="color: #34495e;">
                            <b>Cedula</b>
                        </label>
                        <p class="text-dark" id="cedula_soli_ingreso"></p>
                    </div>
                    <div class="col-md-3 text-center">
                        <label style="color: #34495e;">
                            <b>Correo</b>
                        </label>
                        <p class="text-dark" id="correo_soli_ingreso"></p>
                    </div>
                </div>
                <hr style="margin: 20px 0px">
                <div class="row d-flex justify-content-center">

                    <div class="col-md-3 text-center">
                        <label style="color: #34495e;">
                            <b>Telefono</b>
                        </label>
                        <p class="text-dark" id="telefono_soli_ingreso"></p>
                    </div>
                    <div class="col-md-3 text-center">
                        <label style="color: #34495e;">
                            <b>Estado</b>
                        </label>
                        <p class="text-dark" id="estado_soli_ingreso"></p>
                    </div>
                </div>
                <hr style="margin: 20px 0px">

                <form action="{{route('pedirDotaciones')}}" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="id_soli_ingreso" id="id_soli_ingreso">
                        <input type="hidden" name="num_solicitud" id="num_solicitud">

                        <section id="section-dotaciones" style="max-height: 350px; overflow-x: hidden">
                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-md-4">
                                    <label>
                                        <b class="text-center">
                                            Dotacion
                                        </b>
                                    </label>
                                    <label class="field select">
                                        <select name="dotacion[]" required>
                                            <option value="">Seleccione una dotación
                                            </option>
                                            @foreach ($dotaciones as $dotacion)
                                                <option value="{{ $dotacion->id_dotacion }}">
                                                    {{ $dotacion->nombre_dotacion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label>
                                        <b class="text-center">
                                            Talla
                                        </b>
                                    </label>
                                    <label class="field select">
                                        <select name="talla[]" disabled required>
                                            <option value="">Seleccione una talla
                                            </option>
                                        </select>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label>
                                        <b class="text-center">
                                            Cantidad
                                        </b>
                                    </label>
                                    <label class="field select">
                                        <input type="number" name="cantidad[]" placeholder="Ingrese la cantidad" required>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <br>
                                    <br>
                                </div>
                            </div>

                            <div class="contenedor-solicitud-dotaciones">
                            </div>
                            <br>
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-11 d-flex" style="justify-content: space-evenly;">
                                    <button type="button" class="btn btn-primary agregar-soli-dotacion">Agregar</button>
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </section>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


{{-- Plantila utilizada para agregar dinamicamente las dotaciones de la solicitud --}}

<template id="template-solicitud-dotaciones">
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-4">
            <label>
                <b class="text-center">
                    Dotacion
                </b>
            </label>
            <label class="field select">
                <select name="dotacion[]" required>
                    <option value="">Seleccione una dotación
                    </option>
                    @foreach ($dotaciones as $dotacion)
                        <option value="{{ $dotacion->id_dotacion }}">
                            {{ $dotacion->nombre_dotacion }}
                        </option>
                    @endforeach
                </select>
            </label>
        </div>
        <div class="col-md-3">
            <label>
                <b class="text-center">
                    Talla
                </b>
            </label>
            <label class="field select">
                <select name="talla[]" disabled required>
                    <option value="">Seleccione una talla
                    </option>
                </select>
            </label>
        </div>
        <div class="col-md-2">
            <label>
                <b class="text-center">
                    Cantidad
                </b>
            </label>
            <label class="field select">
                <input type="number" name="cantidad[]" placeholder="Ingrese la cantidad" required>
            </label>
        </div>
        <div class="col-md-2 d-flex justify-content-center">
           
            <a style="color:red; cursor:pointer; padding-top: 33px" id="eliminar_dotacion">
            
                <i class="fa-regular fa-trash-can fa-xl"></i>
            </a>
        </div>
    </div>

</template>

{{-- --------------------------------- --}}
