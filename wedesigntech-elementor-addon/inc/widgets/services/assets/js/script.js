(function ($) {

const wdtServicesWidgetHandler = function($scope, $) {

    if ($scope.find('.wdt-services-container.swiper').length) {
        return;
    }
    const $serviceItems = $scope.find('.wdt-service-item.wdt-service-type-2');

    $serviceItems.each(function() {
        const $item = $(this);
        const $mediaGroup = $item.find('.wdt-service-media-group');
        const $description = $mediaGroup.find('.wdt-service-description');

        if ($description.length) {
            const detailHeight = $description.outerHeight();

            $description.css('margin-bottom', -detailHeight + 'px');

            $item.on('mouseenter', function() {
                $description.css('margin-bottom', '0');
            });

            $item.on('mouseleave', function() {
                $description.css('margin-bottom', -detailHeight + 'px');
            });
        }

        if ($mediaGroup.length) {
            const height = $mediaGroup.outerHeight();
            $mediaGroup.css('height', height + 'px');
        }
    });
    
}
            
$(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/wdt-services.default', wdtServicesWidgetHandler);
});

})(jQuery);            
        