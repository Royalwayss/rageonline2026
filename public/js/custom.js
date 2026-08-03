$(document).ready(function(){
	//Login
	
	
   
  


/* Cart Icon Show Div & Close icon  */
  
      $('.click-to-show, #div-to-toggle').click(function (e) {
        console.log("hai hai");
          if ($(e.target).attr('id') != 'close-btn') {
              
    var isMobile = window.matchMedia("only screen and (max-width: 760px)");
    var mob = isMobile.matches ? true : false;
            if(mob==true){
                $('#div-to-toggle').hide();
                $(".click-to-show").attr("href", '/cart');
            }else{
                $('#div-to-toggle').show();
            }

              event.stopPropagation();
          }
      });
      $('body, #close-btn').click(function () {
          $('#div-to-toggle').hide();
          // event.stopPropagation();
      })
 /* Cart Icon Show Div & Close icon  */
 
 /* Newsletters */
 $("#newsletter").submit(function(e){
	e.preventDefault();
	$('.PleaseWaitDiv').show();
	var formdata = $("#newsletter").serialize();
	$.ajax({
        url: '/add-subscriber',
        type:'GET',
        data: formdata,
        success: function(data) {
        	$('.PleaseWaitDiv').hide();
        	if(!data.status){
                $.each(data.errors, function (i, error) {
                    $('#Subscriber-'+i).attr('style', '');
                    $('#Subscriber-'+i).html(error);
                    setTimeout(function () {
                        $('#Subscriber-'+i).css({
                            'display': 'none'
                        });
                    }, 3000);
                });
            }else{
            	$('#UpdateText').html('Thank you for making our day signing up to receive our emails');
            		setTimeout(function(){
					  $('#newsletterModal').modal('hide');
					  $('#UpdateText').html('Tell us a little about you so we can send you updates');
					}, 4000);
            	//$('#newsletterModal').modal('hide');
            	$('#newsletter').trigger("reset");
            }
        	
        }
    });
});
 /* Newsletters */
    
 
 /* Newsletters Footer */
 $("#NewsletterFooter").submit(function(e){
	e.preventDefault();
	$('.PleaseWaitDiv').show();
	var formdata = $("#NewsletterFooter").serialize();
	$.ajax({
        url: '/add-subscriber',
        type:'GET',
        data: formdata,
        success: function(data) {
        	$('.PleaseWaitDiv').hide();
        	if(!data.status){
        	    $('#NewsSuccess').empty();
                $.each(data.errors, function (i, error) {
                    $('#Newsletter-'+i).attr('style', 'color:red');
                    $('#Newsletter-'+i).html(error);
                    setTimeout(function () {
                        $('#Newsletter-'+i).css({
                            'display': 'none'
                        });
                    }, 3000);
                });
            }else{
            	$('#NewsletterFooter').trigger("reset");
            	
            	 $('#NewsSuccess').attr('style', 'color:green');
                 $('#NewsSuccess').html('Thank you for making our day signing up to receive our emails.');
            }
        	
        }
    });
});
 /* Newsletters Footer */
 
 
 //Guest Checkout
    $("#GuestCheckoutForm_old").submit(function(e){
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
                            $('#guestCheckout-'+i).attr('style', 'color:red');
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
//Guest Checkout 
 
 
 
 
 
 
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
function cartitemsAjax(){ 
	$.ajax({
		url : "/cart-items-ajax",
		type : "get",
		success:function(resp){
			$('#cartdata').html(resp.view);
		},
		error:function(){

		}
	});
}
});
