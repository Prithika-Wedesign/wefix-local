var dtRecentlyViewedProductsInit = function() {

    // Recently Viewed Products - Carousel

        jQuery('.wdt-shop-recently-viewed-products-container.swiper').each(function() {


            const wdtrecentlyview = {
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
					clickable: true,
				},

			}

		 	const recentlyviewedproduct = new Swiper('.wdt-recently-viewed-products', wdtrecentlyview);

        });


    // Recently Viewed Products - Toggle View

        jQuery(document).on('click', '.wdt-shop-recently-viewed-products-toggle-icon', function(){
            let $parentHolder = jQuery(this).parents('.wdt-shop-recently-viewed-products-holder');
            let $itemWidth = +$parentHolder.width();
            if($parentHolder.hasClass('expand')) {
                $parentHolder.animate({
                    right: -$itemWidth
                },function() {
                    $parentHolder.toggleClass('expand')
                });
            } else {
                $parentHolder.animate({
                    right:0
                },function() {
                    $parentHolder.toggleClass('expand')
                });
            }
        });

};


jQuery.noConflict();
jQuery(document).ready(function(jQuery){

    'use strict';

    if ( typeof dtrvpObjects !== 'undefined' ) {
        if(dtrvpObjects.enable_recently_viewed_products) {
            dtRecentlyViewedProductsInit();
        }
    }

});