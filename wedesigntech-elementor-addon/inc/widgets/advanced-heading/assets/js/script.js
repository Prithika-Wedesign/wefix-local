(function ($) {

  const wdtAdvancedheadingWidgetHandler = function($scope, $) {

    const $holder  = $scope.find('.wdt-creative-heading-holder');
    const $heading = $scope.find('.wdt-heading-title-wrapper');

    if (!$heading.length) return;

    const text = $heading.text().trim();

    if ($holder.hasClass('animat-skew')) {
      const words = text.split(" ");
      const spannedText = words.map(word => `<span class="wdt-title-word">${word}</span>`).join(" ");
      $heading.html(spannedText);
    }

    else if ($holder.hasClass('animat-charsplit')) {
      const words = text.split(" ");
      let charIndex = 0; 

      const spannedText = words.map(word => {
        const chars = word.split("").map(ch => {
          const delay = (charIndex * 0.02).toFixed(2); 
          charIndex++;
          return `<span class="wdt-title-char" style="animation-delay:${delay}s">${ch}</span>`;
        }).join("");

        return `<span class="wdt-title-word">${chars}</span>`;
      }).join(" ");

      $heading.html(spannedText);
    }

  };

  $(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-advanced-heading.default', wdtAdvancedheadingWidgetHandler);
  });

})(jQuery);
