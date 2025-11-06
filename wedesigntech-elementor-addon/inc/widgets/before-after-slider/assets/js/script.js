(function ($) {

  const wdtBeforeAfterSlideWidgetHandlers = function($scope, $) {

    $(window).load(function() {
      $scope.find(".wdt-slider-button").css("left", `calc(50% - 0px)`);
    });

    var element_scope = $scope.find('.wdt-before-after-slider-container');

    $.each(element_scope, function() {

      var element = $(this);
      var element_div = element.find('input');
      var element_id = element_div.attr('id');

      $scope.find("#"+element_id).on("input change", (e) => {
        const BeforeAfterSlider = e.target.value;
        element.find(".wdt-foreground-img").css("clip-path", `inset(0 0 0 ${BeforeAfterSlider}%)`);
        element.find(".wdt-slider-button").css("left", `calc(${BeforeAfterSlider}% - 0px)`);
      });

    });
    

    return  wdtBeforeAfterSlideWidgetHandlers;
  }

  $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-before-after-slider.default', wdtBeforeAfterSlideWidgetHandlers);
  });

})(jQuery);