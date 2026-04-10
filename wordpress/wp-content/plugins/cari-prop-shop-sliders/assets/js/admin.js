/**
 * CariPropShop Sliders - Admin JavaScript
 */

(function($) {
    'use strict';

    var CPS_Admin = {
        init: function() {
            this.bindEvents();
            this.initSortable();
            this.initColorPickers();
        },

        bindEvents: function() {
            $('#cps_add_slide').on('click', this.addSlide);
            $('#cps-add-new-slide').on('click', this.openModal);
            $('#cps-cancel-slide').on('click', this.closeModal);
            $('.cps-modal-backdrop').on('click', this.closeModal);
            $('.cps-modal-close').on('click', this.closeModal);
            $('#cps-save-slide').on('click', this.saveSlide);
            $('.cps-edit-slide').on('click', this.editSlide);
            $('.cps-delete-slide').on('click', this.deleteSlide);

            $('#cps_slide_bg_type').on('change', this.toggleBgFields);

            $('#cps_upload_bg_image').on('click', this.openMediaManager);

            $('.cps-upload-image').on('click', this.uploadImage);
            $('.cps-remove-image').on('click', this.removeImage);
            $('.cps-bg-type-select').on('change', this.toggleBgTypeFields);
        },

        toggleBgFields: function() {
            var bgType = $(this).val();
            $('.cps-bg-image-row, .cps-bg-color-row, .cps-video-row').removeClass('cps-visible');

            if (bgType === 'image') {
                $('.cps-bg-image-row').addClass('cps-visible');
            } else if (bgType === 'color') {
                $('.cps-bg-color-row').addClass('cps-visible');
            } else if (bgType === 'video') {
                $('.cps-video-row').addClass('cps-visible');
            }
        },

        toggleBgTypeFields: function() {
            var $select = $(this);
            var $card = $select.closest('.cps-slide-card');
            var bgType = $select.val();

            $card.find('.cps-bg-image-field, .cps-bg-color-field, .cps-video-field').removeClass('cps-visible');

            if (bgType === 'image') {
                $card.find('.cps-bg-image-field').addClass('cps-visible');
            } else if (bgType === 'color') {
                $card.find('.cps-bg-color-field').addClass('cps-visible');
            } else if (bgType === 'video') {
                $card.find('.cps-video-field').addClass('cps-visible');
            }
        },

        addSlide: function() {
            var modal = $('#cps-slide-modal');
            modal.find('#cps-edit-slide-id').val('');
            modal.find('input, select').not('[type="hidden"]').val('');
            modal.find('#cps_slide_bg_type').val('image');
            modal.find('#cps-bg-image-preview').html('');
            $('#cps-slide-modal').show();
        },

        openModal: function() {
            var modal = $('#cps-slide-modal');
            modal.find('#cps-edit-slide-id').val('');
            modal.find('input[type="text"], input[type="url"], textarea').val('');
            modal.find('select').val('image');
            modal.find('#cps_slide_bg_color').val('#000000');
            modal.find('#cps_slide_overlay').val('50');
            modal.find('#cps_slide_alignment').val('center');
            modal.find('#cps-bg-image-preview').html('');
            modal.show();
        },

        closeModal: function() {
            $('#cps-slide-modal').hide();
        },

        saveSlide: function() {
            var slideData = {
                title: $('#cps_slide_title').val(),
                bg_type: $('#cps_slide_bg_type').val(),
                background_image: $('#cps_slide_bg_image').val(),
                background_color: $('#cps_slide_bg_color').val(),
                video_url: $('#cps_slide_video').val(),
                overlay_opacity: $('#cps_slide_overlay').val(),
                subtitle: $('#cps_slide_subtitle').val(),
                cta_text: $('#cps_slide_cta_text').val(),
                cta_link: $('#cps_slide_cta_link').val(),
                alignment: $('#cps_slide_alignment').val()
            };

            var sliderId = $('#post_ID').val();
            var slideId = $('#cps-edit-slide-id').val();

            if (slideId) {
                this.updateSlide(slideId, slideData);
            } else {
                this.createSlide(sliderId, slideData);
            }
        },

        createSlide: function(sliderId, slideData) {
            $.ajax({
                url: cpsAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_save_slide',
                    nonce: cpsAdmin.nonce,
                    slider_id: sliderId,
                    slide: slideData
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data.message || 'Error saving slide');
                    }
                },
                error: function() {
                    alert('Error saving slide');
                }
            });
        },

        updateSlide: function(slideId, slideData) {
            var formData = new FormData();
            formData.append('action', 'cps_update_slide');
            formData.append('nonce', cpsAdmin.nonce);
            formData.append('slide_id', slideId);
            $.each(slideData, function(key, value) {
                formData.append('slide[' + key + ']', value);
            });

            $.ajax({
                url: cpsAdmin.ajaxUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data.message || 'Error updating slide');
                    }
                },
                error: function() {
                    alert('Error updating slide');
                }
            });
        },

        editSlide: function() {
            var slideId = $(this).data('slide-id');
            var modal = $('#cps-slide-modal');

            $.ajax({
                url: cpsAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_get_slides',
                    nonce: cpsAdmin.nonce,
                    slider_id: $('#post_ID').val()
                },
                success: function(response) {
                    if (response.success) {
                        var slides = response.data;
                        var slide = slides.find(function(s) {
                            return s.id == slideId;
                        });

                        if (slide) {
                            modal.find('#cps-edit-slide-id').val(slide.id);
                            modal.find('#cps_slide_title').val(slide.title || '');
                            modal.find('#cps_slide_bg_type').val(slide.settings.bg_type || 'image');
                            modal.find('#cps_slide_bg_image').val(slide.settings.background_image || '');
                            modal.find('#cps_slide_bg_color').val(slide.settings.background_color || '#000000');
                            modal.find('#cps_slide_video').val(slide.settings.video_url || '');
                            modal.find('#cps_slide_overlay').val(slide.settings.overlay_opacity || '50');
                            modal.find('#cps_slide_subtitle').val(slide.settings.subtitle || '');
                            modal.find('#cps_slide_cta_text').val(slide.settings.cta_text || '');
                            modal.find('#cps_slide_cta_link').val(slide.settings.cta_link || '');
                            modal.find('#cps_slide_alignment').val(slide.settings.alignment || 'center');

                            if (slide.settings.background_image) {
                                var imageSrc = slide.settings.background_image;
                                if (typeof imageSrc === 'number') {
                                    imageSrc = wp.media().state().get('selection')._byCid[imageSrc] ?
                                        wp.media().state().get('selection')._byCid[imageSrc].attributes.url : '';
                                }
                                modal.find('#cps-bg-image-preview').html('<img src="' + imageSrc + '" alt="" />');
                            }

                            modal.show();
                        }
                    }
                }
            });
        },

        deleteSlide: function() {
            if (!confirm('Are you sure you want to delete this slide?')) {
                return;
            }

            var slideId = $(this).data('slide-id');

            $.ajax({
                url: cpsAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_delete_slide',
                    nonce: cpsAdmin.nonce,
                    slide_id: slideId
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data.message || 'Error deleting slide');
                    }
                },
                error: function() {
                    alert('Error deleting slide');
                }
            });
        },

        initSortable: function() {
            if ($('#cps-sortable-slides').length) {
                $('#cps-sortable-slides').sortable({
                    handle: '.cps-slide-item-handle',
                    update: this.reorderSlides
                });
            }
        },

        reorderSlides: function(event, ui) {
            var slideOrder = [];
            $('#cps-sortable-slides .cps-slide-item').each(function() {
                slideOrder.push($(this).data('slide-id'));
            });

            $.ajax({
                url: cpsAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_reorder_slides',
                    nonce: cpsAdmin.nonce,
                    slider_id: $('#post_ID').val(),
                    slide_order: slideOrder
                }
            });
        },

        initColorPickers: function() {
            $('.cps-color-picker').wpColorPicker();
        },

        uploadImage: function() {
            var $button = $(this);
            var $field = $button.closest('p');
            var $idField = $field.find('.cps-image-id');

            var frame = wp.media({
                title: 'Select Image',
                multiple: false,
                library: {
                    type: 'image'
                }
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $idField.val(attachment.id);

                var previewHtml = '<img src="' + attachment.sizes.thumbnail.url + '" alt="" />';
                $field.find('.cps-image-preview').html(previewHtml);
                $button.siblings('.cps-remove-image').removeClass('hidden');
            });

            frame.open();
        },

        removeImage: function() {
            var $button = $(this);
            var $field = $button.closest('p');
            var $idField = $field.find('.cps-image-id');

            $idField.val('');
            $field.find('.cps-image-preview').html('');
            $button.addClass('hidden');
        },

        openMediaManager: function() {
            var frame = wp.media({
                title: 'Select Image',
                multiple: false,
                library: {
                    type: 'image'
                }
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#cps_slide_bg_image').val(attachment.id);
                $('#cps-bg-image-preview').html('<img src="' + attachment.sizes.thumbnail.url + '" alt="" />');
            });

            frame.open();
        }
    };

    $(document).ready(function() {
        CPS_Admin.init();
    });

})(jQuery);