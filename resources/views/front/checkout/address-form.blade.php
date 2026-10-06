<style>
    /* Country and country codes are fixed to India / +91: the control can't be opened.
       The second selector also covers the Select2 box if the page wraps these selects in Select2. */
    .rage-fixed-select,
    .rage-fixed-select + .select2-container { pointer-events: none; }

    /* Fixed country code: plain "+91" text inside the phone box - no arrow, no separate border */
    .rage-phone-group select.rage-phone-code.rage-fixed-select {
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
        background: transparent !important;
        background-image: none !important;
        border: 0 !important;
        border-right: 1px solid #d8d0c5 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        outline: none !important;
        padding: 0 12px !important;
        margin: 0 !important;
        width: auto !important;
        min-width: 0 !important;
        flex-shrink: 0;
        font-size: 14px;
        color: #2b2b2b;
        text-align: center;
        text-align-last: center;
    }
</style>
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
                        <select class="form-select rage-fixed-select" name="country" data-rage-country data-rage-group="ship" tabindex="-1">
                            <option value="India" selected>India</option>
                        </select>
                        <span class="err" id="Address-country"></span>
                    </div>
                </div>

				
				
				<div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Mobile</label>
                        <div class="rage-phone-group">
                            <select class="rage-country-code rage-phone-code rage-fixed-select" name="country_code" data-rage-code="main" data-rage-group="ship" tabindex="-1">
                            <option value="91" selected>+91</option>
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
                            <select class="rage-country-code rage-phone-code rage-fixed-select" name="country_code2" data-rage-code="alt" data-rage-group="ship" tabindex="-1">
                            <option value="91" selected>+91</option>
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
                        <select class="form-select rage-fixed-select" name="billing_country" data-rage-country data-rage-group="bill" tabindex="-1">
                            <option value="India" selected>India</option>
                        </select>
                        <span class="err" id="Address-billing_country"></span>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Mobile</label>
                        <div class="rage-phone-group">
                            <select class="rage-country-code rage-phone-code rage-fixed-select" name="billing_country_code" data-rage-code="main" data-rage-group="bill" tabindex="-1">
                            <option value="91" selected>+91</option>
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
                            <select class="rage-country-code rage-phone-code rage-fixed-select" name="billing_country_code2" data-rage-code="alt" data-rage-group="bill" tabindex="-1">
                            <option value="91" selected>+91</option>
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