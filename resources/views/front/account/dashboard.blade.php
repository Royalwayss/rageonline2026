<?php $countries = \App\GeoCountry::getcountries(); ?>
<section class="account-content-grid">
  <div class="container-fluid">

    @if(isset($_GET['r']) && $_GET['r'] == "success")
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <strong>Success!</strong> Profile has been updated successfully!
    </div>
    @endif

    <div class="row g-4">

      <!-- LEFT COLUMN: PROFILE SNAPSHOT -->
      <div class="col-lg-4 col-12">

        <div class="luxury-card profile-snapshot-card">
          <div class="luxury-card-head">
            <div class="head-icon">
              <i class="fa-regular fa-id-card"></i>
            </div>
            <div>
              <h2>Personal Snapshot</h2>
              <p>Your account identity</p>
            </div>
          </div>

          <div class="snapshot-body">

            <div class="snapshot-item">
              <div class="snapshot-label">Full Name</div>
              <div class="snapshot-value">{{ Auth::user()->name }}</div>
            </div>

            <div class="snapshot-item">
              <div class="snapshot-label">Email Address</div>
              <div class="snapshot-value">
                <span id="Admin_email_address">{{ Auth::user()->email }}</span>
                <a href="javascript:;" class="email_update" id="email_update">Edit</a>
              </div>
            </div>

            <div class="snapshot-item">
              <div class="snapshot-label">Primary Mobile</div>
              <div class="snapshot-value">
                <span>+91 {{ Auth::user()->mobile }}</span>
              </div>
            </div>

          </div>
        </div>

        <?php
                    $default_shipping = \App\ShippingAddress::where('user_id', Auth::id())->where('is_default', 'yes')->first();
                    $billing_address  = \App\BillingAddress::where('user_id',Auth::user()->id)->where('is_default','yes')->first();
                   
				
				?>

        <div class="luxury-card profile-snapshot-card mt-4">
          <div class="luxury-card-head">
            <div class="head-icon">
              <i class="fa-solid fa-location-dot"></i>
            </div>
            <div>
              <h2>Primary Delivery Location</h2>
              <p>Your default shipping address</p>
            </div>
          </div>

          <div class="snapshot-body">
            <div class="snapshot-item">
              <div class="snapshot-address-box">
                @if($default_shipping)
                <strong>{{ $default_shipping->name }}</strong>
                <p>
                  {{ $default_shipping->address }}, {{ $default_shipping->city }},
                  {{ $default_shipping->state }} - {{ $default_shipping->postcode }}, {{ $default_shipping->country }}
                </p>
                <p>+91 {{ $default_shipping->mobile }}</p>
                @else
                <p class="no-address-msg">No delivery address on file yet.</p>
                @endif
                <a href="{{ url('account/address') }}" class="manage-link">
                  <i class="fa-solid fa-location-dot"></i> Manage Addresses
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="luxury-card profile-snapshot-card mt-4">
          <div class="luxury-card-head">
            <div class="head-icon">
              <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
              <h2>Billing Address</h2>
              <p>Used for invoicing</p>
            </div>
          </div>

          <div class="snapshot-body">
            <div class="snapshot-item">
              <div class="snapshot-address-box">
                @if($billing_address)
                <strong>{{ $billing_address->name }}</strong>
                <p>
                  {{ $billing_address->address }}, {{ $billing_address->city }},
                  {{ $billing_address->state }} - {{ $billing_address->postcode }}, {{ $billing_address->country }}
                </p>
                <p>+91 {{ $billing_address->mobile }}</p>
                @else
                <p class="no-address-msg">No billing address on file yet.</p>
                @endif
                <a href="{{ url('account/address') }}" class="manage-link">
                  <i class="fa-solid fa-location-dot"></i> Manage Addresses
                </a>
              </div>
            </div>
          </div>
        </div>

        @if(!empty(Auth::user()->loyalty_points))
        <div class="luxury-card sizing-card mt-4">
          <div class="luxury-card-head">
            <div class="head-icon">
              <i class="fa-solid fa-gift"></i>
            </div>
            <div>
              <h2>Reward Points</h2>
              <p>Redeemable on your next purchase</p>
            </div>
          </div>

          <div class="sizing-body">
            <p id="profile-reward-points">🎁 You've earned {{ Auth::user()->loyalty_points }} Reward Points — redeemable on your next purchase!</p>
          </div>
        </div>
        @endif

      </div>

      <!-- RIGHT COLUMN: EDIT PROFILE -->
      <div class="col-lg-8 col-12">
        <div class="luxury-card profile-edit-card">
          <div class="luxury-card-head">
            <div class="head-icon">
              <i class="fa-regular fa-pen-to-square"></i>
            </div>
            <div>
              <h2>Edit Profile Details</h2>
              <p>Keep your account details up to date for smooth checkout and deliveries</p>
            </div>
          </div>

          <form class="luxury-form" id="MyAccountform" autocomplete="off" action="javascript:;" method="post">
            @csrf

            <div class="form-section-title">
              <span>01</span> Personal Details
            </div>

            <div class="row g-3">

              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="name">Full Name <span>*</span></label>
                  <div class="field-with-icon">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" value="{{ Auth::user()->name }}">
                  </div>
                  <p class="err" id="MyAccount-name" style="display: none;"></p>
                </div>
              </div>

             <div class="col-md-6 col-12">
                <label for="country">Country <span>*</span></label>
                
                <select name="country" id="country" class="form-select">
                  @foreach($countries as $country)
                  <option value="{{ $country['name'] }}" data-phone-code="{{ $country['phone_code'] }}" @if($country['name']== Auth::user()->country  ) selected @endif>{{ $country['name'] }}</option>
                  @endforeach
                </select>
                <div class="err" id="MyAccount-country"></div>
              </div>

              <div class="col-md-6 col-12">
                <label for="mobile">Mobile <span>*</span></label>
                <div class="rage-phone-group">
                 <select name="country_code" id="country_code" class="rage-phone-code" tabindex="-1" style="pointer-events:none;">
					  @foreach($countries as $country)
					  <option value="{{ $country['phone_code'] }}" data-country="{{ $country['name'] }}" @if(Auth::user()->country_code == $country['phone_code']) selected @endif >+{{ $country['phone_code'] }} ({{ $country['name'] }})</option>
					  @endforeach
				</select>
                  <input type="tel" name="mobile" id="mobile" class="form-control rage-phone-number" placeholder="Enter the mobile number" value="{{ Auth::user()->mobile }}" readonly>
                </div>
                <div class="err" id="MyAccount-mobile"></div>
              </div>
			  
			  
			  <div class="col-md-6 col-12">
                <label for="alternative_number">Alternative Mobile</label>
                <div class="rage-phone-group">
                  <select name="country_code2" id="country_code2" class="rage-phone-code"> 
                    @foreach($countries as $country)
                    <option value="{{ $country['phone_code'] }}" data-country="{{ $country['name'] }}" @if(Auth::user()->country_code2 == $country['phone_code']) selected @endif >+{{ $country['phone_code'] }} ({{ $country['name'] }})</option>
                    @endforeach
                  </select>
                  <input type="tel" name="alternative_number" id="alternative_number" class="form-control rage-phone-number" placeholder="Enter the mobile number" value="{{ Auth::user()->alternative_number }}">
                </div>
                <div class="err" id="MyAccount-alternative_number"></div>
              </div>
			  
              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="state">State <span>*</span></label>
                  <div class="field-with-icon">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" name="state" id="state" class="form-control" placeholder="Enter state" value="{{ Auth::user()->state }}">
                  </div>
                  <p class="err" id="MyAccount-state" style="display: none;"></p>
                </div>
              </div>
            
             

              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="city">City</label>
                  <div class="field-with-icon">
                    <i class="fa-solid fa-city"></i>
                    <input type="text" class="form-control user_city" name="city" id="city" placeholder="Enter city" value="{{ Auth::user()->city }}">
                  </div>
                  <p class="err" id="MyAccount-city" style="display: none;"></p>
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="postcode">Postcode</label>
                  <div class="field-with-icon">
                    <i class="fa-solid fa-signs-post"></i>
                    <input type="text" class="form-control user_pincode" name="postcode" id="postcode" placeholder="Enter postcode" value="{{ Auth::user()->postcode }}">
                  </div>
                  <p class="err" id="MyAccount-postcode" style="display: none;"></p>
                </div>
              </div>

              <div class="col-12">
                <div class="luxury-field">
                  <label for="address">Address</label>
                  <div class="field-with-icon">
                    <i class="fa-solid fa-location-dot"></i>
                    <textarea name="address" id="address" class="form-control" rows="2" placeholder="Enter address">{{ Auth::user()->address }}</textarea>
                  </div>
                  <p class="err" id="MyAccount-address" style="display: none;"></p>
                </div>
              </div>

            </div>

            <div class="form-section-title mt-4">
              <span>02</span> Primary Delivery Location
            </div>

            <?php
              // Billing country: the saved one if it is in the list, otherwise India
              $billCountrySel = 'India';
              foreach ($countries as $billRow) {
                if (strcasecmp($billRow['name'], $billing_address->country ?? '') === 0) { $billCountrySel = $billRow['name']; break; }
              }
            ?>

            <div class="row g-3">

              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="billing_name">Full Name</label>
                  <div class="field-with-icon">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" class="form-control" name="billing_name" id="billing_name" placeholder="Enter name" value="{{ $billing_address->name ?? '' }}">
                  </div>
                  <p class="err" id="MyAccount-billing_name" style="display: none;"></p>
                </div>
              </div>
               <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="billing_country">Country</label>
                  <div class="field-with-icon rage-country-field">
                    <i class="fa-solid fa-earth-americas"></i>
                    <select class="form-select" name="billing_country" id="billing_country">
                      @foreach($countries as $country)
                      <option value="{{ $country['name'] }}" @if($country['name'] === $billCountrySel) selected @endif>{{ $country['name'] }}</option>
                      @endforeach
                    </select>
                  </div>
                  <p class="err" id="MyAccount-billing_country" style="display: none;"></p>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="billing_mobile">Mobile</label>
                  <div class="rage-phone-group">
                    <select name="billing_country_code" id="billing_country_code" class="rage-phone-code">
                      @foreach($countries as $country)
                      @if(!empty($country['phone_code']))
                      <option value="{{ $country['phone_code'] }}" data-country="{{ $country['name'] }}" @if($country['name'] === $billCountrySel) selected @endif>+{{ $country['phone_code'] }} ({{ $country['name'] }})</option>
                      @endif
                      @endforeach
                    </select>
                    <input type="text" class="form-control rage-phone-number" name="billing_mobile" id="billing_mobile" placeholder="Enter mobile" value="{{ $billing_address->mobile ?? '' }}">
                  </div>
                  <p class="err" id="MyAccount-billing_mobile" style="display: none;"></p>
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="billing_alternative_number">Alternative Mobile Number</label>
                  <div class="rage-phone-group">
                    <select name="billing_country_code2" id="billing_country_code2" class="rage-phone-code">
                      @foreach($countries as $country)
                      @if(!empty($country['phone_code']))
                      <option value="{{ $country['phone_code'] }}" data-country="{{ $country['name'] }}" @if($country['name'] === $billCountrySel) selected @endif>+{{ $country['phone_code'] }} ({{ $country['name'] }})</option>
                      @endif
                      @endforeach
                    </select>
                    <input type="text" class="form-control rage-phone-number" name="billing_alternative_number" id="billing_alternative_number" placeholder="Enter alternative mobile" value="{{ $billing_address->alternative_number ?? '' }}">
                  </div>
                  <p class="err" id="MyAccount-billing_alternative_number" style="display: none;"></p>
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="billing_address">Address</label>
                  <div class="field-with-icon">
                    <i class="fa-solid fa-location-dot"></i>
                    <input type="text" class="form-control" name="billing_address" id="billing_address" placeholder="House number, street, area" value="{{ $billing_address->address ?? '' }}">
                  </div>
                  <p class="err" id="MyAccount-billing_address" style="display: none;"></p>
                </div>
              </div>

             

              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="billing_state">State/Province</label>
                  <div class="field-with-icon">
                    <i class="fa-solid fa-map"></i>
                    <input type="text" class="form-control user_state" name="billing_state" id="billing_state" placeholder="Enter state" value="{{ $billing_address->state ?? '' }}">
                  </div>
                  <p class="err" id="MyAccount-billing_state" style="display: none;"></p>
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="billing_city">City</label>
                  <div class="field-with-icon">
                    <i class="fa-solid fa-city"></i>
                    <input type="text" class="form-control user_city" name="billing_city" id="billing_city" placeholder="Enter city" value="{{ $billing_address->city ?? '' }}">
                  </div>
                  <p class="err" id="MyAccount-billing_city" style="display: none;"></p>
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="luxury-field">
                  <label for="billing_postcode">Zip Code</label>
                  <div class="field-with-icon">
                    <i class="fa-solid fa-signs-post"></i>
                    <input type="text" class="form-control user_pincode" name="billing_postcode" id="billing_postcode" placeholder="Enter postcode" value="{{ $billing_address->postcode ?? '' }}">
                  </div>
                  <p class="err" id="MyAccount-billing_postcode" style="display: none;"></p>
                </div>
              </div>

            </div>

            <div class="col-12 mt-3">
              <div class="alert alert-danger print-error-msg text-center" style="display:none">
                <ul></ul>
              </div>
            </div>

            <div class="profile-actions-bar mt-4 pt-3">
              <button type="submit" class="primary-btn luxury-save-btn">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save Profile Changes</span>
              </button>
              <?php /*    <button type="reset" class="modal-cancel">
                                Discard Changes
                            </button> */ ?>
              <span id="saveStatusMsg" class="save-status-msg"></span>
            </div>

          </form>
       

	   </div>
      </div>

    </div>
  </div>
</section>

<!-- Email update modal -->
<div class="modal fade" id="user_email_update" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content review-modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Update Email Address</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div id="EmailUpdateresult" class="text-center"></div>

      <form id="EmailUpdateForm" action="javascript:;" method="post">
        @csrf
        <div class="modal-body">

          <div class="review-field">
            <input type="text" class="form-control" name="new_email" id="new_email" placeholder="Enter new email address">
            <p class="err" id="EmailUpdate-new_email" style="display: none;"></p>
          </div>

          <div class="review-field" style="display: none;" id="otp_field">
            <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP">
            <p class="err" id="EmailUpdate-otp" style="display: none;"></p>
          </div>

        </div>

        <div class="modal-footer" id="Genreateotpbutton">
          <button type="submit" id="Genreate_otp_button" class="primary-btn">Generate OTP</button>
        </div>
        <div class="modal-footer" style="display:none" id="Updateemailbutton">
          <button type="submit" id="Update_email_button" class="primary-btn">Update Email</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- Email update modal end -->

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
  // Scoped to the register form so a duplicate id elsewhere in the layout
  // can never be picked up by mistake.
  var $countrySelect = $('#MyAccountform select[name="country"]');
  var $codeSelect = $('#MyAccountform select[name="country_code"]');
  var $codeSelect2 = $('#MyAccountform select[name="country_code2"]');
  $countrySelect.select2({
    width: '100%',
    minimumResultsForSearch: 0
  });
  $codeSelect2.select2({
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
  
  
  /*
  $countrySelect.on('change', function() {
		var country_code = $("#country option:selected").attr("data-phone-code");
		var option = new Option(country_code, country_code, true, true);
		$("#country_code").append(option).trigger("change");
 });
  */
  
  
  
  
  
  
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
				
				
				var $target2 = $codeSelect2.find('option').filter(function() {
				  return $(this).attr('data-country') === countryName;
				}).first();
				if ($target2.length && !$target2.prop('selected')) {
				  $codeSelect2.find('option').prop('selected', false);
				  $target2.prop('selected', true);
				  $codeSelect2.trigger('change.select2');
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
  // Primary Delivery Location: Country <-> phone code (searchable, kept in sync)
  var $billCountry = $('#MyAccountform select[name="billing_country"]');
  var $billCode = $('#MyAccountform select[name="billing_country_code"]');
  var $billCode2 = $('#MyAccountform select[name="billing_country_code2"]'); // Alternative Mobile

  $billCountry.select2({
    width: '100%',
    minimumResultsForSearch: 0
  });

  var billCodeOptions = {
    width: '70px',
    minimumResultsForSearch: 0,
    dropdownAutoWidth: true, // open list isn't squeezed into the 70px box
    templateSelection: function(option) {
      // Collapsed box shows only "+91"; the open list shows "+91 (India)"
      var value = option.text.split(' ')[0];
      return value || option.text;
    }
  };
  $billCode.select2(billCodeOptions);
  $billCode2.select2(billCodeOptions);

  // Select the phone-code option of a given country. Matched by country NAME
  // (data-country), never by the code value, because several countries share a
  // code (+1, +44, +7). Only Select2's display is refreshed ('change.select2')
  // so the handlers below can't trigger each other.
  function setCodeForCountry($code, countryName) {
    var $target = $code.find('option').filter(function() {
      return $(this).attr('data-country') === countryName;
    }).first();

    if ($target.length && !$target.prop('selected')) {
      $code.find('option').prop('selected', false);
      $target.prop('selected', true);
      $code.trigger('change.select2');
    }
  }

  // Country changed -> both phone codes follow it
  $billCountry.on('change', function() {
    var countryName = $(this).val();
    setCodeForCountry($billCode, countryName);
    setCodeForCountry($billCode2, countryName);
  });

  // Mobile code changed -> Country (and the alternative code) follow it
  $billCode.on('change', function() {
    var countryName = $(this).find(':selected').attr('data-country');
    if (countryName && $billCountry.val() !== countryName) {
      $billCountry.val(countryName).trigger('change.select2');
      setCodeForCountry($billCode2, countryName);
    }
  });
</script>

<script>
  var accounturl = '/account/dashboard';
  window.history.pushState({
    path: accounturl
  }, '', accounturl);
  $('#country_code').next('.select2-container').css('pointer-events', 'none');
  //$("#country").select2();
  //$("#country_code").select2();
  $("#MyAccountform").submit(function(e) {
    e.preventDefault();
    var $btn = $('.luxury-save-btn');
    var originalText = $btn.html();
    $btn.html('<i class="fa-solid fa-spinner fa-spin"></i> <span>Saving...</span>').prop('disabled', true);
    var formdata = $("#MyAccountform").serialize();
    $.ajax({
      url: '/submit-account-details',
      type: 'POST',
      data: formdata,
      success: function(data) {
        $('.err').css('display', 'none');
        if (!data.status) {
          $btn.html(originalText).prop('disabled', false);
          $.each(data.errors, function(i, error) {
            $('#MyAccount-' + i).attr('style', '');
            $('#MyAccount-' + i).html(error);
            setTimeout(function() {
              $('#MyAccount-' + i).css({
                'display': 'none'
              });
            }, 9000);
          });
        } else {
          $btn.html('<i class="fa-solid fa-check"></i> <span>Profile Updated!</span>');
          $btn.css('background', '#287444');
          $('#saveStatusMsg').html('<i class="fa-solid fa-circle-check"></i> Your profile details have been saved successfully.').addClass('active');
          setTimeout(function() {
            $btn.css('background', '#111');
            $btn.html(originalText).prop('disabled', false);
            $('#saveStatusMsg').html('');
            //window.location.href = '/account/dashboard?r=success';
          }, 4000);
        }
      }
    });
  });
  $(".email_update").click(function() {
    $('#user_email_update').modal('show');
  });
  $('#Genreate_otp_button').click(function(e) {
    e.preventDefault();
    var formdata = $("#EmailUpdateForm").serialize();
    $.ajax({
      url: '/genreate-otp',
      type: 'POST',
      data: formdata,
      success: function(data) {
        $('.PleaseWaitDiv').hide();
        if (!data.status) {
          $.each(data.errors, function(i, error) {
            $('#EmailUpdate-' + i).attr('style', 'color:red');
            $('#EmailUpdate-' + i).html(error);
            setTimeout(function() {
              $('#EmailUpdate-' + i).css({
                'display': 'none'
              });
            }, 3000);
          });
        } else {
          $('#EmailUpdateresult').attr('style', 'color:green');
          $('#EmailUpdateresult').html(data.message);
          $('#otp_field').attr('style', 'display:block');
          $('#Genreateotpbutton').attr('style', 'display:none');
          $('#Updateemailbutton').attr('style', 'display:block');
        }
      }
    });
  });
  $('#Update_email_button').click(function(e) {
    e.preventDefault();
    var formdata = $("#EmailUpdateForm").serialize();
    $.ajax({
      url: '/update-email',
      type: 'POST',
      data: formdata,
      success: function(data) {
        $('.PleaseWaitDiv').hide();
        if (!data.status) {
          $.each(data.errors, function(i, error) {
            $('#EmailUpdate-' + i).attr('style', 'color:red');
            $('#EmailUpdate-' + i).html(error);
            setTimeout(function() {
              $('#EmailUpdate-' + i).css({
                'display': 'none'
              });
            }, 3000);
          });
        } else {
          if (data.type == 'otp') {
            $('#EmailUpdateresult').attr('style', 'color:red');
            $('#EmailUpdateresult').html(data.message);
          } else {
            $("#EmailUpdateForm").trigger("reset");
            $("#Admin_email_address").html(data.new_email);
            $('#EmailUpdateresult').attr('style', 'color:green');
            $('#EmailUpdateresult').html(data.message);
            setTimeout(function() {
              $('#user_email_update').modal('hide');
            }, 1500);
          }
        }
      }
    });
  });
</script>
@stop