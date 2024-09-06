@extends('email.layouts.app')
@section('content')
<style>
    .my-button {
        padding: 10px 20px;
        background-color: #ffc400;
        color: #253061;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .my-button:hover {
        background-color: #c39a12;
        color: #253061;
    }

    .my-button:active {
        background-color: #efc538;
        color: #253061;
    }
</style>
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
                                                            <span> <strong>Notificación solicitud de examen ocupacional</strong></span><br/><br />
                                                        </td>
                                                    </tr>
                                                    <br>
                                                    <tr>
                                                        <td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#ffffff; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
                                                            <span style="font-size: 16px; color:#ffc400">Solicitud (<span>{{$consec_examen}}</span>)</span>
                                                        </td>
                                                    </tr>



                                                    <tr>
                                                        <td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                             <span>Le informamos que se ha generado una solicitud de examen ocupacional. </span><br /><br />
                                                        </td>
                                                    </tr>


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
                                                        <td height="40">&nbsp;</td>
                                                    </tr>

                                                    <tr>
                                                        <td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color: #253061; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                            <a href="{{$link_examen}}" class="my-button" style="cursor: pointer">Ver solicitud</a>
                                                        </td>
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