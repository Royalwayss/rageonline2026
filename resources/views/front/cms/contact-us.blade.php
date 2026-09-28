@extends('layouts.frontLayout.front-layout')
@section('content')
<?php
    $counties = get_counties();
    $state_options = get_state_options();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.3.5/css/intlTelInput.css"/>
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}"/>
<style>
.iti-phone-input {
    width: 100% !important;
    padding: 10px;
    box-sizing: border-box;
}
.iti.iti--separate-dial-code {
    width: 100%;
}
</style>

<main class="inner-page">
    <section class="contact-page">
        <div class="container">

            <div class="contact-breadcrumb-wrap" data-aos="fade-up">
                <div class="detail-breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <span>Contact Us</span>
                </div>
            </div>

            @if(isset($_GET['s']))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Your information has been submitted successfully.<br>We will get back to you soon.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="contact-split-wrapper" data-aos="fade-up" data-aos-duration="600">
                <div class="row g-0">

                    <!-- LEFT COLUMN: EDITORIAL VISUAL & CONTACT INFO -->
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="contact-visual-panel">
                            <div>
                                <h2 class="contact-visual-title">CONTACT US</h2>

                                <div class="contact-visual-list">
                                    <div class="contact-visual-item">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>HA-54 PHASE 6 FOCAL POINT LUDHIANA 141010 Punjab India</span>
                                    </div>

                                    <a href="tel:+917986158756" class="contact-visual-item">
                                        <i class="fa-solid fa-phone"></i>
                                        <span>+91 79861 58756</span>
                                    </a>

                                    <a href="mailto:rageindiaonline@gmail.com" class="contact-visual-item">
                                        <i class="fa-solid fa-envelope"></i>
                                        <span>rageindiaonline@gmail.com</span>
                                    </a>

                                    <a href="https://facebook.com/rageindiaonline" target="_blank" rel="noopener noreferrer" class="contact-visual-item">
                                        <i class="fa-brands fa-facebook-f"></i>
                                        <span>rageindiaonline</span>
                                    </a>

                                    <a href="https://instagram.com/rageindiaonline" target="_blank" rel="noopener noreferrer" class="contact-visual-item">
                                        <i class="fa-brands fa-instagram"></i>
                                        <span>rageindiaonline</span>
                                    </a>
                                </div>
                            </div>

                            <div class="contact-visual-watermark">
                                <span>RAGE</span>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: GET IN TOUCH FORM -->
                    <div class="col-lg-7 col-md-7 col-12">
                        <div class="contact-form-panel">
                            <h2 class="contact-form-title">GET IN TOUCH</h2>

                            <form id="SaveContact" action="javascript:;" method="post">
                                @csrf

                                <div class="rage-field-group">
                                    <label for="con-name">Name <span class="req">*</span></label>
                                    <input type="text" id="con-name" name="name" class="form-control rage-input">
                                    <p class="err text-center" id="Contact-name" style="display: none;"></p>
                                </div>

                                <div class="rage-field-group">
                                    <label for="con-email">Email <span class="req">*</span></label>
                                    <input type="text" id="con-email" name="email" class="form-control rage-input">
                                    <p class="err text-center" id="Contact-email" style="display: none;"></p>
                                </div>

                                <div class="rage-field-group">
                                    <label for="iti_phone_input">Mobile <span class="req">*</span></label>
                                    <input type="tel" id="iti_phone_input" class="iti-phone-input form-control rage-input" placeholder="Phone no *" name="mobile">
                                    <input type="hidden" id="iti_country_code" name="country_code">
                                    <input type="hidden" id="iti_mobile_number" name="mobile_number">
                                    <p class="err text-center" id="Contact-mobile" style="display: none;"></p>
                                </div>

                                <div class="rage-field-group">
                                    <label for="country">Country</label>
                                    <select id="country" name="country" class="form-select rage-select" onchange="get_state_city('1')">
                                        <option value="" disabled selected>Select your country</option>
                                        <?php foreach ($counties as $country) { ?>
                                        <option data-id="{{ $country['id'] }}" value="{{ $country['country'] }}" <?php if ($country['country'] == 'India') { echo 'selected'; } ?>>{{ $country['country'] }}</option>
                                        <?php } ?>
                                    </select>
                                    <p class="err text-center" id="Contact-country" style="display: none;"></p>
                                </div>

                                <div class="rage-field-group">
                                    <label for="state">State</label>
                                    <select id="state" name="state" class="form-select rage-select" onchange="get_state_city('2')">
                                        {!! $state_options !!}
                                    </select>
                                </div>

                                <div class="rage-field-group">
                                    <label for="city">City</label>
                                    <select id="city" name="city" class="form-select rage-select">
                                        <option value="" disabled selected>Select your city</option>
                                    </select>
                                </div>

                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                                <div class="rage-field-group">
                                    <label for="fMessage">Your Message <span class="req">*</span></label>
                                    <textarea id="fMessage" name="message" class="form-control rage-textarea" rows="4"></textarea>
                                    <p class="err text-center" id="Contact-message" style="display: none;"></p>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="rage-send-btn">SEND</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</main>
@stop

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}" async defer></script>

<script type="text/javascript">
    window.history.pushState("", "", "/contact-us");

    $('#country').select2();
    $('#state').select2();
    $('#city').select2();

    $('#SaveContact').submit(function(event) {
        event.preventDefault();

        if ($('#g-recaptcha-response').val() == '') {
            grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY') }}", { action: "save-contact" }).then(function(token) {
                $('#g-recaptcha-response').val(token);
                ContactFormonSubmit();
            });
        } else {
            ContactFormonSubmit();
        }
    });

    function ContactFormonSubmit() {
        setPhoneValues();

        var $btn = $('.rage-send-btn');
        var origText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> SENDING...');

        $('.PleaseWaitDiv').show();
        var formdata = $("#SaveContact").serialize();
        $.ajax({
            url: "/save-contact",
            type: 'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if (!data.status) {
                    $btn.prop('disabled', false).html(origText);
                    if (data.type == "validation") {
                        var err_no = 0;
                        $.each(data.errors, function(i, error) {
                            err_no = err_no + 1;
                            $('#Contact-' + i).attr('style', 'color:red!important');
                            $('#Contact-' + i).html(error);
                            if (err_no == 1) {
                                $('#con-' + i).focus();
                            }
                            setTimeout(function() {
                                $('#Contact-' + i).css({
                                    'display': 'none'
                                });
                            }, 5000);
                        });
                    }
                } else {
                    $btn.html('<i class="fa-solid fa-check me-2"></i> SENT!');
                    $btn.css('background', '#287444');
                    if (window.RageToast) {
                      //  RageToast.show('Thank you! Your message has been sent.', 'fa-paper-plane');
                    }
					printSuccessMsg('Thank you! Your message has been sent.');
                    /* setTimeout(function() {
                        window.location.href = data.url;
                    }, 1200); */
                }
            }
        });
    }

    function get_state_city(action) {
        var country = $('#country').find(":selected").attr("data-id");
        if (action == 2) {
            var state = $('#state').find(":selected").attr("data-id");
        } else {
            var state = '';
            const el = $('#country');
            setTimeout(() => {
                el.select2('close');
                el.blur();
            }, 10);
        }
        $.ajax({
            url: "{{ url('get-state-city') }}",
            type: 'GET',
            data: { country: country, state: state, action: action },
            success: function(resp) {
                if (action == '1') {
                    $("#state").html(resp);
                    $("#city").html('');
                }
                if (action == '2') {
                    $("#city").html(resp);
                }
            },
            error: function() {}
        });
    }
</script>

<script src="{{ asset('assets/js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('assets/js/utils.js') }}"></script>
<script>
    const itiInput = document.getElementById("iti_phone_input");
    const allCountries = window.intlTelInputGlobals.getCountryData();
    allCountries.sort((a, b) => a.name.localeCompare(b.name));
    const sortedCountryCodes = allCountries.map(c => c.iso2);

    const iti = window.intlTelInput(itiInput, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.3.5/js/utils.js",
        onlyCountries: sortedCountryCodes
    });

    function setPhoneValues() {
        const countryData = iti.getSelectedCountryData();
        document.getElementById("iti_country_code").value = "+" + countryData.dialCode;
        document.getElementById("iti_mobile_number").value = itiInput.value;
    }
</script>
@stop