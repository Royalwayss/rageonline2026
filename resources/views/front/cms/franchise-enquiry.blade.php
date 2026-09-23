@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page">
    <section class="franchise-page">
        <div class="container">

            <div class="detail-breadcrumb" data-aos="fade-up">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <span>Franchise Enquiry</span>
            </div>

            <div class="auth-head" data-aos="fade-up">
                <span>Partner With Rage</span>
                <h1>Franchise Enquiry</h1>
                <p>All fields marked with an (*) are mandatory.</p>
            </div>

            @if(isset($_GET['s']))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Your information has been submitted successfully.<br>We will get back to you soon.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form name="franchiseForm" id="franchiseForm" method="post" action="javascript:;" data-aos="fade-up" data-aos-delay="100">
                @csrf

                <div class="row g-4">

                    <!-- YOUR DETAILS -->
                    <div class="col-lg-6 col-12">
                        <div class="luxury-card">
                            <div class="luxury-card-head">
                                <div class="head-icon">
                                    <i class="fa-regular fa-id-card"></i>
                                </div>
                                <div>
                                    <h2>Your Details</h2>
                                </div>
                            </div>

                            <div class="luxury-form">

                                <div class="form-field">
                                    <label for="fe-name_of_party">Name of Party *</label>
                                    <input type="text" class="form-control" name="name_of_party" id="fe-name_of_party">
                                    <p style="display:none" class="err" id="Franchise-name_of_party"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-address_of_party">Address *</label>
                                    <input type="text" class="form-control" name="address_of_party" id="fe-address_of_party">
                                    <p style="display:none" class="err" id="Franchise-address_of_party"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-city_of_party">City / State *</label>
                                    <input type="text" class="form-control" name="city_of_party" id="fe-city_of_party">
                                    <p style="display:none" class="err" id="Franchise-city_of_party"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-phone_of_party">Phone *</label>
                                    <input type="text" class="form-control" name="phone_of_party" id="fe-phone_of_party">
                                    <p style="display:none" class="err" id="Franchise-phone_of_party"></p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- AREA LOCATION DETAILS -->
                    <div class="col-lg-6 col-12">
                        <div class="luxury-card">
                            <div class="luxury-card-head">
                                <div class="head-icon">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                                <div>
                                    <h2>Area Location Details</h2>
                                </div>
                            </div>

                            <div class="luxury-form">

                                <div class="form-field">
                                    <label for="fe-profile1">Other Profile</label>
                                    <input type="text" class="form-control" name="profile1" id="fe-profile1">
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-profile2">Other Profile</label>
                                    <input type="text" class="form-control" name="profile2" id="fe-profile2">
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-competitor">Competitors Presence</label>
                                    <textarea rows="3" class="form-control" name="competitor" id="fe-competitor"></textarea>
                                    <p style="display:none" class="err" id="Franchise-competitor"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-mode_of_operation">Mode of Operation *</label>
                                    <input type="text" class="form-control" name="mode_of_operation" id="fe-mode_of_operation">
                                    <p style="display:none" class="err" id="Franchise-mode_of_operation"></p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- SHOWROOM DETAILS -->
                    <div class="col-lg-6 col-12">
                        <div class="luxury-card">
                            <div class="luxury-card-head">
                                <div class="head-icon">
                                    <i class="fa-solid fa-store"></i>
                                </div>
                                <div>
                                    <h2>Showroom Details</h2>
                                </div>
                            </div>

                            <div class="luxury-form">

                                <div class="form-field">
                                    <label for="fe-showroom_name">Name of Showroom *</label>
                                    <input type="text" class="form-control" name="showroom_name" id="fe-showroom_name">
                                    <p style="display:none" class="err" id="Franchise-showroom_name"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-showroom_address">Address *</label>
                                    <input type="text" class="form-control" name="showroom_address" id="fe-showroom_address">
                                    <p style="display:none" class="err" id="Franchise-showroom_address"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-showroom_phone">Phone *</label>
                                    <input type="text" class="form-control" name="showroom_phone" id="fe-showroom_phone">
                                    <p style="display:none" class="err" id="Franchise-showroom_phone"></p>
                                </div>

                                <div class="row g-3 mt-1">
                                    <div class="col-md-4 col-6">
                                        <div class="form-field">
                                            <label for="fe-floor1">Floor *</label>
                                            <input type="text" class="form-control" name="floor1" id="fe-floor1">
                                            <p style="display:none" class="err" id="Franchise-floor1"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-field">
                                            <label for="fe-frontage">Frontage *</label>
                                            <input type="text" class="form-control" name="frontage" id="fe-frontage">
                                            <p style="display:none" class="err" id="Franchise-frontage"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-field">
                                            <label for="fe-depth">Depth *</label>
                                            <input type="text" class="form-control" name="depth" id="fe-depth">
                                            <p style="display:none" class="err" id="Franchise-depth"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-area">Area *</label>
                                    <input type="text" class="form-control" name="area" id="fe-area">
                                    <p style="display:none" class="err" id="Franchise-area"></p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- BUSINESS DETAILS -->
                    <div class="col-lg-6 col-12">
                        <div class="luxury-card">
                            <div class="luxury-card-head">
                                <div class="head-icon">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <div>
                                    <h2>Business Details</h2>
                                </div>
                            </div>

                            <div class="luxury-form">

                                <div class="form-field">
                                    <label for="fe-prop">Prop./Partners/Directors *</label>
                                    <input type="text" class="form-control" name="prop" id="fe-prop">
                                    <p style="display:none" class="err" id="Franchise-prop"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-father_name">Father's Name *</label>
                                    <input type="text" class="form-control" name="father_name" id="fe-father_name">
                                    <p style="display:none" class="err" id="Franchise-father_name"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-res_address">Res. Address *</label>
                                    <textarea rows="3" class="form-control" name="res_address" id="fe-res_address"></textarea>
                                    <p style="display:none" class="err" id="Franchise-res_address"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-mobile">Mobile *</label>
                                    <input type="text" class="form-control" name="mobile" id="fe-mobile">
                                    <p style="display:none" class="err" id="Franchise-mobile"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-phone">Phone *</label>
                                    <input type="text" class="form-control" name="phone" id="fe-phone">
                                    <p style="display:none" class="err" id="Franchise-phone"></p>
                                </div>

                                <div class="form-field mt-3">
                                    <label for="fe-email">E-mail *</label>
                                    <input type="text" class="form-control" name="email" id="fe-email">
                                    <p style="display:none" class="err" id="Franchise-email"></p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="primary-btn" name="btnSubmit">Submit Enquiry</button>
                </div>

            </form>

        </div>
    </section>
</main>
@stop

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script type="text/javascript">
    window.history.pushState("", "", "/franchise-enquiry");

    $("#franchiseForm").submit(function(e) {
        e.preventDefault();
        $('.PleaseWaitDiv').show();
        var formdata = $("#franchiseForm").serialize();
        $.ajax({
            url: "/save-franchiseenquiry",
            type: 'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if (!data.status) {
                    if (data.type == "validation") {
                        var err_no = 0;
                        $('.err').html('');
                        $.each(data.errors, function(i, error) {
                            err_no = err_no + 1;
                            $('#Franchise-' + i).attr('style', 'color:red');
                            $('#Franchise-' + i).html(error);
                            if (err_no == 1) {
                                $('#fe-' + i).focus();
                            }
                            setTimeout(function() {
                                $('#Franchise-' + i).css({
                                    'display': 'none'
                                });
                            }, 5000);
                        });
                    }
                } else {
                    window.location.href = data.url;
                }
            }
        });
    });
</script>
@stop