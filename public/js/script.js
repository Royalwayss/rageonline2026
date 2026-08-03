
// filter widget toggle

  $('.filter-popup').hide();

  $('.filter-widget-toggle').on('click',function(){

    $('.filter-popup').slideToggle(500);

  })

  /* Price filter active */

  if ($("#slider-range").length) {

    $("#slider-range").slider({

      range: true,

      min: 0,

      max: 10000,

      values: [500, 10000],

      slide: function (event, ui) {

        $("#amount").val("INR " + ui.values[0] + " - INR " + ui.values[1]);

        $("#price_sort").val("" + ui.values[0] + "-" + ui.values[1]);
        $("#slider-range-value1").html(ui.values[0]);
        $("#slider-range-value2").html(ui.values[1]);

      }

    });

    $("#amount").val("INR " + $("#slider-range").slider("values", 0) +

      " - INR " + $("#slider-range").slider("values", 1));

    $('#filter-btn').on('click', function () {

      $('.filter-widget').slideToggle(1000);

    });

  }


  if ($("#slider-range-2").length) {

    $("#slider-range-2").slider({

      range: true,

      min: 0,

      max: 10000,

      values: [500, 10000],

      slide: function (event, ui) {

        $("#amount-2").val("INR " + ui.values[0] + " - INR " + ui.values[1]);

        $("#price_sort").val("" + ui.values[0] + "-" + ui.values[1]);
        $("#slider-range-value-1").html(ui.values[0]);
        $("#slider-range-value-2").html(ui.values[1]);

      }

    });

    $("#amount-2").val("INR " + $("#slider-range-2").slider("values", 0) +

      " - INR " + $("#slider-range-2").slider("values", 1));

    $('#filter-btn-2').on('click', function () {

      $('.filter-widget').slideToggle(1000);

    });



  }



  // quantity js

(function () {
  const quantityContainer = document.querySelector(".quantity");
  if (!quantityContainer) return; // Ensure the container exists

  const minusBtn = quantityContainer.querySelector(".minus");
  const plusBtn = quantityContainer.querySelector(".plus");
  const inputBox = quantityContainer.querySelector(".input-box");

  updateButtonStates();

  quantityContainer.addEventListener("click", handleButtonClick);
  inputBox.addEventListener("input", handleQuantityChange);

  function updateButtonStates() {
    const value = parseInt(inputBox.value);
    const max = inputBox.hasAttribute("max") ? parseInt(inputBox.max) : Infinity;
    minusBtn.disabled = value <= 1;
    plusBtn.disabled = value >= max;
  }

  function handleButtonClick(event) {
    if (event.target.classList.contains("minus")) {
      decreaseValue();
    } else if (event.target.classList.contains("plus")) {
      increaseValue();
    }
  }

  function decreaseValue() {
    let value = parseInt(inputBox.value);
    value = isNaN(value) ? 1 : Math.max(value - 1, 1);
    inputBox.value = value;
    updateButtonStates();
    handleQuantityChange();
  }

  function increaseValue() {
    let value = parseInt(inputBox.value);
    const max = inputBox.hasAttribute("max") ? parseInt(inputBox.max) : Infinity;
    value = isNaN(value) ? 1 : Math.min(value + 1, max);
    inputBox.value = value;
    updateButtonStates();
    handleQuantityChange();
  }

  function handleQuantityChange() {
    let value = parseInt(inputBox.value);
    value = isNaN(value) ? 1 : value;

    // Execute your code here based on the updated quantity value
    console.log("Quantity changed:", value);
  }
})();

// category slider 
if ($('.carousel-wrapper').length > 0) {
document.addEventListener("DOMContentLoaded", () => {
  document.body.classList.add("loading");

  const carousel = document.querySelector(".carousel-wrapper");
  const carouselSlides = document.querySelectorAll(".carousel-slide");
  const carouselButtons = document.querySelectorAll("button.slider-nav");
  const sliderScrollbar = document.querySelector(".carousel-scrollbar");
  const sliderScrollbarThumb = document.querySelector(
    ".carousel-scrollbar .scrollbar-thumb"
  );

  let carouselMaxScroll = carousel.scrollWidth - carousel.clientWidth;

  const resizeScrollbarThumb = () => {
    sliderScrollbarThumb.style.width = `${
      (carousel.clientWidth / carousel.scrollWidth) * 100
    }%`;
  };

  resizeScrollbarThumb();

  let interval;
  let spaceBetween = 15;
  let slideWidth = 144;
  let slidesPerView = Math.floor(
    carousel.clientWidth / (slideWidth + spaceBetween)
  );

  const hideShowSliderNavButtons = (sliderElement) => {
    if (sliderElement) {
      document.body.classList.toggle(
        "slider-start",
        sliderElement.scrollLeft - 3 <= 0
      );
      document.body.classList.toggle(
        "slider-end",
        sliderElement.scrollLeft + sliderElement.offsetWidth + 3 >=
          sliderElement.scrollWidth
      );
    } else {
      console.error("sliderElement is not defined");
    }
  };

  let startX,
    thumbPosition,
    isMouseDown = false;

  const positionScrollbarThumb = () => {
    const scrollPositionX = carousel.scrollLeft;
    const thumbPositionX =
      (scrollPositionX / carouselMaxScroll) *
      (sliderScrollbar.clientWidth - sliderScrollbarThumb.offsetWidth);
    sliderScrollbarThumb.style.left = `${thumbPositionX}px`;
  };

  if (carouselSlides && carouselSlides.length > 0) {
    let intersectionObserver = new IntersectionObserver(
      (entries) => {
        console.log(entries);
        entries.map((slide) => {
          console.log("slide.intersectionRatio:", slide.intersectionRatio);
          if (slide.isIntersecting) {
            let image = new Image();
            image.src = slide.target.dataset.imageSrc;
            image.className = "carousel-image";
            image.onload = (event) => {
              slide.target.prepend(image);
              let index = parseInt(slide.target.dataset.index);
              index = index % slidesPerView;
              window.setTimeout(() => {
                slide.target.classList.add('loaded');
              }, (500 * index));
              intersectionObserver.unobserve(slide.target);
            };
          }
        });
      },
      {
        root: carousel
      }
    );
    
    carouselSlides.forEach((slide) => {
      intersectionObserver.observe(slide);
    });
  }

  if (carousel) {
    carousel.addEventListener("scroll", (event) => {
      let sliderWrapper = event.target || carousel;
      hideShowSliderNavButtons(sliderWrapper);
      positionScrollbarThumb();
    });

    hideShowSliderNavButtons(carousel);
  }

  if (carouselButtons && carouselButtons.length > 0) {
    carouselButtons.forEach((button) => {
      button.addEventListener("click", (event) => {
        event.preventDefault();
        let direction = event.target.id === "prev" ? -1 : 1;
        let slidesPerView = Math.floor(
          carousel.clientWidth / (slideWidth + spaceBetween)
        );
        let amountToScroll = (slideWidth + spaceBetween) * slidesPerView;
        carousel.scrollLeft += Math.floor(amountToScroll * direction);
      });
    });
  }

  if (sliderScrollbarThumb) {
    sliderScrollbarThumb.addEventListener("mousedown", (event) => {
      event.preventDefault();
      isMouseDown = true;
      sliderScrollbarThumb.classList.add("dragging");
      carousel.classList.add("dragging");
      startX = event.clientX;
      thumbPosition = event.target.offsetLeft;
    });

    document.addEventListener("mousemove", (event) => {
      if (!isMouseDown) return;
      event.preventDefault();
      const deltaX = event.clientX - startX;
      const newThumbPosition = thumbPosition + deltaX;
      const maxThumbPosition =
        sliderScrollbar.getBoundingClientRect().width -
        sliderScrollbarThumb.offsetWidth;
      const thumbPositionX = Math.max(
        0,
        Math.min(maxThumbPosition, newThumbPosition)
      );
      const sliderScrollLeft =
        (thumbPositionX / maxThumbPosition) * carouselMaxScroll;
      sliderScrollbarThumb.style.left = `${thumbPositionX}px`;
      carousel.scrollLeft = sliderScrollLeft;
    });

    const stopScrolling = (event) => {
      event.preventDefault();
      isMouseDown = false;
      sliderScrollbarThumb.classList.remove("dragging");
      carousel.classList.remove("dragging");
    };

    document.addEventListener("mouseup", stopScrolling);
  }

  window.onresize = function () {
    carouselMaxScroll = carousel.scrollWidth - carousel.clientWidth;
    slideWidth = 144;
    slidesPerView = Math.floor(carousel.clientWidth / slideWidth);
    resizeScrollbarThumb();
    positionScrollbarThumb();
  };
});

}

window.onload = function () {
  if (document.body.classList.contains("loading")) {
    document.body.classList.add("loaded");
  } else {
    setTimeout(() => {
      document.body.classList.add("loaded");
    }, 1000);
  }
};


// latest obsessions


$(document).ready(function() {
    $("#news-slider").owlCarousel({
        items : 3,
        itemsDesktop:[1199,3],
        itemsDesktopSmall:[980,2],
        itemsMobile : [600,1],
        navigation:true,
        navigationText:["",""],
        pagination:true,
        autoPlay:true
    });

     $("#news-slider1").owlCarousel({
        items : 3,
        itemsDesktop:[1199,3],
        itemsDesktopSmall:[980,2],
        itemsMobile : [600,1],
        navigation:true,
        navigationText:["",""],
        pagination:true,
        autoPlay:true
    });

    $("#lookbook").owlCarousel({
        items : 4,
        itemsDesktop:[1199,4],
        itemsDesktopSmall:[980,3],
        itemsMobile : [600,1],
        navigation:true,
        navigationText:["",""],
        pagination:true,
        autoPlay:true,
    });

    $("#related-product").owlCarousel({
        items : 3,
        itemsDesktop:[1199,3],
        itemsDesktopSmall:[980,2],
        itemsMobile : [600,1],
        navigation:true,
        navigationText:["",""],
        pagination:true,
        autoPlay:true
    });
});

// sidebar open close js code
let navLinks = document.querySelector(".nav-links");
let menuOpenBtn = document.querySelector(".navbar .bx-menu");
let menuCloseBtn = document.querySelector(".nav-links .bx-x");
menuOpenBtn.onclick = function() {
navLinks.style.left = "0";
}
menuCloseBtn.onclick = function() {
navLinks.style.left = "-100%";
} 


// sidebar submenu open close js code
let htmlcssArrow = document.querySelector(".htmlcss-arrow");
htmlcssArrow.onclick = function() {
 navLinks.classList.toggle("show1");
}
/*
let moreArrow = document.querySelector(".more-arrow");
moreArrow.onclick = function() {
 navLinks.classList.toggle("show2");
} 
let jsArrow = document.querySelector(".js-arrow");
jsArrow.onclick = function() {
 navLinks.classList.toggle("show3");
}
 */

//////header scroll bg change/////  

// $(window).on("scroll", function () {
//   if ($(this).scrollTop() > 50) { 
//     $("nav").addClass("scrolled");

//     // Change logo
//      $(".logo .logo-name img, .sidebar-logo .logo-name img").attr("src", "/images/logo.png");
//   } else {
//     $("nav").removeClass("scrolled");

//     // Revert logo
//      $(".logo .logo-name img, .sidebar-logo .logo-name img").attr("src", "/images/logo-w.png");
//   }
// });
// Put this after jQuery is loaded (or in a file included after jQuery)

$(function () {
  // Detect "homeMain" anywhere (body or an element)
  var isHome = $('body').hasClass('homeMain') || $('.homeMain').length > 0;

  var $window = $(window);
  // Try a few reasonable nav/header fallbacks
  var $nav = $('nav');
  if (!$nav.length) $nav = $('.header-area, header');

  // Try a few logo selectors so it works with different markup

  //  .sidebar-logo .logo-name img,
  
  var $logos = $('.logo .logo-name img, .logo img, #main-logo img');

  // Paths — adjust if your path is different (relative/absolute)
  var logoDefault = '/images/logo.png';
  var logoWhite   = '/images/logo-w.png';

  function setScrolled() {
    $nav.addClass('scrolled');
    if ($logos.length) $logos.attr('src', logoDefault);
  }
  function unsetScrolled() {
    $nav.removeClass('scrolled');
    if ($logos.length) $logos.attr('src', logoWhite);
  }

  if (isHome) {
    // Initialize based on current scroll position
    if ($window.scrollTop() > 50) setScrolled(); else unsetScrolled();

    // Use requestAnimationFrame to avoid overfiring on scroll
    var ticking = false;
    $window.off('scroll.homeMain'); // remove any previous handler with same namespace
    $window.on('scroll.homeMain', function () {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          if ($window.scrollTop() > 50) setScrolled(); else unsetScrolled();
          ticking = false;
        });
        ticking = true;
      }
    });
  } else {
    // Internal pages — force scrolled state immediately, no scroll logic
    setScrolled();
    // Optionally remove any scroll handlers to save work
    $window.off('scroll.homeMain');
  }

  // Debug logs (remove in production)
  // console.log('isHome:', isHome, 'nav found:', $nav.length, 'logos found:', $logos.length);
});

///home page category section image change on scroll///
const blocks = document.querySelectorAll(".content-block");
const images = document.querySelectorAll(".sticky-img");

window.addEventListener("scroll", () => {
  let index = 0;

  blocks.forEach((block, i) => {
    const rect = block.getBoundingClientRect();
    if (rect.top <= window.innerHeight / 2 && rect.bottom >= window.innerHeight / 2) {
      index = i;
    }
  });

  images.forEach((img, i) => {
    img.classList.toggle("active", i === index);
  });
});


if ($('.product-listing').length > 0) {
// product listing grid view toggle
document.addEventListener("DOMContentLoaded", function() {
    const grid3Btn = document.getElementById("grid-3");
    const grid4Btn = document.getElementById("grid-4");
    const listing = document.querySelector(".product-listing");

    grid3Btn.addEventListener("click", function() {
        listing.classList.remove("grid-4");
        listing.classList.add("grid-3");
        grid3Btn.classList.add("active");
        grid4Btn.classList.remove("active");
    });

    grid4Btn.addEventListener("click", function() {
        listing.classList.remove("grid-3");
        listing.classList.add("grid-4");
        grid4Btn.classList.add("active");
        grid3Btn.classList.remove("active");
    });
});

}
// product detail page image slider

const sliderThumbs = new Swiper(".slider__thumbs .swiper-container", {
  // ищем слайдер превью по селектору
  // задаем параметры
  direction: "vertical", // вертикальная прокрутка
  slidesPerView: 3, // показывать по 3 превью
  spaceBetween: 24, // расстояние между слайдами
  navigation: {
    // задаем кнопки навигации
    nextEl: ".slider__next", // кнопка Next
    prevEl: ".slider__prev" // кнопка Prev
  },
  freeMode: true, // при перетаскивании превью ведет себя как при скролле
  breakpoints: {
    // условия для разных размеров окна браузера
    0: {
      // при 0px и выше
      direction: "horizontal" // горизонтальная прокрутка
    },
    768: {
      // при 768px и выше
      direction: "vertical" // вертикальная прокрутка
    }
  }
});
// Инициализация слайдера изображений
const sliderImages = new Swiper(".slider__images .swiper-container", {
  // ищем слайдер превью по селектору
  // задаем параметры
  direction: "vertical", // вертикальная прокрутка
  slidesPerView: 1, // показывать по 1 изображению
  spaceBetween: 32, // расстояние между слайдами
  mousewheel: true, // можно прокручивать изображения колёсиком мыши
  navigation: {
    // задаем кнопки навигации
    nextEl: ".slider__next", // кнопка Next
    prevEl: ".slider__prev" // кнопка Prev
  },
  grabCursor: true, // менять иконку курсора
  thumbs: {
    // указываем на превью слайдер
    swiper: sliderThumbs // указываем имя превью слайдера
  },
  breakpoints: {
    // условия для разных размеров окна браузера
    0: {
      // при 0px и выше
      direction: "horizontal" // горизонтальная прокрутка
    },
    768: {
      // при 768px и выше
      direction: "vertical" // вертикальная прокрутка
    }
  }
});

// review form toggle and submit
 // ⭐ Star Rating Functionality
  const stars = document.querySelectorAll(".star-rating .star");
  const ratingValue = document.getElementById("ratingValue");

  stars.forEach((star, index) => {
    star.addEventListener("mouseover", () => {
      stars.forEach((s, i) => s.classList.toggle("hovered", i <= index));
    });

    star.addEventListener("mouseout", () => {
      stars.forEach(s => s.classList.remove("hovered"));
    });

    star.addEventListener("click", () => {
      ratingValue.value = star.dataset.value;
      stars.forEach((s, i) => s.classList.toggle("selected", i <= index));
    });
  });

  // Preview uploaded images (multiple)
  function previewImages(event) {
    const files = event.target.files;
    const container = document.getElementById("previewContainer");
    container.innerHTML = "";
    Array.from(files).forEach(file => {
      const reader = new FileReader();
      reader.onload = e => {
        const img = document.createElement("img");
        img.src = e.target.result;
        img.classList.add("preview-img");
        container.appendChild(img);
      };
      reader.readAsDataURL(file);
    });
  }

  // Submit Review
  function submitReview(event) {
    event.preventDefault();

    const rating = ratingValue.value;
    const title = document.getElementById("reviewTitle").value;
    const content = document.getElementById("reviewContent").value;
    const name = document.getElementById("displayName").value;
    const files = document.getElementById("fileUpload").files;

    if (rating === "0") {
      alert("Please select a star rating");
      return;
    }

    const reviewsList = document.getElementById("reviewsList");
    const reviewItem = document.createElement("div");
    reviewItem.classList.add("review-item");

    // Render stars
    const starsHTML = "★".repeat(rating) + "☆".repeat(5 - rating);

    // Render uploaded images
    let imgHTML = "";
    if (files.length > 0) {
      imgHTML = '<div class="review-images">';
      Array.from(files).forEach(file => {
        const imgURL = URL.createObjectURL(file);
        imgHTML += `<img src="${imgURL}" alt="uploaded">`;
      });
      imgHTML += "</div>";
    }

    reviewItem.innerHTML = `
      <h5>${name}</h5>
      <p>${starsHTML}</p>
      <strong>${title}</strong>
      <p>${content}</p>
      ${imgHTML}
    `;
    reviewsList.prepend(reviewItem);

    // Reset form
    event.target.reset();
    document.getElementById("previewContainer").innerHTML = "";
    stars.forEach(s => s.classList.remove("selected"));
    ratingValue.value = "0";
  }


$(document).ready(function(){
  $("#showLogin").click(function(){
    $(".tab-btn").removeClass("active");
    $(this).addClass("active");

    $(".form-box").removeClass("active").hide();
    $("#loginForm").fadeIn(300).addClass("active");
  });

  $("#showRegister").click(function(){
    $(".tab-btn").removeClass("active");
    $(this).addClass("active");

    $(".form-box").removeClass("active").hide();
    $("#registerForm").fadeIn(300).addClass("active");
  });
});


AOS.init({
  disable: function() {
    return window.innerWidth < 768; // disable below 768px
  }
});




		// Select elements
		const tabButtons = document.querySelectorAll(".tab-btn");
		const contentBlocks = document.querySelectorAll(".content-block");
		const stickyImages = document.querySelectorAll(".sticky-img");

		// Tab click
		tabButtons.forEach((btn, index) => {
		  btn.addEventListener("click", (e) => {
			setActive(index);
			e.preventDefault();
			// contentBlocks[index].scrollIntoView({ behavior: "smooth" });
		  });
		});

		// Scroll sync
		window.addEventListener("scroll", () => {
		  let current = 0;

		  contentBlocks.forEach((block, i) => {
			const rect = block.getBoundingClientRect();
			if (rect.top <= window.innerHeight / 2 && rect.bottom >= window.innerHeight / 2) {
			  current = i;
			}
		  });

		  setActive(current);
		  
		});






// Set active state
function setActive(index) {
  tabButtons.forEach(b => b.classList.remove("active"));
  contentBlocks.forEach(c => c.classList.remove("active"));
  stickyImages.forEach(img => img.classList.remove("active"));

  tabButtons[index].classList.add("active");
  contentBlocks[index].classList.add("active");
  stickyImages[index].classList.add("active");
}



