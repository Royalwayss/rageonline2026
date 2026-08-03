@extends('layouts.frontLayout.front-layout') @section('content')
<style>
.register-btn {
  cursor: pointer;
}

.login-btn {
  cursor: pointer;
}

.ui-datepicker-month {
  width: 50px;
}

.ui-datepicker-year {
  width: 83px !important;
}

@media only screen and (max-width: 360px) {
  /* .login-pg .login-form {
    padding: 2rem;
    margin-bottom: 2rem;
  }
  .login-pg .register-form {
    padding: 2rem;    
  }
  .login-pg .lgn-pg-btn {
    display: block;
      width: 100%;
    padding: 1rem 3.5rem;
  }
  .rage-LostPassword {
    margin-top: 1rem;
      text-align: right;
  } */
}
</style>
<main>
  <div class="container auto-container login-pg login-register">
    <div class="row login-main-row">
      <div class="main-content col-md-12">
        <div class="page-main-content">
                  <!-- Tabs -->
          <div class="auth-tabs">
            <button id="showLogin" class="tab-btn active">Login</button>
            <button id="showRegister" class="tab-btn">Register</button>
          </div>
          <div class="rage form-wrapper">
            <div class="rage-notices-wrapper"></div>
            <div class="u-columns col2-set" id="customer_login">
              <div class="row justify-content-center">
                <div class="u-column1 col-lg-6 form-box active" id="loginForm">
                  <div class="login-form">
                    <h2>Login</h2>
                    <!--  <form><div class="form-group"><label for="exampleInputEmail1">Email address</label><input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"><small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small></div><div class="form-group"><label for="exampleInputPassword1">Password</label><input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"></div><div class="form-group form-check"><input type="checkbox" class="form-check-input" id="exampleCheck1"><label class="form-check-label" for="exampleCheck1">Check me out</label></div><button type="submit" class="btn btn-primary">Submit</button></form> -->
                    <form class="rage-form rage-form-login login" id="SignInForm" action="javascript:;"> @csrf
                      <div class="alert-message alert alert-danger print-error-msg login-err-message">
                        <ul class="mb-0"></ul>
                      </div>
                      <div class="alert-message alert alert-success print-success-msg login-message">
                        <ul class="mb-0"></ul>
                      </div>
                      <div class="form-group row rage-form-row rage-form-row--wide form-row form-row-wide">
                        <!-- <label class="col-lg-12 ml-0" for="email">Email Address&nbsp; <span class="required">*</span> </label> -->
                        <input type="text" placeholder="Email Address*" class="form-control col-lg-12 rage-Input rage-Input--text input-text" name="email" id="email" autocomplete="username" value="">
                        <div class="err" id="Login-email"></div>
                      </div>
                      <div class="form-group row rage-form-row rage-form-row--wide form-row form-row-wide">
                        <!-- <label class="col-lg-12 ml-0" for="password">Password&nbsp; <span class="required">*</span> </label> -->
                        <input class="form-control col-lg-12 rage-Input rage-Input--text input-text"  placeholder="Password*" type="password" name="password" id="password" autocomplete="current-password">
                        <div class="err" id="Login-password"></div>
                      </div>
                      <p class="form-row">
                        <input type="hidden" id="rage-login-nonce" name="rage-login-nonce" value="832993cb93">
                        <input type="hidden" name="_wp_http_referer" value="/rage/my-account/">
                        <div class="row align-items-center row-lost">
                          <div class="col-lg-4 col-6">
                              <button type="submit" class="btn-cart2" name="login" value="Log in">Submit</button>
                          </div>
                          <div class="col-lg-8 col-6">
                            <p class="rage-LostPassword lost_password text-right"> <a href="{{ url('forgot-password') }}">Lost your password?</a> </p>
                          </div>
                        </div>
                        <!-- <label class="rage-form__label rage-form__label-for-checkbox inline"> -->
                          <?php /* 
                                  <input class="rage-form__input rage-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever">
                                    <span>Remember me</span>
                                  </label> */ ?>
                      </p>
                      
                    </form>
                  </div>
                </div>
                <div class="u-column2 form-box col-lg-6" id="registerForm" class="">
                  <div class="register-form">
                    <h2>Register</h2>
                    <form class="rage-form rage-form-register register" id="RegisterForm" action="javascript:;">@csrf
                      <div class="alert-message alert alert-success print-success-msg register-message">
                        <ul class="mb-0"></ul>
                      </div>
                      <div class="form-group row rage-form-row rage-form-row--wide form-row form-row-wide">
                        <!-- <label class="col-lg-12 ml-0" for="reg_name">Name&nbsp; <span class="required">*</span> </label> -->
                        <input type="text" class="form-control col-lg-12 rage-Input rage-Input--text input-text" name="name" id="reg_name" autocomplete="off" value="" placeholder="Name*">
                        <div class="err" id="Register-name"></div>
                      </div>
                      <div class="form-group row rage-form-row rage-form-row--wide form-row form-row-wide">
                        <!-- <label class="col-lg-12 ml-0" for="reg_email">Email Address&nbsp; <span class="required">*</span> </label> -->
                        <input type="text" class="form-control col-lg-12 rage-Input rage-Input--text input-text" name="email" id="reg_email" value="" placeholder="Email Address*">
                        <div class="err" id="Register-email"></div>
                      </div>
                      <div class="form-group row rage-form-row rage-form-row--wide form-row form-row-wide">
                        <!-- <label class="col-lg-12 ml-0" for="reg_mobile">Mobile*&nbsp; <span class="required">*</span> </label> -->
                        <input type="text" class="form-control col-lg-12 rage-Input rage-Input--text input-text" name="mobile" id="reg_mobile" value="" placeholder="Mobile*">
                        <div class="err" id="Register-mobile"></div>
                      </div>
                      <div class="form-group row rage-form-row rage-form-row--wide form-row form-row-wide">
                        <!-- <label class="col-lg-12 ml-0" for="datepicker">DOB (DD/MM/YYYY)&nbsp;</label> -->
                        <input type="text" class="form-control col-lg-12 rage-Input rage-Input--text input-text" name="dob" id="datepicker" value="" placeholder="DOB (DD/MM/YYYY)">
                        <div class="err" id="Register-dob"></div>
                      </div>
                      <div class="form-group row rage-form-row rage-form-row--wide form-row form-row-wide">
                        <!-- <label class="col-lg-12 ml-0" for="reg_password">Enter your Password *&nbsp; <span class="required">*</span> </label> -->
                        <input type="password" class="form-control col-lg-12 rage-Input rage-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" value="" placeholder="Password*">
                        <div class="err" id="Register-password"></div>
                      </div>
                      <div class="rage-privacy-policy-text">
                        <p class="privacy-txt">Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="{{ url('privacy-policy') }}" class="rage-privacy-policy-link" target="_blank">privacy policy</a>. </p>
                      </div>
                      <p class="rage-FormRow form-row">
                        <button type="submit" class="btn-cart2 registerform" name="register" value="Register">Submit </button>
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
</main>
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js') }}"></script>
<script>
$(function() {
  $("#datepicker").datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    yearRange: '-70:+70'
  });
});
</script>
<script>
$(document).ready(function() {
  $("#SignInForm").submit(function(e) {
    e.preventDefault();
    var formdata = $("#SignInForm").serialize();
    $.ajax({
      url: "/login",
      type: 'POST',
      data: formdata,
      success: function(data) {
        if(!data.status) {
          if(data.type == "validation") {
            var err_no = 0;
            $.each(data.errors, function(i, error) {
              err_no = err_no + 1;
              $('#Login-' + i).attr('style', 'color:red');
              $('#Login-' + i).html(error);
              if(err_no == 1) {
                $("#" + i).focus();
              }
              setTimeout(function() {
                $('#Login-' + i).css({
                  'display': 'none'
                });
              }, 3000);
            });
          } else {
            var msg = [];
            msg[0] = data.errors;
            printErrorMsg(msg, 'login-err-message');
            $('.login-err-message').delay(3000).fadeOut('slow');
          }
        } else {
          var msg = [];
          msg[0] = data.message;
          printSuccessMsg(msg, 'login-message');
          $('.login-message').delay(3000).fadeOut('slow');
          setTimeout(function() {
            window.location.href = data.url;
          }, 3000);
        }
      }
    });
  });
  $("#RegisterForm").submit(function(e) {
    e.preventDefault();
    var formdata = $("#RegisterForm").serialize();
    $.ajax({
      url: "register",
      type: 'POST',
      data: formdata,
      success: function(data) {
        $('.PleaseWaitDiv').hide();
        if(!data.status) {
          if(data.type == "validation") {
            var err_no = 0;
            $.each(data.errors, function(i, error) {
              err_no = err_no + 1;
              $('#Register-' + i).attr('style', 'color:red!important');
              $('#Register-' + i).html(error);
              if(err_no == 1) {
                $("#reg_" + i).focus();
              }
              setTimeout(function() {
                $('#Register-' + i).css({
                  'display': 'none'
                });
              }, 3000);
            });
          }
        } else {
          var msg = [];
          msg[0] = data.message;
          printSuccessMsg(msg, 'register-message');
          $('#RegisterForm')[0].reset();
          $('.register-message').delay(4000).fadeOut('slow');
          $("#reg_name").focus();
          setTimeout(function() {
            window.location.href = data.url;
          }, 3000);
        }
      }
    });
  });
});
</script> @stop