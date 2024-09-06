<script>
    jQuery(document).ready(function($) {
        $("#dependencia").select2({
            closeOnSelect: true,
            width: '250px'
        });
    });
</script>
<!-- Modal -->
<form id="ExportinventarioArchivo" action="{{ route('exportar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="inventarioArchivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group mx-sm-3 mb-2">
                        <label>
                            <font style="color: black">Seleccione una dependencia:</font>
                        </label>
                        <label>

                            <select name="dependencia" id="dependencia" required>
                                <option>
                                    <font style="color: black">Seleccione ----</font>
                                </option>
                                @foreach ($DatosDepedencia as $DatIte)
                                    <option value="{{ $DatIte->dependencia }}">
                                        {{ $DatIte->dependencia }}
                                    </option>
                                @endforeach

                            </select>


                        </label>

                        <button type="submit" class="btn btn-success" id="btnEnviar">Confirmar</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('ExportinventarioArchivo').addEventListener('submit', function(event) {
        // Evitar que el formulario se envíe de forma predeterminada
        //event.preventDefault();
        fetch(this.action, {
                method: this.method,
                body: new FormData(this),
            })
            .then(response => {

                // Si la respuesta es exitosa, recargar la página
                if (response.ok) {
                    Swal.fire({

                        icon: "success",
                        title: "Se descargo Correctamente!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {

                        window.location.reload();
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error al enviar el formulario:', error);
            });
    });
</script>
