<?php Use App\CustomFunction; ?> 
<style>
.text1{ font-size:13px; font-family:'roboto_condensedregular';  }
.text1  {  font-size:12px;  font-family:'roboto_condensedregular'; }
</style>
<?php //echo "<pre>"; print_r( $orderDetails['order_products']); exit; ?>
	<div class="">
	<span class="text1">-----------------------------------<strong>Customer Detail</strong>----------------------------</span><br>
	<span class="text1">
	<table>
	    <tr>  <td width="145px"><b>Name:</b></td> <td>{{ $data['name_of_party'] }} </td>  </tr>
	    <tr>  <td><b>Address:</b></td><td> {{ $data['address_of_party'] }} </td>  </tr>
	    <tr>  <td><b>City:</b></td><td> {{ $data['city_of_party'] }} </td> </tr>
	    <tr>  <td><b>Phone:</b></td><td> {{ $data['phone_of_party'] }} </td>  </tr>
	   
	 
		</table>
	</span>
	<br><br />

	<span class="text1">-----------------------------------<strong>Showroom Detail</strong>----------------------------</span><br>
	<span class="text1">
    	<table>
	    <tr>  <td width="145px"><b>Name:</b></td> <td>{{ $data['showroom_name'] }} </td>  </tr>
	    <tr>  <td><b>Address:</b></td><td> {{ $data['showroom_address'] }} </td>  </tr>
	    <tr>  <td><b>Phone:</b></td><td> {{ $data['showroom_phone'] }} </td> </tr>
	    <tr>  <td><b>Floor:</b></td><td> {{ $data['floor1'] }} </td>  </tr>
	    <tr>  <td><b>Frontage:</b></td><td> {{ $data['frontage'] }} </td>  </tr>
	    <tr>  <td><b>Depth:</b></td><td> {{ $data['depth'] }} </td>  </tr>
	    <tr>  <td><b>Area:</b></td><td> {{ $data['area'] }} </td>  </tr>
		</table>
	</span>
	<br><br />
	
	<span class="text1">-----------------------------------<strong>Area Location  Detail</strong>----------------------------</span><br>
	<span class="text1">
    	<table>
	    <tr>  <td width="145px"><b>Profile1:</b></td> <td>{{ $data['profile1'] }} </td>  </tr>
	    <tr>  <td><b>Profile2:</b></td><td> {{ $data['profile2'] }} </td>  </tr>
	    <tr>  <td><b>Competitor:</b></td><td> {{ $data['competitor'] }} </td> </tr>
	    <tr>  <td><b>Mode Of Operation:</b></td><td> {{ $data['mode_of_operation'] }} </td> </tr>
	   
		</table>
	</span>
	<br><br />
	 
	 
	 	<span class="text1">-----------------------------------<strong>Business Details</strong>----------------------------</span><br>
	<span class="text1">
    	<table>
	    <tr>  <td width="145px"><b>Prop./Partners/Directors:</b></td> <td>{{ $data['prop'] }} </td>  </tr>
	    <tr>  <td><b>Father's Name:</b></td><td> {{ $data['father_name'] }} </td>  </tr>
	    <tr>  <td><b>Res. Address:</b></td><td> {{ $data['res_address'] }} </td> </tr>
	    <tr>  <td><b>Mobile:</b></td><td> {{ $data['mobile'] }} </td> </tr>
	    <tr>  <td><b>Phone:</b></td><td> {{ $data['phone'] }} </td> </tr>
	    <tr>  <td><b>Email:</b></td><td> {{ $data['email'] }} </td> </tr>
	   
		</table>
	</span>
	<br><br />
	 
	


