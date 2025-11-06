jQuery.noConflict();

jQuery(document).ready(function($){
    "use strict";

    // Product Listing Isotope
        $('.products-apply-isotope').each(function() {
            if(!$(this).hasClass('swiper-wrapper')) {
                var $grid = $(this).isotope({itemSelector : '.wdt-col', transformsEnabled:false });

                $(".sort-by-filter-group").on("click", ".filter", function () {
                    var sortValue = $(this).attr("data-filter");
                    if (sortValue === '*') {
                        $grid.isotope({ filter: '*' });
                    } else {
                        $grid.isotope({ filter: $(sortValue).find('.wdt-col') });
                    }
                  });
                  
                // change is-checked class on buttons
                $(".sort-by-filter-group").each(function (i, buttonGroup) {
                    var $buttonGroup = $(buttonGroup);
                    $buttonGroup.on("click", ".filter", function () {
                        $buttonGroup.find(".is-checked").removeClass("is-checked");
                        $(this).addClass("is-checked");
                    });
                });
            }
        });

    // On window resize
        $(window).on('resize', function() {
            // Product Listing Isotope
            $('.products-apply-isotope').each(function() {
                if(!$(this).hasClass('swiper-wrapper')) {
                    $(this).isotope({itemSelector : '.wdt-col', transformsEnabled:false });
                }
            });
        });

    setTimeout( function() {
        if($('.products-apply-isotope').length) {
            window.dispatchEvent(new Event('resize'));
        }
    }, 900 );

    $('a.woocommerce-review-link').on('click', function( e ) {
        $( '.reviews_tab a' ).click();
        $('html, body').animate({
            scrollTop: $("#tab-reviews").offset().top - 100
        }, 1000);
        e.preventDefault();
    });

    $('#primary .products .product').each( function () {
        if($(this).hasClass('first')) {
            $(this).removeClass('first');
        }
        if($(this).hasClass('last')) {
            $(this).removeClass('last');
        }
    });

        // Product Offers Top Fix
        $('.product-offers').each(function() {
             if($(this).prev('.product-labels').length) {
                if($(this).parents('.products').hasClass('product-label-ribbon') || $(this).parents('.products').hasClass('product-label-angular')) {
                    var $height =$(this).prev('.product-labels').width() + 10;
                } else {
                    var $height =$(this).prev('.product-labels').height() + 10;
                }
                $(this).css({
                    'top': $height
                });
            }
        });

        // Product Custom Type Top Fix
        $('.product-custom-type').each(function() {
            if($(this).parents('.product').find('.featured-tag').length > 0) {
                var $height = $(this).parents('.product').find('.featured-tag').height();
                $(this).css({
                    'top': $height+20
                });
            }
        });

});