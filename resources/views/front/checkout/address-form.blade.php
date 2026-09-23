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
                        <label>Mobile</label>
                        <div class="mobile-input">
                            <span>+91</span>
                            <input type="tel" class="form-control" name="mobile" value="{{ $address->mobile ?? '' }}" placeholder="Enter mobile number">
                        </div>
                        <span class="err" id="Address-mobile"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Alternative Mobile Number</label>
                        <input type="tel" class="form-control" name="alternative_number" value="{{ $address->alternative_number ?? '' }}" placeholder="Alternative mobile">
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
                        <label>Country</label>
                        <select class="form-select" name="country">
                            <option value="India" selected>India</option>
                        </select>
                        <span class="err" id="Address-country"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>State/Province</label>
                        <select class="form-select" name="state">
                            <option value="" disabled {{ empty($address->state ?? '') ? 'selected' : '' }}>Select state</option>
                            @foreach($states as $st)
                            <option value="{{ $st }}" {{ (isset($address) && $address->state == $st) ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
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
                        <label>Mobile</label>
                        <div class="mobile-input">
                            <span>+91</span>
                            <input type="tel" class="form-control" name="billing_mobile" value="{{ $billing->mobile ?? '' }}" placeholder="Enter mobile number">
                        </div>
                        <span class="err" id="Address-billing_mobile"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>Alternative Mobile Number</label>
                        <input type="tel" class="form-control" name="billing_alternative_number" value="{{ $billing->alternative_number ?? '' }}" placeholder="Alternative mobile">
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
                        <label>Country</label>
                        <select class="form-select" name="billing_country">
                            <option value="India" selected>India</option>
                        </select>
                        <span class="err" id="Address-billing_country"></span>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-field">
                        <label>State/Province</label>
                        <select class="form-select" name="billing_state">
                            <option value="" disabled {{ empty($billing->state ?? '') ? 'selected' : '' }}>Select state</option>
                            @foreach($states as $st)
                            <option value="{{ $st }}" {{ (isset($billing) && $billing->state == $st) ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
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