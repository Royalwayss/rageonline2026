<?php use App\ShippingAddress; ?>





<h2><a href="{{url('account/dashboard')}}" style="color:#213271;font-size: 18px;">View Billing Address</a></h2><br><br>

<div class="col-12 addresses">
<div class="ShowResult"></div>
	<div class="row">

		<?php $addresses = ShippingAddress::where('user_id',Auth::user()->id)->get();  $address_count = 0;  ?> 

		@foreach($addresses as $address)
			<div class="col-sm-6 col-12">

                <div class="col-12">
                            <h5 class="orange"> Shipping Address </h5>
                </div>

				<ul class="filter listeeTarget radio"  @if($address['is_default'] =="yes") style="list-style: none; background-color:#d9fae7" @else style="list-style: none;" @endif>

					<li>	

						<input type="radio"  name="defaultAddress" id="Shipping{{$address['id']}}" @if($address['is_default'] =="yes") checked @endif value="{{$address['id']}}">

						<label for="Shipping{{$address['id']}}"><p>Name : {{$address['name']}} <br />

							Mobile : {{$address['mobile']}} <br/>

							{{$address['address']}}<br>

							{{$address['city']}}, {{$address['state']}}, {{$address['country']}}, {{$address['postcode']}} 

							<?php if($address['company_name'] != '' || $address['gstin'] != ''){ echo '<br>'. $address['company_name'].','.$address['gstin']; } ?>

							</p><br />

						<a href="javascript:;" data-addressid="{{$address['id']}}" class="address-edit editAddress" data-toggle="modal">Edit</a>

						@if($address['is_default'] !="yes")

							<a href="javascript:;" data-addressid="{{ $address['id'] }}" class="address-edit removeAddress">Remove</a></label>

						@endif

					</li>

				</ul>

			</div>

		@endforeach

	</div>

</div>



<div class="clearfix"></div>


@if(empty($addresses))
<div class="col-12 mt-3">

	<button class="add-btn-style" data-toggle="modal" data-target="#shipAdd" style="background-color: #253746;color:white"> <i class="fa fa-plus"></i> &nbsp; Add New Address</button>

</div>
@endif


@section('javascript')

@parent

<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>

<script type="text/javascript">

		

	// Remove Delivery Address

	$(document).on('click', '.removeAddress', function(e) {

		if (confirm('Are you sure you want to remove this?')) {

			$('.PleaseWaitDiv').show();

            var addressid = $(this).data("addressid");

            $.ajax({

                url: '/remove-delivery-address',

                type:'GET',

                data : {"id":addressid}, 

                success:function(resp){   

                    $('#deliveryAddresses').html(resp.view);

                    $('.PleaseWaitDiv').hide();

                        var  message ='Delivery Addresses removed successfully.';

                        var alertclasss = 'success';

                        $('.ShowResult').html('<div class="alert alert-'+alertclasss+' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+message+'</span></div>');

               

                }

            });

        }

    });



	// Set Default Delivery Address

    $(document).on('change', '[name=defaultAddress]', function(){

    	$('.PleaseWaitDiv').show();

        var addressid = $(this).val();

        $.ajax({

            type:'get',

            url:'/set-default-address',

            data:{addressid:addressid},

            success:function(resp){

                $('#deliveryAddresses').html(resp.view);  

                $('.PleaseWaitDiv').hide();

				        var  message ='Delivery Addresses updated successfully.';

                        var alertclasss = 'success';

                        

                        $('.alert-danger').hide();

                        $('.ShowResult').html('<div class="alert alert-'+alertclasss+' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+message+'</span></div>');

               

            },

            error:function(){

            	//nothing to do

            }

        });

    });



	$(document).on('click', '.editAddress', function(e) {

    	$('.PleaseWaitDiv').show();

    	var addressid = $(this).data("addressid");

    	$.ajax({

    		data : { id:addressid},

    		url : "/get-delivery-address",

    		type : 'get',

    		success:function(resp){

    			$('.PleaseWaitDiv').hide();

    			if(resp.status){

    				$('[name=shipping_id]').val(resp.address['id']);

    				$('[name=first_name]').val(resp.address['first_name']);

    				$('[name=last_name]').val(resp.address['last_name']);

    				$('[name=state]').val(resp.address['state']);

    				$('[name=city]').val(resp.address['city']);

    				$('[name=mobile]').val(resp.address['mobile']);

    				$('[name=postcode]').val(resp.address['postcode']);

    				$('[name=address]').val(resp.address['address']);

    				$('[name=address2]').val(resp.address['address2']);

    				$('[name=company_name]').val(resp.address['company_name']);

    				$('[name=gstin]').val(resp.address['gstin']);

    				$('#shipAdd').modal('show');

    			}else{

    				$('#deliveryAddresses').html(resp.view);

    			}

    		}

    	});

    });


	$(document).on('click', '#btnShipping', function(e) {
		//alert($('.company').val().length);
                if($('.company').val().length!=0){
                    if($('#gstin').val().length==0){
                        $("#gstin").prop('required',true);
                        $('#DeliveryAddress-gstin').css("display", "block");
                        return false;
                    }else{
                        $("#gstin").prop('required',false);
                        $('#DeliveryAddress-gstin').css("display", "none");       
                        //return true;
                    }
                }else{
                    $("#gstin").prop('required',false);
                    $('#DeliveryAddress-gstin').css("display", "none");  
                    //return true;
                }
		$('.PleaseWaitDiv').show();

		var formdata = $("#addressModalForm").serialize();

		$.ajax({

            url: '/save-address',

            type:'POST',

            data: formdata,

            success: function(data) {

            	$('.PleaseWaitDiv').hide();

            	if(!data.status){

                    $.each(data.errors, function (i, error) {

                        $('#DeliveryAddress-'+i).attr('style', 'color:red');

                        $('#DeliveryAddress-'+i).html(error);

                        $('#DeliveryAddress-'+i).addClass('error-triggered');

                        setTimeout(function () {

                            $('#DeliveryAddress-'+i).css({

                                'display': 'none'

                            });

                        }, 3000);

                        $('#DeliveryAddress-'+i).removeClass('error-triggered');

                    });

                    $('html,body').animate({

                        scrollTop: $('.error-triggered').first().stop().offset().top - 200

                    }, 1000);

                }else{

                	$('#shipAdd').modal('hide');

                	$('#addressModalForm').trigger("reset");

                    $('#deliveryAddresses').html('<hr />' + data.view);

					 

					 

					   

						var  message ='Delivery Addresses updated successfully.';

                        var alertclasss = 'success';

                        $('.ShowResult').html('<div class="alert alert-'+alertclasss+' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+message+'</span></div>');

                        $('.alert-danger').hide();

						setTimeout(function(){

							$(".ShowResult").slideUp();      

						}, 3000);

						

					}

            	

            }

        });

	});

</script>

@stop