<link rel="stylesheet" type="text/css" href="{{ asset('css/archivo-digital/modales/modal-insercionDocuEscaneoD.blade.css') }}">


<form id="escaneoInsercionForm" method="POST" action="{{ route('escanear.fuid') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade " id="escaneoInsercion" tabindex="-1" data-backdrop="static" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Activos asignados</h5>
                </div>
                <div class="modal-body" style="padding-right: 0px">
                    <input type="hidden" id="id_solicitud_h" name="id_solicitud_h">
                    <div class="row" name="lista_articulos_sst" id="lista_articulos_sst">
                        <div class="d-flex justify-content-center">
                            <table id="tabla_inserciones" class="table " style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="">Dependencia</th>
                                        <th style="text-align: center; ">Codigo Caja</th>
                                        <th style="text-align: center ; ">Asunto o titulo de la unidad
                                            documental</th>
                                        <th style="text-align: center;">Descripcion</th>
                                        <th style="text-align: center;">Accion</th>
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
        $('#escaneoInsercionForm').on('shown.bs.modal', function(e) {
            if (!$.fn.DataTable.isDataTable('#tabla_inserciones')) {
                $('#tabla_inserciones').DataTable({
                    /* scrollY: 400, */
                    searching: false,
                });
            }
            // Inicializar select2 para los campos select

            cargarDatos();
        });
    });



    function cargarDatos() {
        let idSolicitud = document.getElementById('id_solicitud_h').value;
        fetch(
                `{{ env('API_BASE_URL') }}{{ asset ('/panel/archivo/inserciond/escaner/')}}` + idSolicitud
            )
            .then(response => response.json())
            .then(data => {
                var tablaDocumentos = document.getElementById('tablaRegistros');
                tablaDocumentos.innerHTML =
                    '';
                console.log(data);
                var i = 1; // Limpiar la tabla antes de agregar nuevos datos
                data.DatosSolIns.forEach(solIns => {


                    console.log(solIns.id_insercion);

                    tablaDocumentos.innerHTML += `
                            <tr class="message-unread">
                                <td>
                                            <input type="hidden" id="id_insercion" name="id_insercion[]" value="${solIns.id_insercion}" />
                                    <font color="#2A2F43" size="2">
                                        ${i}
                                    </font>
                                </td>
                                <td>

                                    <select class="form-select select2-init" id="dependencia" name="dependencia[]" style="width: 180px; border: 1px solid #ced4da;padding:0.375rem 0.75rem;font-size: 1.5rem;line-height: 1.5;border-radius: 0.25rem;height: 30px; border: 1px solid black;" >
                                        <option value="">
                                            * Selecione la dependencia...
                                        </option>
                                        @foreach ($Datosfuids as $DatFuid)
                                        <option> {{ $DatFuid->dependencia }}</option>
                                        @endforeach
                                        </select>

                                </td>
                                <td>
                                    <select class="form-select select2-init" id="codigo_caja" name="codigo_caja[]" style="width: 180px; border: 1px solid #ced4da;padding:0.375rem 0.75rem;font-size: 1.5rem;line-height: 1.5;border-radius: 0.25rem;height: 30px; border: 1px solid black;" >
                                        <option value="">
                                            * Selecione codigo de caja...
                                        </option>
                                        @foreach ($Datosfuids as $DatFuid)
                                        <option> {{ $DatFuid->codigo_caja }}</option>
                                        @endforeach
                                        </select>
                                </td>
                                <td>
                                    <select class="form-select select2-init" id="asunto" name="asunto[]" style="width: 180px; border: 1px solid #ced4da;padding:0.375rem 0.75rem;font-size: 1.5rem;line-height: 1.5;border-radius: 0.25rem;height: 30px; border: 1px solid black;" >
                                        <option value="">
                                            * Selecione el titulo...
                                        </option>
                                        @foreach ($Datosfuids as $DatFuid)
                                        <option> {{ $DatFuid->titulo_unidad_documental }}</option>
                                        @endforeach
                                        </select>
                                </td>
                                <td >
                                    <input type="hidden" id="id_insercion" name="id_insercion[]" value="${solIns.descripcion}" />
                                    <font color="#2A2F43" size="2">
                                        ${solIns.descripcion}
                                    </font>
                                </td>
                                <td >

                                </td>
                            </tr>`;
                    i++;

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

    document.getElementById('escaneoInsercionForm').addEventListener('submit', function(event) {
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
                        title: "Insercion registrada correctamente!",
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
