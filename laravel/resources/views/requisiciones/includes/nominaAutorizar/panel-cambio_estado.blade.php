@if ($DatosSolicitud[0]->estado != 1)
    <div class="row allcp-form p30">
        <form id="form-actualizar" action="{{ route('actualizarEstadoSoli') }}" method="post">
            @csrf
            <input type="hidden" name="solicitud" value="{{ $DatosSolicitud[0]->num_solicitud }}">
            <div class="col-md-3">
                <br>
                <label style="color:#34495e;">
                    <b>
                        Estado
                    </b>
                </label>
                <label class="field select">
                    <select name="estado" id="cambio_estado" {{ $DatosSolicitud[0]->estado == 6 ? 'disabled' : '' }}
                        {{ $DatosSolicitud[0]->estado == '7' || $DatosSolicitud[0]->estado == '8' ? 'disabled' : '' }}
                        required>
                        <option value="3"
                            {{ $DatosSolicitud[0]->estado == '3' || $DatosSolicitud[0]->estado == '5' ? 'selected ' : '' }}>
                            Activo</option>
                        <option value="9" {{ $DatosSolicitud[0]->estado == '9' ? 'selected ' : '' }}>
                            Aplazado</option>
                        <option value="7"
                            {{ $DatosSolicitud[0]->estado == '7' || $DatosSolicitud[0]->estado == '8' ? 'selected ' : '' }}>
                            Cancelado</option>
                        <option value="10" {{ $DatosSolicitud[0]->estado == '10' ? 'selected ' : '' }}>
                            Finalizado</option>
                        <option value="6" {{ $DatosSolicitud[0]->estado == '6' ? 'selected ' : '' }}>
                            Cerrado</option>
                    </select>
                </label>
            </div>

            <div class="col-md-3 notificar" hidden>
                <br>
                <label style="color: #34495e; display:flex; justify-content:center;">
                    <b>
                        Notificar al solicitante
                    </b>
                </label>

                <div class="check box">
                    <div class="flipswitch">
                        <input id="notificar_solicitante" value="Si" class="flipswitch-cb"
                            name="notificar_solicitante[]" type="checkbox">
                        <label style="min-height: 0px;width: 75px;" for="notificar_solicitante"
                            class="flipswitch-label">
                            <div class="flipswitch-inner">
                            </div>
                            <div class="flipswitch-switch">
                            </div>
                        </label>
                    </div>
                </div>

                


            </div>


            <div class="col-md-2 nueva_fecha" hidden>
                <br>
                <label style="color:#34495e;">
                    <b>
                        Fecha estimada de ingreso
                    </b>
                </label>
                <label class="field select">
                    <input class="gui-input" type="date" id="nueva_fecha_aprox" name="nueva_fecha_aprox" readonly>
                </label>
            </div>
            <input type="hidden" name="dias_aplazado">
            <input type="hidden" name="dias_proceso">
            <input type="hidden" name="dias_proceso_real">

            <br><br><br>

            @if ($DatosSolicitud[0]->estado != 6 && $DatosSolicitud[0]->estado != 7 && $DatosSolicitud[0]->estado != 8)
                <div class="col-md-3 btn_cambio_estado">
                    <button class="btn btn-primary" type="submit">Cambiar
                        Estado</button>
                </div>
            @endif

        </form>
    </div>
@endif

<section id="section-examenes" class="allcp-form" hidden>
    <form action="{{ route('crearExamenesIngresos') }}" method="POST">
        @csrf
        <div class="panel-header p5 text-white text-center" style="background-color:#39405a">
            Solicitar exámenes médicos
        </div>
        <br>
        <div class="container-fluid contenedor-examenes">
            <input type="hidden" name="fk_num_solicitud" value="{{ $DatosSolicitud[0]->num_solicitud }}">
            <div class="examen">
                <div class="row d-flex align-items-center">
                    <div class="col-md-1">
                        <label class="form-label">Consecutivo</label>
                        <p class="text-dark text-center consecutivo">
                            {{ $DatosSolicitud[0]->num_solicitud }}-{{ $consecutivo }}
                        </p>
                        <input type="hidden" name="consecutivo[]"
                            value="{{ $DatosSolicitud[0]->num_solicitud }}-{{ $consecutivo }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" name="nombre_soli_ingreso[]"
                            placeholder="Ingresa el nombre completo" required>
                    </div>

                    <div class="col-md-4 text-center">
                        <label class="form-label">Género</label>
                        <div class="mydict">
                            <div>
                                <label>
                                    <input type="radio" name="genero0" value="Femenino" required>
                                    <span class="gender">Femenino</span>
                                </label>
                                <label>
                                    <input type="radio" name="genero0" value="Masculino" required>
                                    <span class="gender">Masculino</span>
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <label class="form-label">Cédula de Ciudadanía</label>
                        <input type="text" class="form-control" name="cedula_soli_ingreso[]"
                            placeholder="Ingresa la cédula" required>
                    </div>



                </div>
                <br>
                <div class="row d-flex align-items-center">
                    <div class="col-md-3">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" name="telefono_soli_ingreso[]"
                            placeholder="Ingresa el número de teléfono" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="correo_soli_ingreso[]"
                            placeholder="Ingresa el correo electrónico" required>
                    </div>

                    <div class="col-md-6">
                        <label style="color: #34495e; display:flex; justify-content:center; ">
                            <b>
                                ¿Solicitar exámen médico? (Marque una opción)
                            </b>
                        </label>
                        <div class="box">
                            <label class="radio-button">
                                <input type="radio" class="input-examen" name="examen_medico0" value="Si"
                                    required>
                                <span class="radio"></span>
                                Sí
                            </label>
                            <label class="radio-button">
                                <input type="radio" class="input-examen" name="examen_medico0" value="No"
                                    required>
                                <span class="radio"></span>
                                No
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-2">
                <button type="button" class="btn btn-primary agregar-examen">Agregar</button>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Solicitar
                    Examen</button>
            </div>
        </div>
    </form>
</section>


{{-- Plantila utilizada para agregar dinamicamente los examenes --}}

<template id="template-examenes">
    <div class="examen">
        <br>
        <br>
        <div class="row d-flex align-items-center">
            <div class="col-md-1">
                <label class="form-label">Consecutivo</label>
                <p class="text-dark text-center consecutivo"></p>
                <input type="hidden" name="consecutivo[]">
            </div>
            <div class="col-md-6">
                <label class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" name="nombre_soli_ingreso[]"
                    placeholder="Ingresa el nombre completo" required>
            </div>

            <div class="col-md-4 text-center">
                <label class="form-label">Género</label>
                <div class="mydict">
                    <div>
                        <label>
                            <input type="radio" class="input-genero" value="Femenino" required>
                            <span class="gender">Femenino</span>
                        </label>
                        <label>
                            <input type="radio" class="input-genero" value="Masculino" required>
                            <span class="gender">Masculino</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">Cédula de Ciudadanía</label>
                <input type="text" class="form-control" name="cedula_soli_ingreso[]"
                    placeholder="Ingresa la cédula" required>
            </div>



        </div>
        <br>
        <div class="row d-flex align-items-center">
            <div class="col-md-3">
                <label class="form-label">Teléfono</label>
                <input type="tel" class="form-control" name="telefono_soli_ingreso[]"
                    placeholder="Ingresa el número de teléfono" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="correo_soli_ingreso[]"
                    placeholder="Ingresa el correo electrónico" required>
            </div>

            <div class="col-md-6">
                <label style="color: #34495e; display:flex; justify-content:center; ">
                    <b>
                        ¿Solicitar exámen médico? (Marque una opción)
                    </b>
                </label>
                <div class="box">
                    <label class="radio-button">
                        <input type="radio" value="Si" class="input-examen" required>
                        <span class="radio"></span>
                        Sí
                    </label>
                    <label class="radio-button">
                        <input type="radio" value="No" class="input-examen" required>
                        <span class="radio"></span>
                        No
                    </label>
                </div>
            </div>
            <div class="col-md-1">
                <br>
                <a style="color:red; cursor:pointer;" id="eliminar_examen"><i
                        class="fa-regular fa-trash-can fa-xl"></i></a>
            </div>

        </div>
    </div>
</template>

{{-- --------------------------------- --}}
