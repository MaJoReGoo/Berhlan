<div class="modal fade" id="elementos{{ $solicitudes->num_solicitud }}Modal" tabindex="-1"
    aria-labelledby="elementos{{ $solicitudes->num_solicitud }}Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Elementos de la solicitud {{ $solicitudes->num_solicitud }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3" style="text-align: center;">
                        <label style="color: #34495e">
                            <b>
                                Num Solicitud
                            </b>
                        </label>
                        <div>
                            {{ $solicitudes->num_solicitud }}
                        </div>
                    </div>

                    <div class="col-md-5" style="text-align: center;">
                        <label style="color: #34495e">
                            <b>
                                Cargo
                            </b>
                        </label>
                        <div>
                            {{ $solicitudes->cargo }}
                        </div>
                    </div>

                    <div class="col-md-4" style="text-align: center;">
                        <label style="color: #34495e">
                            <b>
                                Centro de operación
                            </b>
                        </label>
                        <div>
                            {{ $solicitudes->centro_operacion }}
                        </div>
                    </div>
                </div>
                <br>

                @if (isset($solicitudes->nombre_persona))
                    <div class="row">
                        <div class="col-md-3" style="text-align: center;">
                            <label style="color: #34495e">
                                <b>
                                    Persona
                                </b>
                            </label>
                            <div>
                                {{ $solicitudes->nombre_persona }}
                            </div>
                        </div>

                        <div class="col-md-5" style="text-align: center;">
                            <label style="color: #34495e">
                                <b>
                                    N° Cedula
                                </b>
                            </label>
                            <div>
                                {{ $solicitudes->numero_cedula }}
                            </div>
                        </div>

                    </div>
                @endif
                <br>
                <div class="row">
                    <br>
                    <div class="col-md-12">

                        <label style="color: #34495e">
                            <b>
                                Requiere
                            </b>
                        </label>

                        <div style="display: flex; flex-wrap: wrap;">


                            @if ($DatLog->area == 'TIC')
                                @foreach ($herramientas as $herramienta)
                                    <div class="check" style="padding-right: 30px; padding-bottom: 30px">
                                        <div class="flipswitch">
                                            <input id="{{ 'fs' . $herramienta->id_herramienta }}"
                                                value="{{ $herramienta->id_herramienta }}"
                                                {{ $solicitudes->elemTicRequiere->contains($herramienta->nombre_herramienta) ? 'checked' : '' }}
                                                class="flipswitch-cb" name="requiere[]" type="checkbox" disabled>
                                            <label style="min-height: 0px;width: 75px;"
                                                for="{{ 'fs' . $herramienta->id_herramienta }}"
                                                class="flipswitch-label">
                                                <div class="flipswitch-inner">
                                                </div>
                                                <div class="flipswitch-switch">
                                                </div>
                                            </label>
                                        </div>
                                        &nbsp;&nbsp;
                                        <b
                                            style="color: black; width: 137px;">{{ $herramienta->nombre_herramienta }}</b>
                                    </div>
                                @endforeach
                            @endif


                            @if ($DatLog->area == 'SOPORTE ADMINISTRATIVO')
                                @foreach ($herramientas as $herramienta)
                                    <div class="check" style="padding-right: 30px; padding-bottom: 30px">
                                        <div class="flipswitch">
                                            <input id="{{ 'fs' . $herramienta->id_herramienta }}"
                                                value="{{ $herramienta->id_herramienta }}"
                                                {{ $solicitudes->elemSopRequiere->contains($herramienta->nombre_herramienta) ? 'checked' : '' }}
                                                class="flipswitch-cb" name="requiere[]" type="checkbox" disabled>
                                            <label style="min-height: 0px;width: 75px;"
                                                for="{{ 'fs' . $herramienta->id_herramienta }}"
                                                class="flipswitch-label">
                                                <div class="flipswitch-inner">
                                                </div>
                                                <div class="flipswitch-switch">
                                                </div>
                                            </label>
                                        </div>
                                        &nbsp;&nbsp;
                                        <b
                                            style="color: black; width: 137px;">{{ $herramienta->nombre_herramienta }}</b>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @if ($DatLog->area == 'SOPORTE ADMINISTRATIVO')
                <div class="row">
                    <div class="col-md-12">
                        <label style="color: #34495e; display:flex; justify-content:center">
                            <b>Requiere dotacion:</b>
                        </label>

                        <div class="box">
                            @foreach ($dotaciones as $dotacion)
                                <label class="material-checkbox">
                                    <input type="checkbox" name="dotacion[]" value="{{ $dotacion->id_dotacion }}"
                                        {{ $solicitudes->dotSopRequiere->contains($dotacion->nombre_dotacion) ? 'checked' : '' }}
                                        disabled>
                                    <span class="checkmark"></span>
                                    {{ $dotacion->nombre_dotacion }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary cerrar_solicitud" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
