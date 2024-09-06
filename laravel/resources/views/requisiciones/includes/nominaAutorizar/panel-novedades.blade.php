<div class="panel-header p5 text-white text-center d-flex justify-content-center align-items-center" style="background-color:#39405a; gap:20px;">
    <a class="text-white cursor: pointer;" data-toggle="collapse" data-target="#novedades"
        aria-expanded="false" aria-controls="novedades"> Novedades
    </a>
    <i class="fa-solid fa-caret-down" data-toggle="collapse" data-target="#novedades"
    aria-expanded="false" aria-controls="novedades" style="cursor: pointer; font-size: 20px;"></i>
</div>

<div class="panel-body collapse" id="novedades">
    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('enviarNovedad') }}" method="post">
                @csrf
                <div class="allcp-form">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Añadir Novedad</h4>
                            <input type="hidden" name="id_solicitud" value="{{ $DatosSolicitud[0]->num_solicitud }}">

                            <br>
                            <label style="color: #34495e">
                                <b>
                                    Descripcion de la novedad
                                </b>
                            </label>
                            <label class="field prepend-icon">
                                <textarea name="descripcion_novedad" id="condiciones" class="gui-input" cols="30" rows="10"></textarea>

                                <label for="username" class="field-icon">
                                    <i class="fa fa-reorder"></i>
                                </label>
                            </label>
                        </div>
                        <div class="col-md-2 ">
                            <br>
                            <br>
                            <br>
                            <br>
                            <button class="btn btn-primary ">Enviar</button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="nano-content p20">
                <table class="table table-hover" id="novedades-solicitudes" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="text-dark text-center" colspan="2">Novedades de la
                                solicitud</th>
                        </tr>
                        <tr>
                            <th class="text-dark text-center">Fecha</th>
                            <th class="text-dark text-center">Descripción</th>
                        </tr>
                    </thead>
                    <tbody style="color: black; text-align: center;">
                        @foreach ($novedades as $novedad)
                            <tr>
                                <td style="word-wrap: break-word;">
                                    {{ \Carbon\Carbon::parse($novedad->fecha_novedad)->format('d-m-Y') }}
                                </td>
                                <td style="word-wrap: break-word;">
                                    {{ $novedad->descripcion_novedad }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
