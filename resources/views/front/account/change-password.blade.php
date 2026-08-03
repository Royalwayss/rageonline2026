<div class="row accTabsInfo chnge-pass">
	<div class="col-12">
		<h4 class="booster-font">Change Password</h4><hr />
	</div>
	<div class="col-sm-12 col-12 mt-3 p-0">
		<form id="MySettingsForm" action="javascript:;" method="post" autocomplete="off">@csrf
			<p class="err text-left" id="MyAccount-newsletter_subscription" style="display: none;"></p>
			<div class="alert alert-success print-success-msg" style="display:none">
	 			<ul></ul>
			</div>
			
			<div class="clearfix"></div>
			<div class="form-group" style="">
				<input type="password" name="current_password" class="input-style form-control" placeholder="Current Password"/>
				<p class="err text-center" id="ChangePwd-current_password" style="display: none;"></p>
			</div>
			<div class="clearfix"></div>
			<div class="form-group">
				<input type="password" name="password" class="input-style form-control" placeholder="New Password"/>
				<p class="err text-center" id="ChangePwd-password" style="display: none;"></p>
			</div>
			<div class="clearfix"></div>
			<div class="form-group">
				<input type="password" name="password_confirmation" class="input-style form-control" placeholder="Retype New Password"/>
				<p class="err text-center" id="ChangePwd-password_confirmation" style="display: none;"></p>
			</div>
			
			<div class="clearfix"></div>
			<div class="form-group">
				<button type="submit" class="accound_btn-style ">Change Password</button>
			</div>
			
		</form>
	</div>
</div>
@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>
	//Register 
	    $("#MySettingsForm").submit(function(e){
        e.preventDefault();
        $('.PleaseWaitDiv').show();
        var formdata = $("#MySettingsForm").serialize();
        $.ajax({
            url: '/change-password',
            type:'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if(!data.status){
        			$.each(data.errors, function (i, error) {
        			 	$('#ChangePwd-'+i).attr('style', 'color:red');
        			 	$('#ChangePwd-'+i).html(error);
        			 	setTimeout(function () {
        			 		$('#ChangePwd-'+i).css({
        			 			'display': 'none'
        			 		});
        			 	}, 3000);
		            });
            	}else{
            		printSuccessMsg(data.message);
	            	$('.print-success-msg').delay(2000).fadeOut('slow');
	            	$("#MySettingsForm").trigger("reset");
	            	$('#MySettingsForm').find('.processing').removeClass('processing');
	            	$('#my_settings').find('.updating').removeClass('updating');
            	}
            }
        });
    });
	
 function user_accound(status){
	 
      $('.PleaseWaitDiv').show();
	  $.ajax({
            url: '/newsletter-subscription-change',
            type:'get',
            data: {  status: status },    
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if(data.status){
        			 	$('#MyAccount-newsletter_subscription').attr('style', 'color:green');
        			 	$('#MyAccount-newsletter_subscription').html(data.message);
        			 	setTimeout(function () {
        			 		$('#MyAccount-newsletter_subscription').css({
        			 			'display': 'none'
        			 		});
        			 	}, 3000);
            	}
            }
        });
 }	 
</script>
@stop