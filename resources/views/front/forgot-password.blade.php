@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page">
    <section class="auth-page">
        <div class="container">
            <div class="auth-box" data-aos="fade-up" data-aos-duration="600">

                <div class="auth-head">
                    <span>Account Recovery</span>
                    <h1>Forgot Password</h1>
                    <p>Enter your registered email address and we'll send you instructions to reset your password.</p>
                </div>

                <form class="rage-form" id="ForgotPwdForm" action="javascript:;">
                    @csrf

                    <div class="alert-message alert alert-success print-success-msg">
                        <ul class="mb-0"></ul>
                    </div>

                    <div class="form-field">
                        <label for="email">Email Address</label>
                        <input type="text" class="form-control forgot-email" name="email" id="email" autocomplete="username" placeholder="Enter your registered email">
                        <div class="err" id="forgot-email"></div>
                    </div>

                    <button type="submit" class="primary-btn w-100 mt-3">
                        Submit
                    </button>

                </form>

                <div class="auth-bottom">
                    <span>Remembered your password?</span>
                    <a href="{{ url('login') }}">Login Here</a>
                </div>

            </div>
        </div>
    </section>
</main>

<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
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