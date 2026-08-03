@extends('layouts.frontLayout.front-layout')
@section('content')
<main>
<div class="site-main  main-container no-sidebar franchiseForm-div">
  <div class="section-037">
    <div class="container">
      <div class="rage-popupvideo style-01">
        <!-- <div class="row">
          <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home&nbsp;/&nbsp;</a></li>
            <li class="active">Franchise Enquiry</li>
          </ol>
        </div> -->
         <div class="row justify-content-center">
					
					<div class="col-sm-12">
						<div class="franchise-form">
							<div class="row">
								<div class="col-xs-12 col-sm-12">
									<h3>Franchise Enquiry</h3>
									<hr>
									<p class="black">All fields marked with an (*) are mandatory</p>
								</div>
								<div class="col-xs-12 col-sm-12">
								 @if(isset($_GET['s']))
									<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Your infomation has been submitted successfully.We will get back to you soon.<span></span></div>
								@endif 
									<form  name="franchiseForm" id="franchiseForm" method="post" action="javascript:;" >@csrf
										<div class="row">
											<div class="col-md-6 col-sm-12 col-xs-12 mg-top-10">
									            <h4>Your Details</h4><hr>
									            <div class="form-group">
									                <label>Name of Party* :</label>
									                <input type="text" class="form-control" name="name_of_party" id="fe-name_of_party">
													<p style="display:none" class="err" id="Franchise-name_of_party"></p>
									            </div>
									            <div class="form-group">
									                <label>Address* :</label>
									                <input type="text" class="form-control" name="address_of_party" id="fe-address_of_party">
													<p style="display:none" class="err" id="Franchise-address_of_party"></p>
									            </div>
									            <div class="form-group">
									                <label>City / State* :</label>
									                <input type="text" class="form-control" name="city_of_party" id="fe-city_of_party">
													<p style="display:none" class="err" id="Franchise-city_of_party"></p>
									            </div>
									            <div class="form-group">
									                <label>Phone* :</label>
									                <input type="text" class="form-control" name="phone_of_party" id="fe-phone_of_party" >
													<p style="display:none" class="err" id="Franchise-phone_of_party"></p>
									            </div>
									        </div>
									        <div class="col-md-6 col-sm-12 col-xs-12 mg-top-20">
												<h4>Area Location Details</h4><hr>
												<div class="form-group">
													<label>Other Profile :</label>
													<input type="text" class="form-control" name="profile1"  id="fe-profile1" >
												</div>
												<div class="form-group">
													<label>Other Profile :</label>
													<input type="text" class="form-control" name="profile2"  id="fe-profile2" >
												</div>
												<div class="form-group">
													<label>Competitors Presence :</label>
													<textarea cols="40" rows="1" class="form-control" name="competitor" id="fe-competitor"></textarea>
													<p style="display:none" class="err" id="Franchise-competitor"></p>
												</div>
												<div class="form-group">
													<label>Mode of Operation* :</label>
													<input type="text" class="form-control" name="mode_of_operation" id="fe-mode_of_operation">
													<p style="display:none" class="err" id="Franchise-mode_of_operation"></p>
												</div>
											</div>
								        </div>
								        <div class="row">
								        	<div class="col-md-6 col-sm-12 col-xs-12 mg-top-10">
												<h4>Showroom Details</h4><hr>
												<div class="form-group">
													<label>Name of Showroom* :</label>
													<input type="text" class="form-control" name="showroom_name"  id="fe-showroom_name" >
													<p style="display:none" class="err" id="Franchise-showroom_name"></p>
												</div>
												<div class="form-group">
													<label>Address* :</label>
													<input type="text" class="form-control" name="showroom_address"  id="fe-showroom_address" >
													<p style="display:none" class="err" id="Franchise-showroom_address"></p>
												</div>
												<div class="form-group">
													<label>Phone* :</label>
													<input type="text" class="form-control" name="showroom_phone"  id="fe-showroom_phone" >
													<p style="display:none" class="err" id="Franchise-showroom_phone"></p>
												</div>
												<div class="form-group">
													<label>Floor* :</label>
													<input type="text" class="form-control" name="floor1"  id="fe-floor1" >
													<p style="display:none" class="err" id="Franchise-floor1"></p>
												</div>
												<div class="form-group">
													<label>Frontage* :</label>
													<input type="text" class="form-control" name="frontage"  id="fe-frontage" >
													<p style="display:none" class="err" id="Franchise-frontage"></p>
												</div>
												<div class="form-group">
													<label>Depth* :</label>
													<input type="text" class="form-control" name="depth"  id="fe-depth" >
													<p style="display:none" class="err" id="Franchise-depth"></p>
												</div>
												<div class="form-group">
													<label>Area* :</label>
													<input type="text" class="form-control" name="area"  id="fe-area" >
													<p style="display:none" class="err" id="Franchise-area"></p>
												</div>
											</div>
								        	<div class="col-md-6 col-sm-12 col-xs-12 mg-top-20">
									            <h4>Business Details</h4><hr>
									            <div class="form-group">
									                <label>Prop./Partners/Directors* :</label>
									                <input type="text" class="form-control" name="prop"  id="fe-prop" >
													<p style="display:none" class="err" id="Franchise-prop"></p>
									            </div>
									            <div class="form-group">
									                <label>Father's Name* :</label>
									                <input type="text" class="form-control" name="father_name"  id="fe-father_name" >
													<p style="display:none" class="err" id="Franchise-father_name"></p>
									            </div>
									            <div class="form-group">
									                <label>Res. Address* :</label>
									                <textarea cols="40" rows="1" class="form-control" name="res_address"  id="fe-res_address" ></textarea>
													<p style="display:none" class="err" id="Franchise-res_address"></p>
									            </div>
									            <div class="form-group">
									                <label>Mobile* :</label>
									                <input type="text" class="form-control" name="mobile"  id="fe-mobile" >
													<p style="display:none" class="err" id="Franchise-mobile"></p>
									            </div>
									            <div class="form-group">
									                <label>Phone* :</label>
									                <input type="text" class="form-control" name="phone"  id="fe-phone" >
													<p style="display:none" class="err" id="Franchise-phone"></p>
									            </div>
									            <div class="form-group">
									                <label>E-mail* :</label>
									                <input type="text" class="form-control" name="email"  id="fe-email" >
													<p style="display:none" class="err" id="Franchise-email"></p>
									            </div>
									        <?php /*    <div class="form-group">
													<label>Enter Captcha</label>
													<p><img src="
														captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></p>
													<p><input type="text" class="form-control" placeholder="Enter Captcha" size="6" maxlength="5" name="captcha" value=""></p>
												</div> */ ?>
								        	</div>
											
									        <div class="col-xs-12 col-sm-12 mg-top-20">
												<input type="submit" class="btn signbtn lgn-pg-btn theme-bg-color float-right d-sm-block" value="Submit" name="btnSubmit">
									        </div>
							    		</div>
							    	</form>
								</div>
							</div>	
						</div>
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
<script type="text/javascript">
    window.history.pushState("", "", "/franchise-enquiry");
    //Guest Checkout
    $("#franchiseForm").submit(function(e){
        e.preventDefault();
        $('.PleaseWaitDiv').show();
        var formdata = $("#franchiseForm").serialize();
        $.ajax({
            url: "/save-franchiseenquiry",
            type:'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if(!data.status){
                    if(data.type=="validation"){
						var err_no = 0;  $('.err').html('');
                        $.each(data.errors, function (i, error) {
							err_no = err_no + 1;
                            $('#Franchise-'+i).attr('style', 'color:red');
                            $('#Franchise-'+i).html(error);
							if(err_no  == 1) {   $('#fe-'+i).focus(); }
                            setTimeout(function () {
                                $('#Franchise1-'+i).css({
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
    });
</script>
@stop