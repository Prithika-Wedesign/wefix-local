jQuery(document).ready(function($) {
    "use strict";
    var swiperContainer = $('.wdt-taxonomy-swiper.swiper-container');
    var settings = swiperContainer.data('settings');

    if (!settings) {
        return; // Exit if no settings are found
    }

    if (typeof settings === 'string') {
        settings = JSON.parse(settings);
    }

    var currentDeviceMode = elementorFrontend.getCurrentDeviceMode();
    var slidesPerView = settings.slides_to_show;
    var spaceBetween = settings.space_between_gaps[currentDeviceMode];
    var loop = settings.loop === "true"; 
    var arrows = settings.arrows === "true"; 
    var bulletpagination = settings.bulletpagination === "true"; 

    // Handle responsiveness
    var breakpoints = {};
    settings.responsive.forEach(function(breakpoint) {
        breakpoints[breakpoint.breakpoint] = {
            slidesPerView: breakpoint.toshow,
            spaceBetween: spaceBetween,
        };
    });

    // Initialize Swiper
    var swiper = new Swiper(swiperContainer[0], {
        slidesPerView: slidesPerView,
        spaceBetween: spaceBetween,
        loop: loop,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
                return '<span class="' + className + '"></span>';
            },
        },
        navigation: {
            nextEl: '.wdt-taxonomy-swiper-button-next',
            prevEl: '.wdt-taxonomy-swiper-button-prev',
        },
        loop: loop,
        breakpoints: breakpoints, // Add breakpoints for responsiveness
    });

    swiper.navigation.enabled = arrows;
    swiper.pagination.enabled = bulletpagination;
    swiper.update();
});