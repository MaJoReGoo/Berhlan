  @php
      use App\Models\Parametrizacion\PanelEmpleados;
  @endphp

  <script>
      jQuery(document).ready(function($) {
          $("#empleado_act").select2({
              closeOnSelect: true,
              width: '250px'
          });
      });
  </script>
  <!-- Modal -->
  <div class="modal fade" id="consultasxusuario" aria-labelledby="exampleModalLabel"data-backdrop="static"
      aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Consulta activos por usuario</h5>
              </div>
              <div class="modal-body">
                  <form method="GET" action="{{ route('activo.usuario') }}" enctype="multipart/form-data"
                      class="form-inline">
                      @csrf
                      <br>
                      <div class="form-group mx-sm-3 mb-2">
                          <label for="staticEmail2">
                              <font style="color: black">Seleccione un empleado:</font>
                          </label>
                          <label class="">
                              @php
                                  $DatosEmpleados = PanelEmpleados::EmpleadosT();
                              @endphp
                              <select name="empleado_act" id="empleado_act" required>
                                  <option>
                                      <font style="color: black">Seleccione ----</font>
                                  </option>
                                  @foreach ($DatosEmpleados as $DatIte)
                                      <option value="{{ $DatIte->id_empleado }}">
                                          {{ $DatIte->identificacion . ' - ' . $DatIte->primer_nombre . ' ' . $DatIte->ot_nombre . ' ' . $DatIte->primer_apellido }}
                                      </option>
                                  @endforeach

                              </select>


                          </label>

                      </div>

                      <button type="submit" class="btn btn-success mb-2">
                          <font style="color: black">Buscar</font>
                      </button>

                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
