@extends('layouts.frontLayout.front-layout')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/country-phone.css') }}">

<main class="inner-page">
    <section class="auth-page">
        <div class="container">
            <div class="auth-box" data-aos="fade-up" data-aos-duration="600">

                <div class="auth-head">
                    <span>Join The Atelier</span>
                    <h1>Create Your Account</h1>
                    <p>Join the Rage Privilege Club to enjoy curated recommendations and bespoke services.</p>
                </div>

                <form class="rage-form" id="RegisterForm" action="javascript:;">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6 col-12">
                            <div class="form-field">
                                <label for="first_name">First Name <span>*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name">
                                <div class="err" id="Register-first_name"></div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-field">
                                <label for="last_name">Last Name <span>*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name">
                                <div class="err" id="Register-last_name"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-field mt-3">
                        <label for="email">Email Address <span>*</span></label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Enter email address">
                        <div class="err" id="Register-email"></div>
                    </div>

                    <div class="form-field mt-3">
                        <label for="country">Country <span>*</span></label>
                        <?php $countries = \App\GeoCountry::getcountries(); ?>
                        <select name="country" id="country" class="form-select">
                            @foreach($countries as $country)
                                <option value="{{ $country['name'] }}" data-phone-code="{{ $country['phone_code'] }}" @if($country['name'] == 'India') selected @endif>{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                        <div class="err" id="Register-country"></div>
                    </div>

                    <div class="form-field mt-3">
                        <label for="mobile">Mobile Number <span>*</span></label>
                        <div class="rage-phone-group">
                            <select name="country_code" id="country_code" class="rage-phone-code">
                                @foreach($countries as $country)
                                    <option value="{{ $country['phone_code'] }}" data-country="{{ $country['name'] }}" @if($country['name'] == 'India') selected @endif>+{{ $country['phone_code'] }} ({{ $country['name'] }})</option>
                                @endforeach
                            </select>
                            <input type="tel" name="mobile" id="mobile" class="form-control rage-phone-number" placeholder="Enter the mobile number">
                        </div>
                        <div class="err" id="Register-mobile"></div>
                    </div>

                    <div class="form-field mt-3">
                        <label for="password">Create Password <span>*</span></label>
                        <div class="password-toggle-wrap">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Minimum 6 characters">
                            <button type="button" class="pass-toggle-btn" onclick="togglePassVisibility('password', this);" title="Toggle password">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        <div class="err" id="Register-password"></div>
                    </div>

                    <div class="form-field mt-3">
                        <label for="password_confirmation">Confirm Password <span>*</span></label>
                        <div class="password-toggle-wrap">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repeat your password">
                            <button type="button" class="pass-toggle-btn" onclick="togglePassVisibility('password_confirmation', this);" title="Toggle password">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        <div class="err" id="Register-password_confirmation"></div>
                    </div>

                    <div class="register-check mt-3" id="accept_terms">
                        <label>
                            <input type="checkbox" name="accept_terms" value="1" required checked>
                            <span>
                                I agree to the
                                {{-- TODO: T&C link to be updated later --}}
                                <a target="_blank" href="{{ url('terms-and-conditions') }}">Terms &amp; Conditions</a>
                                and
                                <a target="_blank" href="{{ url('privacy-policy') }}">Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <div class="register-check">
                        <label>
                            <input type="checkbox" name="newsletter_subscription" value="1" checked>
                            <span>
                                I would like to receive collection releases and bespoke updates from Rage.
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="primary-btn w-100 mt-4">
                        Create Account
                    </button>
                </form>

                <div class="auth-bottom">
                    <span>Already have an account?</span>
                    <a href="{{ url('login') }}">Login Here</a>
                </div>

            </div>
        </div>
    </section>
</main>
@stop

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
    // Scoped to the register form so a duplicate id elsewhere in the layout
    // can never be picked up by mistake.
    var $countrySelect = $('#RegisterForm select[name="country"]');
    var $codeSelect = $('#RegisterForm select[name="country_code"]');

    $countrySelect.select2({
        width: '100%',
        minimumResultsForSearch: 0
    });

    $codeSelect.select2({
        width: '70px',
        minimumResultsForSearch: 0, // always show the search box
        templateSelection: function(option) {
            // Show only "+91" once collapsed
            var value = option.text.split(' ')[0];
            return value || option.text;
        }
    });

    // Two-way sync between Country and phone code.
    //
    // Several countries share one calling code (e.g. +1, +44, +7), so we
    // never look an option up by its *value* - that would always land on the
    // first country with that code (Canada -> Anguilla). Instead every phone
    // code option carries data-country, and we select that exact option.
    //
    // Only Select2's own display is refreshed ('change.select2') instead of
    // firing a full 'change', so the two handlers can't trigger each other
    // in a loop.

    // Country changed -> select the matching phone code option
    $countrySelect.on('change', function() {
        var countryName = $(this).val();
        var $target = $codeSelect.find('option').filter(function() {
            return $(this).attr('data-country') === countryName;
        }).first();

        if ($target.length && !$target.prop('selected')) {
            $codeSelect.find('option').prop('selected', false);
            $target.prop('selected', true);
            $codeSelect.trigger('change.select2');
        }
    });

    // Phone code changed -> select the matching country
    $codeSelect.on('change', function() {
        var countryName = $(this).find(':selected').attr('data-country');

        if (countryName && $countrySelect.val() !== countryName) {
            $countrySelect.val(countryName).trigger('change.select2');
        }
    });
</script>
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
        $('#mobile').on('input', function() {
			this.value = this.value.replace(/[^0-9]/g, '');
		});
		$("#RegisterForm").submit(function(e) {
            e.preventDefault();
            $('.PleaseWaitDiv').show();
            var formdata = $("#RegisterForm").serialize();
            $.ajax({
                /* TODO: unconfirmed endpoint - site convention guess (/login
                   uses "/login", /save-contact uses that exact name). Verify
                   against the real registration route. */
                url: "/signup",
                type: 'POST',
                data: formdata,
                success: function(data) {
                    $('.PleaseWaitDiv').hide();
                    if (!data.status) {
                        if (data.type == "validation") {
                            var err_no = 0;
                            $.each(data.errors, function(i, error) {
                                err_no = err_no + 1;
                                $('#Register-' + i).attr('style', 'color:red');
                                $('#Register-' + i).html(error);
                                if (err_no == 1) {
                                    $("#" + i).focus();
                                }
                                setTimeout(function() {
                                    $('#Register-' + i).css({
                                        'display': 'none'
                                    });
                                }, 5000);
                            });
                        } else {
                            printErrorMsg(data.errors);
							$('.rage-toast-error').focus();
                            $('.rage-toast-error').delay(3000).fadeOut('slow');
                        }
                    } else {
                        printSuccessMsg(data.message);
						$('.rage-toast-success').focus();
                        setTimeout(function() {
                            window.location.href = data.url;
                        }, 2000);
                    }
                }
            });
        });
    });
</script>
@stop