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

                <td  align='left' valign='middle'><img border='0' width="75px" src="{{ config('constants.site_logo') }}"  /></td>

            </tr>

            <tr>

                <td>&nbsp;</td>

            </tr>

            <tr>

                <td class='style2'>Hi Admin! You have received the franchise enquiry. Below are the details :-</td>

            </tr>

            <tr>

                <td>&nbsp;</td>

            </tr>           

            <tr>

               <td align='left' valign='middle'>

                   <table width='98%' border='0' align='right' cellpadding='5' cellspacing='5' style='background-color:#F5F5F5'>
                      <tr><td width='30%'><h3>Customer Detail</h3></td> </tr>
                        <tr>

                           <td width='30%' align='left' valign='top' class='style2'>Name:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['name_of_party'] }}</td>

                        </tr>

                        <tr>

                           <td width='30%' align='left' valign='top' class='style2'>Address:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['address_of_party'] }}</td>

                        </tr>

                        <tr>

                           <td width='30%' align='left' valign='top' class='style2'>City:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['city_of_party'] }}</td>

                        </tr>

                      
						
						  <tr>

                           <td width='30%' align='left' valign='top' class='style2'>Phone:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['phone_of_party'] }}</td>

                        </tr>
						
                 <tr><td width='30%'><br><h3>Showroom Details</h3></td> </tr>
				 
				         <tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Name:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['showroom_name'] }}</td>

                        </tr>
						
						<tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Address:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['showroom_address'] }}</td>

                        </tr>
						
						<tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Phone:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['showroom_phone'] }}</td>

                        </tr>
						
					
						
						<tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Floor:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['floor1'] }}</td>

                        </tr>
						
						<tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Frontage:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['frontage'] }}</td>

                        </tr>
						
						<tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Depth:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['depth'] }}</td>

                        </tr>
						
						<tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Area:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['area'] }}</td>

                        </tr>
						
						
						
						 <tr><td width='30%'><br><h3>Area Location Details</h3></td> </tr>

						<tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Profile1:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['profile1'] }}</td>

                        </tr>
                        
						<tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Profile2:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['profile2'] }}</td>

                        </tr>
						
						<tr>
					
						
						
						<tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Competitor:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['competitor'] }}</td>

                        </tr>
						
						
						<tr>
						 
                           <td width='30%' align='left' valign='top' class='style2'>Mode Of Operation:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['mode_of_operation'] }}</td>

                        </tr>

                   </table>

               </td>

           </tr>
            <tr>

              

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