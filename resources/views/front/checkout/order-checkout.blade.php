@extends('layouts.frontLayout.front-layout')
@section('content')
<?php
    use App\CustomFunction;
    use App\Cart;
    use App\CouponCode;
    use App\GiftOffer;
    use App\ShippingAddress;

    $total_gst = '0';
    $subtotal = 0;
    $address_type = 'shipping';
	 $addresses = ShippingAddress::where('user_id',Auth::user()->id)->get();  $address_count = 0;
?>
<style>
#points-redemption-box {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid #86efac;
    border-left: 4px solid #16a34a;
    border-radius: 6px;
    padding: 14px 16px;
    margin: 15px 0;
}
#available-points-text {
    margin: 0 0 10px 0;
    font-size: 14px;
    font-weight: 500;
    color: #166534;
}
.points-redeem-row {
    display: flex;
    gap: 8px;
    align-items: center;
}
.points-redeem-row input#points_to_redeem {
    max-width: 180px;
    padding: 6px 10px;
    border: 1px solid #86efac;
    border-radius: 4px;
    font-size: 14px;
}
.points-err {
    color: #dc2626;
    font-size: 13px;
    margin-top: 6px;
}
</style>

<main class="inner-page">
    <section class="checkout-page">
        <div class="container-fluid">

            <div class="checkout-head">
                <span>Secure Checkout</span>
                <h1>Checkout</h1>
            </div>

            <form name="checkout" id="OrderPlace" method="post" action="javascript:;">
                @csrf

                <div class="row">

                    <!-- LEFT SIDE -->
                    <div class="col-lg-7 col-12">
                        <div class="checkout-form-box">
                            <div class="checkout-title">
                                <span>01</span>
                                <h3>Shipping Address</h3>
                            </div>

                            {{-- STATIC PLACEHOLDER: new design's sample saved-address UI.
                                 Not wired to real data or the checkout form yet.
                                 #OrderPlace currently has no shipping_* fields in it,
                                 so /check-order will fail address validation until
                                 this section is connected to real data. --}}
                            <div class="saved-address-list">
                                 @foreach($addresses as $address)
								<label class="saved-address-card active">
                                    <input type="radio" name="saved_address" value="1" checked>
                                    <span class="address-radio"></span>
                                    <div class="saved-address-content">
                                        <strong>Royalways</strong>
                                        <p>
                                            123 Model Town, Ludhiana,
                                            Punjab - 141002, India
                                        </p>
                                        <p>+91 98765 43210</p>
                                    </div>
                                </label>
                                @endforeach
                                
                            </div>
                            <button type="button" class="add-address-btn" data-bs-toggle="modal" data-bs-target="#addressModal">
                                <i class="fa-solid fa-plus"></i>
                                Add Address
                            </button>

                            <div class="form-field mt-4">
                                <label for="order_comments">Order Notes (optional)</label>
                                <textarea name="comments" class="form-control" id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="3"></textarea>
                            </div>
                        </div>
                    
					</div>

                    <!-- RIGHT SIDE -->
                    <div class="col-lg-5 col-12">
                        <div class="checkout-summary">
                            <h3>Your Order</h3>

                            @foreach($cartitems as $cart_key => $cartitem)
                                <?php
                                    $priceDetails = Cart::calProPricing($cartitem);
                                    $subtotal += $priceDetails['prosubtotal'];
                                ?>
                                <div class="checkout-product">
                                    <div class="checkout-product-img">
                                        <a target="_blank" href="{{ url('/product/'.$cartitem['product']['seo_url']) }}">
                                            @if(!empty($cartitem['product']['product_image']))
                                                <img src="{{ asset('images/ProductImages/small/'.$cartitem['product']['product_image']['image']) }}" alt="{{ $cartitem['product']['product_name'] }}">
                                            @else
                                                <img src="{{ asset('images/no-image-found.jpg') }}" alt="{{ $cartitem['product']['product_name'] }}">
                                            @endif
                                        </a>
                                        <span>{{ $cartitem['qty'] }}</span>
                                    </div>

                                    <div class="checkout-product-info">
                                        <h4>
                                            <a target="_blank" href="{{ url('/product/'.$cartitem['product']['seo_url']) }}">
                                                {{ $cartitem['product']['product_name'] }}
                                            </a>
                                        </h4>
                                        <ul>
                                            <li>Item Code: {{ $cartitem['product']['product_code'] }}</li>
                                            <li>Color: {{ $cartitem['product']['color'] }}</li>
                                            <li>Size: {{ $cartitem['size'] }}</li>
                                        </ul>
                                    </div>

                                    <strong>INR {{ CustomFunction::formatAmt($priceDetails['prosubtotal'] / $cartitem['qty']) }}</strong>
                                </div>
                            @endforeach

                            <div id="order_summary">
                                @include('front.checkout.order_summary')
                            </div>

                            <div id="points-redemption-box" @if(empty($availablePoints)) style="display:none;" @endif>
                                <?php
                                    if (Session::has('pointsinfo')) {
                                        $currently_availablePoints = $availablePoints - Session::get('pointsinfo')['points'];
                                    } else {
                                        $currently_availablePoints = $availablePoints;
                                    }
                                ?>
                                <p id="available-points-text">
                                    💰 You have <span id="currently_availablePoints"><strong>{{ $currently_availablePoints ?? 0 }}</strong></span> Reward Points available
                                </p>

                                @if(($availablePoints ?? 0) > 0)
                                <div class="points-redeem-row">
                                    <input type="number" id="points_to_redeem" name="points_to_redeem" min="0" max="{{ $availablePoints }}" placeholder="Enter points to redeem" class="form-control" @if(Session::has('pointsinfo')) value="{{ Session::get('pointsinfo')['points'] }}" @endif>
                                    <button type="button" id="ApplyPoints" @if(Session::has('pointsinfo')) style="display:none;" @endif class="btn btn-outline-dark btn-sm">Apply</button>
                                    <button type="button" id="RemovePoints" class="btn btn-link btn-sm" @if(!Session::has('pointsinfo')) style="display:none;" @endif>Remove</button>
                                </div>
                                <div id="Address-points_to_redeem" class="points-err"></div>
                                @endif
                            </div>

                            <!-- PAYMENT -->
                            <div class="checkout-payment">
                                <h4>Payment Method</h4>

                                <label class="payment-option active">
                                    <input id="payment_method_phonepe" type="radio" class="input-radio" name="paymentMode" value="razorpay" data-order_button_text="Proceed to Razorpay" checked>

                                    <div class="payment-info">
                                        <strong>
                                            Razorpay
                                            <span>5% Discount</span>
                                        </strong>
                                        <p>Net Banking / Debit Card / Credit Card / UPI / Wallets</p>
                                        <div class="payment-icons">
                                            <span>VISA</span>
                                            <span>Mastercard</span>
                                            <span>RuPay</span>
                                            <span>UPI</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="payment-option">
                                    <input id="payment_method_cod" type="radio" class="input-radio" name="paymentMode" value="cod" data-order_button_text="Place Order">

                                    <div class="payment-info">
                                        <strong>Cash On Delivery</strong>
                                        <p>Pay when your order is delivered.</p>
                                    </div>
                                </label>

                                <div class="address-err" id="Address-paymentMode"></div>
                            </div>

                            <a href="javascript:;" id="PlaceOrder">
                                <button type="button" class="primary-btn place-order-btn w-100">
                                    <span>Place Order</span>
                                    <i class="fa-solid fa-lock ms-2"></i>
                                </button>
                            </a>

                            <div class="checkout-secure">
                                <i class="fa-solid fa-lock"></i>
                                <span>Secure & encrypted checkout</span>
                            </div>

                        </div>
                    </div>

                </div>
            </form>

        </div>
    </section>

    {{-- STATIC PLACEHOLDER MODAL: not wired to real data yet --}}
    <div class="modal fade" id="addressModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="address-form-section">
                        <h4>Shipping Address</h4>

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" placeholder="First name">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>Mobile</label>
                                    <div class="mobile-input">
                                        <span>+91</span>
                                        <input type="tel" class="form-control" placeholder="Enter mobile number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>Alternative Mobile Number</label>
                                    <input type="tel" class="form-control" placeholder="Alternative mobile">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>Address</label>
                                    <input type="text" class="form-control" placeholder="House number, street, area">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>Country</label>
                                    <select class="form-select">
                                        <option selected>India</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>State/Province</label>
                                    <select class="form-select">
                                        <option selected disabled>Select state</option>
                                        <option>Punjab</option>
                                        <option>Haryana</option>
                                        <option>Delhi</option>
                                        <option>Chandigarh</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>City</label>
                                    <input type="text" class="form-control" placeholder="City">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>Zip Code</label>
                                    <input type="text" class="form-control" placeholder="Zip code">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="billing-check">
                        <label>
                            <input type="checkbox" id="billingSame" checked>
                            <span>Billing address same as shipping address</span>
                        </label>
                    </div>

                    <div class="billing-form-section" id="billingForm">
                        <h4>Billing Address</h4>

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" placeholder="First name">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>Mobile</label>
                                    <div class="mobile-input">
                                        <span>+91</span>
                                        <input type="tel" class="form-control" placeholder="Enter mobile number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>Alternative Mobile Number</label>
                                    <input type="tel" class="form-control" placeholder="Alternative mobile">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>Address</label>
                                    <input type="text" class="form-control" placeholder="House number, street, area">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>Country</label>
                                    <select class="form-select">
                                        <option selected>India</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>State/Province</label>
                                    <select class="form-select">
                                        <option selected disabled>Select state</option>
                                        <option>Punjab</option>
                                        <option>Haryana</option>
                                        <option>Delhi</option>
                                        <option>Chandigarh</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>City</label>
                                    <input type="text" class="form-control" placeholder="City">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-field">
                                    <label>Zip Code</label>
                                    <input type="text" class="form-control" placeholder="Zip code">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="primary-btn save-address-btn">Save Address</button>
                </div>

            </div>
        </div>
    </div>
</main>
@stop

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>

    // Static address UI (placeholder - not wired to real data yet)
    $(document).on('click', '.saved-address-card', function() {
        $('.saved-address-card').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type=radio]').prop('checked', true);
    });

    $(document).on('change', '#billingSame', function() {
        if ($(this).is(':checked')) {
            $('#billingForm').hide();
        } else {
            $('#billingForm').show();
        }
    });

    $(document).on('click', '.save-address-btn', function() {
        var modalEl = document.getElementById('addressModal');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
        if (typeof RageToast !== 'undefined') {
            RageToast.show('Delivery destination saved!', 'fa-location-dot');
        }
    });

    // Payment option card selection (visual)
    $(document).on('click', '.payment-option', function() {
        $('.payment-option').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type=radio]').prop('checked', true).trigger('change');
    });

    $('input[name=paymentMode]').on('change', function() {
        var paymode = $(this).val();
        $('.PleaseWaitDiv').show();
        $.ajax({
            url: '/get-order-summery',
            type: 'POST',
            data: { _token: "{{ csrf_token() }}", paymode: paymode },
            success: function(res) {
                $('.PleaseWaitDiv').hide();
                $("#order_summary").html(res.order_summary);
            }
        });
    });

    // Points redemption - Apply
    $('#ApplyPoints').click(function() {
        var pointsToRedeem = parseInt($('#points_to_redeem').val()) || 0;
        var payment_mode = $('input[name=paymentMode]:checked').val();

        if (!payment_mode) { payment_mode = ''; }

        var availablePoints = {{ $availablePoints ?? 0 }};

        $('.points-err').html('');

        $('.PleaseWaitDiv').show();
        $.ajax({
            url: '/apply-points',
            type: 'POST',
            data: { _token: "{{ csrf_token() }}", points: pointsToRedeem, payment_mode: payment_mode },
            success: function(res) {
                $('.PleaseWaitDiv').hide();
                if (res.status) {
                    $("#order_summary").html(res.order_summary);
                    $('#Address-points_to_redeem').html('<span style="color:green">' + res.message + '</span>');
                    $('#ApplyPoints').hide();
                    $('#RemovePoints').show();
                } else {
                    $('#Address-points_to_redeem').html('<span style="color:red">' + res.message + '</span>');
                }
            }
        });
    });

    // Points redemption - Remove
    $('#RemovePoints').click(function() {
        $('.PleaseWaitDiv').show();

        var payment_mode = $('input[name=paymentMode]:checked').val();
        if (!payment_mode) { payment_mode = ''; }

        $.ajax({
            url: '/remove-points',
            type: 'POST',
            data: { _token: "{{ csrf_token() }}", payment_mode: payment_mode },
            success: function(res) {
                $('.PleaseWaitDiv').hide();
                $("#order_summary").html(res.order_summary);
                $('#Address-points_to_redeem').html('<span style="color:green">' + res.message + '</span>');
                $('#points_to_redeem').val('').prop('disabled', false);
                $('#ApplyPoints').show();
                $('#RemovePoints').hide();
            }
        });
    });

    $('#PlaceOrder').click(function() {
        $('.PleaseWaitDiv').show();
        var formdata = $("#OrderPlace").serialize();
        $.ajax({
            url: '/check-order',
            type: 'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                $('.address-err').html('');
                if (!data.status) {
                    if (data.type == "validation") {
                        var err_no = 0;
                        $.each(data.errors, function(i, error) {
                            err_no = err_no + 1;
                            $('#Address-' + i).html(error);
                            if (err_no == 1) {
                                $("#" + i).focus();
                            }
                        });
                    }
                } else {
                    $('#OrderPlace').attr('action', data.action);
                    $('#OrderPlace').submit();
                }
            }
        });
    });

</script>
@stop