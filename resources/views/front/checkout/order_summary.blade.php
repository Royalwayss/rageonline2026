<?php
use App\Cart;
$subtotal = 0;
?>
@foreach($cartitems as $cart_key => $cartitem)
    <?php
        $priceDetails = Cart::calProPricing($cartitem);
        $subtotal += $priceDetails['prosubtotal'];
    ?>
@endforeach

<div class="checkout-totals">

    <div>
        <span>Sub Total</span>
        <strong>{{ AmountFormat($subtotal) }}</strong>
    </div>

    <div>
        <span>Shipping</span>
        <strong>{{ AmountFormat($cartPricing['shipping']) }}</strong>
    </div>

    <input type="hidden" id="discountamount" value="{{ $cartPricing['discount'] }}">

    <div>
        <span>Coupon Discount</span>
        <strong class="discount_amount">{{ AmountFormat($cartPricing['discount']) }}</strong>
    </div>

    @if(!empty($cartPricing['order_discount']))
    <div>
        <span>Order Discount ({{ $cartPricing['order_discount_percentage'] }}%)</span>
        <strong>{{ AmountFormat($cartPricing['order_discount']) }}</strong>
    </div>
    @endif

    @if(!empty($cartPricing['prepaid_discount']))
    <div id="prepaid_discount">
        <span>Prepaid Discount</span>
        <strong class="prepaid_discount">{{ AmountFormat($cartPricing['prepaid_discount']) }}</strong>
    </div>
    @endif

    @if(Session::has('pointsinfo'))
    <div id="prepaid_discount">
        <span>Reward Points</span>
        <strong class="prepaid_discount">{{ AmountFormat(Session::get('pointsinfo')['amount']) }}</strong>
    </div>
    @endif

    @if(!empty($cartPricing['round_of']))
    <div id="round_of">
        <span>Round Of</span>
        <strong class="round_of"><?php echo round_of($cartPricing['round_of']); ?></strong>
    </div>
    @endif

</div>

<div class="checkout-grand-total">
    <span>Grand Total <br>
        <small>Inclusive of all taxes</small>
    </span>
    <strong class="grandtotal_amount">
        @if(Session::has('pointsinfo'))
            {{ AmountFormat($cartPricing['final_grandtotal'] - Session::get('pointsinfo')['amount']) }}
        @else
            {{ AmountFormat($cartPricing['final_grandtotal']) }}
        @endif
    </strong>
</div>