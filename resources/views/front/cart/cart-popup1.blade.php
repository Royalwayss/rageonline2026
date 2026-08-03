<?php use App\Cart; 
$cartitems = Cart::cartitems();
?>
<div id="cartdata">
 <div class="gray-bg-with-icon">
        <div class="row align-items-center">
            <div class="col-sm-6 col-8">
                <a href="{{url('/cart') }}">Go to Cart</a>
            </div>
            <div class="col-sm-6 col-4 text-right">
                <button id="close-btn" style="background: #253746; color: #fff; border: none; padding: 2px 8px; cursor: pointer;">X</button>
            </div>
        </div>
    </div>
    <hr>
    <div>
      <ul class="shopping-cart-items">
		@if(!empty($cartitems))
			@foreach($cartitems as $cartitem)
			<?php $priceDetails = Cart::calProPricing($cartitem);?>
				<li class="clearfix">
				    @if(!empty($cartitem['product']['product_image']))
					    <img src="{{asset('images/ProductImages/small/'.$cartitem['product']['product_image']['image'])}}" class="img-fluid" alt="" style="width: 60px; margin-bottom: 5px;">
					@else
						<img src="{{asset('images/no-image-found.jpg')}}" alt="" class="img-fluid" alt="{{$cartitem['product']['product_name']}}" title="{{$cartitem['product']['product_name']}}" />
					@endif
					<span class="item-name">{{$cartitem['product']['product_name']}}</span>
					<span class="item-detail">{{$cartitem['size']}}</span>
					<span class="item-price">Rs. {{formatAmt($priceDetails['price'])}}</span>
				</li>
			@endforeach
		@else
			<p class="text-center">No items found</p>
		@endif
      </ul>
      <div>
          <a class="cart-btn" href="{{ url('/cart')}}" style="background-color: #253746; padding: 10px 20px; color: #fff; border: 0; font-size: 14px; width: 100%;display: block; text-align: center; margin-bottom: 8px;">Go to cart</a>
      </div>
      <div>
          <a class="cart-btn" href="{{ url('') }}" style="background-color: #253746; padding: 10px 20px; color: #fff; border: 0; font-size: 14px; width: 100%; display: block; text-align: center;">Continue Shopping</a>
      </div>
    </div>
	</div>