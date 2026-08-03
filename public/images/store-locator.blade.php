@extends('layouts.frontLayout.front-layout')
@section('content')
<style>.store-logo{ display: block;
    float: left;
    width: 100px;
    padding-top: 9px;
} 
.store_select {
    padding: 5px;
    width: 63%;
}
@media only screen and (max-width:767px) {
.store_select {
    padding: 5px;
    width: 100%;
}
}
.store-div {
    box-shadow: 0 0 10px rgb(0 0 0 / 20%);
    margin-bottom: 20px;
    margin-top: 10px;
    padding: 15px;
    background-color: #fff;
}
</style>
<div class="site-main  main-container no-sidebar">
  <div class="section-037">
    <div class="container">
      <div class="rage-popupvideo style-01 mt-3 pt-2">
        <div class="row">
          <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="active">Store Locator</li>
          </ol>
        </div>
         <div class="store-list-container">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="store-list">
                  <div class="block-title">
                    <h3 class=""><span>STORE LOCATOR</span></h3>
                  </div>
				  
                <h5 class="black">SELECT STATE</h5>
				<select name="state" class="form-control store_select " onChange="window.location.href='store-locator?state=' + escape(this[selectedIndex].value)">
					<option value="">Select State</option>
		            @foreach($state_list as $state)
					<option value="{{ $state['state'] }}" <?php if(isset($_GET['state'])){ if($_GET['state']==$state['state']){ echo 'selected'; }} ?> > {{ $state['state'] }}</option>
					@endforeach
				</select>
				
				
				<h5 class="mg-top-20 black">SELECT CITY</h5>
				<select class="form-control store_select" name="city1" onChange="window.location.href='store-locator?state=<?php if(isset($_GET['state'])) { echo $_GET['state']; } ?>&city=' + escape(this[selectedIndex].value)">
		        	<option value="">Select City</option>
					@foreach($city_list as $city)
					<option value="{{ $city['city1'] }}" <?php if(isset($_GET['city'])) { if($_GET['city']==$city['city1']){ echo 'selected'; }} ?>> {{ $city['city1'] }}</option>
					@endforeach
				</select>
				
                </div>
                
              </div>
			  
			 <div class="col-md-4 col-sm-12 col-xs-12">
				<h5 class="black">
		        <?php 
				if(isset($_GET['city']) && ($_GET['city']!="") && isset($_GET['state']) && ($_GET['state']!="")){
					
					if(count($store_locations) == 0){
						echo "Store Not Available ";
					}else{
						echo " Store Available :";
				}
				?>
		        </h5>
		        <?php
			 	$i=0;
			 	$k=0;
				foreach($store_locations as $store_location){
					$i++;
					if($k==1){
						echo "<tr>";
						$k=0;
					}
					$k++;
				?>
				<div class="col-xs-12 no-pd store-div">
					<span><?php echo $store_location['addess'];?></span><br />
					<span><?php echo $store_location['phone'];?></span><br />
					<span><?php echo $store_location['city1'];?></span><br/>
					<span><?php echo $store_location['state'];?></span><br />
				</div>
		        <?php } } ?>
			</div>
			
             <div class="col-md-4 col-sm-12 col-xs-12">
				<img src="{{ asset('images/map.png') }}" class="img-responsive" alt="" />
			</div>
			  
			  
			  
            </div>
          </div>
	  </div>
    </div>
  </div>
</div>

@stop
@section('javascript')
@parent

@stop