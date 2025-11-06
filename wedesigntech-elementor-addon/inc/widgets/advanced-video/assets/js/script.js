(function ($) {

    const wdtadvancedvideoHandler = function($scope, $) {

        const advancedvideoContainer = $scope.find('.wdt-advanced-video');
        const videoplayButton = $scope.find('.wdt-play-button');

        $paly_icon  = advancedvideoContainer.find('input[name = "wdt_video_paly"]').val();
        $pause_icon  = advancedvideoContainer.find('input[name = "wdt_video_pause"]').val();
        console.log($pause_icon);


        advancedvideoContainer.mousemove(function (event) {

            const containerRect = advancedvideoContainer[0].getBoundingClientRect();
            const mouseX = event.clientX - containerRect.left;
            const mouseY = event.clientY - containerRect.top;
  
            const buttonWidth = videoplayButton[0].offsetWidth;
            const buttonHeight = videoplayButton[0].offsetHeight;
            const buttonX = mouseX - buttonWidth / 2;
            const buttonY = mouseY - buttonHeight / 2;
            const maxButtonX = containerRect.width - buttonWidth;
            const maxButtonY = containerRect.height - buttonHeight;
  
            videoplayButton.css( "left", Math.min(Math.max(buttonX, 0), maxButtonX) + "px" );
            videoplayButton.css( "top", Math.min(Math.max(buttonY, 0), maxButtonY) + "px" );
  
        });

        advancedvideoContainer.mouseleave(function () {
            setTimeout(function () {
              videoplayButton.css({ 
                  "left" : "50%", 
                  "top" : "50%", 
                  "transform" : "translate(-50%, -50%) scale(1)", 
                  "transition" : "all 0.3s ease-out" 
                });
            }, 50);
          });
  
          advancedvideoContainer.mouseover(function () {
            videoplayButton.css({ 
                "transition" : "transform ease-out 0.3s", 
                "transform" : "scale(1.2)" 
              });
          });

        advancedvideoContainer.on('click', function (e) {
            if ($(".advanced-video").get(0).paused) {
                $(".advanced-video").trigger("play");
                $(".wdt-control-icons").html($pause_icon);
                if ($pause_icon == '') {
                  $(".wdt-control-icons").html('<i class="fa fa-solid fa-pause"></i>');
                } else {
                  $(".wdt-control-icons").html($pause_icon);
                }
              } else {
                $(".advanced-video").trigger("pause");
                if ($paly_icon == '') {
                  $(".wdt-control-icons").html('<i class="fa fa-solid fa-play"></i>');
                } else {
                  $(".wdt-control-icons").html($paly_icon);
                }
              }

        });


    };
  
    $(window).on('elementor/frontend/init', function () {
          elementorFrontend.hooks.addAction('frontend/element_ready/wdt-advanced-video.default', wdtadvancedvideoHandler);
    });
  
  })(jQuery);