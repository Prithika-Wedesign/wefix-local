(function ($) {
  "use strict";


  function upload(type) {
    if ( mediaUploader ) {
      mediaUploader.open();
    }

    var mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Select an Image',
      button: {
        text: 'Use This Image'
      },
      multiple: false
    });

    mediaUploader.on('select', function() {
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      $('.wdt-widget-' + type + '-hidden-input').val(attachment.url).trigger('change');
      $('.wdt-widget-' + type + '-media').attr('src', attachment.url);
    });
    mediaUploader.open();
  }

  $('body').on('click', '.wdt-widget-image-upload-button', function() {
    upload('image');
  });

  $('body').on('click', '.wdt-widget-image-delete-button', function() {
    $('.wdt-widget-image-hidden-input').attr('value', '');
    $('.wdt-widget-image-media').attr('src', '');
  });


  

})(jQuery);