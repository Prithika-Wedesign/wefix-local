
(function($) {
    'use strict';

    const wdtTimelineWidgetHandler = function(scope) {

        const $scope = $(scope);
        const $scopeItem = $scope.find('.wdt-temp-default');

        function setEqualSwiperHeights() {
            var maxHeight = 0;

            $scopeItem.find('.swiper-slide').css('height', 'auto').each(function () {
                var slideHeight = $(this).outerHeight();
                if (slideHeight > maxHeight) {
                    maxHeight = slideHeight;
                }
            });

            $scopeItem.find('.swiper-slide').css('height', maxHeight + 'px');

            $scopeItem.each(function () {
                var $template = $(this);
                var $items = $template.find('.swiper-slide');
                var contentItems = [];

                $items.each(function () {
                    var $item = $(this);
                    var $media = $item.find('.wdt-timeline-media-group');
                    var $detail = $item.find('.wdt-timeline-content-group');

                    $media.css('height', '');
                    $detail.css('height', '');

                    var mediaHeight = $media.innerHeight();
                    var detailHeight = $detail.innerHeight();
                    var maxHeight = Math.max(mediaHeight, detailHeight);

                    $media.innerHeight(maxHeight);
                    $detail.innerHeight(maxHeight);

                    contentItems.push($detail);
                });

                $.each(contentItems, function (index, $detailGroup) {
                    var $parentItem = $detailGroup.closest('.swiper-slide');

                    if (index % 2 === 0) {
                        $parentItem.addClass('wdt-even');
                        $detailGroup.css({ 'order': '-1'});
                    } else {
                        $parentItem.addClass('wdt-odd');
                        // $detailGroup.css('align-content', 'start');
                    }
                });

            });

        }

        $scopeItem.each(function () {
            var dataId = $(this).data('id');

            var swiper = new Swiper('.swiper-' + dataId, {
                slidesPerView: "auto",
                allowTouchMove: false,
                navigation: {
                    nextEl: '.swiper-button-next-' + dataId,
                    prevEl: '.swiper-button-prev-' + dataId,
                },
                on: {
                    init: function () {
                        setEqualSwiperHeights();
                    },
                    resize: function () {
                        setEqualSwiperHeights();
                    }
                }
            });
        });

    };

    window.addEventListener('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/wdt-timeline.default', wdtTimelineWidgetHandler);
        } 
    });


})(jQuery);

