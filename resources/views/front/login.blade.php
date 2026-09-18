@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page">
    <section class="auth-page">
        <div class="container">
            <div class="auth-box">

                <div class="auth-head">
                    <span>Welcome Back</span>
                    <h1>Login To Your Account</h1>
                    <p>Access your orders, wishlist and account details.</p>
                </div>

                <ul class="nav nav-pills login-tabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#emailLogin"
                            type="button">
                            Email Login
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#mobileLogin" type="button">
                            Mobile OTP
                        </button>
                    </li>
                </ul>

                <div class="tab-content">

                    <!-- EMAIL LOGIN -->
                    <div class="tab-pane fade show active" id="emailLogin">

                        <form class="rage-form rage-form-login login" id="SignInForm" action="javascript:;">
                            @csrf

                            <div class="alert-message alert alert-danger print-error-msg login-err-message">
                                <ul class="mb-0"></ul>
                            </div>
                            <div class="alert-message alert alert-success print-success-msg login-message">
                                <ul class="mb-0"></ul>
                            </div>

                            <div class="form-field">
                                <label for="email">Email Address</label>
                                <input type="text" class="form-control" name="email" id="email" autocomplete="username" placeholder="Enter your email">
                                <div class="err" id="Login-email"></div>
                            </div>

                            <div class="form-field">
                                <div class="field-head">
                                    <label for="password">Password</label>
                                    <a href="{{ url('forgot-password') }}">Forgot Password?</a>
                                </div>

                                <div class="password-toggle-wrap">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" autocomplete="current-password">
                                    <button type="button" class="pass-toggle-btn" onclick="togglePassVisibility('password', this);" title="Toggle visibility">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                                <div class="err" id="Login-password"></div>
                            </div>

                            <div class="form-check-row">
                                <label>
                                    <input type="checkbox">
                                    <span>Remember Me</span>
                                </label>
                            </div>

                            <button type="submit" class="primary-btn">
                                Login
                            </button>

                        </form>

                    </div>


                    <!-- MOBILE OTP LOGIN -->
                    <div class="tab-pane fade" id="mobileLogin">

                        <form action="my-profile.php">

                            <div class="form-field">
                                <label>Mobile Number</label>

                                <div class="mobile-input">
                                    <span>+91</span>

                                    <input type="tel" class="form-control" placeholder="Enter mobile number">
                                </div>
                            </div>

                            <button type="button" class="primary-btn">
                                Send OTP
                            </button>


                            <!-- SHOW AFTER OTP SENT -->
                            <div class="otp-area">

                                <div class="form-field">
                                    <label>Enter OTP</label>

                                    <div class="otp-inputs">
                                        <input type="text" maxlength="1">
                                        <input type="text" maxlength="1">
                                        <input type="text" maxlength="1">
                                        <input type="text" maxlength="1">
                                        <input type="text" maxlength="1">
                                        <input type="text" maxlength="1">
                                    </div>
                                </div>

                                <div class="otp-meta">
                                    <span>Didn't receive the code?</span>
                                    <button type="button">Resend OTP</button>
                                </div>

                                <button type="submit" class="primary-btn">
                                    Verify & Login
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

                <div class="auth-bottom">
                    <span>New to Rage?</span>
                    <a href="{{ url('register') }}">Create An Account</a>
                </div>

            </div>
        </div>
    </section>
</main>

<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js') }}"></script>

<script>
    function togglePassVisibility(id, btn) {
        const el = document.getElementById(id);
        const icon = btn.querySelector('i');
        if (el.type === 'password') {
            el.type = 'text';
            icon.className = 'fa-regular fa-eye-slash';
        } else {
            el.type = 'password';
            icon.className = 'fa-regular fa-eye';
        }
    }

    $(document).ready(function() {
        $("#SignInForm").submit(function(e) {
            e.preventDefault();
            var formdata = $("#SignInForm").serialize();
            $.ajax({
                url: "/login",
                type: 'POST',
                data: formdata,
                success: function(data) {
                    if (!data.status) {
                        if (data.type == "validation") {
                            var err_no = 0;
                            $.each(data.errors, function(i, error) {
                                err_no = err_no + 1;
                                $('#Login-' + i).attr('style', 'color:red');
                                $('#Login-' + i).html(error);
                                if (err_no == 1) {
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
    });
</script>
@stop