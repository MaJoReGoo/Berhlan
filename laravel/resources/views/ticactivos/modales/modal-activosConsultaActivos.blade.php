  @php
      use App\Models\TicActivos\PanelActivos;
  @endphp


  <script>
      jQuery(document).ready(function($) {
          $("#activo_act").select2({
              closeOnSelect: true,
              width: '250px'
          });
      });
  </script>
  <!-- Modal -->
  <div class="modal fade" id="consultasxactivo" aria-labelledby="exampleModalLabel"data-backdrop="static"
      aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Consulta activos por usuario</h5>
              </div>
              <div class="modal-body">
                  <form method="GET" action="{{ route('usuario.activo') }}" enctype="multipart/form-data"
                      class="form-inline">
                      @csrf
                      <br>
                      <div class="form-group mx-sm-3 mb-2">
                          <label for="staticEmail2">
                              <font style="color: black">Seleccione un empleado:</font>
                          </label>
                          <label class="">
                              @php
                                  $DatosActivos = PanelActivos::getActivos();
                              @endphp
                              <select name="activo_act" id="activo_act" required>
                                  <option>
                                      <font style="color: black">Seleccione ----</font>
                                  </option>
                                  @foreach ($DatosActivos as $DatAct)
                                      <option value="{{ $DatAct->id_activo }}">
                                          {{ $DatAct->cod_interno . ' - ' . $DatAct->serial }}
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
