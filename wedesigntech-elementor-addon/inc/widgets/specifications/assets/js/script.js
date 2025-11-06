(function ($) {

    const wdtSpecificationsWidgetHandler = function($scope, $) {

        
    };
  
    $(window).on('elementor/frontend/init', function () {
          elementorFrontend.hooks.addAction('frontend/element_ready/wdt-specifications.default', wdtSpecificationsWidgetHandler);
    });
  
  })(jQuery);
  