(function ($) {
    "use strict";
    // JS Index
    //----------------------------------------
    // 1. sticky menu js
    // 2. mobile-menu(mean-menu) js
    // 3. preloader js
    // 4. mobile-menu-sidebar js
    // 5. background image js
    // 6. showlogin toggle function js
    // 7. showcoupon toggle function js
    // 8. Create an account toggle function js
    // 9. Create an account toggle function js
    // 10. Scroll To down Js
    // 11. slider - active
    // 12. rooms-hm1-active (home1)
    // 13. brand-active (home1)
    // 14. testimonial-active (home1)
    // 15. feature-hm1-active (home1)
    // 16. about-gallery-active
    // 17. counter js
    // 18. header-search js
    // 19. tilt js
    // 20. aos js
    // 21. Animate the scroll to top
    // 22. Contact form
    // 23. Countdown js
    // 24. Price filter active 2 
    // 25. nice selection js
    // 26. Isotope js
    // 27. accordion(sidebar) 
    // 28. Range Slider Js (filter)
    // 29. datepicker js
    //-------------------------------------------------



    // 1. sticky menu
    // ---------------------------------------------------------------------------
    var wind = $(window);
    var sticky = $("#header-sticky");
    wind.on('scroll', function () {
        var scroll = $(wind).scrollTop();
        if (scroll < 2) {
            sticky.removeClass("sticky-menu");
        } else {
            $("#header-sticky").addClass("sticky-menu");
        }
    });




    // 2. mobile-menu(mean-menu)
    //---------------------------------------------------------------------------
    $("#mobile-menu").meanmenu({
        meanMenuContainer: ".mobile-menu",
        meanScreenWidth: "991",
    });

    //menu-active-js
    document.querySelectorAll('nav a').forEach(link => {
        if (link.href === window.location.href) {
            link.setAttribute('aria-current', 'page')
        }
    });




    // 3. preloader
    //---------------------------------------------------------------------------
    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });



    // 4. mobile-menu-sidebar
    //---------------------------------------------------------------------------
    $(".mobile-menubar").on("click", function () {
        $(".side-mobile-menu").addClass('open-menubar');
        $(".body-overlay").addClass("opened");
    });
    $(".close-icon").click(function () {
        $(".side-mobile-menu").removeClass('open-menubar');
        $(".body-overlay").removeClass("opened");
    });

    $(".body-overlay").on("click", function () {
        $(".side-mobile-menu").removeClass('open-menubar');
        $(".body-overlay").removeClass("opened");
    });



    // 5. background image js
    //---------------------------------------------------------------------------
    $("[data-background]").each(function () {
        $(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
    });




    // 6. showlogin toggle function
    // ---------------------------------------------------------------------------
    $('#login').on('click', function () {
        $('#checkout-login').slideToggle(900);
    });





    // 7. showcoupon toggle function
    // ---------------------------------------------------------------------------
    // payment-method1
    $('#payment-method1').on('click', function () {
        $('#payment-method-content1').slideToggle(900);
    });
    // payment-method2
    $('#payment-method2').on('click', function () {
        $('#payment-method-content2').slideToggle(900);
    });
    // payment-method3
    $('#payment-method3').on('click', function () {
        $('#payment-method-content3').slideToggle(900);
    });





    // 8. Create an account toggle function
    // ---------------------------------------------------------------------------
    $('#cbox-account').on('click', function () {
        $('#cbox-account-info').slideToggle(900);
    });


    // 9. Create an account toggle function
    // ---------------------------------------------------------------------------
    $('#ship-box').on('click', function () {
        $('#ship-box-info').slideToggle(1000);
    });






    // 10. Scroll To down Js
    //---------------------------------------------------------------------------
    function smoothSctollTop() {
        $('.smooth-scroll a').on('click', function (event) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 0
                }, 1500);

            }
        });
    }
    smoothSctollTop();




    // 11. slider - active
    //---------------------------------------------------------------------------
    function mainSlider() {
        var BasicSlider = $('.slider-active');

        BasicSlider.on('init', function (e, slick) {
            var $firstAnimatingElements = $('.single-slider:first-child').find('[data-animation]');
            doAnimations($firstAnimatingElements);
        });

        BasicSlider.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
            var $animatingElements = $('.single-slider[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
            doAnimations($animatingElements);
        });

        BasicSlider.slick({
            dots: true,
            fade: true,
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: true,
            prevArrow: '<b><span class="fa-solid fa-long-arrow-alt-left l-a"></span></b>',
            nextArrow: '<b><span class="fa-solid fa-long-arrow-alt-right r-a"></span></b>',
            responsive: [{
                breakpoint: 767,
                settings: {}
            }]
        });

        function doAnimations(elements) {
            var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            elements.each(function () {
                var $this = $(this);
                var $animationDelay = $this.data('delay');
                var $animationType = 'animated ' + $this.data('animation');
                $this.css({
                    'animation-delay': $animationDelay,
                    '-webkit-animation-delay': $animationDelay
                });
                $this.addClass($animationType).one(animationEndEvents, function () {
                    $this.removeClass($animationType);
                });
            });
        }
    }
    mainSlider();






    // 12. rooms-hm1-active (home1)
    //---------------------------------------------------------------------------
    $('.rooms-hm1-active').slick({
        infinite: false,
        dots: true,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1000,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 2,
                }
            }
        ]
    });



    // 13. brand-active (home1)
    //---------------------------------------------------------------------------
    $('.brand-active').slick({
        infinite: true,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1000,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 2,
                }
            }
        ]
    });



    // 14. testimonial-active (home1)
    //---------------------------------------------------------------------------
    $('.testimonial-active').slick({
        infinite: false,
        dots: true,
        arrows: false,
        // prevArrow: '<b><span class="fa-solid fa-long-arrow-alt-left l-a"></span></b>',
        // nextArrow: '<b><span class="fa-solid fa-long-arrow-alt-left r-a"></span></b>',
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1000,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 2,
                }
            }
        ]
    });






    // 15. feature-hm1-active (home1)
    //---------------------------------------------------------------------------
    $('.feature-hm1-active').slick({
        dots: false,
        arrows: true,
        prevArrow: '<b><span class="fa-solid fa-long-arrow-alt-left l-a"></span></b>',
        nextArrow: '<b><span class="fa-solid fa-long-arrow-alt-right r-a"></span></b>',
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
    });




    // 16. about-gallery-active
    //---------------------------------------------------------------------------
    $('.about-gallery-active').slick({
        dots: false,
        arrows: false,
        // variableWidth: true,
        prevArrow:'<b><span class="fal fa-long-arrow-left l-a"></span></b>',
        nextArrow:'<b><span class="fal fa-long-arrow-right r-a"></span></b>',
        infinite: true,
        autoplay: true,
        autoplaySpeed: 5000,
        speed: 500,
        centerPadding: '0',
        slidesToShow: 1,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    variableWidth: false,
                }
            }
        ]
    });





    // 17. counter js
    // ---------------------------------------------------------------------------
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });




    // 18. header-search
    //---------------------------------------------------------------------------
    $(".header-search").on("click", function () {
        $(".header-search-details").addClass('open-search-info');
    });
    $(".close-icon").click(function () {
        $(".header-search-details").removeClass('open-search-info');

    });




    // 19. tilt js
    // ---------------------------------------------------------------------------
    $('.tilt').tilt({
        maxTilt: 15,
        perspective: 1500,
    });



    // 20. aos js
    // ---------------------------------------------------------------------------
    AOS.init();




    // 21. Animate the scroll to top
    // --------------------------------------------------------------------------
    // Show or hide the sticky footer button
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 600) {
            $('#scroll').addClass('show');
        } else {
            $('#scroll').removeClass('show');
        }
    });

    $('#scroll').on('click', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: 0,
        }, 1500);
    });




    // 22. Contact form 
    //---------------------------------------------------------------------------
    $(function () {
        // Here is the form
        var form = $('#contact-form');

        // Getting the messages div
        var formMessages = $('.form-message');


        // Setting up an event listener for the contact form
        $(form).submit(function (event) {
            // Stopping the browser to submit the form
            event.preventDefault();

            // Serializing the form data
            var formData = $(form).serialize();

            // Submitting the form using AJAX
            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
                data: formData
            }).done(function (response) {

                // Making the formMessages div to have the 'success' class
                $(formMessages).removeClass('error');
                $(formMessages).addClass('success');

                // Setting the message text
                $(formMessages).text(response);

                // Clearing the form after successful submission 
                $('#inputName').val('');
                $('#inputEmail').val('');
                $('#inputPhone').val('');
                $('#inputMessage').val('');
            }).fail(function (data) {

                // Making the formMessages div to have the 'error' class
                $(formMessages).removeClass('success');
                $(formMessages).addClass('error');

                // Setting the message text
                if (data.responseText !== '') {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).text('Oops! An error occurred and your message could not be sent.');
                }
            });

        });

    });




    // 23. Countdown
    //---------------------------------------------------------------------------
    $('[data-countdown]').each(function () {
        var $this = $(this),
            finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function (event) {
            $this.html(event.strftime('<span class="cdown days"><span class="time-count">%-D</span> <p>Days</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Hours</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>Mins</p></span> <span class="cdown second"><span><span class="time-count">%S</span> <p>Sec</p></span>'));
        });
    });





    /* 24. Price filter active 2*/
    //---------------------------------------------------------------------------
    if ($("#slider-range2").length) {
        $("#slider-range2").slider({
            range: true,
            min: 0,
            max: 1000,
            values: [0, 500],
            slide: function (event, ui) {
                $("#amount2").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#amount2").val("$" + $("#slider-range2").slider("values", 0) +
            " - $" + $("#slider-range2").slider("values", 1));


        $('#filter-btn').on('click', function () {
            $('.filter-widget').slideToggle(1000);
        })
    };





    // 25. nice selection
    // -------------------------------------------------------------------
    $('select').niceSelect();





    // 26. Isotope js
    // -------------------------------------------------------------------
    $('.grid').imagesLoaded(function () {
        var grid = $('.grid').isotope({
            itemSelector: '.grid-item',
            percentPosition: true,
            layoutMode: 'masonry',
            masonry: {
                // use outer width of grid-sizer for columnWidth
                // columnWidth: '.grid-item'
                columnWidth: '.grid-item',
                // horizontalOrder: true
            }
        });

        // filter items on button click
        $('.portfolio-menu').on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            grid.isotope({
                filter: filterValue
            });
        });
    });



    //for menu active class
    $('.portfolio-menu button').on('click', function (event) {
        $(this).siblings('.active').removeClass('active');
        $(this).addClass('active');
        event.preventDefault();
    });




    // 27. accordion(sidebar) 
    //---------------------------------------------------------------------------
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
        } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
        } 
    });
    };






    // 28. Range Slider Js (filter)
    //---------------------------------------------------------------------------
    if ($("#slider-range2").length) {
        $("#slider-range2").slider({
            range: true,
            min: 0,
            max: 500,
            values: [10.00, 250.00],
            slide: function (event, ui) {
                $("#amount2").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#amount2").val("$" + $("#slider-range2").slider("values", 0) +
            " - $" + $("#slider-range2").slider("values", 1));


        $('#filter-btn').on('click', function () {
            $('.filter-widget').slideToggle(1000);
        });

    };


    // 29. datepicker js
    //---------------------------------------------------------------------------
    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat:"d MM, y",
        showAnim:"slideDown",
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wen', 'Thu', 'Fri', 'Sta'],
        showOn: "button",
        // showButtonPanel: true,
        // // buttonImage: "images/calendar.gif",
        // buttonImageOnly: true,
        buttonText: "",
        // showOn: "",
        firstDay: 1,
    });


})(jQuery);