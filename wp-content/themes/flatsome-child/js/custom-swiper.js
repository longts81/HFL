jQuery(document).ajaxComplete(function() {

    jQuery(window).on('load resize', function () {
        jQuery(window).scroll(function () { 
            var height = jQuery('footer').offset().top - 1000;
            if(jQuery(this).scrollTop() > height) {
                jQuery('.scroll-bottom').addClass('hidden');
                jQuery('.scroll-top').removeClass('hidden');
            } else {
                jQuery('.scroll-bottom').removeClass('hidden');
                jQuery('.scroll-top').addClass('hidden');
            }
        });
    });

    const swiperPartner = new Swiper(".swiper-partner", {
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        speed: 2000,        
        slidesPerView: 1,
        spaceBetween: 10,
        mousewheel: false,
        loop: true,
        pagination: {
            el: ".swiper-partner-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-partner-button-next",
            prevEl: ".swiper-partner-button-prev",
        },
        breakpoints: {
            280: {
                slidesPerView: 1.2,
                spaceBetween: 16,
            },
            768: {                
                slidesPerView: 1.5,
                spaceBetween: 10,
            },
            1024: {                
                slidesPerView: 2.5,
                spaceBetween: 16,
            },
            1180: {
                slidesPerView: 3,
                spaceBetween: 40,
            }
        },
    });

    var swiper = new Swiper(".swiper-related", {
        slidesPerView: 3,
        spaceBetween: 24,
        centeredSlides: false,
        preventClicks: true,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        speed: 1000,        
        navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev',
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 16,
            },
            380: {
                slidesPerView: 1,
                spaceBetween: 16,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 16,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 24,
            }
        },
        on: {
            init: function () {
            },
            slideChangeTransitionStart: function () {
            },
            slideChangeTransitionEnd: function () {
            }
        },
    });
});