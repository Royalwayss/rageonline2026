<style>
   .rage-form__label-for-checkbox .rage-form__input-checkbox:checked + span::after {
   content: "";
   display: inline-block;
   width: 5px;
   height: 5px;
   border-radius: 50%;
   background-color: #ffffff;
   position: absolute;
   left: 4px;
   left: 6px;
   top: 7px;
   }
</style>
<div class="row accTabsInfo edit-prf">
<div class="col-sm-12 col-12 shipping">
   @if(isset($_GET['r']) && $_GET['r'] =="success")
   <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Success!</strong> Address has been updated successfully! 
   </div>
   @endif
   <form id="billingAddress" autocomplete="off" action="javascript:;" method="post">
      @csrf
      <div class="row">
        <!-- <div class="col-lg-6">
            <h4 class="booster-font">Billing Address</h4>
            <hr />
            <?php $address_type = 'billing'; ?>
            <div class="form-group">
               <label>Name&nbsp;</label>
               <input type="text" class="input-style form-control" name="<?php echo $address_type; ?>_first_name" id="<?php echo $address_type; ?>_first_name" value="{{(!empty($address[$address_type]))?$address[$address_type]['first_name']: '' }}" autocomplete="given-name">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_first_name"> </span>
            </div>
            <div class="form-group">
               <label for="<?php echo $address_type; ?>_mobile" class="">Mobile&nbsp;<abbr class="required" title="required">*</abbr></label>
               <input type="text" class="input-style form-control"name="<?php echo $address_type; ?>_mobile" id="<?php echo $address_type; ?>_mobile" placeholder=""  autocomplete="family-name" value="{{(!empty($address[$address_type]))?$address[$address_type]['mobile']: '' }}">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_mobile"> </span>
            </div>
            <div class="form-group">
               <label for="<?php echo $address_type; ?>_address" class="">Address&nbsp;<abbr class="required" title="required">*</abbr></label>
               <input type="text" class="input-style form-control"name="<?php echo $address_type; ?>_address" id="<?php echo $address_type; ?>_address" placeholder="" autocomplete="given-name" value="{{(!empty($address[$address_type]))?$address[$address_type]['address']: '' }}">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_address"> </span>
            </div>
            <div class="form-group">
               <label for="<?php echo $address_type; ?>_postcode" class="">Zip Code&nbsp;<abbr class="required" title="required">*</abbr></label>
               <input type="text" class="input-style form-control"name="<?php echo $address_type; ?>_postcode" id="<?php echo $address_type; ?>_postcode" placeholder="" value="{{(!empty($address[$address_type]))?$address[$address_type]['postcode']: '' }}" autocomplete="family-name">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_postcode"> </span>
            </div>
            <div class="form-group">
               <label for="<?php echo $address_type; ?>_city" class="">City&nbsp;<abbr class="required" title="required">*</abbr></label>
               <input type="text" class="input-style form-control"name="<?php echo $address_type; ?>_city" id="<?php echo $address_type; ?>_city" placeholder="" value="{{(!empty($address[$address_type]))?$address[$address_type]['city']: '' }}" autocomplete="given-name">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_city"> </span>
            </div>
            <div class="form-group">
               <label for="<?php echo $address_type; ?>_state" class="">State&nbsp;<abbr class="required" title="required">*</abbr></label>
               <select  class="input-text form-control" name="<?php echo $address_type; ?>_state" id="<?php echo $address_type; ?>_state" >
                  <option value=""> Select state </option>
                  @foreach($states as $state)
                  <option value="{{$state}}" <?php if(!empty($address[$address_type])){ if($address[$address_type]['state'] == $state){ echo "selected"; } }?>>{{$state}}</option>
                  @endforeach
               </select>
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_state"> </span>
            </div>
            <div class="form-group" style="width:100%">
               <label for="<?php echo $address_type; ?>_country" class="">Country&nbsp;<abbr class="required" title="required">*</abbr></label>
               <select name="<?php echo $address_type; ?>_country" id="<?php echo $address_type; ?>_country" class="input-text form-control" autocomplete="country" tabindex="-1" aria-hidden="true">
                  <option value="India" <?php if(!empty($address[$address_type])) { if($address[$address_type]['country']  == 'India'){ echo 'selected';    } } ?> >INDIA</option>
               </select>
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_country"> </span>
            </div>
            
			<div class="form-group" style="width:100%">
               <label class="rage-form__label rage-form__label-for-checkbox checkbox">
                      <input class="rage-form__input rage-form__input-checkbox input-checkbox" id="same_address" type="checkbox" name="createaccount" value="1">
                      <span>Delivery Address same as Invoice Address</span> </label>
            </div> 
			
			
         </div>  -->
         <div class="col-lg-12 shippingAddress">
            <h4 class="booster-font">Shipping Address</h4>
            <hr />
            <?php $address_type = 'shipping'; ?>
            <div class="form-group">
               <label>Name&nbsp;<abbr class="required" title="required">*</abbr></label>
               <input type="text" class="input-style form-control" name="<?php echo $address_type; ?>_first_name" id="<?php echo $address_type; ?>_first_name" value="{{(!empty($address[$address_type]))?$address[$address_type]['first_name']: '' }}" autocomplete="given-name">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_first_name"></span>
            </div>
            <div class="form-group">
               <label for="<?php echo $address_type; ?>_mobile" class="">Mobile&nbsp;<abbr class="required" title="required">*</abbr></label>
               <input type="text" class="input-style form-control"name="<?php echo $address_type; ?>_mobile" id="<?php echo $address_type; ?>_mobile" placeholder=""  autocomplete="family-name" value="{{(!empty($address[$address_type]))?$address[$address_type]['mobile']: '' }}">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_mobile"> </span>
            </div>
			<div class="form-group">
               <label for="<?php echo $address_type; ?>_alternative_number" class="">Alternative Mobile Number&nbsp;<abbr class="required" title="required">*</abbr></label>
               <input type="text" class="input-style form-control"name="<?php echo $address_type; ?>_alternative_number" id="<?php echo $address_type; ?>_alternative_number" placeholder=""  autocomplete="family-name" value="{{(!empty($address[$address_type]))?$address[$address_type]['alternative_number']: '' }}">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_alternative_number"> </span>
            </div>
            <div class="form-group">
               <label for="<?php echo $address_type; ?>_address" class="">Address&nbsp;<abbr class="required" title="required">*</abbr></label>
               <input type="text" class="input-style form-control"name="<?php echo $address_type; ?>_address" id="<?php echo $address_type; ?>_address" placeholder="" autocomplete="given-name" value="{{(!empty($address[$address_type]))?$address[$address_type]['address']: '' }}">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_address"> </span>
            </div>
            <div class="form-group">
               <label for="<?php echo $address_type; ?>_postcode" class="">Zip Code&nbsp;<abbr class="required" title="required">*</abbr></label>
               <input type="text" class="input-style form-control user_pincode "name="<?php echo $address_type; ?>_postcode" id="<?php echo $address_type; ?>_postcode" placeholder="" value="{{(!empty($address[$address_type]))?$address[$address_type]['postcode']: '' }}" autocomplete="family-name">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_postcode"> </span>
            </div>
           
            <div class="form-group">
               <label for="<?php echo $address_type; ?>_state" class="">State&nbsp;<abbr class="required" title="required">*</abbr></label>
               <select  class="input-text form-control user_state" name="<?php echo $address_type; ?>_state" id="<?php echo $address_type; ?>_state" >
                  <option value=""> Select state </option>
                  @foreach($states as $state)
                  <option value="{{$state}}" <?php if(!empty($address[$address_type])){ if($address[$address_type]['state'] == $state){ echo "selected"; } }?>>{{$state}}</option>
                  @endforeach
               </select>
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_state"> </span>
            </div>
			 <div class="form-group">
               <label for="<?php echo $address_type; ?>_city" class="">City&nbsp;<abbr class="required" title="required">*</abbr></label>
               <input type="text" class="input-style form-control user_city" name="<?php echo $address_type; ?>_city" id="<?php echo $address_type; ?>_city" placeholder="" value="{{(!empty($address[$address_type]))?$address[$address_type]['city']: '' }}" autocomplete="given-name">
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_city"> </span>
            </div>
            <div class="form-group">
               <label for="<?php echo $address_type; ?>_country" class="">Country&nbsp;<abbr class="required" title="required">*</abbr></label>
               <select name="<?php echo $address_type; ?>_country" id="<?php echo $address_type; ?>_country" class="input-text form-control" autocomplete="country" tabindex="-1" aria-hidden="true">
                  <option value="India" <?php if(!empty($address[$address_type])) { if($address[$address_type]['country']  == 'India'){ echo 'selected';    } } ?> >INDIA</option>
               </select>
               <span class="err address-err" id="Address-<?php echo $address_type; ?>_country"> </span>
            </div>  
			
			
			
            <div class=" mt-3">
               <div class="alert alert-danger print-error-msg text-center" style="display:none">
                  <ul></ul>
               </div>
               <button type="submit" class="accound_btn-style" id="update-address">Update</button>
            </div>
         </div>
   </form>
   </div>
</div>
@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>
   var accounturl = '/account/address';
   	window.history.pushState({path:accounturl},'',accounturl);
   	$('#update-address').click(function(){ 
   	   
   	     var formdata = $("#billingAddress").serialize();
   	        var actionType= $('[name=action]').val();
   	        $.ajax({
   	            url: '/update-address',
   	            type:'POST',
   	            data: formdata,
   	            success: function(data) {
   	                $('.PleaseWaitDiv').hide();
   					$('.address-err').html(''); 
   	                if(!data.status){
   	            		if(data.type=="validation"){
   							var err_no = 0;
   	            			 $.each(data.errors, function (i, error) { 
   							  err_no = err_no + 1;
   							        
   									$('#Address-'+i).html(error); 
   									if(err_no == 1){  
   										$("#"+i).focus();
   									}
   									
   								   });
   	                    	
   	            		}
   	            	}else{ 
   	            		window.location.href= data.action;
   	            	}
   	            }
   	        });
   	});
   	
   	$('#same_address').change(function () { 
   		if ($(this).prop('checked')==true){ 
   			$("#shipping_first_name").val($("#billing_first_name").val());		
   			$("#shipping_mobile").val($("#billing_mobile").val());		
   			$("#shipping_address").val($("#billing_address").val());		
   			$("#shipping_postcode").val($("#billing_postcode").val());		
   			$("#shipping_city").val($("#billing_city").val());		
   			$("#shipping_state").val($("#billing_state").val()); 	
   			$("#shipping_country").val($("#billing_country").val());		
   		}else{
   			
   			$("#shipping_first_name").val('');		
   			$("#shipping_mobile").val('');		
   			$("#shipping_address").val('');		
   			$("#shipping_postcode").val('');		
   			$("#shipping_city").val('');		
   			$("#shipping_state").val(''); 	
   			$("#shipping_country").val('');	
   		}
       });
   	
</script>
@stop