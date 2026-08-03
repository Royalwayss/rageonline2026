<script>
   $(document).ready(function(){ 
   $(document).on('click','.removeCartProduct',function(){ 
   			if (confirm('Are you sure you want to delete this?')) {
   				$('.PleaseWaitDiv').show();
   				var cartid = $(this).data('cart');
   				var cart_type = $(this).data('type');
   				$.ajax({
   					type : 'post',
   					data : {
   						"cartid" : cartid,
   						"_token" : "{{csrf_token()}}"
   					},
   					url :'/remove-cart-product',
   					success:function(resp){
   						
   						if(cart_type != 'popup'){
   							if(!resp.status){
   								$('#AppendCartDetails').html(resp.view);
   								alertclasss ="danger";
   							}else{
   								$('#AppendCartDetails').html(resp.view);
   								alertclasss ="success";
   							}
   							$('#couponInput').val(''); 
   							$('.totalItems').html(resp.totalItems);
   							$('#CartMessages').html('<div class="alert alert-'+alertclasss+' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+resp.message+'</span></div>');
   							$("#Cartindixdiv").focus();
   						}
   						cartitems_Ajax();
   						$('.PleaseWaitDiv').hide();
   						
   					},
   					error:function(){
   						//nothing to do
   					}
   				})
   			
   			}
   		})
   		
   		//Guest Checkout
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
   
   
   /* Product Quick View */
   $(document).on('click','.btn-quickview',function(){ 
                   $('.PleaseWaitDiv').show(); 
   	            $.ajax({
   					type : 'post',
   					data : {
   						"seo_url" : $(this).attr('data-product-seo_url'),
   						"_token" : "{{csrf_token()}}"
   					},
   					url :'{{ route('product_quick_view') }}',
   					success:function(resp){ 
   						$('#productOffcanvas').empty();
   						$('#productOffcanvas').html(resp.html);
   						$('#productOffcanvas').addClass("show");
   						$('.PleaseWaitDiv').hide();
   						
   					},
   					error:function(){
   						//nothing to do
   					}
   				})
   
   });
   /* Product Quick View */


   /* Add to Cart Start */
    $(document).on('click','.addCart',function(e){ 
       
       var cart_type = $(this).data('cart-type');   
       var page_type = $(this).attr('page-type');   
             if(cart_type == 'buy'){     
         $('[name=action]').val('buy');
       }else{
         $('[name=action]').val('');
       }
       var proid = $(this).attr('data-product-id');
           e.preventDefault();
           $('.PleaseWaitDiv').show();
			 var size = $("#"+page_type+"-product_size").val(); 
			 var qty= $("#"+page_type+"-qty").val();
			 var _token = "{{csrf_token()}}";
           var formdata = { proid:proid,size:size,qty:qty,_token:_token};
           var actionType= $('[name=action]').val();
           $.ajax({
               url: '/add-to-cart',
               type:'POST',
               data: formdata,
               success: function(data) {
                   $('.PleaseWaitDiv').hide();
                   if(!data.status){
                   if(data.type=="validation"){
                         printErrorMsg(data.errors);
                         $('.print-error-msg').delay(3000).fadeOut('slow');
                   }
                 }else{
                    $('#msgDiv').css('display', 'block').delay(3000).fadeOut('slow');
                     $('.totalItems').html(data.totalitems);
               if(actionType =="buy"){
                 window.location.href = "/cart";
               }else{
                          cartitems_Ajax();
                          printSuccessMsg(data.message);
                         $('.print-success-msg').delay(3000).fadeOut('slow');
                 
               }
                   $('input[name="size"]').attr('checked', false);
                 }
               }
           });
       });
       
   /* Add to Cart End */






   
   /* Product Quick View Close*/
   $(document).on('click','#productOffcanvascloseBtn',function(){ 
   	$('#productOffcanvas').removeClass("show");
   	
   });
   /* Product Quick View Close*/
   

  /*  Add to Wishlist Start */
		$(document).on('click','.addWishList',function(){ 
			$('.PleaseWaitDiv').show();
			var page_type = $(this).attr('page-type');
			var proid = $(this).data('productid');
			var size = $("#"+page_type+"-product_size").val();
			$.ajax({
				data : {
					"_token": "{{ csrf_token() }}",
					"proid":proid,
					"qty":1,
					"size":size
				},
				type : 'post',
				url : '/add-to-wishlist',
				success:function(resp){	
					if(resp.status){
						if(resp.message ==='set'){
							$('a[data-productid='+proid+']').html('<span class="wishlist-wrap"><i class="fa fa-heart" aria-hidden="true"></i></span>');
						}else if(resp.message ==='unset'){
							$('a[data-productid='+proid+']').html('<span class="wishlist-wrap"><i class="far fa-heart"></i></span>');

						}
					}else{
						alert(resp.message);
						if(resp.login == false){
						   window.location.href=resp.url;
						}

					}
					$('.PleaseWaitDiv').hide();
				},
				error:function(){
					//Nothing to do
				}
			});	
		});
/*  Add to Wishlist End */





    $(document).on('change','[name=size]',function(){ 
            $('.PleaseWaitDiv').show(); 
			var page_type = $(this).attr('page-type'); 
         
            var proid = $(this).attr('data-proid');
            var catid = $(this).attr('data-catid');
            var size = $(this).val();
            check_stock($("#"+page_type+"-qty").val(),proid,catid,size,page_type);
   
   
          $("#"+page_type+"-product_size").val(size);
            $.ajax({
              url: '/get-product-attribute-price',
                  type:'POST',
                  data: {size:size,proid:proid,catid:catid,_token:"{{csrf_token()}}"},
                  success: function(data) {
                      $('.PleaseWaitDiv').hide();
                       $('.single_product_price').empty();
                      
                      if(data.status){

                      }else{  
   					    
                                   var msg = {};
                                    msg[0] = data.message;                   
                                    printErrorMsg(msg,page_type+'-error-msg');
                                    $('.'+page_type+'-error-msg').delay(3000).fadeOut('slow');
                      //$('input[name="size"]').attr('checked', false);
                      $("#product-add-to-cart").html(data.button); 
                      }
                          if(page_type == 'popup'){
                                   $('.single-product-price').html(data.data['quick_view_single_product_price']);
                          }else{
                                  $('.single-product-price').html(data.data['single_product_price']);
                          }
                          
             
              
               
                 if(data.wishlist_count =='1'){ 
                    $('a[data-productid='+proid+']').html('<span class="wishlist-wrap"><i class="fa fa-heart" aria-hidden="true"></i></span>');
                }else{
                   $('a[data-productid='+proid+']').html('<span class="wishlist-wrap"><i class="far fa-heart"></i></span>');   
                }
        
        
        
        
                  }
            })
          })
        
          $(document).on('change','.product-qty',function(e){ 
                  var value = $(this).val();
                  var type = $(this).val();
                  if ($.isNumeric(value)) {
                         if(value > 0 && value < 11){
                               $(this).val(value);
                          }else{
                            $(this).val(1);
                          }
                  }else{
                      $(this).val(1);
                  }
            })
         $(document).on('submit','#notify1',function(e){ 
          e.preventDefault();
          $('.PleaseWaitDiv').show();
          var formdata = $("#notify").serialize();
          $.ajax({
              url: "/save-notify",
              type:'POST',
              data: formdata,
              success: function(data) {
                  $('.PleaseWaitDiv').hide();
                  if(data.status){
                      $('#notify_msg').attr('style', '');
                      $('#notify_msg').html('<div role="alert" class="alert alert-success alert-dismissible"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button>Your infomation has been submitted successfully. We will get back to you soon.</div>');
                      setTimeout(function () {
                          $('#notify')[0].reset();
                          $('#notify_msg').empty();
                          $('#notifyme').modal('hide');
                      }, 3000);
                      
                  }
              }
          });
      });
   
   
   
   
   
   	 /* Newsletters Footer */
   	$("#NewsletterFooter button").click(function() {
   
   	$('.PleaseWaitDiv').show();
   	var formdata = $("#NewsletterFooter").serialize();
   	$.ajax({
           url: '/add-subscriber',
           type:'GET',
           data: formdata,
           success: function(data) {
           	  $('.PleaseWaitDiv').hide();
   			  $('#newsletter-result').empty();
           	if(!data.status){
   				 var message = data.errors;
   				var  alertclasss ="danger";
             
               }else{
               	 $('#NewsletterFooter').trigger("reset");
   				 var message = data.message;
   				 var alertclasss ="success";
   			} 
   			 $('#newsletter-result').attr('style', 'display:block');
   			 $('#newsletter-result').html('<br>'+message);
           	 setTimeout(function () {
                                   $('#newsletter-result').css({
                                       'display': 'none'
                                   });
                               }, 5000);
           }
       });
   });
    /* Newsletters Footer */
    
   	
   	});
   	
   $(document).on('keyup', '.user_pincode', function() {
        var pincode = $(this).val();
        if($(this).val().length == 6){
		  $('.PleaseWaitDiv').show();
		  $.ajax({
            url: '/get-state',
            type:'POST',
            data: {_token: "{{ csrf_token() }}",  pincode: pincode},
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if(data.status){
					if(data.state == 'Jammu And  kashmir'){
					    $('.user_state').val('Jammu And  Kashmir');
					}else{
						$('.user_state').val(data.state);
					}
					
        			$('.user_city').val(data.city);
            	}else{
					alert('Invalid pincode!');
            	}
            }
         });
	    }
	});
    function check_stock(qty,proid,catid,size,page_type){ 
                   
              if (typeof size !== "undefined" && size != '' ) {
                       
                  $.ajax({
                      url: '/check-product-qty',
                      type:'POST',
                      data: {size:size,proid:proid,catid:catid,qty:qty,_token:"{{csrf_token()}}"},
                      success: function(data) {  
                        if(!data.status){ 
                            $('.'+page_type+'-notify').css('display','block'); 
   					        if(page_type == 'popup'){
							   $("#notifyme_content").html(data.notify); 
							}
                        }else{
                           $('.'+page_type+'-notify').css('display','none');
                        }
                        
                      }
                  })
              }
      }
   
   
   
   
   function popup_cart_qty_update(cartid){ 
   	var qty = $("#cart-quantity-"+cartid).val();  
   	$.ajax({
   					type : 'get',
   					data : {
   						"cartid" : cartid,
   						"qty" : qty,
   					},
   					url :'/popup-cart-qty-update',
   					success:function(resp){
   							if(!resp.status){
   								alert(resp.message);
                                   if(resp.already_deleted == true){ 
   									$("#mini_cart_item_"+cartid).css('display','none');
   								}
   								$("#cart-quantity-"+cartid).val(resp.current_qty); 
   							}else{
   								
   								$("#popup-cartitem-quantity-"+cartid).html(qty);
   								$(".cartssubtotal").html("INR "+resp.cartssubtotal);
   							}
   						
   					},
   					error:function(){
   						//nothing to do
   					}
   				})
   			
   	
   }
   function printErrorMsg(msg,className='print-error-msg'){
       $("."+className).find("ul").html('');
       $("."+className).css('display','block');
       $.each( msg, function( key, value ) {
           $("."+className).find("ul").append('<li>'+value+'</li>');
       });
   }
   
   function printSuccessMsg(msg,className='print-success-msg'){
       $("."+className).find("ul").html('');
       $("."+className).css('display','block');
       $.each( msg, function( key, value ) {
           $("."+className).find("ul").append('<li>'+value+'</li>');
       });
   }
   
   function cartitems_Ajax(){ 
   	$.ajax({
   		url : "/cart-items-ajax",
   		type : "get",
   		success:function(resp){
   			$('#cart-popup').html(resp.view); 
   			$('.totalItems').html(resp.totalItems);
   		},
   		error:function(){
   
   		}
   	})
   }
   function show_category(){
   $(".rage-menu-next-panel").trigger("click"); 
   }








  function decreaseValue(type) { 
     var value = $("#"+type+"-qty").val();
    value = parseInt(value) - parseInt(1);
    if(value > 0){
        $("#"+type+"-qty").val(value);
    }else{
        $("#"+type+"-qty").val(1);
    }
  }

  function increaseValue(type) { 
    var value = $("#"+type+"-qty").val();
    value = parseInt(value) + parseInt(1);
    if(value < 10){
        $("#"+type+"-qty").val(value);
    }else{
        $("#"+type+"-qty").val(10);
    }
    
  }






</script>