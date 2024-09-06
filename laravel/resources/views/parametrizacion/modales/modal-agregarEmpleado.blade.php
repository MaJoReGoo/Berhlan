<!-- Modal -->
<div class="modal fade allcp-form" id="modalAgregarEmpleado" data-backdrop="static" data-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header text-white" style="background-color:#39405a">
                Ingrese la información del nuevo empleado
                <button type="button" class="close" style="color: white; font-size: 20px" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="allcp-form">
                    <form action="{{ route('agregarEmpleado') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="hidden" name="login" value="{{ $DatLog->login }}">

                        <div class="row">

                            <div class="col-md-4">
                                <label>Primer nombre</label>
                                <label class="field prepend-icon">
                                    <input type="text" name="primer_nombre" id="primer_nombre" class="gui-input"
                                        placeholder="* Primer nombre" required>
                                    <label for="username" class="field-icon">
                                        <i class="fa fa-file"></i>
                                    </label>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label>Segundo nombre</label>
                                <label class="field prepend-icon">
                                    <input type="text" name="ot_nombre" id="segundo_nombre" class="gui-input"
                                        placeholder="* Segundo nombre" required>
                                    <label for="username" class="field-icon">
                                        <i class="fa fa-file"></i>
                                    </label>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label>Primer apellido</label>
                                <label class="field prepend-icon">
                                    <input type="text" name="primer_apellido" id="primer_apellido" class="gui-input"
                                        placeholder="* Primer apellido" required>
                                    <label for="username" class="field-icon">
                                        <i class="fa fa-file"></i>
                                    </label>
                                </label>
                            </div>
                        </div>

                        <hr style="margin: 15px">

                        <div class="row">
                            <div class="col-md-4">
                                <label>Segundo apellido</label>
                                <label class="field prepend-icon">
                                    <input type="text" name="ot_apellido" id="segundo_apellido"
                                        class="gui-input" placeholder="Segundo apellido">
                                    <label for="username" class="field-icon">
                                        <i class="fa fa-file"></i>
                                    </label>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label>Identificación</label>
                                <label class="field prepend-icon">
                                    <input type="text" name="identificacion" id="identificacion" class="gui-input"
                                        placeholder="* Identificación" required>
                                    <label for="username" class="field-icon">
                                        <i class="fa fa-tag"></i>
                                    </label>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label>Teléfono</label>
                                <label class="field prepend-icon">
                                    <input type="number" name="numtel" id="numtel" class="gui-input"
                                        placeholder="* Teléfono" required>
                                    <label for="username" class="field-icon">
                                        <i class="fa fa-phone-square"></i>
                                    </label>
                                </label>
                            </div>
                        </div>

                        <hr style="margin: 15px">

                        <div class="row">
                            <div class="col-md-4">
                                <label>Email</label>
                                <label class="field prepend-icon">
                                    <input type="email" name="correo" id="correo" class="gui-input"
                                        placeholder="* Email" required>
                                    <label for="username" class="field-icon">
                                        <i class="fa fa-envelope"></i>
                                    </label>
                                </label>
                            </div>

                            <div class="col-md-8">
                                <label>
                                    Cargo
                                </label>
                                <label class="field select">
                                    <select name="cargo" id="cargo" required>
                                        <option value="">
                                            * Cargo
                                        </option>
                                        @foreach ($cargos as $cargo)
                                            <option value="{{ $cargo->id_cargo }}">
                                                {{ $cargo->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>

                        </div>

                        <hr style="margin: 15px">

                        <div class="row">
                            <div class="col-md-4">
                                <label>
                                    Centro de operación
                                </label>
                                <label class="field select">
                                    <select name="centro_op" id="centro_op" required>
                                        <option value="">
                                            * Centro de operación
                                        </option>
                                        @foreach ($centrosOp as $centroOp)
                                            <option value="{{ $centroOp->id_centro }}">
                                                {{ $centroOp->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label>
                                    Fecha de nacimiento
                                </label>
                                <label class="field select">
                                    <input type="date" name="fecha_nacimiento" class="gui-input">
                                </label>
                            </div>

                            <div class="col-md-2">
                                <br>
                                <br>
                                <button class="btn btn-primary" type="submit">Ingresar
                                    empleado</button>
                            </div>

                        </div>
                        <br>



                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
