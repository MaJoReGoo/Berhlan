<form id="agregarInsercionForm" method="POST" action="{{ route('insert.insercionU') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade " id="agregarInsercion" tabindex="-1" data-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Activos asignados</h5>
                </div>
                <div class="modal-body" style="padding-right: 0px">

                    <div class="row" name="lista_articulos_sst" id="lista_articulos_sst">
                        <div style="float: right; padding-right: 20px">
                            <a type="submit" type="button" id="addRow"class="btn btn-success"
                                style="margin-bottom: 3px">
                                <img src="{{ asset ('/images/plus.png')}}">

                                </img>
                                <span class="nav-text">
                                    Agregar
                                </span>
                            </a>
                            <a type="submit" type="button" id="removeRow"class="btn btn-danger"
                                style="margin-bottom: 3px">
                                <img src="{{ asset ('/images/minus.png')}}">
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
                                        <th style="width: 10px">#</th>
                                        <th style="text-align: center; width: 200px">Descripcion nombre del documento o expediente</th>
                                        <th style="text-align: center ; width: 20px">N° Folios </th>
                                        <th style="text-align: center;width: 180px;">Observaciones</th>
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
    <input type="hidden" id="empleado_hidden" name="empleado_hidden" value="{{$DatLog->empleado}}">
</form>

<script>
    $(document).ready(function() {
        let t = null;
        let rowCount = 1;
        // Cargar los datos al abrir el modal
        $('#agregarInsercion').on('shown.bs.modal', function(e) {
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
                t.row
                    .add([
                        rowCount,
                        "<input type='text' name='descripcion[]'style='width: 100%' id='asunto'class='form-control' />",
                        "<input type='text' name='folios[]'style='width: 90%' id='fecha_inicial'class='form-control' />",
                        "<input type='text' name='observaciones[]'style='width: 100%' id='observaciones'class='form-control' />",
                    ])
                    .draw(false);
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
        $('#agregarInsercion').on('hidden.bs.modal', function(e) {
            if (t) {
                t.clear().draw();
                rowCount = 1;
            }
        });
    });

    document.getElementById('agregarInsercionForm').addEventListener('submit', function(event) {
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
                        title: "Inercion registrada correctamente!",
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
