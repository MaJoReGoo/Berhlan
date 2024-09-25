

<form id="escaneoTransferenciaForm" method="POST" action="{{ route('escanear.fuid') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade " id="escaneoTransferencia" tabindex="-1" data-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Activos asignados</h5>
                </div>
                <div class="modal-body" style="padding-right: 0px">
                    <input type="hidden" id="id_fuid_h" name="id_fuid_h">
                    <div class="row" name="lista_articulos_sst" id="lista_articulos_sst">
                        <div class="d-flex justify-content-center">
                            <table id="tabla_registros" class="table " style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="text-align: center; width: 100px">Dependencia</th>
                                        <th style="text-align: center; width: 200px">Codigo Caja</th>
                                        <th style="text-align: center ; width: 20px">Asunto o titulo de la unidad
                                            documental</th>
                                        <th style="text-align: center;width: 180px;">Accion</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaRegistros">

                                </tbody>
                            </table>

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
</form>

<script>
    $(document).ready(function() {
        // Cargar los datos al abrir el modal
        $('#escaneoTransferenciaForm').on('shown.bs.modal', function(e) {
            if (!$.fn.DataTable.isDataTable('#tabla_registros')) {
                $('#tabla_registros').DataTable({
                    scrollY: 400,
                });
            }
            cargarDatos();
        });
    });



    function cargarDatos() {
        let idFuid = document.getElementById('id_fuid_h').value;
        fetch(
                `{{ env('API_BASE_URL') }}{{ $server }}/panel/archivo/transferenciad/escanear/` + idFuid
            )
            .then(response => response.json())
            .then(data => {
                var tablaDocumentos = document.getElementById('tablaRegistros');
                tablaDocumentos.innerHTML =
                    '';
                var i = 1; // Limpiar la tabla antes de agregar nuevos datos
                data.forEach(dato => {
                    if (dato.dependencia !== null && dato.codigo_caja !== null && dato
                        .titulo_unidad_documental !== null) {
                        tablaDocumentos.innerHTML += `
                                    <tr class="message-unread">
                                        <td style="text-align:center;">
                                            <input type="hidden" id="id_registro" name="id_registro[]" value="${dato.id_registro}" />
                                    <font color="#2A2F43" size="2">
                                        ${i}
                                    </font>
                                </td>
                                <td style="text-align:center;">
                                    <input type="hidden" id="dependencia" name="dependencia[]" value="${dato.dependencia}" />
                                    <font color="#2A2F43" size="2" >
                                        ${dato.dependencia}
                                    </font>
                                </td>
                                <td style="text-align:center;">
                                    <input type="hidden" id="codigo_caja" name="codigo_caja[]" value="${dato.codigo_caja}" />
                                    <font color="#2A2F43" size="2" >
                                        ${dato.codigo_caja}
                                        </font>
                                        </td>
                                <td style="text-align:center;">
                                            <input type="hidden" id="asunto" name="asunto[]" value="${dato.titulo_unidad_documental}" />
                                    <font color="#2A2F43" size="2" >
                                        ${dato.titulo_unidad_documental}
                                    </font>
                                </td>
                                <td style="text-align:center;">

                                <input type="file" name="file-3[]" id="file-${i}" class="inputfile inputfile-3" accept=".jpg, .png, .pdf" required/>
                                <label for="file-${i}" >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="iborrainputfile" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                                        <span class="iborrainputfile">Seleccionar archivo</span>
                                </label>


                                </td>
                                    </tr>
                                `;
                        i++;
                    }
                });
            })
            .catch(error => {
                console.error('Error al obtener los datos actualizados:', error);
            });
        $('#tabla_registros').DataTable().destroy();
        $('#tabla_registros').DataTable({
            scrollY: 400,
        });

    }

       document.getElementById('escaneoTransferenciaForm').addEventListener('submit', function(event) {
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
