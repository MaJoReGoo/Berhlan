@extends('email.layouts.app')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/email/email_requision_personal/notificacion_rechazo_soli_personal.blade.css')}}">

<table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
    <tr>
        <td valign="top" width="100%">
            <table align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="100%">
                        <table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #253061; background-size:cover" width="600" background="">
                            <tr>
                                <td align="center" width="100%">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                        <tr>
                                            <td class="spacer" width="30"></td>
                                            <td width="540">
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
                                                    <tr>
                                                        <td height="40">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
                                                            <span> <strong>Notificación rechazo de solicitud de requisición personal</strong></span><br/><br />
                                                        </td>
                                                    </tr>
                                                    <br>

                                                    <tr>
                                                        <td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                             <span>Ha sido rechazada su <span style="font-size: 16px; color:#ffc400">solicitud #(<span>{{$num_solicitud}}</span>)  </span>de requisición de personal</span><br /><br />
                                                        </td>
                                                    </tr>
                                                    <br>



                                                    <tr>
                                                        <td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                            <span style="color: #ffc400;">Cargo:</span><br/>
                                                             <span>{{$cargo}}</span><br />
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                            <br />
                                                            <span style="color: #ffc400;">Centro operacion:</span><br />
                                                            <span>{{$centro_operacion}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                            <br />
                                                            <span style="color: #ffc400;">Motivo rechazo:</span><br />
                                                            <span>{{$rechazo_nomina}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                            <br />
                                                            <span style="color: #ffc400;">Observaciones:</span><br />
                                                            <span>{{$obs_rechazo}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="40">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="40">&nbsp;</td>
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
