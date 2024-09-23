jQuery(function ($) {
    "use strict";
    const eyes = document.querySelectorAll('.eye');
    const pupils = document.querySelectorAll('.pupil');
    $('.post__item').on('click', '.post__title, .post__content', function () {
        $(this).parents('.post__item').toggleClass('active');
    });
    
    $(window).on('load resize', function () {
        var heg = $('.video-url').innerHeight() + $('.scroll-bottom').innerHeight()/2;
        if ($(window).width() < 768) {            
            heg = $('.video-url').innerHeight() + 350;
        }
        $('.scroll-bottom').css('top', heg);

        var foo = $('footer').innerHeight();
        $('.scroll-top').css('bottom', foo);

        // $(window).scroll(function () { 
        //     var height = $('footer').offset().top - 1000;
        //     if($(this).scrollTop() > height) {
        //         // $('.scroll-bottom').addClass('hidden');
        //         $('.scroll-top').removeClass('hidden');
        //     } else {
        //         // $('.scroll-bottom').removeClass('hidden');
        //         $('.scroll-top').addClass('hidden');
        //     }
        // });
    });

    $('html').on('click', '.scroll-top', function () {
        console.log(123);
        
        $('html, body').animate({scrollTop: 0}, 1000);        
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
        autoplay: false,
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
    var max = 0;
    $('.col-item .col-inner .icon-box h5').each(function (indexInArray, valueOfElement) { 
        if ($(this).height() > max) {
            max = $(this).height();
        }
    });
    $('.col-item .col-inner .icon-box h5').height(max);

    var mh = 0;
    $('#post-list .post-item .post-title').each(function (indexInArray, valueOfElement) {
        if ($(this).height() > mh) {
            mh = $(this).height();
        }        
    })
    $('#post-list .post-item .post-title').height(mh);
    document.addEventListener('mousemove', (event) => {
        const x = event.clientX;
        const y = event.clientY;
        eyes.forEach((eye, index) => {
            const rect = eye.getBoundingClientRect();
            const eyeX = rect.left + rect.width / 2;
            const eyeY = rect.top + rect.height / 2;
            const angle = Math.atan2(y - eyeY, x - eyeX);
            const distanceX = (eye.clientWidth - pupils[index].clientWidth) / 2;
            const distanceY = (eye.clientHeight - pupils[index].clientHeight) / 2;
            const pupilX = distanceX * Math.cos(angle);
            const pupilY = distanceY * Math.sin(angle);
            pupils[index].style.transform = `translate(${pupilX}px, ${pupilY}px)`;
        });
    });
    window.addEventListener(
        "scroll",
        () => {
            document.body.style.setProperty(
                "--scroll",
                window.pageYOffset / (document.body.offsetHeight - window.innerHeight)
            );
        },
        false
    );
    // var hPosition = $('#header').innerHeight() + $('.video-url').innerHeight() + 70;
    // $('.scroll-bottom').css('top', hPosition);
    setTimeout(function() {
        MoveBackground();
        MoveClick();
    }, 500);
    function MoveBackground() {
        function e() {
            gsap.to(".items-1", 1, {
                x: 0,
                y: 0,
                z: 0,
                ease: Power2.easeOut
            }), gsap.to(".items-2", 1, {
                x: 0,
                y: 0,
                z: 0,
                ease: Power2.easeOut
            }),gsap.to(".items-center", 1, {
                x: 0,
                y: 0,
                z: 0,
                ease: Power2.easeOut
            })
        }
        function t() {
            var DX, DY, MoveX, MoveY, Radius, Degree;
            DX = o.X - i, DY = o.Y - l, MoveX = DY / l, MoveY = -(DX / i), Radius = Math.sqrt(Math.pow(MoveX, 2) + Math.pow(
                MoveY, 2)), Degree = 10 * Radius, gsap.to(".items-1", 3, {
                    x: 15 * MoveX,
                    y: 15 * MoveY,
                    z: 0,
                    ease: Power2.easeOut
                }), gsap.to(".items-2", 3, {
                    x: 0,
                    y: 20 * MoveY,
                    z: 10 * MoveY,
                    ease: Power2.easeOut
                }), gsap.to(".items-center", 3, {
                    x: 15 * MoveX,
                    y: 15 * MoveY,
                    z: 0,
                    ease: Power2.easeOut
                })
        }
        var a = null,
            o = {
                X: 0,
                Y: 0
            },
            i = $(window).width() / 2,
            l = $(window).height() / 2;
        var s = $(".mockup");        
        $(s).addClass("moving"), $(window).width() > 1100 ? $(s).on("mousemove", function (e) {
            o.X = e.pageX, o.Y = e.pageY, cancelAnimationFrame(a), a = requestAnimationFrame(t)
        }) : $(s).on("mousemove", function () {
            cancelAnimationFrame(a), e()
        }), $(window).resize(function () {
            $(window).width() > 1100 ? (i = $(window).width() / 2, l = $(window).height() / 2) : e()
        })
    }
    function MoveClick() {
        function e() {
            gsap.to(".items-3", 1, {
                x: 0,
                y: 0,
                z: 0,
                ease: Power2.easeOut
            }), gsap.to(".items-4", 1, {
                x: 0,
                y: 0,
                z: 0,
                ease: Power2.easeOut
            })
        }
        function t() {
            var DX, DY, MoveX, MoveY, Radius, Degree;
            DX = o.X - i, DY = o.Y - l, MoveX = DY / l, MoveY = -(DX / i), Radius = Math.sqrt(Math.pow(MoveX, 2) + Math.pow(
                MoveY, 2)), Degree = 10 * Radius, gsap.to(".items-3", 3, {
                    x: 5 * MoveX,
                    y: 0,
                    z: 0,
                    ease: Power2.easeOut
                }), gsap.to(".items-4", 3, {
                    x: 0,
                    y: 5 * MoveY,
                    z: 5 * MoveY,
                    ease: Power2.easeOut
                })
        }
        var a = null,
            o = {
                X: 0,
                Y: 0
            },
            i = $(window).width() / 2,
            l = $(window).height() / 2;
        var s = $(".mockup-two");        
        $(s).addClass("moving"), $(window).width() > 1100 ? $(s).on("mousemove", function (e) {
            o.X = e.pageX, o.Y = e.pageY, cancelAnimationFrame(a), a = requestAnimationFrame(t)
        }) : $(s).on("mousemove", function () {
            cancelAnimationFrame(a), e()
        }), $(window).resize(function () {
            $(window).width() > 1100 ? (i = $(window).width() / 2, l = $(window).height() / 2) : e()
        })
    }
    var tl = gsap.timeline();
    tl.from(".items-1", {
        opacity: 0,
        y: 50,
        duration: 1
    }, 0.4);
    tl.from(".items-2", {
        opacity: 0,
        x: -50,
        duration: 1
    }, 0.4);
    tl.from(".items-3", {
        opacity: 0,
        x: -50,
        duration: 1
    }, 0.4);
    tl.from(".items-4", {
        opacity: 0,
        x: 50,
        duration: 1
    }, 0.4);
    tl.from(".items-center", {
        opacity: 0,
        y: 50,
        duration: 1
    }, 0.4);
    if(!$('body').hasClass('ux-builder-iframe') ){
        const circle = document.body.querySelector(".circle-line");    
        const timing = {
            duration: 10000,
            easing: "linear",            
        };    
        // Use WAAPI to set things off
        run_line();
        function run_line() {
            if (circle) {                
                const animation = circle.animate(
                    [
                        {
                            offsetDistance: "0%"
                        },
                        { 
                            offsetDistance: "100%"
                        }
                    ],
                    timing
                );                
                // Restart the animation when it finishes
                animation.onfinish = function() {
                    run_line();
                };
            }
        }
    }
    var arCuPromptClosed = false;
    var _arCuTimeOut = null;
    var arCuClosedCookie = 0;
    var arcItems = [];
    var tool = toolData.tool;    
    window.addEventListener('load', function() {
        //arCuClosedCookie = arCuGetCookie('arcu-closed');
        $('#arcontactus').on('arcontactus.init', function() {
            if (arCuClosedCookie) {
                return false;
            }
            arCuShowMessages();
        });
        $('#arcontactus').on('arcontactus.openMenu', function() {
            clearTimeout(_arCuTimeOut);
            arCuPromptClosed = true;
            $('#contact').contactUs('hidePrompt');
            arCuCreateCookie('arcu-closed', 1, 30);
        });
        $('#arcontactus').on('arcontactus.hidePrompt', function() {
            clearTimeout(_arCuTimeOut);
            arCuPromptClosed = true;
            arCuCreateCookie('arcu-closed', 1, 30);
        });
        for (let i = 0; i < tool.length; i++) {
            var arcItem = {};
            arcItem.id = 'msg-item-'+i;
            arcItem.class = 'msg-item-'+i;
            arcItem.title = tool[i]["ten"];
            arcItem.icon = '<img src="'+tool[i]['photo']+'"/>';
            arcItem.href = tool[i]['link'];
            arcItem.desc = tool[i]['excerpt'];
            arcItem.color = '';
            arcItems.push(arcItem);
        }
        $('#arcontactus').contactUs({
            items: arcItems
        });
        $('#msg-item-n').attr('datae', '#contact');
    });
});
