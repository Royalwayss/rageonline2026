@extends('layouts.frontLayout.front-layout')
@section('content')
<div class="container login-pg forgot-pg">
   <div class="row forgot-row">
      <div class="main-content col-md-12">
         <div class="page-main-content">
            <div class="rage">
               <div class="rage-notices-wrapper"></div>
               <div class="u-columns col2-set" id="customer_login">
                  <div class="row justify-content-center">
                    <div class="u-column1 col-lg-5">
                      <div class="login-form">
                         <h2>Forgot Password</h2>
                         <form action="javascript:;" id="ForgotPwdForm">
                            @csrf
                            <div class="alert-message alert alert-success print-success-msg">
                               <ul class="mb-0"></ul>
                            </div>
                            <div class="form-group row rage-form-row rage-form-row--wide form-row form-row-wide">
                               <!-- <label class="col-lg-12 ml-0" for="email">Email Address&nbsp;<span class="required">*</span></label> -->
                               <input type="text" class="form-control col-lg-12 rage-Input rage-Input--text input-text forgot-email" placeholder="Email Address*" name="email" id="email" autocomplete="username" value="">
                            <div class="err" id="forgot-email"></div>
                            </div>
                            <p class="form-row">
                               <button type="submit" class="btn-cart2 r-btn" name="forgot-password" value="Forgot Password">Forgot Password</button>
                            </p>
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
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js') }}"></script>
<script>
   $(document).ready(function(){
      //Forgot Password
       $("#ForgotPwdForm").submit(function(e){ 
           e.preventDefault();
           var formdata = $("#ForgotPwdForm").serialize();
           $.ajax({
               url: "forgot-password",
               type:'POST',
               data: formdata,
               success: function(data) {
                   if(!data.status){
                  if(data.type=="validation"){
                    $.each(data.errors, function (i, error) {
                      $('#forgot-'+i).attr('style', 'color:red');
                      $('#forgot-'+i).html(error);
                      setTimeout(function () {
                        $('#forgot-'+i).css({
                          'display': 'none'
                        });
                      }, 3000);
                    });
                  }
                }else{
                  var msg = [];
            msg[0] = data.message;   
                  printSuccessMsg(msg);
                  $('.print-success-msg').delay(3000).fadeOut('slow');
                $('.forgot-email').val('');
                
                }
               }
           });
       });
   });
</script>
<script type="text/javascript" src="{{ asset('assets/js/custom.js')}}"></script>
@stop