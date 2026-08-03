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
                 .button {
                    border-radius: 2px;
                }
                
                .button a {
                    padding: 8px 12px;
                    border: 1px solid #ED2939;
                    border-radius: 2px;
                    font-family: Helvetica, Arial, sans-serif;
                    font-size: 14px;
                    color: #ffffff; 
                    text-decoration: none;
                    font-weight: bold;
                    display: inline-block;  
                }                

        </style>

    </head>

    <body>

        <table width='80%' border='0' cellpadding='3' cellspacing='3' style='border:#EFEFEF 5px solid; padding:5px;'>

            <tr>

                <td colspan='3'></td>

            </tr>

            <tr>

                <td  align='left' valign='middle'><img border='0' width="75px" src="https://www.rageonline.co.in/img/logo/logo.png" alt='logo' /></td>

            </tr>

            <tr>

                <td>&nbsp;</td>

            </tr>

            <tr>


				<td align='left' valign='top' class='style3'>
				
				<b>Hi Admin,</b><br></b><br>
				
					Product {{ $data['action'] }} request has been received. Product details are below:-

				
				</td>


            </tr>

            <tr>

                <td>&nbsp;</td>

            </tr>   


               <tr>

               <td align='left' valign='middle'>

                   <table width='98%' border='0' align='right' cellpadding='5' cellspacing='5' style='background-color:#F5F5F5'>
                        
						<tr>

                           <td width='30%' align='left' valign='top' class='style2'>Order ID:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>#{{ @$product['order_id'] }}</td>

                        </tr>
						
						
						<tr>

                           <td width='30%' align='left' valign='top' class='style2'>Product Name:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>
						    <a target="_block" href="{{ url('product/'.$product['productdetail']['seo_url']) }}">
								{{ @$product['productdetail']['product_name'] }}
						    <a>
						   </td>

                        </tr>
						
						<tr>

                           <td width='30%' align='left' valign='top' class='style2'>Product Size:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>
						    
								{{ @$product['product_size'] }}
						    
						   </td>

                        </tr>
						
						<tr>

                           <td width='30%' align='left' valign='top' class='style2'>{{ $data['action'] }} Reason:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ @$data['return_reason'] }}</td>

                        </tr>
						
						
						@if(!empty($data['required_size']))
						<tr>

                           <td width='30%' align='left' valign='top' class='style2'>Required Size:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ @$data['required_size'] }}</td>

                        </tr>
						@endif
                                           
                       
                       <tr>

                           <td width='30%' align='left' valign='top' class='style2'>Comments:</td>

                           <td width='5%' align='left' valign='top' class='style2'>:</td>

                           <td width='65%' align='left' valign='top' class='style3'>{{ @$data['reason'] }}</td>

                        </tr>
						@if(!empty($data['filename']))
						<?php 
							$implode_images = $data['filename']; 
							$images = explode(',',$data['filename']); 
						?>
							@foreach($images  as $key=>$img)
							<tr>

							   <td width='30%' align='left' valign='top' class='style2'>
							   @if($key == 0)
							   Images:
							   @endif
							   </td>

							   <td width='5%' align='left' valign='top' class='style2'>:</td>

							   <td width='65%' align='left' valign='top' class='style3'>
							   
							     <img src="{{ asset('images/return/'.$img) }}" style="max-width:50%!important">
							   
							   </td>

							</tr>
							@endforeach
						@endif
					
                   </table>

               </td>

           </tr>

           <tr>

                <td>&nbsp;</td>

            </tr>

            <tr>

                <td  class='style2'> Regards<br />

                    Deerclub Team

                </td>

            </tr>

        </table>

    </body>

</html>
