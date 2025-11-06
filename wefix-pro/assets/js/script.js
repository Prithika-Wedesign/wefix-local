jQuery(document).ready(function ($) {

    function updateServiceIconPreview(url) {
        var ext = url.split('.').pop().toLowerCase();
        var $preview = $('#csf-icon-preview');

        if (!url) {
            $preview.html('');
            return;
        }

        if (ext === 'svg') {
            // Load SVG and convert to string
            $.get(url, function (data) {
                const svgHTML = new XMLSerializer().serializeToString(data.documentElement);
                $preview.html('<div class="service_icon" style="width:80px;height:80px;overflow:hidden;">' + svgHTML + '</div>');
            }).fail(function () {
                $preview.html('<span style="color:red;">Failed to load SVG</span>');
            });
        } else {
            $preview.html('<img src="' + url + '" style="width:80px;height:80px;object-fit:contain;" />');
        }
    }

    var $input = $('input[name="_wefix_service_settings[service_icon]"]');
    if ($input.length) {
        updateServiceIconPreview($input.val());
    }

    $(document).on('change blur', 'input[name="_wefix_service_settings[service_icon]"]', function () {
        updateServiceIconPreview($(this).val());
    });

});

jQuery(document).ready(($) => {
    $("#wefix-settings-form").on("submit", function (e) {
        e.preventDefault();

        const form = $(this);
        const submitButton = form.find('input[type="submit"]');

        submitButton.prop("disabled", true).val("Saving...");

        const formData = {
            action: "save_service_settings",
            security: wefix_urls.wpnonce,
            _wefix_service_settings: {
                count: form.find("#service_count").val(),
                layout: form.find("#service_layout").val(),
                currency: form.find("#currency_symbol").val()
            }
        };

        console.log("Form data being sent:", formData);

        $.ajax({
            url: wefix_urls.ajaxurl,
            type: "POST",
            data: formData,
            dataType: "json",
            success: (response) => {
                console.log("Response received:", response);

                $(".notice").remove();

                if (response.success) {
                    $('<div class="notice notice-success is-dismissible"><p>Settings saved successfully!</p></div>')
                        .insertAfter(".wrap h1");
                } else {
                    const errorMsg = response.data || "Unknown error occurred.";
                    $('<div class="notice notice-error is-dismissible"><p>Error: ' + errorMsg + '</p></div>')
                        .insertAfter(".wrap h1");
                }
            },
            error: (xhr, status, error) => {
                console.error("AJAX Error:", {
                    status: status,
                    error: error,
                    response: xhr.responseText,
                });

                $(".notice").remove();

                $('<div class="notice notice-error is-dismissible"><p>Network error occurred. Please try again.</p></div>')
                    .insertAfter(".wrap h1");
            },
            complete: () => {
                submitButton.prop("disabled", false).val("Save Settings");

                setTimeout(() => {
                    $(".notice").fadeOut();
                }, 5000);
            },
        });
    });

    $('#currency_symbol').on('change', function () {
        if ($(this).val() === 'custom') {
            $('#custom_currency_wrap').show();
        } else {
            $('#custom_currency_wrap').hide();
        }
    });
});

