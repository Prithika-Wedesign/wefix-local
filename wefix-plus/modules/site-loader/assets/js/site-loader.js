(function ($) {
    "use strict";

    const $ready = function ($readyFn) {
        document.readyState === 'loading'
            ? // If document is still loading
                document.addEventListener('DOMContentLoaded', function (e) {
                    $readyFn();
                })
            : // If document is loaded completely
                $readyFn();
    };

    $ready(function() {
        setTimeout(() => {
            // $('.pre-loader').slideUp(500);

            jQuery('.pre-loader').css({
                clipPath: 'circle(0% at 50% 50%)',
            });

            // setTimeout(() => {
            //     jQuery('.pre-loader').fade(500);
            // }, 1000);
        }, 400);
    });


})(jQuery);