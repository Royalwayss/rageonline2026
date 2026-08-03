@extends('layouts.frontLayout.front-layout')
@section('content')
<style>
   .cart-warp .title{
   margin-bottom: 5vh;
   }
   .cart-warp .card{
   margin: auto;
   max-width: 950px;
   width: 90%;
   box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
   border-radius: 1rem;
   border: transparent;
   }
   @media(max-width:767px){
   .cart-warp .card{
   margin: 3vh auto;
   }
   }
   .cart-warp .cart{
   background-color: #fff;
   padding: 4vh 5vh;
   border-bottom-left-radius: 1rem;
   border-top-left-radius: 1rem;
   }
   @media(max-width:767px){
   .cart-warp .cart{
   padding: 4vh;
   border-bottom-left-radius: unset;
   border-top-right-radius: 1rem;
   }
   }
   .cart-warp .summary{
   background-color: #ddd;
   border-top-right-radius: 1rem;
   border-bottom-right-radius: 1rem;
   padding: 4vh;
   color: rgb(65, 65, 65);
   }
   @media(max-width:767px){
   .cart-warp .summary{
   border-top-right-radius: unset;
   border-bottom-left-radius: 1rem;
   }
   }
   .cart-warp .summary .col-2{
   padding: 0;
   }
   .cart-warp .summary .col-10
   {
   padding: 0;
   }
   .cart-warp .close{
   margin-left: auto;
   font-size: 0.7rem;
   }
   .cart-warp img{
   width: 3.5rem;
   }
   .cart-warp .back-to-shop{
   margin-top: 4.5rem;
   }
   .cart-warp h5{
   margin-top: 4vh;
   }
   .cart-warp hr{
   margin-top: 1.25rem;
   }
   .cart-warp form{
   padding: 2vh 0;
   }
   .cart-warp select{
   border: 1px solid rgba(0, 0, 0, 0.137);
   padding: 1.5vh 1vh;
   margin-bottom: 4vh;
   outline: none;
   width: 100%;
   background-color: rgb(247, 247, 247);
   }
   .cart-warp input{
   border: 1px solid rgba(0, 0, 0, 0.137);
   padding: 1vh;
   margin-bottom: 4vh;
   outline: none;
   width: 100%;
   background-color: rgb(247, 247, 247);
   }
   .cart-warp input:focus::-webkit-input-placeholder
   {
   color:transparent;
   }
   .cart-warp .btn{
   background-color: #000;
   border-color: #000;
   color: white;
   width: 100%;
   font-size: 0.7rem;
   margin-top: 4vh;
   padding: 1vh;
   border-radius: 0;
   }
   .cart-warp .btn:focus{
   box-shadow: none;
   outline: none;
   box-shadow: none;
   color: white;
   -webkit-box-shadow: none;
   -webkit-user-select: none;
   transition: none; 
   }
   .cart-warp .btn:hover{
   color: white;
   }
   .cart-warp #code{
   background-image: linear-gradient(to left, rgba(255, 255, 255, 0.253) , rgba(255, 255, 255, 0.185)), url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
   background-repeat: no-repeat;
   background-position-x: 95%;
   background-position-y: center;
   }
   .f-size { font-size:13px;}
   .card-registration .btn-link {    
   background: #8e313c;
    border: 0;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    width: 38px;
    height: 38px;
   }
   .card-registration .btn-link.focus, .card-registration .btn-link:focus, .card-registration .btn-link:hover{
     background: #000;
       color: #fff;
   }
   .card-registration .summary {box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .07), 0 4px 6px -2px rgba(0, 0, 0, .05);
   }
   .card-registration.card {box-shadow: inherit;
   }
   .card-registration .coupon-welcome { padding: 10px; height:auto;}
   .coupon-welcome h6 {
   background-color: #8e313c;
   padding: 5px 10px;
   margin-right: 10px;
   }
   .coupon-welcome p { font-size:12px;     }
   .coupon-welcome p span { margin-left: 10px;}
   .card-registration .input-wrapper button {
   top: 28px;
   padding: 14px;
   }
   .available_coupon_code{
	 background-color: #8e313c;
    padding: 5px 10px;
    border: transparent;
    margin-right: 0;
    width: 100%;
    text-align: center;
    color: #fff;
   }
   .cartoffer {
    background: url(images/listing-bg.jpg);
    color: #fff;
    padding: 14px 10px;
    margin-bottom: 20px;
    text-align: center;
    font-size: 16px;
    line-height: normal;
    font-weight: 200;
  }
</style>
<link rel="stylesheet" href="css/bootstrap-shopping-carts.min.css" />
<main>
   <section class="h-100 h-custom">
      <div class="container py-5 h-100">
         <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
               <div id="Cartindixdiv" tabindex="1">  </div>
		       <div id="CartMessages"></div> 
			   <div class="card card-registration card-registration-2" id="AppendCartDetails" style="border-radius: 15px;">
                  @include('front.cart.cart-details')
			   </div>
            </div>
         </div>
      </div>
   </section>
</main>
<!-- Guest checkout model start -->
<div class="modal fade" id="GuestCheckoutModal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Guest Checkout</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <div id="notify_msg"></div>
            <form action="javascript:;" method="post" id="GuestCheckoutForm">
               @csrf
               <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" id="email_address" name="email_address">
                  <p class="err text-center" id="guestCheckout-email_address" style="display: none;"></p>
               </div>
               <div class="form-group">
                  <label for="email">Mobile:</label>
                  <input type="text" class="form-control" id="mobile" name="mobile">
                  <p class="err text-center" id="guestCheckout-mobile" style="display: none;"></p>
               </div>
               <button type="submit" class="btn btn-default mt-3" style="background-color: #000;;border: none;color: white; border-radius:0">Submit</button>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Guest checkout model end --> 
@stop
@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>
   $(document).ready(function(){
   	$(document).on('change','[name=coupon]',function(){ 
   		var coupon = $(this).val();
   		$('#couponInput').val(coupon);
   		$( "#ApplyCoupon" ).trigger( "submit" );
   	})
   
   	$(document).on('submit','#ApplyCoupon',function(e){  
   		e.preventDefault(); 
   		$('.PleaseWaitDiv').show();
   		var alertclasss ="";
   		var formdata = $("#ApplyCoupon").serialize()+"&_token={{csrf_token()}}";
   		$.ajax({
   			type : 'post',
   			data : formdata,
   			url :'/apply-coupon',
   			success:function(resp){
   				if(!resp.status){
   					$('#AppendCartDetails').html(resp.view);
   					$('#couponInput').val('');
   					alertclasss ="danger";
   				}else{
   					$('#AppendCartDetails').html(resp.view);
   					alertclasss ="success";
   				}
   				$('#PrintMessages').html('<div class="alert alert-'+alertclasss+' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+resp.message+'</span></div>');
   				$('.PleaseWaitDiv').hide();
   			},
   			error:function(){
   				//nothing to do
   			}
   		})
   	});
   
   
     
     $(document).on('change','[name=size]',function(){
   		$('.PleaseWaitDiv').show();
   		var size = $(this).val();
   		var cartid = $(this).find(':selected').attr('data-cartid');
   		var cartsku = $(this).find(':selected').attr('data-cartsku');
   		$.ajax({
   			data : {
   				"_token" : "{{csrf_token()}}",
   				"cartid" : cartid,
   				"size" : size,
   				"cartsku" : cartsku
   			},
   			url : '/update-cart-productsize',
   			type : 'post',
   			success:function(resp){
   				if(!resp.status){
   					$('#AppendCartDetails').html(resp.view);
   					alertclasss ="danger";
   				}else{
   					$('#AppendCartDetails').html(resp.view);
   					$('#couponInput').val('');
   					alertclasss ="success";
   				}
   				$('.PleaseWaitDiv').hide();
   				if(resp.message !=""){
   					$('#CartMessages').html('<div class="alert alert-'+alertclasss+' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+resp.message+'</span></div>');
   				}
   				  $("#Cartindixdiv").focus();
   			},	
   			error:function(){
   				//nothing to do
   			}
   		})
   	})
   
     $("#GuestCheckoutForm").submit(function(e){ 
          e.preventDefault();
          $('.PleaseWaitDiv').show();
          var formdata = $("#GuestCheckoutForm").serialize();
          $.ajax({
              url: "/guest-checkout",
              type:'POST',
              data: formdata,
              success: function(data) {
                  $('.PleaseWaitDiv').hide();
                  if(!data.status){
                      if(data.type=="validation"){
                          $.each(data.errors, function (i, error) {
                              $('#guestCheckout-'+i).attr('style', '');
                              $('#guestCheckout-'+i).html(error);
                              setTimeout(function () {
                                  $('#guestCheckout-'+i).css({
                                      'display': 'none'
                                  });
                              }, 3000);
                          });
                      }
                  }else{
                      window.location.href= data.url;
                  }
              }
          });
      });
     
   
   });
   $(document).on('click','#GuestLogin',function(){
    $('#GuestLoginModel').modal('show');
   });	
   function loginrequired(){
          $('#overlay-back').fadeIn(500,function(){
   		$('#popup').show();
   	});
   	 $('#overlay-back').fadeIn(500,function(){
   		$('#popup').show();
   	});
   	$(".close-image").on('click', function() {
   		$('#popup').hide();
   		$('#overlay-back').fadeOut(500);
   	});
   	$(".close-image-signin").on('click', function() {
   		$('#popupsignin').hide();
   		$('#overlay-back-signin').fadeOut(500);
   	});
   	$(".close-image-forgot").on('click', function() {
   		$('#popupforgot').hide();
   		$('#overlay-back-forgot').fadeOut(500);
   	});
   
   }
   function qty_onchange(type='',id=''){
	 if(type == 'plus'){   
		var quantity = $("#qty-"+id).val(); 
	
		if(quantity == ''){
			quantity = 0;
		}
		var sum =  parseInt(quantity) + 1;     
		$("#qty-"+id).val(sum);
		update_qty(sum,id);
	 }else{
		   var quantity = $("#qty-"+id).val();
			if(quantity > 1){
				$("#qty-"+id).val(quantity-1);
				update_qty(quantity-1,id);
			}
	 }		 
	   
	   
   }
   	function update_qty(qty,cartid){ 
   		$('.PleaseWaitDiv').show();
   		
   		$.ajax({
   			data : {
   				"_token" : "{{csrf_token()}}",
   				"cartid" : cartid,
   				"qty" : qty
   			},
   			url : '/update-cart-product',
   			type : 'post',
   			success:function(resp){
   				if(!resp.status){ 
   					$('#AppendCartDetails').html(resp.view);
   					alertclasss ="danger";
   				}else{
   					$('#AppendCartDetails').html(resp.view);
   					$('#couponInput').val('');
   					alertclasss ="success";
   				}
   				$('.PleaseWaitDiv').hide();
   				if(resp.message !=""){
   					$('#CartMessages').html('<div class="alert alert-'+alertclasss+' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+resp.message+'</span></div>');
   				}
   				 $("#Cartindixdiv").focus();
   			},	
   			error:function(){
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
 // $('#copymsg').show();
 $( "#ApplyCoupon" ).trigger( "submit" );
}     
</script>
@stop