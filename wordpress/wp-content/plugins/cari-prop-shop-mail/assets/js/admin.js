(function($) {
    'use strict';

    $(document).ready(function() {
        initSubscriberManagement();
        initCampaignManagement();
    });

    function initSubscriberManagement() {
        $('.delete-subscriber').on('click', function(e) {
            e.preventDefault();
            
            if (!confirm(cpsMailAdminData.strings.confirm_delete || 'Are you sure you want to delete this subscriber?')) {
                return;
            }
            
            var button = $(this);
            var id = button.data('id');
            var row = button.closest('tr');
            
            button.prop('disabled', true);
            
            $.ajax({
                url: cpsMailAdminData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_mail_delete_subscriber',
                    nonce: cpsMailAdminData.nonce,
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        row.fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        alert(response.data.message);
                        button.prop('disabled', false);
                    }
                },
                error: function() {
                    alert(cpsMailAdminData.strings.error || 'An error occurred.');
                    button.prop('disabled', false);
                }
            });
        });
    }

    function initCampaignManagement() {
        $('.send-campaign').on('click', function(e) {
            e.preventDefault();
            
            if (!confirm(cpsMailAdminData.strings.confirm_send || 'Are you sure you want to send this campaign?')) {
                return;
            }
            
            var button = $(this);
            var id = button.data('id');
            
            button.prop('disabled', true).text(cpsMailAdminData.strings.sending || 'Sending...');
            
            $.ajax({
                url: cpsMailAdminData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_mail_send_campaign',
                    nonce: cpsMailAdminData.nonce,
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.data.message);
                        window.location.reload();
                    } else {
                        alert(response.data.message);
                        button.prop('disabled', false).text(cpsMailAdminData.strings.send || 'Send');
                    }
                },
                error: function() {
                    alert(cpsMailAdminData.strings.error || 'An error occurred.');
                    button.prop('disabled', false).text(cpsMailAdminData.strings.send || 'Send');
                }
            });
        });
        
        $('.delete-campaign').on('click', function(e) {
            e.preventDefault();
            
            if (!confirm(cpsMailAdminData.strings.confirm_delete || 'Are you sure you want to delete this campaign?')) {
                return;
            }
            
            var button = $(this);
            var id = button.data('id');
            var row = button.closest('tr');
            
            button.prop('disabled', true);
            
            $.ajax({
                url: cpsMailAdminData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_mail_delete_campaign',
                    nonce: cpsMailAdminData.nonce,
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        row.fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        alert(response.data.message);
                        button.prop('disabled', false);
                    }
                },
                error: function() {
                    alert(cpsMailAdminData.strings.error || 'An error occurred.');
                    button.prop('disabled', false);
                }
            });
        });
    }

})(jQuery);