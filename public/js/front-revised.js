
$(document).ready(function() {
    DetailPageFunc();

    if ($('[data-target="#subCategory"]').length > 0 && window.matchMedia('(min-width: 1025px)').matches) {
        $('[data-target="#subCategory"]').click();
    }
    $(document).on('click', 'span.input-value-checked', function() {
        $(this).siblings('input[type="checkbox"], input[type="radio"] ').trigger('click');
    });


    if ($('.datePicker').length > 0) {
        var $min = document.querySelector('.datePicker');
        $min.DatePickerX.init({
            mondayFirst: false,
            minDate    : new Date(1959, 1, 1),
            maxDate    : new Date()
        }); 
    }
    if ($('.homepageTrigger').length > 0) {

        //Home> We Think Section 2 swiper Slider Starts
        var swiper = new Swiper(".we-think--slider3", {
            slidesPerView: 1,
            preventClicks: true,
            preventClicksPropagation: true,
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                1024: {
                    slidesPerView: 1,
                },
            },
        });
        //Home> We Think Section 2 swiper Slider Ends




        //Home> We Think Section 2 swiper Slider Starts
        var swiper = new Swiper(".we-think--slider2", {
            slidesPerView: 3,
            spaceBetween: 15,
            preventClicks: true,
            preventClicksPropagation: true,
            breakpoints: {
                360: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 15,

                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
            },
            navigation: {
                nextEl: ".we-think2-next",
                prevEl: ".we-think2-prev",
            },
        });
        //Home> We Think Section 2 swiper Slider Ends




        //Home> We Think You'll Love swiper Slider Starts
        var swiper = new Swiper(".we-think--slider", {
            slidesPerView: 5,
            spaceBetween: 15,
            navigation: {
                nextEl: ".we-think-next",
                prevEl: ".we-think-prev",
            },
            preventClicks: true,
            preventClicksPropagation: true,
            breakpoints: {
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                360: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
            },
        }); //Home> We Think You'll Love swiper Slider Starts
        var swiper = new Swiper(".similar-slider", {
            slidesPerView: 5,
            spaceBetween: 15,
            navigation: {
                nextEl: ".we-think-next",
                prevEl: ".we-think-prev",
            },
            preventClicks: true,
            preventClicksPropagation: true,
            breakpoints: {
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                360: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
            },
        });
        //Home> We Think You'll Love swiper Slider Ends




        //Home> Collection swiper Slider Starts
        var swiper = new Swiper(".collecion--slider", {
            cssMode: true,
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                    marginLeft: 15,
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                1024: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
            },
            navigation: {
                nextEl: ".collecion-button-next",
                prevEl: ".collecion-button-prev",
            },
            pagination: {
                el: ".collecion-pagination",
            },
        });
        //Home> Collection swiper Slider Ends
    }

});

function debounce(func, time) {
    var time = time || 100;
    var timer;
    return function(event) {
        if (timer) { clearTimeout(timer) };
        timer = setTimeout(func, time, event);
    };
}

function Sliders() {}



function DetailPageFunc() {
    if ($('.detailPageTrigger').length>0) {
        debounce(function() {
            var deskDetail = (window.matchMedia('(min-width: 1025px)').matches) ? true : false;
            if (deskDetail) {
                $('body').removeClass('detailBreakpointAchieved');
            } else {
                $('body').addClass('detailBreakpointAchieved');
            }
            if ($('body').hasClass('detailBreakpointAchieved')) {
                var detailSlider = new Swiper('#DetailPageSlider', {
                    autoHeight: false,
                    preloadImages: false,
                    lazyLoading: false,
                    preventClicks: true,
                    preventClicksPropagation: true,
                    grabCursor: true,
                    observer: true,
                    loop: false,
                    autoplay: false,
                    mousewheel: false,
                    keyboard: false,
                    navigation: {
                        nextEl: '#nextBtn',
                        prevEl: '#prevBtn',
                    },
                    effect: 'slide',
                    direction: 'horizontal',
                    speed: 1050,
                    slidesPerView: 1,
                    spaceBetween: 0,
                    observeParents: false,
                });
                setTimeout(function() {
                    detailSlider.update();
                }, 100);
                var options = {
                    refreshOnResize: true,
                    zoomOnMouseWheel: true,
                    zoomValue: 120,
                    maxZoom: 500,
                    snapView: true,
                };
                var imageHRS = $('.detail--link').map(function() {
                    return $(this).attr('data-hrs');
                }).get();
                var viewer = ImageViewer('#containerDet', options);
                $('body').attr('curImg', '0');
                var curImageIdx = curImageIdx = $('body').attr('curImg');
                var l = imageHRS.length;
                $('.detail--link').each(function(key) {
                    $(this).on('click', function() {
                        if (!($('body').hasClass('activatedDetailPop'))) {
                            $('.PopupFixedWrapper').addClass('activatedPopup');
                            $('body').addClass('activatedDetailPop');
                            $('body').attr('curImg', (key));
                            viewer.load(imageHRS[key]);
                        }
                    });
                });

                $('#PopupNext').on('click', function(e) {
                    e.preventDefault();
                    curImageIdx = curImageIdx = $('body').attr('curImg');
                    curImageIdx++;
                    if (!(curImageIdx > (l - 1))) {
                        viewer.load(imageHRS[curImageIdx]);
                        $('body').attr('curImg', curImageIdx);
                    } else {
                        curImageIdx = 0;
                        $('body').attr('curImg', curImageIdx);
                        viewer.load(imageHRS[curImageIdx]);
                    }
                });
                $('#PopupPrev').on('click', function(e) {
                    e.preventDefault();
                    curImageIdx = curImageIdx = $('body').attr('curImg');
                    curImageIdx--;
                    if (!(curImageIdx < 0)) {
                        viewer.load(imageHRS[curImageIdx]);
                        $('body').attr('curImg', curImageIdx);
                    } else {
                        curImageIdx = (l - 1);
                        $('body').attr('curImg', curImageIdx);
                        viewer.load(imageHRS[curImageIdx]);
                    }
                });
                $('.PopupClose').on('click', function(e) {
                    e.preventDefault();
                    $('.PopupFixedWrapper').removeClass('activatedPopup');
                    $('body').removeClass('activatedDetailPop');
                 
                    if ($('body').hasClass('detailBreakpointAchieved')) {
                        var k = $('body').attr('curImg');
                        detailSlider.slideTo(k, 1050, function() {});
                    }
                });

                $(document).keyup(function(e) {
                    if (e.keyCode === 27 && $('body').hasClass('activatedDetailPop')) {
                        $('.PopupClose').trigger('click');
                    }
                });
            } else {
                $('a.easyzoom').zoom({
                    magnify: 1.4,
                    on: 'mouseover',
                    onZoomIn: function() {
                        $('.easyzoom').css({ 'cursor': 'crosshair' });
                        $('.easyzoom').find('b').css({ 'opacity': '0' });
                    },
                    onZoomOut: function() {
                        $('.easyzoom').css({ 'cursor': 'zoom-in' });
                        $('.easyzoom').find('b').css({ 'opacity': '1' });
                    },
                });
                // PopUp Slider zoom
                setTimeout(function() {
                    var detailPopupSlider = new Swiper('#SliderDetailPopup', {
                        autoplay: false,
                        autoplayDisableOnInteraction: false,
                        preloadImages: false,
                        lazyLoading: false,
                        preventClicks: true,
                        preventClicksPropagation: true,
                        grabCursor: true,
                        observer: true,
                        observerParents: true,
                        loop: false,
                        mousewheel: false,
                        keyboard: {
                            enabled: true
                        },
                        navigation: {
                            nextEl: '#DetailPopNext',
                            prevEl: '#DetailPopPrev',
                        },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        },
                        speed: 1050,
                        slidesPerView: 1,
                        slideToClickedSlide: false,
                        spaceBetween: 0,
                    });
                    detailPopupSlider.on('slideChangeTransitionEnd transitionEnd', function() {
                        var k = $('#SliderDetailPopup').find('.swiper-slide-active').index();
                        $('.thumbSlidePopup').eq(k).find('.thumb--linkPop').trigger('click');
                    });
                    $('.detail--linkPop').on('click', function(e) {
                        e.preventDefault();
                    });
                    // PopUp Slider zoom
                    $('.thumbSlidePopup').each(function(key, index) {
                        var $this = $(this);
                        var $ch = $this.find('a.thumb--linkPop');
                        $ch.bind('click', function(e) {
                            if (!$(this).hasClass('active--thumb')) {
                                $(this).addClass('active--thumb');
                                $(this).parents('.thumbSlidePopup').first().siblings().find('a.thumb--linkPop').removeClass('active--thumb');
                                detailPopupSlider.slideTo(key, 1050, function() {});
                            }
                        });
                    });
                }, 100);

                if ($('#DetailPageSlider').length > 0) {
                    var detailSlider = new Swiper('#DetailPageSlider', {
                        autoHeight: false,
                        preloadImages: false,
                        lazyLoading: false,
                        preventClicks: true,
                        grabCursor: true,
                        observer: true,
                        loop: false,
                        autoplay: false,
                        mousewheel: false,
                        keyboard: false,
                        navigation: {
	                        nextEl: '#nextBtn',
	                        prevEl: '#prevBtn',
	                    },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        },
                        speed: 1050,
                        slidesPerView: 1,
                        spaceBetween: 10,
                        observeParents: true,
                    });
                    setTimeout(function() {
                        detailSlider.update();
                        detailSlider.updateSize();
                    }, 200);
                    $(window).resize(debounce(function() {
                        detailSlider.update();
                        detailSlider.updateSize();
                    }, 1000));

                    var DetailThumbsSlider = new Swiper('#thumbsSlider', {
                        autoHeight: false,
                        preloadImages: false,
                        lazyLoading: false,
                        preventClicks: true,
                        grabCursor: true,
                        observer: true,
                        loop: false,
                        autoplay: false,
                        mousewheel: false,
                        keyboard: false,
                        effect: 'slide',
                        direction: 'vertical',
                        speed: 1050,
                        observeParents: true,
                        breakpoints: {
                            1025: {
                                slidesPerView: 7,
                                slidesPerGroup: 7,
                                spaceBetween: 10
                            },
                        },
                    });
                    $('.thumb--link').click(function(e) {
                        var $th = $(this);
                        var i = $th.parent().index();
                        if (!$th.hasClass('activatedThumbLink')) {
                            $th.addClass('activatedThumbLink');
                            $th.parent().siblings().find('a').removeClass('activatedThumbLink');
                            detailSlider.slideTo(i, 1050, function() {});
                        }
                    });
                    setTimeout(function() {
                        DetailThumbsSlider.update();
                    }, 100);
                    detailSlider.on('slideChangeTransitionEnd transitionEnd', function() {
                        var ind = $('#DetailPageSlider').find('.swiper-slide-active').index();
                        DetailThumbsSlider.slideTo(ind, 1050, function() {});
                        $('.leftThumbs').find('.swiper-slide').children('a').removeClass('activatedThumbLink');
                        $('.leftThumbs').find('.swiper-slide').eq(ind).children('a').addClass('activatedThumbLink');
                    });
                    $('.thumb--link').first().click();
                }
                $('.detail--link').each(function(key) {
                    $(this).on('click', function() {
                        var k = $(this).parent('.swiper-slide').index();
                        if (!($('body').hasClass('activatedDetailPop'))) {
                            $('.PopupFixedWrapper').addClass('activatedPopup');
                            $('body').addClass('activatedDetailPop');
                            
                            $('.thumbSlidePopup').eq(k).find('a.thumb--linkPop').trigger('click');
                        }
                    });
                });
                $('.PopupClose').on('click', function(e) {
                    e.preventDefault();
                    var k = $('#SliderDetailPopup').find('.swiper-slide-active').index();
                    $('.PopupFixedWrapper').removeClass('activatedPopup');
                    $('body').removeClass('activatedDetailPop');
                    $('body').removeClass('zoomEnabled');
                    detailSlider.slideTo(k, 1050, function() {});

                });

                $(document).keyup(function(e) {
                    if (e.keyCode === 27 && $('body').hasClass('activatedDetailPop')) {
                        $('.PopupClose').trigger('click');
                    }
                });
            }


            $('.DetailPopup--backdrop').on('click', function() {
                if ($('body').hasClass('activatedDetailPop')) {
                    $('.PopupClose').trigger('click');
                }
            });           
        }, 100)();
    }
}