(function ($) {
    "use strict";

    var wefixFacebookProfile = {
        init: function () {
            $('body').on('submit', '#wefix-fb-update-form', function (e) {
                e.preventDefault();

                var firstName = $('#wefix-fb-first-name').val().trim();
                var lastName  = $('#wefix-fb-last-name').val().trim();
                var email     = $('#wefix-fb-email').val().trim();
                var $alert = $('.wefix-fb-update-alert');

                $alert.removeClass('invalid success').hide();

                if (!firstName || !lastName || !email) {
                    $alert.text('Please fill out all required fields.').addClass('invalid').show();
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: wefix_social_api.ajax_url,
                    data: {
                        action: 'wefix_get_fresh_nonce'
                    },
                    dataType: 'json',
                    success: function (nonceResponse) {
                        if (nonceResponse.success && nonceResponse.data.nonce) {
                            var freshNonce = nonceResponse.data.nonce;
                            $.ajax({
                                type: 'POST',
                                url: wefix_social_api.ajax_url,
                                data: {
                                    action: 'wefix_update_fb_profile',
                                    first_name: firstName,
                                    last_name: lastName,
                                    email: email,
                                    nonce: freshNonce
                                },
                                dataType: 'json',
                                success: function (response) {
                                    if (response.success) {
                                        $('#wefix-fb-update-form')[0].reset();
                                        $alert.text('Profile updated successfully.').addClass('success').show();
                                        setTimeout(function () {
                                            window.location.href = response.data?.redirect_url || wefix_social_api.redirect_url || window.location.href;
                                        }, 1000);
                                    } else {
                                        var msg = typeof response.data === 'string' ? response.data : 'Profile update failed.';
                                        $alert.text(msg).addClass('invalid').show();
                                    }
                                },
                                error: function (xhr, status, error) {
                                    $alert.text('Something went wrong. Please try again.').addClass('invalid').show();
                                    console.error('AJAX Error:', error, xhr.responseText);
                                }
                            });

                        } else {
                            $alert.text('Security token failed to generate. Please refresh the page.').addClass('invalid').show();
                        }
                    },
                    error: function () {
                        $alert.text('Unable to get secure token. Try reloading the page.').addClass('invalid').show();
                    }
                });
            });
        }
    };

    $(document).ready(function () {
        wefixFacebookProfile.init();
    });

})(jQuery);
