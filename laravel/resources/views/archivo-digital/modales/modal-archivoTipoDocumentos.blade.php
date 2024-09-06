<style>
    .input-style {
        padding: 10px;
        border: 2px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        color: #555;
        outline: none;
    }

    .input-style:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
<form id="insertarTipoDocumentosForm" method="POST" action="{{ route('insert.tipodocumento') }}"
    enctype="multipart/form-data">
    @csrf
    <div class="modal fade " id="creacionTipoDoc" tabindex="-1" data-backdrop="static" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tipo de documentos</h5>
                </div>
                <div class="modal-body">
                    <div>
                        <Label>
                            <font>
                                <h4>Tipo de documento:</h4>
                            </font>
                        </Label>
                        <input name="descripcion_td" id="descripcion_td" class="input-style" type="text" required>
                        <button id="btn" type="submit" class="btn btn-success mb-2">
                            <img src="{{ $server }}/images/add-task.png">
                            Crear tipo Documento
                            </img>
                        </button>
                    </div>
                    <br>
                    <br>
                    <div>
                        <table id="message-table2"
                            class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                            <thead style="color: #1e5799">
                                <tr style="background-color: #b2b2db">
                                    <th style="text-align:center;">
                                        #
                                    </th>
                                    <th style="text-align:center;">
                                        Tipo Documento
                                    </th>
                                    <th style="text-align:center;">
                                        Estado
                                    </th>
                                    <th style="text-align:center;">
                                        Accion
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="tablaTipoDocumentos">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="empleado_hidden" name="empleado_hidden">
</form>

<script>
    $(document).ready(function() {
        // Cargar los datos al abrir el modal
        $('#creacionTipoDoc').on('shown.bs.modal', function(e) {
            $('#message-table2').DataTable({
                scrollY: 400,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
            cargarDatos();
        });
    });

    function cargarDatos() {
        fetch(
                `{{ env('API_BASE_URL') }}/Berhlan/public/panel/archivo/historias/tipodocumentos/`
            )
            .then(response => response.json())
            .then(data => {
                var tablaDocumentos = document.getElementById('tablaTipoDocumentos');
                tablaDocumentos.innerHTML =
                    '';
                var i = 1; // Limpiar la tabla antes de agregar nuevos datos
                data.DatosTipoDoc.forEach(dato => {
                    tablaDocumentos.innerHTML += `
                                    <tr class="message-unread">
                                        <td style="text-align:center;">
                                    <font color="#2A2F43" size="2">
                                        ${i}
                                    </font>
                                </td>
                                <td style="text-align:center;">
                                    <font color="#2A2F43" size="2">
                                        ${dato.descripcion}
                                    </font>
                                </td>
                                <td style="text-align:center;">
                                    <font color="#2A2F43" size="2">
                                        ${dato.estado == 1 ? 'Activo' : 'Inactivo'}
                                    </font>
                                </td>
                                <td style="text-align:center;">
                                        ${dato.estado == 1 ?
                                         `<button id="btn_inactivar_${dato.id_tipodocumento}" data-id="${dato.id_tipodocumento}" type="button" class="btn btn-danger mb-2" onclick="Inactivar(this)" >Inactivar</button>` :
                                         `<button style="width: 104px;" id="btn_activar_${dato.id_tipodocumento}" data-id="${dato.id_tipodocumento}" type="button" class="btn btn-success mb-2" onclick="Activar(this)">Activar</button>`
                                        }
                                </td>
                                    </tr>
                                `;
                    i++;
                });
            })
            .catch(error => {
                console.error('Error al obtener los datos actualizados:', error);
            });
    }

    document.getElementById('insertarTipoDocumentosForm').addEventListener('submit', function(
        event) {
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
                        title: "Se creo el tipo de documento correctamente!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Realizar una nueva petición AJAX para obtener los datos actualizados y actualizar la tabla
                    fetch('{{ route('actualizar.tablaTipoDocumentos') }}')
                        .then(response => response.json())
                        .then(data => {

                            // Actualizar la tabla en la modal con los nuevos datos
                            const tablaTipoDocumentos = document.getElementById(
                                'tablaTipoDocumentos');
                            const descripcion_td = document.getElementById(
                                'descripcion_td');
                            tablaTipoDocumentos.innerHTML =
                                '';
                            descripcion_td.value =
                                ''; // Limpiar la tabla antes de agregar los nuevos datos
                            var i = 1;
                            data.DatosTipoDoc.forEach(dato => {

                                const newRow = tablaTipoDocumentos
                                    .insertRow();
                                newRow.innerHTML = `
                                <td style="text-align:center;">
                                    <font color="#2A2F43" size="2">
                                        ${i}
                                    </font>
                                </td>
                                <td style="text-align:center;">
                                    <font color="#2A2F43" size="2">
                                        ${dato.descripcion}
                                    </font>
                                </td>
                                <td style="text-align:center;">
                                    <font color="#2A2F43" size="2">
                                        ${dato.estado == 1 ? 'Activo' : 'Inactivo'}
                                    </font>
                                </td>
                                <td style="text-align:center;">
                                        ${dato.estado == 1 ?
                                         `<button id="btn_inactivar_${dato.id_tipodocumento}" data-id="${dato.id_tipodocumento}" type="button" class="btn btn-danger mb-2" onclick="Inactivar(this)" >Inactivar</button>` :
                                         `<button style=" width: 104px;" id="btn_activar_${dato.id_tipodocumento}" data-id="${dato.id_tipodocumento}" type="button" class="btn btn-success mb-2" onclick="Activar(this)">Activar</button>`
                                        }
                                </td>
                            `;
                                i++;
                            });
                        })
                        .catch(error => {
                            console.error(
                                'Error al obtener los datos actualizados:',
                                error);
                        });

                }
            })
            .catch(error => {
                console.error('Error al enviar el formulario:', error);
            });
    });

    function Inactivar(button) {
        var id = $(button).data("id");
        var token = $('meta[name="csrf-token"]').attr("content");

        console.log(id);
        var estado = 0;
        $.ajax({
            url: "{{ env('API_BASE_URL') }}/Berhlan/public/panel/archivo/historias/tipodocumento/estado",
            type: "POST",
            data: {
                id: id,
                estado: estado,
                _token: token,
            },
            success: function(response) {
                cargarDatos(); // Actualizar el estado en la interfaz de usuario si es necesario
            },
            error: function(xhr) {
                // Manejar errores
            },
        });
    }

    function Activar(button) {
        var id = $(button).data("id");
        var token = $('meta[name="csrf-token"]').attr("content");
        console.log(id);
        var estado = 1;
        $.ajax({
            url: "{{ env('API_BASE_URL') }}/Berhlan/public/panel/archivo/historias/tipodocumento/estado",
            type: "POST",
            data: {
                id: id,
                estado: estado,
                _token: token,
            },
            success: function(response) {
                cargarDatos(); // Actualizar el estado en la interfaz de usuario si es necesario
            },
            error: function(xhr) {
                // Manejar errores
            },
        });

    }
</script>
