
<section class="dashboard--pg">
	<div class="container">
		<div class="row accTabsInfo">
			@if(isset($_GET['r']) && $_GET['r'] =="success")
						<div class="alert alert-success alert-dismissible">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Success!</strong> Profile has been updated successfully! 
						</div>
					@endif
			
			<div class="col-sm-4 col-12 billing">
				<div class="my-profile-data ">
					
					<!-- <h4 class="booster-font">My Profile</h4><hr />  -->
					<h5>Hello {{Auth::user()->name}},</h5>
					<hr />
					<p><b>Email Id:</b> <span class="my-info" id="Admin_email_address">{{Auth::user()->email}}</span> <!-- <a href="javascript:;" style="color:blue" class="email_update" id="email_update"> Edit </a>  --></p>
					<p><b>Phone No:</b> <span class="my-info">+91-{{Auth::user()->mobile}}</span></p>
					<p><b>Address:</b> <span class="my-info">{{Auth::user()->address}}</span></p>
					<p>@if(!empty(Auth::user()->city)) {{Auth::user()->city}},@endif @if(!empty(Auth::user()->state)) {{Auth::user()->state}}, @endif {{Auth::user()->postcode}}</p>
				</div>
			</div>

			<!-- <div class="col-12 mt-4">
			</div> -->
			<div class="col-sm-8 col-12 billing edit-prf">
				<h5 class="booster-font">Edit Profile</h5><hr />
				<form id="MyAccountform" autocomplete="off" action="javascript:;" method="post">@csrf
					@if(!empty(Auth::user()->loyalty_points))
					<div class="row">
					         <p id="profile-reward-points">🎁 You've earned {{ Auth::user()->loyalty_points }} Reward Points — redeemable on your next purchase!</p>
					</div>
					@endif
					
					<div class="row">
						<div class="form-group">
							<span class="edit-prf-lable"> Name :</span>
							<input type="text" name="name" class="input-style form-control" placeholder="Enter Name" value="{{Auth::user()->name}}" />
							<p class="err text-center" id="MyAccount-name" style="display: none;"></p>
						</div>
						
						<div class="form-group">
							<span class="edit-prf-lable">Mobile :</span>
							<input type="number" name="mobile" class="input-style form-control" placeholder="Enter Mobile" value="{{Auth::user()->mobile}}"/>
							<p class="err text-center" id="MyAccount-mobile" style="display: none;"></p>
						</div>
						
						<div class="form-group">
							<span class="edit-prf-lable">Mobile :</span>
							<input type="number" name="alternative_number" class="input-style form-control" placeholder="Enter Alternative Mobile" value="{{Auth::user()->alternative_number}}"/>
							<p class="err text-center" id="MyAccount-alternative_number" style="display: none;"></p>
						</div>
						
						
						
						
						
						
					<!--	<div class="form-group">
							<span> Date of Birth :</span>
							<input type="date" name="dob" class="input-style form-control" placeholder="" value="{{Auth::user()->dob}}" />
							<p class="err text-center" id="MyAccount-dob" style="display: none;"></p>
						</div> -->
						<div class="form-group">
							<span class="edit-prf-lable">Country :</span>
							<select  class="form-control" name="">
								<option value="India" selected>India</option>
							</select>
							<!--<input type="text" class="input-style form-control" name="state" placeholder="Enter State" value="{{Auth::user()->state}}"/>-->
							<p class="err text-center" id="MyAccount-country" style="display: none;"></p>
						</div>
						<div class="form-group">
							<span class="edit-prf-lable">Postcode :</span>
							<input type="text" class="input-style form-control user_pincode" name="postcode" placeholder="Enter Postcode" value="{{Auth::user()->postcode}}"/>
							<p class="err text-center" id="MyAccount-postcode" style="display: none;"></p>
						</div>
						<div class="form-group">
							<span class="edit-prf-lable">State :</span>
							<select  class="form-control user_state" name="state">
							<option value=""> Select </option>
							@foreach($states as $state)
								<option value="{{$state}}" <?php if(Auth::user()->state==$state){ echo "selected"; } ?>>{{$state}}</option>
							@endforeach
							</select>
							<!--<input type="text" class="input-style form-control" name="state" placeholder="Enter State" value="{{Auth::user()->state}}"/>-->
							<p class="err text-center" id="MyAccount-state" style="display: none;"></p>
						</div>
						<div class="form-group">
							<span class="edit-prf-lable">City :</span>
							<input type="text" class="input-style form-control user_city" name="city" placeholder="Enter City" value="{{Auth::user()->city}}" />
							<p class="err text-center" id="MyAccount-city" style="display: none;"></p>
						</div>
						
						<div class="form-group address">
							<span class="edit-prf-lable">Address</span>
							<textarea class="input-style form-control" name="address" rows="3" placeholder="Enter Adresss">{{Auth::user()->address}}</textarea>
							<p class="err text-center" id="MyAccount-address" style="display: none;"></p>
						</div>
						
						<?php /*<div class="form-group">
							<span>Accound Status :</span>
							<select class="form-control" name="user_accound_status">
							<option value="1" <?php if(Auth::user()->user_accound_status== '1'){ echo 'selected'; } ?>>Active </option>
							<option value="0" <?php if(Auth::user()->user_accound_status== '0'){ echo 'selected'; } ?>>Deactive </option>
							</select>
							<p class="err text-center" id="MyAccount-postcode" style="display: none;"></p>
						</div>*/ ?>
						<div class="clearfix"></div>
						<div class="col-md-12 col-12 mt-3">
			                <div class="alert alert-danger print-error-msg text-center" style="display:none">
			                    <ul></ul>
			                </div>
			                <button type="submit" class="accound_btn-style">Update</button>
			            </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<!-- Email update Model start -->

<div class="modal fade popup-options" id="user_email_update" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">

	<div class="modal-dialog modal-lg">
	
		<div class="modal-content">
			<!-- Modal Header -->
			
			<div class="modal-header">
				<h4 class="modal-title">Email Update</h4>
				
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				 
			</div>
			<div id="EmailUpdateresult" class="text-center"> </div>
			<!-- Modal body -->
			
			<form id="EmailUpdateForm" action="javascript:;" method="post">@csrf
			
				<div class="modal-body">
					<div class="col-sm-12 col-12">
						<div class="row">
							<div class="col-sm-12 col-12 form-group">
								<input type="text" class="input-style form-control" name="new_email" id="new_email"  placeholder="Enter New Email Address" />
								<p class="err text-center" id="EmailUpdate-new_email" style="display: none;"></p>
							</div>
							
							<div class="col-sm-12 col-12 form-group" style="display: none;" id="otp_field">
								<input type="email" class="input-style form-control" name="otp" id="otp"  placeholder="Otp" />
								<p class="err text-center" id="EmailUpdate-otp" style="display: none;"></p>
							</div>
							
						
							
						</div>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer" id="Genreateotpbutton">
					<button type="submit" id="Genreate_otp_button" class="btn-style save-btn">Generate Otp
                     </button>
				</div>
				<div class="modal-footer" style="display:none" id="Updateemailbutton">
					<button type="submit" id="Update_email_button" class="btn-style save-btn">Update Email
                     </button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Email update Model end -->

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>
	var accounturl = '/account/dashboard';
	window.history.pushState({path:accounturl},'',accounturl);
	//Register 
	$("#MyAccountform").submit(function(e){ 
        e.preventDefault();
        //$('.PleaseWaitDiv').show();
        var formdata = $("#MyAccountform").serialize(); 
        $.ajax({ 
            url: '/submit-account-details',
            type:'POST',
            data: formdata,
            success: function(data) { 
                $('.PleaseWaitDiv').hide();
                if(!data.status){
        			$.each(data.errors, function (i, error) { 
        			 	$('#MyAccount-'+i).attr('style', '');
        			 	$('#MyAccount-'+i).html(error); 
        			 	setTimeout(function () {
        			 		$('#MyAccount-'+i).css({
        			 			'display': 'none'
        			 		});
        			 	}, 9000);
		            });
            	}else{
            		window.location.href = '/account/dashboard?r=success';
            	}
            }
        });
    });
	$(".email_update").click(function(){ 
      $('#user_email_update').modal('show');
    });
	
	$('#Genreate_otp_button').click(function(e){
         e.preventDefault();
		 var formdata = $("#EmailUpdateForm").serialize();
		 $.ajax({
            url: '/genreate-otp',
            type:'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if(!data.status){
        			$.each(data.errors, function (i, error) {
        			 	$('#EmailUpdate-'+i).attr('style', 'color:red');
        			 	$('#EmailUpdate-'+i).html(error);
        			 	setTimeout(function () {
        			 		$('#EmailUpdate-'+i).css({
        			 			'display': 'none'
        			 		});
        			 	}, 3000);
		            });
            	}else{
					$('#EmailUpdateresult').attr('style', 'color:green');
            		$('#EmailUpdateresult').html(data.message);
					$('#otp_field').attr('style', 'display:block'); 
					$('#Genreateotpbutton').attr('style', 'display:none'); 
					$('#Updateemailbutton').attr('style', 'display:block'); 
					  setTimeout(function () {
        			 		$('#EmailUpdateotp').css({
        			 			'display': 'none'
        			 		});
        			 	}, 3000);
            	}
            }
        });
	});
	
	$('#Update_email_button').click(function(e){
		 e.preventDefault();
		 var formdata = $("#EmailUpdateForm").serialize();
		 $.ajax({
            url: '/update-email',
            type:'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if(!data.status){
        			$.each(data.errors, function (i, error) {
        			 	$('#EmailUpdate-'+i).attr('style', 'color:red');
        			 	$('#EmailUpdate-'+i).html(error);
        			 	setTimeout(function () {
        			 		$('#EmailUpdate-'+i).css({
        			 			'display': 'none'
        			 		});
        			 	}, 3000);
		            });
            	}else{
					if(data.type == 'otp'){
						$('#EmailUpdateresult').attr('style', 'color:red');
						$('#EmailUpdateresult').html(data.message);
						setTimeout(function () {
        			 		$('#EmailUpdateresult').css({
        			 			'display': 'none'
        			 		});
        			 	}, 3000);
					}else{
						$("#EmailUpdateForm").trigger("reset");
						$("#Admin_email_address").html(data.new_email);
					    $('#EmailUpdateresult').attr('style', 'color:green');
						$('#EmailUpdateresult').html(data.message);
						setTimeout(function () {
        			 		$('#EmailUpdateresult').css({
        			 			'display': 'none'
        			 		});
        			 	}, 3000);
					}
            	}
            }
        });
	});
	
	
	
	
	
		
</script>
@stop