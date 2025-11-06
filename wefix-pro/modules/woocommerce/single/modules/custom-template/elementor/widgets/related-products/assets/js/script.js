( function( $ ) {
	var wdtShopProductSingleRelatedImagesCarousel = function($scope, $){
		$scope.find('.wdt-product-related-products').each(function() {
	
		var $swiperItem = jQuery(this);
		const $layout=$swiperItem.data('layout');
		if($layout === '' || $layout === 'column') {
			return;
		}
		if($layout=="carousel")
		{
			$(".wdt-product-related-products ul").addClass('swiper-container');
			$(".wdt-product-related-products ul li").addClass('swiper-slide');
			$('.wdt-product-related-products ul li').wrapAll('<div class="swiper-wrapper" />');
			
		}
		
		// const $productcarouselloopmode = $swiperItem.data('carouselloopmode');
		const $productcarouselslidesperview = $swiperItem.data('carouselslidesperview');
		const $productcarouselmousewheelcontrol = $swiperItem.data('carousel_mousewheelcontrol');
		const $productcarouselbulletpagination = $swiperItem.data('carousel_bulletpagination');
		const $productcarouselarrowpagination = $swiperItem.data('carousel_arrowpagination');
		const $productcarouselspacebetween = $swiperItem.data('carousel_spacebetween');
		const $carouselresponsive = $swiperItem.data('carouselresponsive');
		if($productcarouselspacebetween=='')
			$productcarouselspacebetweenis=0;
		else
			$productcarouselspacebetweenis=$productcarouselspacebetween;
		var pagination_class = '';
		var pagination_type = '';
			// Bullets pagination
			if($productcarouselbulletpagination == true ) {
				var pagination_class = '.wdt-related-product-image-gallery-bullet-pagination';
				var pagination_type = 'bullets';
				var watch_state = true;
			}

		const productimagerelatedgallery = {
			initialSlide: 0,
			//touchRatio: 0.2,
			grabCursor: true,
			// centeredSlides: true,
			slideToClickedSlide: true,
			// direction: 'horizontal',
			spaceBetween: $productcarouselspacebetweenis,
			keyboardControl: true,
			loop: true,
			mousewheel: $productcarouselmousewheelcontrol,
			pagination: {
				el: pagination_class,
				type: pagination_type,
				clickable: true,
			},
			slidesPerView: $productcarouselslidesperview
		}
		if ($productcarouselarrowpagination == true) {
			productimagerelatedgallery.navigation = {
				prevEl: '.wdt-related-product-image-gallery-arrow-prev',
				nextEl: '.wdt-related-product-image-gallery-arrow-next',
			};
		}
		const $responsiveSettings = $carouselresponsive['responsive'];
		const $responsiveData = {};
		jQuery.each($responsiveSettings, function (index, value) {
		$responsiveData[value.breakpoint] = {
			slidesPerView: value.toshow,
		};
		});
		productimagerelatedgallery['breakpoints'] = $responsiveData;
			var swiper = new Swiper('.wefix-related-product-carousel',productimagerelatedgallery);
		});
	};
    $(window).on('elementor/frontend/init', function(){
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-shop-related-products.default', wdtShopProductSingleRelatedImagesCarousel);
    });
} )( jQuery );