jQuery(function ($) {
    'use strict';

    $('.js-tetk-import-data').on('click', function () {

        // Reset response div content.
        $('.js-tetk-ajax-response').empty();

        // Prepare data for the AJAX call
        var data = new FormData();
        data.append('action', 'TETK_import_demo_data');
        data.append('security', tetk.ajax_nonce);
        data.append('selected', $('#TETK__demo-import-files').val());
        if ($('#TETK__content-file-upload').length) {
            data.append('content_file', $('#TETK__content-file-upload')[0].files[0]);
        }
        if ($('#TETK__widget-file-upload').length) {
            data.append('widget_file', $('#TETK__widget-file-upload')[0].files[0]);
        }
        if ($('#TETK__customizer-file-upload').length) {
            data.append('customizer_file', $('#TETK__customizer-file-upload')[0].files[0]);
        }

        // AJAX call to import everything (content, widgets, before/after setup)
        ajaxCall( data );

    });

    function ajaxCall(data) {
        $.ajax({
            method: 'POST',
            url: tetk.ajax_url,
            data: data,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.js-tetk-ajax-loader').show();
            }
        })
            .done(function (response) {

                if ('undefined' !== typeof response.status && 'newAJAX' === response.status) {
                    ajaxCall(data);
                }
                else if ('undefined' !== typeof response.message) {
                    $('.js-tetk-ajax-response').append('<p>' + response.message + '</p>');
                    $('.js-tetk-ajax-loader').hide();
                }
                else {
                    $('.js-tetk-ajax-response').append('<div class="notice  notice-error  is-dismissible"><p>' + response + '</p></div>');
                    $('.js-tetk-ajax-loader').hide();
                }
            })
            .fail(function (error) {
                $('.js-tetk-ajax-response').append('<div class="notice  notice-error  is-dismissible"><p>Error: ' + error.statusText + ' (' + error.status + ')' + '</p></div>');
                $('.js-tetk-ajax-loader').hide();
            });
    }

    // Switch preview images on select change event, but only if the img element .js-tetk-preview-image exists.
    // Also switch the import notice (if it exists).
    $('#TETK__demo-import-files').on('change', function () {
        if ($('.js-tetk-preview-image').length) {

            // Attempt to change the image, else display message for missing image.
            var currentFilePreviewImage = tetk.import_files[this.value]['import_preview_image_url'] || '';
            $('.js-tetk-preview-image').prop('src', currentFilePreviewImage);
            $('.js-tetk-preview-image-message').html('');

            if ('' === currentFilePreviewImage) {
                $('.js-tetk-preview-image-message').html(tetk.texts.missing_preview_image);
            }
        }

        // Update import notice.
        var currentImportNotice = tetk.import_files[this.value]['import_notice'] || '';
        $('.js-tetk-demo-import-notice').html(currentImportNotice);
    });

});
