@extends('layouts.frontLayout.front-layout')
@section('content')
<?php
    use App\CustomFunction;
    use App\Cart;
    use App\CouponCode;
    use App\GiftOffer;

    $total_gst = '0';
    $subtotal = 0;
    $address_type = 'shipping';
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

                            {{-- Real saved shipping addresses. The controller rendering
                                 this page must pass $shippingAddresses - see note below. --}}
                            @include('front.checkout.address-list')
                            <p class="address-err error-message" id="address-err"> </p>
                            <button type="button" class="add-address-btn" onclick="loadAddressForm('shipping', 0)">
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
                                    <input id="payment_method_phonepe" type="radio" class="input-radio" name="paymentMode" value="razorpay" data-order_button_text="Proceed to Razorpay">

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

    {{-- Modal shell - body is loaded via AJAX by loadAddressForm() --}}
    <div class="modal fade" id="addressModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="addressModalContent">
                <!-- AJAX-loaded content goes here -->
            </div>
        </div>
    </div>
</main>
@stop

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>

    // Address book - real AJAX wiring
    $(document).on('click', '.saved-address-card', function() {
        $('.saved-address-card').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type=radio]').prop('checked', true);
    });

    function loadAddressForm(type, id) {
        $('.PleaseWaitDiv').show();
        $.ajax({
            url: '/address/form/' + type + '/' + id,
            type: 'GET',
            success: function(html) {
                $('.PleaseWaitDiv').hide();
                $('#addressModalContent').html(html);
                var modal = new bootstrap.Modal(document.getElementById('addressModal'));
                modal.show();
            }
        });
    }

    $(document).on('change', '#billingSame', function() {
        if ($(this).is(':checked')) {
            $('#billingForm').hide();
        } else {
            $('#billingForm').show();
        }
    });

    $(document).on('submit', '#addressForm', function(e) { 
        e.preventDefault();
        $('.PleaseWaitDiv').show();
        var formdata = $('#addressForm').serialize();
        $.ajax({
            url: '/address/save',
            type: 'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                $('.err').html('');
                if (!data.status) {
                    if (data.type == 'validation') { 
                        $.each(data.errors, function(i, error) {
                            $('#Address-' + i).html(error);
                        });
                    } else {
                        printSuccessMsg(data.message);
                    }
					
                } else { 
                    $('#addressListWrap').replaceWith(data.view);
                    var modalEl = document.getElementById('addressModal');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    if (typeof RageToast !== 'undefined') {
                       // RageToast.show(data.message, 'fa-location-dot');
                    }
					printSuccessMsg(data.message);
                }
            }
        });
    });

    function deleteAddress(id) {
        if (!confirm('Remove this address?')) {
            return;
        }
        $('.PleaseWaitDiv').show();
        $.ajax({
            url: '/address/delete',
            type: 'POST',
            data: { _token: "{{ csrf_token() }}", id: id },
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if (data.status) {
                    $('#addressListWrap').replaceWith(data.view);
					printSuccessMsg(data.message);
                } else {
                    printSuccessMsg(data.message);
                }
            }
        });
    }

    function setDefaultAddress(id) {
        $('.PleaseWaitDiv').show();
        $.ajax({
            url: '/address/set-default',
            type: 'POST',
            data: { _token: "{{ csrf_token() }}", id: id },
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if (data.status) {
                    $('#addressListWrap').replaceWith(data.view);
                } else {
                    alert(data.message);
                }
            }
        });
    }

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
							printErrorMsg(error);
							return false; // stops $.each after the first item
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