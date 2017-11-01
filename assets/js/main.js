jQuery(function ($) {
    'use strict';

    $('.js-tetk-import-data').on('click', function () {

        var attr = $(this).attr('disabled');

        if (typeof attr !== typeof undefined && attr !== false) {

            return;
        }
        // Reset response div content.
        $('.js-tetk-ajax-response').empty();

        // Prepare data for the AJAX call
        var data = new FormData();
        data.append('action', 'TETK_import_demo_data');
        data.append('security', tetk.ajax_nonce);
        data.append('selected', $(this).attr('data-index'));//$('#TETK__demo-import-files').val());
        if ($('#TETK__content-file-upload').length) {
            data.append('content_file', $('#TETK__content-file-upload')[0].files[0]);
        }
        if ($('#TETK__widget-file-upload').length) {
            data.append('widget_file', $('#TETK__widget-file-upload')[0].files[0]);
        }
        if ($('#TETK__customizer-file-upload').length) {
            data.append('customizer_file', $('#TETK__customizer-file-upload')[0].files[0]);
        }
        $(this).closest('.theme').attr('class', 'theme');
        $(this).closest('.theme').find('.notice').remove();
        // AJAX call to import everything (content, widgets, before/after setup)
        ajaxCall(data, $(this));

    });

    function ajaxCall(data, $this) {
        var $notice_node;
        if ($this.hasClass('no-data-exists')) {

            $('.tetk-no-data').html('');

            $notice_node = $('.tetk-no-data');

        } else {


            $notice_node = $this.closest('.theme');
        }
        $.ajax({
            method: 'POST',
            url: tetk.ajax_url,
            data: data,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.js-tetk-import-data').attr('disabled', 'disabled');
                $this.addClass('updating-message');
                $this.closest('.theme').addClass('focus');
                $this.text('Importing..');
            }
        })
            .done(function (response) {


                if ('undefined' !== typeof response.status && 'newAJAX' === response.status) {
                    ajaxCall(data, $this);
                }
                else if ('undefined' !== typeof response.message) {
                    var success = '<div class="notice update-message notice-success notice-alt"><p>' + response.message + '</p></div>';
                    $this.closest('.theme').addClass('theme-install-success');
                    $notice_node.append(success);
                    $('.js-tetk-ajax-loader').hide();
                    $this.removeClass('updating-message');
                    $this.closest('.theme').removeClass('focus');
                    $('.js-tetk-import-data').removeAttr('disabled');
                }
                else {
                    var error = '<div class="notice update-message notice-error notice-alt"><p>' + response + '</p></div>';
                    $this.closest('.theme').addClass('theme-install-failed');
                    $notice_node.append(error);
                    $('.js-tetk-ajax-loader').hide();
                    $this.removeClass('updating-message');
                    $this.closest('.theme').removeClass('focus');
                    $('.js-tetk-import-data').removeAttr('disabled');
                }
                $this.text('Import Demo');
            })
            .fail(function (error) {
                var error = '<div class="notice update-message notice-error notice-alt"><p>Error: ' + error.statusText + ' (' + error.status + ')' + '</p></div>';
                $this.closest('.theme').addClass('theme-install-failed');
                $notice_node.append(error);
                $('.js-tetk-ajax-loader').hide();
                $this.removeClass('updating-message');
                $this.closest('.theme').removeClass('focus');
                $('.js-tetk-import-data').removeAttr('disabled');
                $this.text('Import Demo');
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
