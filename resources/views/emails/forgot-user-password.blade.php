<html>
    <head>
        <style type='text/css'>
            <!--
                .style1 {
                    color: #FFFFFF
                }
                .style2 {
                    font-size: 11px;
                    font-weight: bold;
                    text-decoration: none;
                    font-family: Verdana, Arial, Helvetica, sans-serif;
                    color:#666666;
                }
                .style3 {
                    text-decoration: none;
                    font-family: Verdana, Arial, Helvetica, sans-serif;
                    font-size: 11px;
                    color:#666666;
                }
                -->
        </style>
    </head>
    <body>
        <table width='80%' border='0' cellpadding='3' cellspacing='3' style='border:#EFEFEF 5px solid; padding:5px;'>
            <tr>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td  align='left' valign='middle'><img border='0' width="75px" src="{{ config('constants.site_logo') }}" alt='logo' /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class='style2'>Hi {{$name}}  ! You are requested to Change your Password. New Password information is below:</td>
            </tr>
             <tr>
                <td>&nbsp;</td>
            </tr>           
            <tr>
               <td align='left' valign='middle'>
                   <table width='98%' border='0' align='right' cellpadding='5' cellspacing='5' style='background-color:#F5F5F5'>
                        <tr>
                           <td width='30%' align='left' valign='top' class='style2'>Email</td>
                           <td width='5%' align='left' valign='top' class='style2'>:</td>
                           <td width='65%' align='left' valign='top' class='style3'>{{ $user_email }}</td>
                        </tr>
                        <tr>
                           <td width='30%' align='left' valign='top' class='style2'>New Password:</td>
                           <td width='5%' align='left' valign='top' class='style2'>:</td>
                           <td width='65%' align='left' valign='top' class='style3'>{{ $password }}</a></td>
                        </tr>
                   </table>
               </td>
           </tr>
           <tr>
                <td class='style2'>Note:-Please change your password after login by using Dashboard section</td>
            </tr> 
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td  class='style2'> Regards<br />
                    Team {{config('constants.project_name')}}
                </td>
            </tr>
        </table>
    </body>
</html>