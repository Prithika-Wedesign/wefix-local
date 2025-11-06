(function ($) {

  const wdtCounterWidgetHandler = function($scope, $) {
    $scope.find('.wdt-content-counter-number').countTo({
      decimals: 2,
      formatter: function (value, options) {
        let toValue = jQuery(this).data('to');
        let num = parseFloat(value);

        if (isNaN(num)) {
          return value; 
        }

        if (Number(toValue) === 0) {
          return '';
        }

        if (Number.isInteger(Number(toValue))) {
          return num.toFixed(0);
        } else {
          return num.toFixed(options.decimals);
        }
      }
    });

  };

  $(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-counter.default', wdtCounterWidgetHandler);
  });

})(jQuery);
