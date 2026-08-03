		<html>
		<head>
		<style>
      .table_bg {
       font-family: Verdana, Arial, Helvetica, sans-serif;
       font-size: 12px;
       font-weight: normal;
       color: #333333;
       text-decoration: none;
       border: 3px solid #000000;
      }
      .form_bg {
       font-family: Verdana, Arial, Helvetica, sans-serif;
       font-size: 11px;
       color: #666666;
       text-decoration: none;
       background-color: #f2f2f2;
       border: 1px solid #000000;
      }
      </style>
	  </head>
	  <body>
      <table width='600' border='0' cellpadding='0' cellspacing='0'  style='border:#EFEFEF 5px solid; padding:5px;'>
      <tr>
		<td colspan='3'></td>
		</tr>
        <tr>
       <td align='center' valign='middle'><img border='0' src="{{ config('constants.site_logo') }}" /><hr></td>
        </tr>
        <tr bgcolor='#FFFFFF'>
       <td>Date: <?php echo date('Y-m-d'); ?></td>
        </tr>
		<tr>
		<td align='left' valign='top' class='style3'>&nbsp;</td>
		</tr>
        <tr>
       <td colspan='3' bgcolor='#FFFFFF'><strong>Dear </strong> <?php echo $orderDetails['getuser']['name']; ?>, </td>
        </tr>
        <tr>
		<td align='left' valign='top' class='style3'>&nbsp;</td>
		</tr>
		<tr>
		   <td colspan='3' bgcolor='#FFFFFF'>
		   Your order status is  <b> <?php echo  $orderStatus; ?></b>
		   </td>
		</tr>
		
		@if($orderStatus=="Successful")
			<tr>
		   <td colspan='3' bgcolor='#FFFFFF'>
		   This is to confirm you that the products for your Order No, <b> <?php echo  $orderDetails['id']; ?></b> have been delivered to the mailing address provided by you.
		   </td>
		</tr>
		@endif
		@if($orderStatus == "Delivered")
			<tr>
		   <td colspan='3' bgcolor='#FFFFFF'>This is to confirm you that the products for your Order No, <b><?php echo $orderDetails['id']; ?></b> have been delivered to the mailing address provided by you.</td>
			</tr>
		@endif
		
		@if($orderStatus == "Cancelled")
			<tr>
		   <td colspan='3' bgcolor='#FFFFFF'>
		   We are sorry to convey that the order no, <b><?php echo $orderDetails['id']; ?></b> placed by you has been cancelled. <a href="<?php echo  config('constants.base_url'); ?>">Click here</a> to continue shopping with us.
		   </td>
		</tr>
		@endif
       <tr>
          <td colspan='3' bgcolor='#FFFFFF'>&nbsp;</td>
        </tr>
        <tr>
        <td colspan='3' align='left' bgcolor='#FFFFFF'>Thanks for shopping with us.</td>
        </tr>
        <tr>
          <td colspan='3' bgcolor='#FFFFFF'>&nbsp;</td>
        </tr>
        <tr>
       <td colspan='3' align='left' bgcolor='#FFFFFF'>For any enquiries please mail us at <a href='mailto:<?php echo config('constants.project_email'); ?>'><?php echo config('constants.project_email'); ?></a></td>
        </tr>
        <tr>
       <td align='left' bgcolor='#ffffff' colspan='3'><p>&nbsp;</p>
        <p>Thanks & Regards<br />
          Team Rage</p></td>
        </tr>
      </table>
     
	 </body>
	  </html>