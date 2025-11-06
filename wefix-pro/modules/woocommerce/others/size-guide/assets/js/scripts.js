var dtSizeGuideInit = function() {

    // Product Size Guide

        jQuery( 'body' ).delegate( '.wcsg_btn_wrapper .wdt-wcsg-button:not(.disabled)', 'click', function(e) {

            var this_item = jQuery(this);
            var product_id = this_item.attr('data-product_id');
            var sizeguide_nonce = this_item.attr('data-sizeguide-nonce');

            if(this_item.hasClass('disabled')) {
                return;
            }

            // ajax call
            jQuery.ajax({
                type: "POST",
                url: wdtShopObjects.ajaxurl,
                data:
                {
                    action: 'wefix_shop_size_guide_popup',
                    product_id: product_id,
                    sizeguide_nonce: sizeguide_nonce
                },
                beforeSend: function(){
                    this_item.parents('.wcsg_btn_wrapper').append( '<div class="wdt-product-loader"><i class="fa fa-spinner fa-spin"></i></div>' );

                },
                success: function (response) {
                    jQuery('body').append(response);
                    sizeGuideCarousel();
                },
                complete: function(){
                    this_item.parents('.wcsg_btn_wrapper').find('.wdt-product-loader').remove();
                }
            });

            this_item.addClass('disabled');

            e.preventDefault();

        });

    // Product Size Guide Close

        jQuery( 'body' ).delegate( '.wdt-size-guide-popup-close', 'click', function(e) {

            var this_item = jQuery(this);
            this_item.parents('.wdt-size-guide-popup-holder').remove();

            jQuery('.wcsg_btn_wrapper .wdt-wcsg-button').removeClass('disabled');

            e.preventDefault();

        });


    // Carousel

        function sizeGuideCarousel() {

            jQuery('.wdt-size-guide-popup-container.swiper').each(function() {
                
                const wdtsizeguide = {
                    initialSlide: 0,
                    simulateTouch: true,
                    // roundLengths: true,
                    grabCursor: true,

                    slidesPerView: 1,
                    mousewheel: true,
                    direction: 'horizontal',

                    pagination: {
                        el: '.wdt-products-bullet-pagination',
                        type: 'bullets',
                        clickable: true
                    },

                }

		 	    const productsizeguide = new Swiper('.wdt-products-size-guide', wdtsizeguide);

            });

        }

};


jQuery.noConflict();
jQuery(document).ready(function($){

    "use strict";

    if ( typeof wdtShopObjects !== 'undefined' ) {
        if(wdtShopObjects.product_template == 'woo-default') {
            dtSizeGuideInit();
        }
    }

});


( function( $ ) {

	var wdtShopSizeGuideJs = function($scope, $){
        dtSizeGuideInit();
	};

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-shop-product-single-summary.default', wdtShopSizeGuideJs);
	});

} )( jQuery );