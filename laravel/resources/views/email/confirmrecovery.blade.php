@extends('email.layouts.app')
@section('content')
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
        <tr>
            <td valign="top" width="100%">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%">
                            <table border="0" cellpadding="0" cellspacing="0" class="table_scale" width="600" background="">
                                <tr>
                                    <td align="center" width="100%">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
                                            <tr>
                                                <td height="40">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="center" style="padding-bottom: 5px; font-weight: 300; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#444444; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
                                                    Hola<br> <span> <strong>{{$nombre}}</strong></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="center" style="margin: 0; font-weight: 300; font-size:16px ; color:#444444; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 26px;mso-line-height-rule: exactly;">
                                                    <span>Tu contraeña ha sido modificada con Éxito<br/>
                                                        {{$key}}<br/>
                                                        Ya puedes ingresar el CMS Nuevamente</span>
                                                    <br/><br/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding-top: 15px;" valign="top">
                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #444444; border-radius: 5px; margin: 0">
                                                        <tr>
                                                            <td align="center" style="background-color: #444444; border-radius: 5px; color: #0079ff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 26px; margin: 0 !important; padding: 10px 25px" valign="middle">
                                                                <a href="https://seguritechtest.com/panel/login" style="border: none; font-weight: normal; font-style: normal; color: #ffffff;" target="_blank">Ir al CMS</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="40">
                                                    &nbsp;
                                                </td>
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
