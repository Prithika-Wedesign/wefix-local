(function ($) {

  const wdtTeamWidgetHandler = function($scope, $) {

    var $teamRoot = $scope.find('.wdt-team-holder.wdt-item-clickable');
    if (!$teamRoot.length) return;
    
    $teamRoot.find('.wdt-content-item').each(function () {
      var $item = $(this);
      var $container = $item.find('.wdt-social-icons-container');

      if ($container.find('.wdt-team-click-icon').length === 0) {
        $container.append(
          `<div class="wdt-team-click-icon">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20" xml:space="preserve">
            <path d="M13.9,4.7C13.9,4.7,13.9,4.8,13.9,4.7c0.2,0.4,0.5,0.6,0.8,0.8c0.3,0.2,0.7,0.3,1.1,0.3c0.6,0,1.1-0.2,1.5-0.6  c0.4-0.4,0.6-0.9,0.6-1.5c0-0.6-0.2-1.1-0.6-1.5c-0.4-0.4-0.9-0.6-1.5-0.6c-0.6,0-1.1,0.2-1.5,0.6c-0.4,0.4-0.6,0.9-0.6,1.5  c0,0.2,0,0.4,0.1,0.5C13.8,4.4,13.8,4.6,13.9,4.7L13.9,4.7z M13,6.2L7.8,9C7.9,9.3,8,9.6,8,10s-0.1,0.7-0.1,1l5.2,2.8  c0.3-0.3,0.6-0.5,0.9-0.7c0.6-0.3,1.2-0.5,1.9-0.5c1,0,2,0.4,2.6,1.1c0.7,0.7,1.1,1.6,1.1,2.6c0,1-0.4,2-1.1,2.6  c-0.7,0.7-1.6,1.1-2.6,1.1c-1,0-2-0.4-2.6-1.1c-0.7-0.7-1.1-1.6-1.1-2.6c0-0.3,0-0.6,0.1-0.9l0-0.1L7,12.5c-0.1,0.1-0.1,0.1-0.2,0.2  c-0.7,0.7-1.6,1.1-2.6,1.1c-1,0-2-0.4-2.6-1.1C0.9,12,0.5,11,0.5,10c0-1,0.4-2,1.1-2.6c0.7-0.7,1.6-1.1,2.6-1.1s2,0.4,2.6,1.1  C6.9,7.4,7,7.5,7,7.6l5.2-2.8l0-0.1C12.1,4.3,12,4,12,3.7c0-1,0.4-2,1.1-2.6C13.8,0.4,14.7,0,15.8,0s2,0.4,2.6,1.1  c0.7,0.7,1.1,1.6,1.1,2.6c0,1-0.4,2-1.1,2.6c-0.7,0.7-1.6,1.1-2.6,1.1c-0.7,0-1.3-0.2-1.9-0.5C13.6,6.7,13.2,6.5,13,6.2L13,6.2z   M17.3,14.8c-0.4-0.4-0.9-0.6-1.5-0.6c-0.4,0-0.8,0.1-1.1,0.3c-0.3,0.2-0.6,0.5-0.8,0.8c-0.1,0.2-0.2,0.3-0.2,0.5  c0,0.2-0.1,0.3-0.1,0.5c0,0.6,0.2,1.1,0.6,1.5c0.4,0.4,0.9,0.6,1.5,0.6c0.6,0,1.1-0.2,1.5-0.6c0.4-0.4,0.6-0.9,0.6-1.5  C17.9,15.7,17.7,15.2,17.3,14.8z M5.7,8.5C5.3,8.1,4.8,7.9,4.2,7.9S3.1,8.1,2.7,8.5C2.3,8.9,2.1,9.4,2.1,10c0,0.6,0.2,1.1,0.6,1.5  c0.4,0.4,0.9,0.6,1.5,0.6s1.1-0.2,1.5-0.6c0.4-0.4,0.6-0.9,0.6-1.5C6.3,9.4,6.1,8.9,5.7,8.5z"/>
            </svg>
          </div>`
        );
      }
    });

    $teamRoot
      .off('click.wdtTeam', '.wdt-team-click-icon')
      .on('click.wdtTeam', '.wdt-team-click-icon', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var $item = $(this).closest('.wdt-content-item');
        var $list = $item.find('.wdt-social-icons-list').first();

        $teamRoot.find('.wdt-social-icons-list').removeClass('wdtactive');

        $list.toggleClass('wdtactive');
      });
  };

  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/wdt-team.default', wdtTeamWidgetHandler);
  });

})(jQuery);
