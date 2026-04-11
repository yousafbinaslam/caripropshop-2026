jQuery(document).ready(function($) {
    var leadModal = $('#leadModal');
    var leadForm = $('#leadForm');

    $('#addNewLead').on('click', function() {
        $('#modalTitle').text('Add New Lead');
        $('#leadForm')[0].reset();
        $('#leadId').val('');
        leadModal.show();
    });

    $('.cps-modal-close').on('click', function() {
        leadModal.hide();
    });

    $(window).on('click', function(e) {
        if (e.target === leadModal[0]) {
            leadModal.hide();
        }
    });

    leadForm.on('submit', function(e) {
        e.preventDefault();
        
        var formData = {
            action: 'cps_save_lead',
            nonce: cpsCrmData.nonce,
            lead_id: $('#leadId').val(),
            name: $('#leadName').val(),
            email: $('#leadEmail').val(),
            phone: $('#leadPhone').val(),
            status: $('#leadStatus').val(),
            property_id: 0,
            inquiry_type: $('#leadInquiryType').val(),
            message: $('#leadMessage').val(),
            source: 'manual'
        };

        $.post(cpsCrmData.ajaxUrl, formData, function(response) {
            if (response.success) {
                alert('Lead saved successfully!');
                location.reload();
            } else {
                alert('Error saving lead');
            }
        });
    });

    $(document).on('click', '.edit-lead-btn', function() {
        var leadId = $(this).data('lead-id');
        
        $.post(cpsCrmData.ajaxUrl, {
            action: 'cps_get_lead_details',
            nonce: cpsCrmData.nonce,
            lead_id: leadId
        }, function(response) {
            if (response.success) {
                var lead = response.data;
                $('#modalTitle').text('Edit Lead');
                $('#leadId').val(lead.id);
                $('#leadName').val(lead.name);
                $('#leadEmail').val(lead.email);
                $('#leadPhone').val(lead.phone);
                $('#leadStatus').val(lead.status);
                $('#leadInquiryType').val(lead.inquiry_type);
                $('#leadMessage').val(lead.message);
                leadModal.show();
            }
        });
    });

    $(document).on('change', '.status-select', function() {
        var leadId = $(this).data('lead-id');
        var status = $(this).val();
        
        $.post(cpsCrmData.ajaxUrl, {
            action: 'cps_update_lead_status',
            nonce: cpsCrmData.nonce,
            lead_id: leadId,
            status: status
        }, function(response) {
            if (response.success) {
                $(this).closest('tr').find('.status-badge')
                    .removeClass('status-new status-contacted status-qualified status-proposal status-negotiation status-converted status-lost')
                    .addClass('status-' + status)
                    .text(status.charAt(0).toUpperCase() + status.slice(1));
            }
        }.bind(this));
    });

    $(document).on('click', '.delete-lead', function() {
        if (!confirm('Are you sure you want to delete this lead?')) return;
        
        var leadId = $(this).data('lead-id');
        var $row = $(this).closest('tr');
        
        $.post(cpsCrmData.ajaxUrl, {
            action: 'cps_delete_lead',
            nonce: cpsCrmData.nonce,
            lead_id: leadId
        }, function(response) {
            if (response.success) {
                $row.fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });
    });

    $('#filterStatus').on('change', function() {
        var status = $(this).val();
        
        if (status === '') {
            $('#leadsTable tbody tr').show();
        } else {
            $('#leadsTable tbody tr').hide();
            $('#leadsTable tbody tr[data-status="' + status + '"]').show();
        }
    });

    $('#searchLeads').on('keyup', function() {
        var search = $(this).val().toLowerCase();
        
        $('#leadsTable tbody tr').each(function() {
            var text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(search) > -1);
        });
    });

    $('#exportLeads').on('click', function() {
        window.location.href = cpsCrmData.ajaxUrl + '?action=cps_export_leads&nonce=' + cpsCrmData.nonce;
    });

    $('#selectAll').on('change', function() {
        var checked = $(this).prop('checked');
        $('.lead-checkbox').prop('checked', checked);
    });

    $('#quickStatusChange').on('change', function() {
        $('#applyStatusChange').data('status', $(this).val());
    });

    $('#applyStatusChange').on('click', function() {
        var leadId = window.location.search.match(/id=(\d+)/);
        var status = $('#quickStatusChange').val();
        
        if (leadId && leadId[1]) {
            $.post(cpsCrmData.ajaxUrl, {
                action: 'cps_update_lead_status',
                nonce: cpsCrmData.nonce,
                lead_id: leadId[1],
                status: status
            }, function(response) {
                if (response.success) {
                    location.reload();
                }
            });
        }
    });

    $('#addNoteForm').on('submit', function(e) {
        e.preventDefault();
        
        var leadId = window.location.search.match(/id=(\d+)/);
        var noteContent = $('#newNoteContent').val();
        
        if (!leadId || !leadId[1] || !noteContent) return;
        
        $.post(cpsCrmData.ajaxUrl, {
            action: 'cps_add_lead_note',
            nonce: cpsCrmData.nonce,
            lead_id: leadId[1],
            note: noteContent
        }, function(response) {
            if (response.success) {
                var noteHtml = '<div class="note-item">' +
                    '<div class="note-content">' + noteContent + '</div>' +
                    '<div class="note-meta"><span class="note-date">Just now</span></div>' +
                    '</div>';
                $('#notesList').prepend(noteHtml);
                $('#newNoteContent').val('');
            }
        });
    });

    $(document).on('click', '.update-status', function() {
        var leadId = window.location.search.match(/id=(\d+)/);
        var status = $(this).data('status');
        
        if (leadId && leadId[1]) {
            $.post(cpsCrmData.ajaxUrl, {
                action: 'cps_update_lead_status',
                nonce: cpsCrmData.nonce,
                lead_id: leadId[1],
                status: status
            }, function(response) {
                if (response.success) {
                    location.reload();
                }
            });
        }
    });
});
