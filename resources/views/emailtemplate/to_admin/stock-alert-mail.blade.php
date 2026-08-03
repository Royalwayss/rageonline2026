<?php 
   Use App\CustomFunction; 
   Use App\ProductImage; 
   $BASE_URL = env('BASE_URL');
   ?>
<html>
   <head>
      <style type='text/css'>
      </style>
   </head>
   <body>
      <table width='100%' border='0' cellpadding='0' cellspacing='0'  style='border:#EFEFEF 5px solid; padding:5px;'>
         <tr>
            <td colspan='3'></td>
         </tr>
         <tr>
            <td  align='center' valign='middle'>
               <img border='0' src="{{ config('constants.site_logo') }}"  />
               <hr>
            </td>
         </tr>
         <tr>
            <td height='70' align='right' valign='top'>
               <table width='93%' border='0' align='right' cellpadding='3' cellspacing='0' >
                  <tr>
                     <td align='left' valign='top' class='style3'>&nbsp;</td>
                  </tr>
				  <tr>
                     <td align='left' valign='top' class='style3'>Hi Admin, a new product stock alert has been received from {{ config('constants.website_url') }}</td>
                  </tr>
				  <tr>
                     <td align='left' valign='top' class='style3'>&nbsp;</td>
                  </tr>
                
                  <tr>
                     <td align='left' valign='top' class='style3'>We wanted to inform you about the current stock levels for the products you're monitoring. Please find the updated stock information below: 
                  </tr>
				  <tr>
                     <td align='left' valign='top' class='style3'>&nbsp;</td>
                  </tr>
                  <tr>
                     <td align='left' valign='top' class='style3'>
                        <table width='95%' border='0' align='left' cellpadding='3' cellspacing='1' bgcolor='ACA899'>
                           <tr>
                              <td width='23%' align='center' valign='top' class='style2' bgcolor='#cccccc' colspan="2">Product</td>
                              <td width='10%' align='center' valign='top' class='style2' bgcolor='#cccccc'>Product Code</td>
                              <td width='10%' align='center' valign='top' class='style2' bgcolor='#cccccc'>Category</td>
                              <td width='15%' align='center' valign='top' class='style2' bgcolor='#cccccc' >Size</td>
                              <td width='10%' align='center' valign='top' class='style2' bgcolor='#cccccc'>Current Stock</td>
                              <td width='12%' align='center' valign='top' class='style2' bgcolor='#cccccc'>Update Link</td>
                           </tr>
                           @foreach($product_attributes as $product)
                           <?php
						     $product_image = ProductImage::where('product_id',$product['product_id'])->orderby('image_sort','asc')->first();
						   ?>
						   <tr style="text-align:center">
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>
                                 <a style="text-decoration: none;"  target="_block" href="{{ url('product/'.$product['seo_url']) }}">
                                 @if(!empty($product_image))
                                 <img src="{{ $BASE_URL.'images/ProductImages/small/'.$product_image['image'] }}" class="attachment-rage_thumbnail size-rage_thumbnail"
                                    alt="img" width="50" height="50" style="margin:10px;">
                                 @else
                                       <img src="{{ $BASE_URL.'images/no-image-found.jpg' }}"  alt="img" width="50" height="50"  class="img-fluid" style="margin:10px;"  />
                                 @endif
                                 </a>
                              </td>
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>
                                 <a style="text-decoration: none;"  target="_block" href="{{ $BASE_URL.'product/'.$product['seo_url'] }}">{{ $product['product_name'] }} </a>
                                
							  </td>
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>
                                 {{ $product['product_code'] }} 
                              </td>
							   <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>
                                 <a style="text-decoration: none;"  target="_block" href="{{ $BASE_URL.$product['category_url'] }}">{{ $product['category_name'] }} </a>
                              </td>
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>
                                 {{ $product['size'] }} 
                              </td>
                             
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>
                                 {{ $product['stock'] }} 
                              </td>
							   <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>
                                <a style="text-decoration: none;"  target="_block" href="{{ $BASE_URL.'admin/stock-update/'.$product['product_id'] }}">Update</a>  
                              </td>
                           </tr>
                           @endforeach
                        </table>
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
            </td>
         </tr>
	
      </table>
   </body>
</html>

