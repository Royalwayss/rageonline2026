<html>

    <head>

        <style type='text/css'>

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

                <td class='style2'>Hi Admin! You have received the feedback. Below are the details :-</td>

            </tr>

            <tr>

                <td>&nbsp;</td>

            </tr>           

            <tr>

               <td align='left' valign='middle'>

                   <table width='98%' border='0' align='right' cellpadding='5' cellspacing='5' style='background-color:#F5F5F5'>

                        <tr>

                           <td width='30%' align='left' valign='top' class='style2'>Name:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['name'] }}</td>

                        </tr>

                        <tr>

                           <td width='30%' align='left' valign='top' class='style2'>Email:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['email'] }}</td>

                        </tr>

                        <tr>

                           <td width='30%' align='left' valign='top' class='style2'>Mobile:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['mobile'] }}</td>

                        </tr>

                        <tr>

                           <td width='30%' align='left' valign='top' class='style2'>Message:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['message'] }}</td>

                        </tr>

                   </table>

               </td>

           </tr>
            <tr>

                <td  class='style2'>

                    <p> We really happy to help . E-mail us at  <a href='mailto: {{config('constants.project_email')}}'> {{config('constants.project_email')}}</a> or give us call at {{config('constants.project_mobile')}}</p>

                </td>

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