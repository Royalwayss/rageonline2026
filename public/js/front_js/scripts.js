// $(function() {
//     var html = $('html, body'),
//         navContainer = $('.nav-container'),
//         navToggle = $('.nav-toggle'),
//         navDropdownToggle = $('.has-dropdown');
//     // Nav toggle
//     navToggle.on('click', function(e) {
//         var $this = $(this);
//         e.preventDefault();
//         $this.toggleClass('is-active');
//         navContainer.toggleClass('is-visible');
//         html.toggleClass('nav-open');
//     });
// });
$(document).ready(function() {
    // $(".topnav").accordion({
  		// accordion:false,
    //   	speed: 500,
    //   	closedSign: '+',
    //   	openedSign: '-'
    // });

   //Search Script Starts 
    $('#show-hidden-menu').click(function() {
	    $('.hidden-menu').slideToggle("fast");
	    //Alternative animation for example
	    slideToggle("fast");
	});
    //Search Script Ends


    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
	  if (!$(this).next().hasClass('show')) {
	    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
	  }
	  var $subMenu = $(this).next(".dropdown-menu");
	  $subMenu.toggleClass('show');


	  $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
	    $('.dropdown-submenu .show').removeClass("show");
	  });

	  return false;
	});

    $('body,html').click(function(e){
	    $('#navbarTogglerDemo01').removeClass('show');
	});

	// function openNav() {
	//   document.getElementById("mySidenav").style.width = "250px";
	// }

	// function closeNav() {
	//   document.getElementById("mySidenav").style.width = "0";
	// }


	//Popup Script starts here
	$('#h-login').on('click', function() {
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
	});

	// start signin popup
	$('#loginUser').on('click', function() {
		$(".close-image-signin").trigger('click');
		$('#overlay-back').fadeIn(500,function(){
			$('#popup').show();
		});
	});

	$('#registerName').on('click', function() {
		$(".close-image").trigger('click');
		$('#overlay-back-signin').fadeIn(500,function(){
			$('#popupsignin').show();
		});
	});

	$('#registerName2').on('click', function() {
		$(".close-image").trigger('click');
		$('#overlay-back-signin').fadeIn(500,function(){
			$('#popupsignin').show();
			$('#popupforgot').hide();
			$('#overlay-back-forgot').fadeOut(500);
		});
	});

	$('#forgotPass').on('click', function() {
		$(".close-image, .close-image-signin").trigger('click');
		$('#overlay-back-forgot').fadeIn(500,function(){
			$('#popupforgot').show();
		});
	});
	//Popup Script Ends here

	if ($(window).width() > 991){
	    $('.nav-hovr').hover(function() {
	      $(this).find('.sub-menu').stop(true, true).delay(200).fadeIn(200);
	    }, function() {
	      $(this).find('.sub-menu').stop(true, true).delay(200).fadeOut(200);
	    });
	}

    if( window.innerWidth < 575 ) {
        $("#topnavmenu li:has(ul.sub-menu)").click(function () {
            //return false;
        });
    }

});

if( window.innerWidth < 575 ) {
	$('document').ready(function() {
	    $('#show2').click(function() {
	        $('#two').slideToggle().css({
		        position: 'fixed',
		        top: 0,
		        right: 0,
		        bottom: 0,
		        left: 0,
		        zIndex: 1030,
		    });;
	    });
	});
}

function closeBtn() {
  document.getElementById("two").style.display = "none";
}

(function($){
    $(window).on("load",function(){
        $(".content").mCustomScrollbar();
    });
})(jQuery);






