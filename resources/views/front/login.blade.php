@extends('layouts.frontLayout.front-layout')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/country-phone.css') }}">
<style>
    /* Fixed, non-editable +91 prefix - this page only (OTP login is India-only) */
    .rage-phone-code-fixed {
        display: flex;
        align-items: center;
        flex-shrink: 0;
        padding: 0 12px;
        border-right: 1px solid #d8d0c5;
        font-size: 14px;
        color: #2b2b2b;
        background: transparent;
        user-select: none;
    }
</style>

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

                        <div class="alert-message alert alert-danger print-error-msg otp-err-message">
                            <ul class="mb-0"></ul>
                        </div>
                        <div class="alert-message alert alert-success print-success-msg otp-message">
                            <ul class="mb-0"></ul>
                        </div>

                        <form action="javascript:;" id="SendOtpForm">
                            @csrf

                            <?php $countries = \App\GeoCountry::getcountries(); ?>

                            <div class="form-field">
                                <label>Mobile Number(India Only)</label>

                                <div class="rage-phone-group">
                                    <span class="rage-phone-code-fixed">+91</span>
                                    <input type="hidden" name="country_code" id="otp_country_code" value="91">

                                    <input type="tel" class="form-control rage-phone-number" name="mobile" id="otp_mobile" placeholder="Enter mobile number" maxlength="10">
                                </div>
                                <div class="err" id="OtpSend-mobile"></div>
                            </div>

                            <button type="submit" class="primary-btn" id="sendOtpBtn">
                                Send OTP
                            </button>

                        </form>


                        <!-- SHOW AFTER OTP SENT -->
                        <form action="javascript:;" id="VerifyOtpForm" class="otp-area" style="display:none;">
                            @csrf
                            <input type="hidden" name="mobile" id="verify_mobile">
                            <input type="hidden" name="country_code" id="verify_country_code">

                            <div class="otp-mobile-display">
                                <span>OTP sent to +<strong id="otpCodeDisplay"></strong> <strong id="otpMobileDisplay"></strong></span>
                                <a href="javascript:;" id="editMobileBtn">Edit</a>
                            </div>

                            <div class="form-field">
                                <label>Enter OTP</label>

                                <div class="otp-inputs">
                                    <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                                    <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                                    <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                                    <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                                    <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                                    <input type="text" maxlength="1" class="otp-digit" inputmode="numeric">
                                </div>
                                <input type="hidden" name="otp" id="otp_full_value">
                                <div class="err" id="OtpVerify-otp"></div>
                            </div>

                            <div class="otp-meta">
                                <span id="resendTimerText">Didn't receive the code? Resend in <strong id="resendCountdown">30</strong>s</span>
                                <button type="button" id="resendOtpBtn" style="display:none;">Resend OTP</button>
                            </div>

                            <button type="submit" class="primary-btn">
                                Verify & Login
                            </button>

                        </form>

                    </div>

                </div>

                <div class="auth-bottom">
                    <span>New to Rage?</span>
                    <a href="{{ url('signup') }}">Create An Account</a>
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

    // The mobile country code is fixed to +91 (see the markup) - no select,
    // no Select2, so nothing to initialise here.

    $(document).ready(function() {
        $('#otp_mobile').on('input', function() {
			this.value = this.value.replace(/[^0-9]/g, '');
		});
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

        // ---- Mobile OTP login ----
        var resendTimer = null;

        function startResendCountdown() {
            var seconds = 30;
            $('#resendTimerText').show();
            $('#resendOtpBtn').hide();
            $('#resendCountdown').text(seconds);

            clearInterval(resendTimer);
            resendTimer = setInterval(function() {
                seconds--;
                $('#resendCountdown').text(seconds);
                if (seconds <= 0) {
                    clearInterval(resendTimer);
                    $('#resendTimerText').hide();
                    $('#resendOtpBtn').show();
                }
            }, 1000);
        }

        $("#SendOtpForm").submit(function(e) {
            e.preventDefault();

            var $btn = $('#sendOtpBtn');
            $btn.prop('disabled', true).text('Sending...');

            var formdata = $("#SendOtpForm").serialize();
            $.ajax({
                url: "/send-mobile-otp",
                type: 'POST',
                data: formdata,
                success: function(data) {
                    $btn.prop('disabled', false).text('Send OTP');

                    if (!data.status) {
                        if (data.type == "validation") {
                            $.each(data.errors, function(i, error) {
                                $('#OtpSend-' + i).attr('style', 'color:red');
                                $('#OtpSend-' + i).html(error);
                                setTimeout(function() {
                                    $('#OtpSend-' + i).css({ 'display': 'none' });
                                }, 3000);
                            });
                        } else {
                            var msg = [];
                            msg[0] = data.errors;
                            printErrorMsg(msg, 'otp-err-message');
                            $('.otp-err-message').delay(3000).fadeOut('slow');
                        }
                    } else {
                        $('#verify_mobile').val($('#otp_mobile').val());
                        $('#verify_country_code').val($('#otp_country_code').val());
                        $('#otpMobileDisplay').text($('#otp_mobile').val());
                        $('#otpCodeDisplay').text($('#otp_country_code').val());
                        $('#SendOtpForm').hide();
                        $('#VerifyOtpForm').show();
                        $('.otp-digit').val('');
                        $('.otp-digit').first().focus();

                        var msg = [];
                        msg[0] = data.message;
                        printSuccessMsg(msg, 'otp-message');
                        $('.otp-message').delay(3000).fadeOut('slow');

                        startResendCountdown();
                    }
                }
            });
        });

        $('#editMobileBtn').click(function() {
            clearInterval(resendTimer);
            $('#VerifyOtpForm').hide();
            $('#SendOtpForm').show();
            $('.otp-digit').val('');
            $('#otp_full_value').val('');
            $('#otp_mobile').focus();
        });

        $('#resendOtpBtn').click(function() {
            $('#SendOtpForm').submit();
        });

        // OTP box auto-advance / backspace-back / combine into hidden field
        $(document).on('input', '.otp-digit', function() {
            var val = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(val);
            if (val.length === 1) {
                $(this).next('.otp-digit').focus();
            }
            var combined = '';
            $('.otp-digit').each(function() {
                combined += $(this).val();
            });
            $('#otp_full_value').val(combined);
        });

        $(document).on('keydown', '.otp-digit', function(e) {
            if (e.key === 'Backspace' && $(this).val() === '') {
                $(this).prev('.otp-digit').focus();
            }
        });

        $("#VerifyOtpForm").submit(function(e) {
            e.preventDefault();
            var formdata = $("#VerifyOtpForm").serialize();
            $.ajax({
                url: "/verify-mobile-otp",
                type: 'POST',
                data: formdata,
                success: function(data) {
                    if (!data.status) {
                        if (data.type == "validation") {
                            $.each(data.errors, function(i, error) {
                                $('#OtpVerify-' + i).attr('style', 'color:red');
                                $('#OtpVerify-' + i).html(error);
                                setTimeout(function() {
                                    $('#OtpVerify-' + i).css({ 'display': 'none' });
                                }, 3000);
                            });
                        } else {
                            var msg = [];
                            msg[0] = data.errors;
                            printErrorMsg(msg, 'otp-err-message');
                            $('.otp-err-message').delay(3000).fadeOut('slow');
                        }
                    } else {
                        var msg = [];
                        msg[0] = data.message;
                        printSuccessMsg(msg, 'otp-message');
                        $('.otp-message').delay(3000).fadeOut('slow');
                        setTimeout(function() {
                            window.location.href = data.url;
                        }, 1500);
                    }
                }
            });
        });
    });
</script>
@stop