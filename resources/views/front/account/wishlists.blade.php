<div class="row accTabsInfo">
	<center></center><div style="color:green"class="addcart"> </div></center>
	<div class="col-12 wishlist">
		<h4 class="booster-font">Wishlist</h4><hr />
		@if(Session::has('flash_message_success'))
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Success!</strong> {!! session('flash_message_success') !!}
			</div>
		@endif
		@if(count($wishlists) >0)
			<div class="row" id="" >
				@foreach($wishlists as $wishlist)
				<div class="col-md-12 col-12">
					<div class="wishlist-data">
						<div class="wishlist-img-wrap">
						<a href="{{ url('product/'.$wishlist->product->seo_url) }}">
							@if(!empty($wishlist->product->product_image))
								<img src="{{asset('images/ProductImages/small/'.$wishlist->product->product_image->image)}}" class="img-fluid" alt="{{$wishlist->product->product_name}}" />
							@else
								<img src="{{asset('images/no-image-found.jpg')}}" class="img-fluid" alt="{{$wishlist->product->product_name}}" title="{{$wishlist->product->product_name}}" />
							@endif
						</a>
						</div>
						<div class="w-100">
							<div class="row" id="row_wish-{{$wishlist->id}}">
								<div class="col-lg-11 col-md-6 col-9 wishlist-text-wrap">
									<a href="{{ url('product/'.$wishlist->product->seo_url) }}"><h5 class="cart-prod-name">{{$wishlist->product->product_name}}</h5></a>
									<p>Size. :  {{$wishlist->size}}</p>
									<p>Item No. :  {{$wishlist->product->product_code}}</p>
									<p>Color : {{$wishlist->product->color}}</p>
									
									@if($wishlist->product->status == 1)
										<p> <a class="prodcut-detail" href="{{ url('product/'.$wishlist->product->seo_url) }}"> <b>View Product Details </b></a> </p>
								    @else
										<p> <a class="prodcut-detail" href="javascript:;"><b> Product is not available </b></a></p>
									@endif
									
								</div>
								
								<div class="col-lg-1 col-1 wishlist-btns-style">
									<p class="wishlist-btn">
										<a onclick="return confirm('Are you sure?')" href="{{url('remove-wishlist/'.$wishlist->id)}}" class="cart-btn-style">
											<i class="fa fa-trash"></i>
											
										</a>
									</p>
									
								</div>  
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<hr />
				</div>
				@endforeach
			</div>
		@else
			<div class="row">
		        <div class="col-12 text-center pt-5 pb-5">
		            <i class="fa fa-exclamation-circle fa-4x orange"></i>
		            <h3 class="mt-4 mb-4">No Wishlist items Found</h3>
		        </div>
		    </div> 
		@endif
	</div>
	
</div>
@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script type="text/javascript">
	$(".MovetoBag").submit(function(e){
			var id = $(this).attr('id');
	        e.preventDefault();
	        $('.PleaseWaitDiv').show();
	        var formdata = $("#"+id).serialize();
	        $.ajax({
	            url: '/add-to-cart',
	            type:'POST',
	            data: formdata,
	            success: function(data) {
	                $('.PleaseWaitDiv').hide();
	                if(!data.status){
	            		if(data.type=="validation"){
	            			
							$.each( data.errors, function( key, value ) { 
									alert(value);
	                    	        
									
								});
	            		}
	            	}else{
					    $('.totalItems').html(data.totalitems);
					   //$('#row_'+id).attr('style', 'display:none');
					    $(".shopping-cart").toggleClass("active");
					    var  alertclasss = 'success';
						var message = 'Product added successfully in cart';
						$('.addcart').html('<div class="alert alert-'+alertclasss+' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+message+'</span></div>');
						location.reload();
	            	}
	            }
	        });
	    });
</script>
@stop