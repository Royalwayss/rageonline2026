@extends('layouts.frontLayout.front-layout')
@section('content')
<?php
   $counties = get_counties(); 
   $state_options = get_state_options();
   ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.3.5/css/intlTelInput.css"/>
<style>
.iti-phone-input {
width: 100% !important;
padding: 10px;
box-sizing: border-box;
margin-top: 10px;
}

/* Make the intl-tel-input wrapper full width */
.iti.iti--separate-dial-code {
width: 100%;
}

.whatsapp-icon {
    bottom: 83px !important;
}

</style>
<main>
   <div class="container-fluid p-0">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54782.05937711032!2d75.73135614395144!3d30.890053832594322!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a83dfca1d05cd%3A0xe6309714ea681f7e!2sRAGE%20FLAGSHIP%20STORE!5e0!3m2!1sen!2sin!4v1727164973627!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
   </div>
   <div class="site-main main-container no-sidebar login-pg contactforms">
   <div class="section-037 contact">
      <div class="container">
         <div class="rage-popupvideo">
            <!--  <div class="row">
               <ol class="breadcrumb">
                 <li><a href="{{ url('/') }}">Home&nbsp;/&nbsp;</a></li>
                 <li class="active">Contact</li>
               </ol>
               </div> -->
            <div class="row">
               <div class="col-md-6 col-12 contact-details-1">
                  <div class="addressSec">
                     <h3 class="az_custom_heading">CONTACT US</h3>
                     <div class="contact-txt">
                        <?php /* <p>HB-3, Phase -VI, Focal Point , Ludhiana, Punjab<br> */ ?>
                        <p><i class="fas fa-map-marker-alt"></i> HA-54 PHASE 6 FOCAL POINT LUDHIANA 141010 Punjab India</p>
                        <p><i class="fas fa-phone-alt"></i> <a href="tel:+91 79861 58756"> +91 79861 58756 </a></p>
                        <!-- <p><i class="fa fa-fax" aria-hidden="true"></i>5095458 F: +91-161-2672517</p> -->
                        <p><i class="fas fa-envelope"></i><a href="mailto:rageindiaonline@gmail.com">rageindiaonline@gmail.com</a></p>
                        <p><i class="fab fa-facebook"></i><a href="https://www.facebook.com/rageindiaonline">rageindiaonline</a></p>
                        <p><i class="fab fa-instagram"></i><a href="https://www.instagram.com/rageindiaonline/">rageindiaonline</a></p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-12 contact-form-1">
                  <h3>GET IN TOUCH</h3>
                  <div role="form" class="wpcf7 register-form">
                     @if(isset($_GET['s']))
                     <div class="alert alert-success alert-dismissible">Your infomation has been submitted successfully.<br>We will get back to you soon.<span></span></div>
                     @endif 
                     <form class="wpcf7-form" id="SaveContact" action="javascript:;" method="post" >
                        @csrf
                        <div class="form-group">
                           <label> Name *<br>
                           <span class="wpcf7-form-control-wrap your-name"></label>
                           <input name="name" id="con-name" size="40" class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required" type="text">
                           </span> 
                           <p class="err text-center" id="Contact-name" style="display: none;"></p>
                        </div>
                        <div class="form-group">
                           <label> Email *<br>
                           <span class="wpcf7-form-control-wrap your-email"></label>
                           <input name="email" id="con-email" size="40" class="form-control wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" type="text">
                           </span>
                           <p class="err text-center" id="Contact-email" style="display: none;"></p>
                        </div>
                        
						
						
						
						 <div class="form-group">
							   <label> Mobile *<br>
							    <span class="wpcf7-form-control-wrap your-mobile"></label>
							  <input type="tel" id="iti_phone_input"  class="iti-phone-input form-control wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" placeholder="Phone no *" name="mobile">
							   <input type="hidden" id="iti_country_code" name="country_code">
							   <input type="hidden" id="iti_mobile_number" name="mobile_number">
							    </span>
							   <p class="err text-center" id="Contact-mobile" style="display: none;"></p>
							</div>
						
						
						
						
						
                        <div class="form-group" style="margin-top:30px">
                           <label>
                              Country <br>
                              <span class="wpcf7-form-control-wrap your-country">
                           </label>
                           <select id="country"  name="country" class="form-control select2 wpcf7-form-control wpcf7-text wpcf7-validates-as-required" onchange="get_state_city('1')">
                           <option value="" disabled selected>Select your country</option>
                           <?php foreach($counties as $country){ ?>
                           <option data-id="<?php echo $country['id']; ?>" value="<?php echo $country['country']; ?>" <?php if($country['country'] == 'India') { echo 'selected'; }?>><?php echo $country['country']; ?></option>
                           <?php } ?>
                           </select>
                           </span>  
                           <p class="err text-center" id="Contact-country" style="display: none;"></p>
                        </div>
                        <div class="form-group" style="margin-top:30px">
                           <label> State <br>
                           <span class="wpcf7-form-control-wrap your-state"></label>
                           <select id="state" name="state" class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required" onchange="get_state_city('2')">
                           <?php echo $state_options; ?>
                           </select>
                           </span>    
                        </div>
                        <div class="form-group" style="margin-top:30px">
                           <label>
                              City <br>
                              <span class="wpcf7-form-control-wrap your-city">
                           </label>
                           <select id="city" name="city" class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required">
                           <option value="" disabled selected>Select your city</option>
                           </select>
                           </span>    
                        </div>
						<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                        <div class="form-group" style="margin-top:23px;">
                           <label> Your Message *<br>
                           <span class="wpcf7-form-control-wrap your-message"></label>
                           <textarea name="message" cols="40" rows="5" class="form-control wpcf7-form-control wpcf7-textarea"></textarea>
                           </span>
                           <p class="err text-center" id="Contact-message" style="display: none;"></p>
                           </p>
                           <div class="btn-wrap">
                              <input value="Send" class="btn-cart2" type="submit">
                           </div>
                           </div>
                     </form>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>
@stop
@section('javascript')
@parent
	<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}" async defer></script>
	<script type="text/javascript">
	window.history.pushState("", "", "/contact-us");

	$('#country').select2();
	$('#state').select2();
	$('#city').select2();

	
	
	  $('#SaveContact').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        if($('#g-recaptcha-response').val() == ''){

                    // Call reCAPTCHA verification before form submission
                    
                        grecaptcha.execute("{{  env('RECAPTCHA_SITE_KEY') }}", { action: "save-contact" }).then(function(token) {
                            // Set the token to the hidden input field
                            $('#g-recaptcha-response').val(token);
            
                            // Now submit the form via AJAX
                            ContactFormonSubmit();
                        });
                    
        }else{
            ContactFormonSubmit();
        }
        
     });
       
	
	function ContactFormonSubmit() { 
		setPhoneValues();
		
		$('.PleaseWaitDiv').show();
		var formdata = $("#SaveContact").serialize();
		$.ajax({
			url: "/save-contact",
			type:'POST',
			data: formdata,
			success: function(data) {
				$('.PleaseWaitDiv').hide();
				if(!data.status){
					if(data.type=="validation"){
						var err_no = 0;
						$.each(data.errors, function (i, error) {
							err_no = err_no + 1;
							$('#Contact-'+i).attr('style', 'color:red!important');
							$('#Contact-'+i).html(error);
							if(err_no  == 1) { $('#con-'+i).focus(); }
							setTimeout(function () {
								$('#Contact-'+i).css({
								'display': 'none'
								});
							}, 5000);
						});
					}
				}else{
					window.location.href= data.url;
				}
			}
		});
		// Submit the form
		// form.submit();
	}
	function get_state_city(action){  
		var country = $('#country').find(":selected").attr("data-id");  
		if(action == 2){
			var state = $('#state').find(":selected").attr("data-id"); 
		}else{
			var state = '';
			const el = $('#country');
			setTimeout(() => {
			el.select2('close');
			el.blur(); 
			}, 10);
		} 
		$.ajax({
			url: "{{ url('get-state-city') }}",
			type:'GET',
			data: { country:country,state:state,action:action },
			success:function(resp){ 
				if(action =='1'){ 
					$("#state").html(resp);
					$("#city").html('');
				}
				if(action =='2'){
					$("#city").html(resp);
				}								 
				},
				error:function(){
			    }	
		});
	}	
	</script>
	<script src="assets/js/intlTelInput.min.js"></script>
	<script src="assets/js/utils.js"></script>
	<script>
	const itiInput = document.getElementById("iti_phone_input");
	const countryNameDisplay = document.getElementById("country_name_display");
	
	// Get all country data, sort by name alphabetically
	const allCountries = window.intlTelInputGlobals.getCountryData();
	allCountries.sort((a, b) => a.name.localeCompare(b.name));
	
	// Extract ISO2 codes in sorted order
	const sortedCountryCodes = allCountries.map(c => c.iso2);
	
	// Initialize intl-tel-input
	const iti = window.intlTelInput(itiInput, {
		initialCountry: "in",
		separateDialCode: true,
		utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.3.5/js/utils.js",
		onlyCountries: sortedCountryCodes // this preserves alphabetical order
	});
	
	// Update hidden fields before submit
	function setPhoneValues() {
		const countryData = iti.getSelectedCountryData();
		document.getElementById("iti_country_code").value = "+" + countryData.dialCode;
		document.getElementById("iti_mobile_number").value = itiInput.value;
	}
	
	// Update country name and hidden country code dynamically on country change
	itiInput.addEventListener("countrychange", function() {
		const countryData = iti.getSelectedCountryData(); 
		var country_name = countryData.name; 
		//$("#country").val(country_name); alert(country_name);
		//$('#country').val(country_name).trigger('change');
		var option = new Option(country_name,country_name, true, true);
		//$('#country').append(option).trigger('change.select2');
		//get_state_city(1);
	});
	</script>
	@stop