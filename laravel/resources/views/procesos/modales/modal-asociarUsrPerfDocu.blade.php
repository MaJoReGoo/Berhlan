  @php
      use App\Models\Procesos\PanelPerfiles;
      use App\Models\Parametrizacion\PanelEmpleados;
      use App\Models\Parametrizacion\PanelCargos;
      use App\Models\Parametrizacion\PanelAreas;
      use App\Models\Parametrizacion\PanelUsuarios;
  @endphp

  <script>
      jQuery(document).ready(function($) {
          $("#perfil").select2({
              closeOnSelect: true,
              width: '250px'
          });
      });
      jQuery(document).ready(function($) {
          $("#usuario").select2({
              closeOnSelect: true,
              width: '250px'
          });
      });


      //   $("#perfil").select2({
      //       closeOnSelect: true,
      //       width: '250px'
      //   });


      //   $("#usuario").select2({
      //       closeOnSelect: true,
      //       width: '250px'
      //   });
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
                  <form method="POST" action="{{ route('documento.perfil') }}" enctype="multipart/form-data"
                      class="form-inline">
                      @csrf
                      <br>
                      <div class="form-group mx-sm-3 mb-2">
                          <input type="hidden" id="documentos" name="documentos[]" value="">
                      </div>
                      <div class="form-group mx-sm-3 mb-2">
                          <label for="staticEmail2">
                              <font style="color: black">Seleccione un Perfil:</font>
                          </label>
                          <label class="">
                              @php
                                  $Perfiles = PanelPerfiles::getPerfiles();
                              @endphp
                              <select id="perfil" name="perfil[]" multiple="multiple">
                                  <option value="">
                                      * Perfil
                                  </option>
                                  @foreach ($Perfiles as $DatPer)
                                      <option value="<?= $DatPer->id_perfil ?>">
                                          <?= $DatPer->descripcion ?>
                                      </option>
                                  @endforeach
                              </select>
                          </label>
                      </div>
                      <div class="form-group mx-sm-3 mb-2">
                          <label for="staticEmail2">
                              <font style="color: black">Seleccione un usuario:</font>
                          </label>
                          <label class="">
                              @php
                                  $Usuarios = PanelUsuarios::getUsuariosActivos();
                              @endphp
                              <select id="usuario" name="usuario[]" multiple="multiple">
                                  <option value="">
                                      * Usuario
                                  </option>
                                  @foreach ($Usuarios as $DatUsr)
                                      @php
                                          $Empleado = PanelEmpleados::getEmpleado($DatUsr->empleado);
                                          $Cargo = PanelCargos::getCargo($Empleado[0]->cargo);
                                          $Area = PanelAreas::getArea($Cargo[0]->area);
                                      @endphp
                                      <option value="<?= $DatUsr->id_usuario ?>">
                                          {{ $Empleado[0]->primer_nombre . ' ' . $Empleado[0]->primer_apellido }}
                                          {{ ' - ' }}
                                          {{ $Cargo[0]->descripcion }}
                                      </option>
                                  @endforeach
                              </select>
                          </label>
                      </div>

                      <div class="modal-footer">
                          <button type="submit" class="btn btn-success mb-2" onclick="Asociarperfilusuario()">
                              <font style="color: black">Asociar perfil</font>
                          </button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
