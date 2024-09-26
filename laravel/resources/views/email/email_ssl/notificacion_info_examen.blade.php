@extends('email.layouts.app')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/email/email_ssl/notificacion_info_examen.blade.css')}}">

    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
        <tr>
            <td valign="top" width="100%">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%">
                            <table border="0" cellpadding="0" cellspacing="0" class="table_scale"
                                style="background-color: #253061; background-size:cover" width="600" background="">
                                <tr>
                                    <td align="center" width="100%">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                            <tr>
                                                <td class="spacer" width="30"></td>
                                                <td width="540">
                                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                        class="full"
                                                        style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"
                                                        width="540">
                                                        <tr>
                                                            <td height="40">
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="center"
                                                                style="padding-bottom: 5px; font-weight: 300; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
                                                                <span><strong>Notificación de cambio estado examen
                                                                        médico</strong></span><br/><br />
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="center"
                                                                style="padding-bottom: 5px; font-weight: 300; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">

                                                                <span style="font-size: 16px; color:#ffc400">
                                                                    Solicitud (#{{ $consec_examen }})</span><br/><br />
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="center"
                                                                style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                                <span>El estado de la solicitud del examen médico ha sido
                                                                    cambiada: <br />
                                                                    <span style="color: #ffc400;">

                                                                        @php
                                                                            if (
                                                                                $estado_examen == 1 &&
                                                                                $asistencia == null
                                                                            ) {
                                                                                echo 'Pendiente';
                                                                            } elseif (
                                                                                $estado_examen == 2 &&
                                                                                $asistencia == null
                                                                            ) {
                                                                                echo 'Agendado';
                                                                            } elseif (
                                                                                $estado_examen == 2 &&
                                                                                $asistencia == 1
                                                                            ) {
                                                                                echo 'Reprogramado';
                                                                            } elseif ($estado_examen == 3) {
                                                                                echo 'Pendiente de resultado';
                                                                            } elseif ($estado_examen == 4) {
                                                                                echo 'Cerrado (No Apto)';
                                                                            } elseif ($estado_examen == 5) {
                                                                                echo 'Cerrado (Apto)';
                                                                            }
                                                                        @endphp


                                                                    </span>
                                                                </span><br/><br />
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td align="center" class="center"
                                                                style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                                <span style="color: #ffc400;">Nombre de la
                                                                    persona:</span><br />
                                                                <span>{{ $nombre_soli_ingreso }}</span><br/><br />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="center"
                                                                style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                                <span style="color: #ffc400;">Cedula:</span><br />
                                                                <span>{{ $cedula_soli_ingreso }}</span><br/><br />
                                                            </td>
                                                        </tr>
                                                        @if (isset($agendar))
                                                        <tr>
                                                            <td align="center" class="center"
                                                                style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                                <span style="color: #ffc400;">Lugar:</span><br />
                                                                <span>{{ $lugar }}</span><br/><br />
                                                            </td>
                                                        </tr>
                                                        <br />
                                                        <tr>
                                                            <td align="center" class="center"
                                                                style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                                <span style="color: #ffc400;">Fecha:</span><br />
                                                                <span>{{ $fecha_formateada }}</span><br/><br />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="center"
                                                                style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                                <span style="color: #ffc400;">Hora:</span><br />
                                                                <span>{{ $hora_formateada }}</span><br/><br />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" class="center"
                                                                style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                                <span style="color: #ffc400;">Preparacion:</span><br />
                                                                <span>{{ $preparacion }}</span><br/><br />
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td height="40">
                                                                &nbsp;
                                                            </td>
                                                        </tr>

                                                    </table>
                                                </td>
                                                <td class="spacer" width="30"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
