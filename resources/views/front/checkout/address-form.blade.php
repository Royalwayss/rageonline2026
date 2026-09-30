<?php
    // Country list for the Country + phone-code dropdowns.
    // Each section starts on its saved country if it is in the list, otherwise India.
    $countries = \App\GeoCountry::getcountries();
    $shipCountrySel = 'India';
    $billCountrySel = 'India';
    foreach ($countries as $rageRow) {
        if (strcasecmp($rageRow['name'], $address->country ?? '') === 0) { $shipCountrySel = $rageRow['name']; }
        if (strcasecmp($rageRow['name'], $billing->country ?? '') === 0) { $billCountrySel = $rageRow['name']; }
    }
?>
<div class="modal-header">
    <h5 class="modal-title">{{ $address ? 'Edit Address' : 'Add New Address' }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form id="addressForm">
    @csrf
    <input type="hidden" name="id" value="{{ $address->id ?? '' }}">

    <div class="modal-body">

        <div class="address-form-section">
            <h4>Shipping Address</h4>

            <div class="row">

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="full_name" value="{{ $address->name ?? '' }}" placeholder="Full name">
                        <span class="err" id="Address-full_name"></span>
                    </div>
                </div>

                
				 <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Country</label>
                        <select class="form-select" name="country" data-rage-country data-rage-group="ship">
                            @foreach($countries as $country)
                            <option value="{{ $country['name'] }}" @if($country['name'] === $shipCountrySel) selected @endif>{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="err" id="Address-country"></span>
                    </div>
                </div>

				
				
				<div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Mobile</label>
                        <div class="rage-phone-group">
                            <select name="country_code" class="rage-country-code rage-phone-code" data-rage-code="main" data-rage-group="ship">
                                @foreach($countries as $country)
                                @if(!empty($country['phone_code']))
                                <option value="{{ $country['phone_code'] }}" data-country="{{ $country['name'] }}" @if($country['name'] === $shipCountrySel) selected @endif>+{{ $country['phone_code'] }} ({{ $country['name'] }})</option>
                                @endif
                                @endforeach
                            </select>
                            <input type="tel" class="form-control rage-phone-number" name="mobile" value="{{ $address->mobile ?? '' }}" placeholder="Enter mobile number">
                        </div>
                        <span class="err" id="Address-mobile"></span>
                    </div>
                </div>

               



                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Alternative Mobile Number</label>
                        <div class="rage-phone-group">
                            <select name="country_code2" class="rage-country-code rage-phone-code" data-rage-code="alt" data-rage-group="ship">
                                @foreach($countries as $country)
                                @if(!empty($country['phone_code']))
                                <option value="{{ $country['phone_code'] }}" data-country="{{ $country['name'] }}" @if($country['name'] === $shipCountrySel) selected @endif>+{{ $country['phone_code'] }} ({{ $country['name'] }})</option>
                                @endif
                                @endforeach
                            </select>
                            <input type="tel" class="form-control rage-phone-number" name="alternative_number" value="{{ $address->alternative_number ?? '' }}" placeholder="Alternative mobile">
                        </div>
                        <span class="err" id="Address-alternative_number"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $address->address ?? '' }}" placeholder="House number, street, area">
                        <span class="err" id="Address-address"></span>
                    </div>
                </div>

               

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>State/Province</label>
                        <input type="text" class="form-control" name="state" value="{{ $address->state ?? '' }}" placeholder="State / Province">
                        <span class="err" id="Address-state"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>City</label>
                        <input type="text" class="form-control" name="city" value="{{ $address->city ?? '' }}" placeholder="City">
                        <span class="err" id="Address-city"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Zip Code</label>
                        <input type="text" class="form-control" name="postcode" value="{{ $address->postcode ?? '' }}" placeholder="Zip code">
                        <span class="err" id="Address-postcode"></span>
                    </div>
                </div>

            </div>
        </div>

        <?php $default_billing_same = empty($billing) ? 'checked' : ''; ?>

        @if(empty($billing))
        <div class="billing-check">
            <label>
                <input type="checkbox" id="billingSame" name="billing_same" value="1" {{ $default_billing_same }}>
                <span>Billing address same as shipping address</span>
            </label>
        </div>
        @endif

        <div class="billing-form-section" id="billingForm" style="{{ $default_billing_same ? 'display:none;' : '' }}">
            <h4>Billing Address</h4>

            <div class="row">

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="billing_full_name" value="{{ $billing->name ?? '' }}" placeholder="Full name">
                        <span class="err" id="Address-billing_full_name"></span>
                    </div>
                </div>
                 <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Country</label>
                        <select class="form-select" name="billing_country" data-rage-country data-rage-group="bill">
                            @foreach($countries as $country)
                            <option value="{{ $country['name'] }}" @if($country['name'] === $billCountrySel) selected @endif>{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="err" id="Address-billing_country"></span>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Mobile</label>
                        <div class="rage-phone-group">
                            <select name="billing_country_code" class="rage-country-code rage-phone-code" data-rage-code="main" data-rage-group="bill">
                                @foreach($countries as $country)
                                @if(!empty($country['phone_code']))
                                <option value="{{ $country['phone_code'] }}" data-country="{{ $country['name'] }}" @if($country['name'] === $billCountrySel) selected @endif>+{{ $country['phone_code'] }} ({{ $country['name'] }})</option>
                                @endif
                                @endforeach
                            </select>
                            <input type="tel" class="form-control rage-phone-number" name="billing_mobile" value="{{ $billing->mobile ?? '' }}" placeholder="Enter mobile number">
                        </div>
                        <span class="err" id="Address-billing_mobile"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Alternative Mobile Number</label>
                        <div class="rage-phone-group">
                            <select name="billing_country_code2" class="rage-country-code rage-phone-code" data-rage-code="alt" data-rage-group="bill">
                                @foreach($countries as $country)
                                @if(!empty($country['phone_code']))
                                <option value="{{ $country['phone_code'] }}" data-country="{{ $country['name'] }}" @if($country['name'] === $billCountrySel) selected @endif>+{{ $country['phone_code'] }} ({{ $country['name'] }})</option>
                                @endif
                                @endforeach
                            </select>
                            <input type="tel" class="form-control rage-phone-number" name="billing_alternative_number" value="{{ $billing->alternative_number ?? '' }}" placeholder="Alternative mobile">
                        </div>
                        <span class="err" id="Address-billing_alternative_number"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Address</label>
                        <input type="text" class="form-control" name="billing_address" value="{{ $billing->address ?? '' }}" placeholder="House number, street, area">
                        <span class="err" id="Address-billing_address"></span>
                    </div>
                </div>

               

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>State/Province</label>
                        <input type="text" class="form-control" name="billing_state" value="{{ $billing->state ?? '' }}" placeholder="State / Province">
                        <span class="err" id="Address-billing_state"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>City</label>
                        <input type="text" class="form-control" name="billing_city" value="{{ $billing->city ?? '' }}" placeholder="City">
                        <span class="err" id="Address-billing_city"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Zip Code</label>
                        <input type="text" class="form-control" name="billing_postcode" value="{{ $billing->postcode ?? '' }}" placeholder="Zip code">
                        <span class="err" id="Address-billing_postcode"></span>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="modal-cancel" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="primary-btn save-address-btn">Save Address</button>
    </div>

</form>