jQuery(document).ready(function ($) {
    var mediaUploader;

    // Upload button click
    $('#upload_service_icon').on('click', function (e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'Select an Icon',
            button: {
                text: 'Use this icon'
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            var fileExtension = attachment.url.split('.').pop().toLowerCase();
            var previewHtml = '';

            if (fileExtension === 'svg') {
                previewHtml = '<div id="service_icon">' + '<object type="image/svg+xml" data="' + attachment.url + '" width="100" height="100"></object>' + '</div>';
            } else {
                previewHtml = '<img id="service_icon" src="' + attachment.url + '" style="max-width: 100px; max-height: 100px;" />';
            }

            $("#service_icon_preview").html(previewHtml);

            if (!$('#remove_service_icon').length) {
                $("#service_icon_preview").append('<button type="button" class="button" id="remove_service_icon">Remove Icon</button>');
            }

            $('input[name="service_icon"]').val(attachment.url);
        });

        mediaUploader.open();
    });

    $(document).on('click', '#remove_service_icon', function () {
        $('#service_icon_preview').empty();
        $('input[name="service_icon"]').val('');
    });


    $('#service_icon_input').on('input change', function () {

        var url = $(this).val().trim();
        if (!url) {
            $('#service_icon_preview').empty();
            return;
        }

        var fileExtension = url.split('.').pop().toLowerCase();
        var previewHtml = '';

        if (fileExtension === 'svg') {
            previewHtml = '<div id="service_icon"><object type="image/svg+xml" data="' + url + '" width="100" height="100"></object></div>';
        } else {
            previewHtml = '<img id="service_icon" src="' + url + '" style="max-width: 100px; max-height: 100px;" />';
        }

        $("#service_icon_preview").html(previewHtml);

        if (!$('#remove_service_icon').length) {
            $("#service_icon_preview").append('<button type="button" class="button" id="remove_service_icon">Remove Icon</button>');
        }
    });


    $('#enable_service_price').on('change', function () {
        if ($(this).val() === 'yes') {
            $('#price_field_wrapper').slideDown();
        } else {
            $('#price_field_wrapper').slideUp();
        }
    });


});
