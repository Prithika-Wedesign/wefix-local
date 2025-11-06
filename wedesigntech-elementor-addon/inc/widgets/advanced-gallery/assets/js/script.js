(function ($) {
  const initWdtGallery = function ($scope) {
    var $gallery = $scope.find('.wdt-gallery.wdt-grid');

      const elementorFrontend = window.elementorFrontend
      if (typeof elementorFrontend !== "undefined" && elementorFrontend.isEditMode()) {

      }

    if (!$gallery.length) return;

    var settings = $gallery.data('settings');
    if (!settings || settings.enable_isotope !== 'true') return;

    var $items = $gallery.find('.wdt-grid-item');

    $items.removeClass('one_items one_half_items one_third_items two_third_items one_fourth_items three_fourth_items');

    $items.each(function (i) {
      var $item = $(this);
      var index = i + 1;

      if (settings.masonry_options) {
        $.each(settings.masonry_options, function (key, values) {
          values = values.map((v) => parseInt(v));
          if (values.includes(index)) {
            $item.addClass(key);
          }
        });
      }
    });

    if (typeof Isotope !== 'undefined' && $gallery.data('isotope')) {
      $gallery.isotope('destroy');
    }

    $gallery.isotope({
      itemSelector: '.wdt-grid-item',
      layoutMode: 'masonry'
    });

    $gallery.imagesLoaded(function () {
      $gallery.isotope({
        itemSelector: '.wdt-grid-item',
        percentPosition: true,
        masonry: {
          columnWidth: '.wdt-grid-sizer'
        }
      });
    });

    let resizeTimer;
    $(window).on("resize", function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        if ($gallery.data("isotope")) {
          $gallery.isotope("layout");
        }
      }, 250);
    });
  };

  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/wdt-advanced-gallery.default', initWdtGallery);
  });
})(jQuery);
