@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page">
    <section class="cart-page">
        <div class="container-fluid">

            <div class="cart-head">
                <span>Your Selection</span>
                <h1>Shopping Bag</h1>
                <p>Review your selected pieces before checkout.</p>
            </div>

            <div id="Cartindixdiv" tabindex="-1"></div>
            <div id="CartMessages"></div>

            <div id="AppendCartDetails">
                @include('front.cart.cart-details')
            </div>

        </div>
    </section>
</main>

<!-- Guest checkout modal -->
<div class="modal fade" id="GuestCheckoutModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content review-modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Guest Checkout</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="notify_msg"></div>
                <form action="javascript:;" method="post" id="GuestCheckoutForm">
                    @csrf
                    <div class="review-field">
                        <label for="email_address">Email:</label>
                        <input type="email" class="form-control" id="email_address" name="email_address">
                        <p class="err text-center" id="guestCheckout-email_address" style="display: none;"></p>
                    </div>
                    <div class="review-field">
                        <label for="mobile">Mobile:</label>
                        <input type="text" class="form-control" id="mobile" name="mobile">
                        <p class="err text-center" id="guestCheckout-mobile" style="display: none;"></p>
                    </div>
                    <button type="submit" class="review-submit-btn mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Guest checkout modal end -->

@stop
@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>
    $(document).ready(function() {

        $(document).on('change', '[name=coupon]', function() {
            var coupon = $(this).val();
            $('#couponInput').val(coupon);
            $("#ApplyCoupon").trigger("submit");
        })

        $(document).on('submit', '#ApplyCoupon', function(e) {
            e.preventDefault();
            $('.PleaseWaitDiv').show();
            var alertclasss = "";
            var formdata = $("#ApplyCoupon").serialize() + "&_token={{csrf_token()}}";
            $.ajax({
                type: 'post',
                data: formdata,
                url: '/apply-coupon',
                success: function(resp) {
                    if (!resp.status) {
                        $('#AppendCartDetails').html(resp.view);
                        $('#couponInput').val('');
                        alertclasss = "danger";
                    } else {
                        $('#AppendCartDetails').html(resp.view);
                        alertclasss = "success";
                    }
                    $('#PrintMessages').html('<div class="alert alert-' + alertclasss + ' alert-dismissible"><button type="button" class="close" data-bs-dismiss="alert">&times;</button><span>' + resp.message + '</span></div>');
                    $('.PleaseWaitDiv').hide();
                },
                error: function() {
                    //nothing to do
                }
            })
        });


        $(document).on('change', '[name=size]', function() {
            $('.PleaseWaitDiv').show();
            var size = $(this).val();
            var cartid = $(this).find(':selected').attr('data-cartid');
            var cartsku = $(this).find(':selected').attr('data-cartsku');
            $.ajax({
                data: {
                    "_token": "{{csrf_token()}}",
                    "cartid": cartid,
                    "size": size,
                    "cartsku": cartsku
                },
                url: '/update-cart-productsize',
                type: 'post',
                success: function(resp) {
                    var alertclasss = "";
                    if (!resp.status) {
                        $('#AppendCartDetails').html(resp.view);
                        alertclasss = "danger";
                    } else {
                        $('#AppendCartDetails').html(resp.view);
                        $('#couponInput').val('');
                        alertclasss = "success";
                    }
                    $('.PleaseWaitDiv').hide();
                    if (resp.message != "") {
                        $('#CartMessages').html('<div class="alert alert-' + alertclasss + ' alert-dismissible"><button type="button" class="close" data-bs-dismiss="alert">&times;</button><span>' + resp.message + '</span></div>');
                    }
                    $("#Cartindixdiv").focus();
                },
                error: function() {
                    //nothing to do
                }
            })
        })

        $("#GuestCheckoutForm").submit(function(e) {
            e.preventDefault();
            $('.PleaseWaitDiv').show();
            var formdata = $("#GuestCheckoutForm").serialize();
            $.ajax({
                url: "/guest-checkout",
                type: 'POST',
                data: formdata,
                success: function(data) {
                    $('.PleaseWaitDiv').hide();
                    if (!data.status) {
                        if (data.type == "validation") {
                            $.each(data.errors, function(i, error) {
                                $('#guestCheckout-' + i).attr('style', '');
                                $('#guestCheckout-' + i).html(error);
                                setTimeout(function() {
                                    $('#guestCheckout-' + i).css({
                                        'display': 'none'
                                    });
                                }, 3000);
                            });
                        }
                    } else {
                        window.location.href = data.url;
                    }
                }
            });
        });

    });

    $(document).on('click', '#GuestLogin', function() {
        $('#GuestLoginModel').modal('show');
    });

    function qty_onchange(type = '', id = '') {
        if (type == 'plus') {
            var quantity = $("#qty-" + id).val();

            if (quantity == '') {
                quantity = 0;
            }
            var sum = parseInt(quantity) + 1;
            $("#qty-" + id).val(sum);
            update_qty(sum, id);
        } else {
            var quantity = $("#qty-" + id).val();
            if (quantity > 1) {
                $("#qty-" + id).val(quantity - 1);
                update_qty(quantity - 1, id);
            }
        }
    }

    function update_qty(qty, cartid) {
        $('.PleaseWaitDiv').show();

        $.ajax({
            data: {
                "_token": "{{csrf_token()}}",
                "cartid": cartid,
                "qty": qty
            },
            url: '/update-cart-product',
            type: 'post',
            success: function(resp) {
                var alertclasss = "";
                if (!resp.status) {
                    $('#AppendCartDetails').html(resp.view);
                    alertclasss = "danger";
                } else {
                    $('#AppendCartDetails').html(resp.view);
                    $('#couponInput').val('');
                    alertclasss = "success";
                }
                $('.PleaseWaitDiv').hide();
                if (resp.message != "") {
                    $('#CartMessages').html('<div class="alert alert-' + alertclasss + ' alert-dismissible"><button type="button" class="close" data-bs-dismiss="alert">&times;</button><span>' + resp.message + '</span></div>');
                }
                $("#Cartindixdiv").focus();
            },
            error: function() {
                //nothing to do
            }
        })
    }

    function copyCode(copycode) {
        $("#couponInput").val(copycode);
        var copyText = document.getElementById("couponInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        $("#ApplyCoupon").trigger("submit");
    }
</script>
@stop