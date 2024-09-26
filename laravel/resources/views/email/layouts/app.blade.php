<!DOCTYPE html>
<html>

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
    <title>
    </title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/email/layouts/app.blade.css')}}">

</head>

<body bgcolor="#F5F7FA">

    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
        <tr>
            <td align="center" valign="top" width="100%">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%">

                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
                                <tr>
                                    <td height="30" width="100%">
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
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
        <tr>
            <td valign="top" width="100%">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%">

                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
                                <tr>
                                    <td height="30" width="100%">
                                        &nbsp;
                                    </td>
                                </tr>
                            </table>
                            <table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
                                <tr>
                                    <td width="100%">
                                        <table border="0" cellpadding="0" cellspacing="0" width="600">
                                            <tr>
                                                <td class="spacer" width="30"></td>
                                                <td width="540">

                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%">
                                                        <tr>
                                                            <td align="center" class="center" style="padding: 0px;font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%; text-align: center;">
                                                                <span><img alt="logo" border="0" src="{{asset('https://berhlan.com/logo-small.png')}}" style="display: inline-block; width: 150px"></span>
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
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #FFFFFF" width="600">
                                <tr>
                                    <td height="30" width="100%">
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


    @yield('content')

    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
        <tr>
            <td valign="top" width="100%">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%">
                            <table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF" width="600">
                                <tr>
                                    <td width="100%">
                                        <table border="0" cellpadding="0" cellspacing="0" width="600">

                                            <tr>
                                                <td width="600">
                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
                                                        <tr>
                                                            <td align="center" class="center" style="margin: 0; padding: 0 0 30px; font-weight:300; font-size:12px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 15px;">

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
            </td>
        </tr>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
        <tr>
            <td valign="top" width="100%">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%">
                            <table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #EFEFEF; border-top: 1px solid #f7f7f7" width="600">
                                <tr>
                                    <td width="100%">
                                        <table border="0" cellpadding="0" cellspacing="0" width="600">
                                            <tr>
                                                <td class="spacer" width="30"></td>
                                                <td width="540">

                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">

                                                        <tr>
                                                            <td align="left" class="center" style="margin: 0; padding-top: 10px; font-weight:300; font-size:12px; font-family: \'Open Sans\', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
                                                                <span style="color: #999">&#169; {{date('Y')}} </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="spacer" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="20">
                                                        <tr>
                                                            <td height="10" width="100%"></td>
                                                        </tr>
                                                    </table>
                                                    <table align="right" border="0" cellpadding="0" cellspacing="0" class="full" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="255">

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
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #F5F7FA" width="100%">
        <tr>
            <td align="center" valign="top" width="100%">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%">
                            <table border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
                                <tr>
                                    <td width="100%">
                                        <table border="0" cellpadding="0" cellspacing="0" width="600">
                                            <tr>
                                                <td width="540">
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="540">
                                                        <tr>
                                                            <td align="center" style="padding: 0px;" valign="top">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #0079FF; margin: 0">
                                                                    <tr>
                                                                        <td align="center" style="background-color: #F5F7FA; color: #adb2bb; font-family: \'Open Sans\',Helvetica,Arial,sans-serif; font-size: 13px ; font-style: normal; line-height: 0; padding: 0px" valign="middle"></td>
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
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="table_scale" style="background-color: #F5F7FA" width="600">
                                <tr>
                                    <td height="40" width="100%">
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
</body>

</html>
