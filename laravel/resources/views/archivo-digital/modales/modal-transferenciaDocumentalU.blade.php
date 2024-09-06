<form id="agregarTransferenciaForm" method="POST" action="{{ route('insert.transferencia') }}"
    enctype="multipart/form-data">
    @csrf
    <div class="modal fade " id="agregarTransferencia" tabindex="-1" data-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Transferencia documental</h5>
                </div>
                <div class="modal-body" style="padding-right: 0px">
                    <div class="row" name="lista_articulos_sst" id="lista_articulos_sst">
                        <div class="form-group">
                            <div class="col-md-4">
                                <Label style="font-size:12px">
                                    ENTIDAD REMITENTE:
                                </Label>
                                <input name="entidad_remitente" id="entidad_remitente" class=" form-control"
                                    type="text" required>
                                <Label style="font-size:12px">
                                    ENTIDAD PRODUCTORA:
                                </Label>
                                <input name="entidad_productora" id="entidad_productora" class=" form-control"
                                    type="text">

                            </div>
                            <div class="col-md-4">
                                <Label style="font-size:12px">
                                    UNIDAD ADMINISTRATIVA:
                                </Label>
                                <input name="unidad_administrativa" id="unidad_administrativa" class=" form-control"
                                    type="text">
                                <Label style="font-size:12px">
                                    OFICINA O DEPENDENCIA PRODUCTORA:
                                </Label>
                                <input name="dependencia_productora" id="dependencia_productora" class=" form-control"
                                    type="text" required>
                            </div>
                            <div class="col-md-4">
                                <Label style="font-size:12px">
                                    CÓDIGO DE LA OFICINA O DEPENDENCIA PRODUCTORA:
                                </Label>
                                <input name="codigo_depedencia" id="codigo_depedencia" class=" form-control"
                                    type="text">
                            </div>


                        </div>
                    </div>
                    <div class="row" name="lista_articulos_sst" id="lista_articulos_sst">
                        <div style="float: right; padding-right: 20px">
                            <a type="submit" type="button" id="addRow"class="btn btn-success"
                                style="margin-bottom: 3px">
                                <img src="{{ $server }}/images/plus.png">

                                </img>
                                <span class="nav-text">
                                    Agregar
                                </span>
                            </a>
                            <a type="submit" type="button" id="removeRow"class="btn btn-danger"
                                style="margin-bottom: 3px">
                                <img src="{{ $server }}/images/minus.png">
                                </img>
                                <span class="nav-text">
                                    Eliminar
                                </span>
                            </a>
                        </div>
                        <div class="d-flex justify-content-center">
                            <table id="tabla_registros" class="table " style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="text-align: center; width: 218px">Asunto o titulo de la unidad
                                            documental</th>
                                        <th style="text-align: center">Fecha Inicial </th>
                                        <th style="text-align: center">Fecha Final</th>
                                        <th style="text-align: center;width: 155px;">Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="row" name="lista_articulos_sst" id="lista_articulos_sst">
                        <div class="col-md-12">
                            <label for="observacion_general">Observaciones:</label>
                            <textarea class="form-control" rows="5" id="observacion_general" name="observacion_general"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnEnviar">Confirmar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="empleado_hidden" name="empleado_hidden" value="{{ $DatLog->empleado }}">
</form>

<script>
    $(document).ready(function() {
        let t = null;
        let rowCount = 1;
        // Cargar los datos al abrir el modal
        $('#agregarTransferencia').on('shown.bs.modal', function(e) {
            if (!t) {
                t = $("#tabla_registros").DataTable({
                    paging: false,
                    autowidth: true,
                    ordering: false,
                    info: false,
                    searching: false,
                    scrollY: 200,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    }
                });
            }
            $("#addRow").on("click", function() {
                rowCount = t.rows().count() + 1;
                var rowId = "row_" + rowCount;
                t.row
                    .add([
                        rowCount,
                        "<input type='text' name='asunto[]'style='width: 100%' id='asunto'class='form-control' required/>",
                        "<input type='date' name='fecha_inicial[]'style='width: 90%'   id='fecha_inicial_" +
                        rowId + "'class='form-control' required/>",
                        "<input type='date' name='fecha_final[]'style='width: 90%'  id='fecha_final_" +
                        rowId + "' class='form-control' required/>",
                        "<input type='text' name='observaciones[]'style='width: 100%' id='observaciones'class='form-control' />",
                    ])
                    .draw(false);
                var currentDate = new Date().toISOString().split('T')[0];

                // Añadir la fecha actual como valor máximo a los elementos input de tipo date
                var fechaInicialInput = document.getElementById('fecha_inicial_' + rowId);
                var fechaFinalInput = document.getElementById('fecha_final_' + rowId);

                fechaInicialInput.setAttribute('max', currentDate);
                fechaFinalInput.setAttribute('max', currentDate);
                rowCount++;
            });

            $("#addRow").click();

            $("#removeRow").on("click", function() {
                var rowCount = t.rows().count();

                if (rowCount > 1) {
                    t.rows(rowCount - 1)
                        .remove()
                        .draw(false);
                    rowCount--;
                }
            });

            $("#removeRow").click();

            $("#addRQS").click();
        });
        // Limpiar la tabla al cerrar el modal
        $('#agregarTransferencia').on('hidden.bs.modal', function(e) {
            if (t) {
                t.clear().draw();
                rowCount = 1;
            }
        });
    });

    document.getElementById('agregarTransferenciaForm').addEventListener('submit', function(event) {
        // Evitar que el formulario se envíe de forma predeterminada
        event.preventDefault();
        // Realizar la petición AJAX para enviar el formulario
        fetch(this.action, {
                method: this.method,
                body: new FormData(this),
            })
            .then(response => {
                // Si la respuesta es exitosa, recargar la página
                if (response.ok) {
                    Swal.fire({

                        icon: "success",
                        title: "Transferencia registrada correctamente!",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error al enviar el formulario:', error);
            });
    });
</script>

<script>
    // Obtén la fecha actual
    var fechaActual = new Date().toISOString().split('T')[0];

    // Establece la fecha actual como el valor mínimo permitido para el input de fecha
    document.getElementById('fecha_inicial').setAttribute('min', fechaActual);
</script>
