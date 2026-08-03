@extends('layouts.frontLayout.front-layout')
@section('content') 
<main>
<div class="site-main  main-container no-sidebar login-pg contactforms feedback">
  <div class="section-037">
    <div class="container">
      <div class="rage-popupvideo style-01">
       <!--  <div class="row">
          <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home&nbsp;/&nbsp;</a></li>
            <li class="active">feedback</li>
          </ol>
        </div> -->
        <div class="row">
          <!-- <div class="col-md-12 col-xl-10 col-lg-12">
                <h4 class="az_custom_heading">GET IN TOUCH</h4>
                <hr>
          </div> -->
          <div class="col-md-12 col-xl-12 col-lg-12">
            <div class="row">
              <!-- <div class="col-md-6">
                <div class="feedback-txt">
                  <p>
                    <span class="d-block mb-3"><i class="fa fa-map-marker" aria-hidden="true"></i>HA-54 PHASE 6 FOCAL POINT LUDHIANA 141010</span>
                    <a href="tel +91 7986158756"><span class="d-block mb-3"><i class="fa fa-phone" aria-hidden="true"></i> 7986158756 </span></a>
                   
                  <h6 class="az_custom_heading mt-4 mb-3">For any information or questions</h6>
                  <p><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:rageindiaonline@gmail.com">r</a>ageindiaonline@gmail.com</p>
                </div>
              </div> -->

              <div class="col-md-6 col-12 contact-details-1">
                <div class="addressSec">
              <h3 class="az_custom_heading">GET IN TOUCH</h3>
                  <div class="contact-txt">
                      <?php /* <p>HB-3, Phase -VI, Focal Point , Ludhiana, Punjab<br> */ ?>
                      <p><i class="fas fa-map-marker-alt"></i> HA-54 PHASE 6 FOCAL POINT LUDHIANA 141010</p>
                    <p><i class="fas fa-phone-alt"></i> <a href="tel:+91 79861 58756"> +91 79861 58756 </a></p>
                    <!-- <p><i class="fa fa-fax" aria-hidden="true"></i>5095458 F: +91-161-2672517</p> -->

                      <p><i class="fas fa-envelope"></i><a href="mailto:rageindiaonline@gmail.com">rageindiaonline@gmail.com</a></p>
                   </div>
              </div>
            </div>

              <div class="col-md-6 register-form mbl-res contact-form-1">
                <h3>FEEDBACK</h3>
                <div role="form" class="wpcf7">
				 @if(isset($_GET['s']))
				  <div class="alert alert-success alert-dismissible">Your infomation has been submitted successfully.<br>We will get back to you soon.<span></span></div>
				 @endif 
                   <form class="rage-form wpcf7-form" id="SaveContact" action="javascript:;" method="post">@csrf
                  
                    <div class="form-group form-row">
                      <label class="w-100 ml-0"> Name *<br>
                        <span class="wpcf7-form-control-wrap your-name">
                        <input name="name" id="con-name" size="40" class="form-control wpcf7-form-control wpcf7-text wpcf7-validates-as-required" type="text">
                        </span> </label>
						            <p class="err text-center" id="Contact-name" style="display: none;"></p>   
                    </div>
                    <div class="form-group form-row">
                      <label class="w-100 ml-0"> Email *<br>
                        <span class="wpcf7-form-control-wrap your-email">
                        <input name="email" id="con-email" size="40" class="form-control wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" type="text">
                        </span> </label>
						 <p class="err text-center" id="Contact-email" style="display: none;"></p>   
                    </div>
					<div class="form-group form-row">
                      <label class="w-100 ml-0"> Mobile *<br>
                        <span class="wpcf7-form-control-wrap your-email">
                        <input name="mobile" id="con-mobile" size="40" class="form-control wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" type="text">
                        </span> </label>
						 <p class="err text-center" id="Contact-mobile" style="display: none;"></p>   
                    </div>
                    <div class="form-group form-row">
                      <label class="w-100 ml-0"> Your Message *<br>
                        <span class="wpcf7-form-control-wrap your-message">
                        <textarea name="message" cols="40" rows="3" class="form-control wpcf7-form-control wpcf7-textarea"></textarea>
                        </span> </label>
						<p class="err text-center" id="Contact-message" style="display: none;"></p>    
                    </div>
                    <div class="form-group">
                      <input value="Send" class="wpcf7-form-control wpcf7-submit btn-cart2" type="submit">
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
    window.history.pushState("", "", "/feedback");
    //Guest Checkout
    $("#SaveContact").submit(function(e){
        e.preventDefault();
        $('.PleaseWaitDiv').show();
        var formdata = $("#SaveContact").serialize();
        $.ajax({
            url: "/save-feedback",
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
    });
</script>
@stop