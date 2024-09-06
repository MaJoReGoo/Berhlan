<?php

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;

?>

<style>
    .allcp-form .gui-input[disabled] {
        color: black;
    }

    .field-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="modal fade" id="actualizarModal" tabindex="-1" aria-labelledby="actualizarModal" aria-hidden="true"
    style="height: 100vh;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="z-index: 1250; position: sticky; color: #fffff;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table  class="table allcp-form theme-warning br-t">
                        <thead>
                            <tr style="background-color:#39405a">
                                <th>
                                    <font color="#fffff">
                                        Actualizar mis datos
                                    </font>

                                </th>
                            </tr>
                        </thead>
                </div>

                <tbody>
                    <tr>
                        <td>
                            <div class="allcp-form">
                                <form action="{{ route('updateDataEmpleadoDB') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="id_empleado"
                                            value="{{ $Empleado[0]->id_empleado }}">
                                        <div class="col-md-2">
                                            <img src="/Berhlan/public/archivos/Empleados/sinimagen.jpg"
                                                class="img-responsive mauto"
                                                style="width: 90px; border-radius:6px; border:1;" />
                                        </div>


                                        <div class="col-md-3">
                                            <label style="color: #4ECCDB">
                                                Primer nombre
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="text" id="primer_nombre" class="gui-input"
                                                    value="{{ $Empleado[0]->primer_nombre }}" readonly disabled>
                                                <label for="username" class="field-icon">
                                                    <i class="fa fa-file"></i>
                                                </label>
                                            </label>
                                        </div>

                                        <div class="col-md-3">
                                            <label style="color: #4ECCDB">
                                                Segundo nombre
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="text" id="ot_nombre" class="gui-input"
                                                    value="{{ $Empleado[0]->ot_nombre }}" readonly disabled>
                                                <label for="username" class="field-icon">
                                                    <i class="fa fa-file"></i>
                                                </label>
                                            </label>
                                        </div>

                                        <div class="col-md-3">
                                            <label style="color: #4ECCDB">
                                                Primer apellido
                                            </label>
                                            <label class="field prepend-icon">

                                                <input type="text" id="primer apellido" class="gui-input"
                                                    value="{{ $Empleado[0]->primer_apellido }}" readonly disabled>

                                                <label for="username" class="field-icon">
                                                    <i class="fa fa-files-o"></i>
                                                </label>
                                            </label>
                                        </div>

                                        <div class="col-md-3">
                                            <label style="color: #4ECCDB">
                                                Segundo apellido
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="text" id="ot_apellido" class="gui-input"
                                                    value="{{ $Empleado[0]->ot_apellido }}" readonly disabled>
                                                <label for="username" class="field-icon">
                                                    <i class="fa fa-files-o"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label style="color: #4ECCDB">
                                                Estado
                                            </label>
                                            <label class="field select">
                                                <select disabled>
                                                    <option value="0"
                                                        {{ $Empleado[0]->estado === '0' ? 'selected' : '' }}>
                                                        Inactivo</option>
                                                    <option value="1"
                                                        {{ $Empleado[0]->estado === '1' ? 'selected' : '' }}>Activo
                                                    </option>
                                                </select>
                                            </label>
                                        </div>

                                        <div class="col-md-3">
                                            <label style="color: #4ECCDB">
                                                Identificación
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="text" id="identificacion" class="gui-input"
                                                    value="{{ $Empleado[0]->identificacion }}" readonly disabled>

                                                <label for="username" class="field-icon">
                                                    <i class="fa fa-tag"></i>
                                                </label>
                                            </label>
                                        </div>

                                        <div class="col-md-3">
                                            <label style="color: #4ECCDB">
                                                Teléfono <font color = 'red'> * </font>
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="tel" id="numtel" name="numtel"
                                                    value="{{ $Empleado[0]->numtel }}" class="gui-input"
                                                    placeholder="Teléfono" required>
                                                <label for="username" class="field-icon">
                                                    <i class="fa fa-phone-square"></i>
                                                </label>
                                            </label>
                                        </div>

                                        <div class="col-md-4">
                                            <label style="color: #4ECCDB">
                                                Email <font color = 'red'> * </font>
                                            </label>
                                            <label class="field prepend-icon">
                                                <input type="email" name="correo" id="correo"
                                                    class="gui-input" placeholder="Email"
                                                    value="{{ $Empleado[0]->correo }}" required>

                                                <label for="username" class="field-icon">
                                                    <i class="fa fa-envelope"></i>
                                                </label>
                                            </label>
                                        </div>

                                        <?php
                                        $DatosCargo = PanelCargos::getCargo($Empleado[0]->cargo);
                                        $Area = PanelAreas::getArea($DatosCargo[0]->area);
                                        $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                        $Centro = PanelCentrosOp::getCentroOp($Empleado[0]->centro_op);
                                        ?>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <br>
                                                <label style="color: #4ECCDB">
                                                    Cargo
                                                </label>
                                                <label class="field select">
                                                    <input type="text" class="gui-input"
                                                        value="{{ $DatosCargo[0]->descripcion . ' - ' . $Area[0]->descripcion . ' - ' . $Empresa[0]->nombre }}"
                                                        readonly disabled>
                                                </label>
                                            </div>


                                            <div class="col-md-4">
                                                <br>
                                                <label style="color: #4ECCDB">
                                                    Centro de operación
                                                </label>
                                                <label class="field select">
                                                    <input type="text" value="{{ $Centro[0]->descripcion }}"
                                                        class="gui-input" readonly disabled>

                                                </label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <?php

                                            $fecha_nacimiento = explode('-', $Empleado[0]->fecha_nacimiento);

                                            ?>


                                            <div class="col-md-3">
                                                <p style="margin-bottom: 17px">
                                                    <font color = '#4ECCDB'>
                                                        Fecha nacimiento
                                                    </font>
                                                </p>

                                                <input type="text" class="gui-input"
                                                    value="{{ $fecha_nacimiento[2] }}" readonly disabled>

                                            </div>

                                            <div class="col-md-2">
                                                <br>
                                                <br>
                                                <input type="text" class="gui-input"
                                                    value="{{ \Carbon\Carbon::create(null, $fecha_nacimiento[1])->locale('es')->monthName }}"
                                                    readonly disabled>
                                            </div>

                                            <div class="col-md-2">
                                                <br>
                                                <br>

                                                <input type="text"  class="gui-input"
                                                    value="{{ $fecha_nacimiento[0] }}" readonly disabled>
                                                <label for="username" class="field-icon">


                                                </label>
                                            </div>

                                            <div class="col-md-3">
                                                <br><br>
                                                <button type="submit" class="btn btn-success">Actualizar
                                                    datos</button>
                                            </div>

                                        </div>
                                    </div>
                                </form>

                        </td>

                    </tr>
                    <tr>
                        <td>

                            {!! Form::open([
                                'action' => 'HomePanelController@PwdModificarDB',
                                'class' => 'form',
                                'id' => 'form-wizard',
                                'name' => 'frmcontraseña',
                            ]) !!}
                            <div class="section">
                                <div class="col-md-4">
                                    <label style="color: #4ECCDB">
                                        Contraseña actual <font color = 'red'> * </font>
                                    </label>
                                    <label class="field prepend-icon">
                                        <input type="password" class="form-control border-end-0" id="pwd1"
                                            name="pwd1" placeholder="* Contraseña actual" required>
                                        <label for="username" class="field-icon">
                                            <i class="fa fa-key"></i>
                                        </label>
                                    </label>
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #4ECCDB">
                                        Nueva contraseña <font color = 'red'> * </font>
                                    </label>
                                    <label class="field prepend-icon">
                                        <input type="password" class="form-control border-end-0" id="pwd2"
                                            name="pwd2" placeholder="* Nueva contraseña" required>
                                        <label for="username" class="field-icon">
                                            <i class="fa fa-key"></i>
                                        </label>
                                    </label>
                                </div>

                                <div class="col-md-4">
                                    <label style="color: #4ECCDB">
                                        Repite nueva contraseña <font color = 'red'> * </font>
                                    </label>
                                    <label class="field prepend-icon">
                                        <input type="password" class="form-control border-end-0" id="pwd3"
                                            name="pwd3" placeholder="* Repite nueva contraseña" required>
                                        <label for="username" class="field-icon">
                                            <i class="fa fa-key"></i>
                                        </label>
                                    </label>
                                </div>

                                <div class="col-md-4">
                                    <br><br>
                                    {!! Form::submit('Cambiar contraseña', ['class' => 'btn btn-success', 'onclick' => 'VALIDAR()']) !!}
                                    <br><br>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </td>
                    </tr>
                </tbody>
                </table>

            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>


<script language="javascript" type="text/javascript">
    function VALIDAR() {
        frm = document.forms["frmcontraseña"];
        var id1 = frm.pwd1.value;
        var id2 = frm.pwd2.value;
        var id3 = frm.pwd3.value;

        if (id1 == "") {
            alert("Debe ingresar la contraseña actual.");
            frm.pwd1.focus();
            return false;
        }

        if (id2.length < 6) {
            alert("La nueva contraseña debe tener mínimo 6 caracteres.");
            frm.pwd2.focus();
            return false;
        }

        if (id2 != id3) {
            alert("La nueva contraseña no coincide.");
            frm.pwd3.focus();
            return false;
        }
        document.frmenvio.submit();
    }
</script>
