(function($) {
    'use strict';

    $(document).ready(function() {
        $('.cps-forms-admin .nav-tab').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            
            $('.cps-forms-admin .nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            
            $('.cps-settings-panel').hide();
            $(target).show();
        });

        if (window.location.hash) {
            var target = window.location.hash;
            $('.cps-forms-admin .nav-tab').removeClass('nav-tab-active');
            $('.cps-forms-admin .nav-tab[href="' + target + '"]').addClass('nav-tab-active');
            $('.cps-settings-panel').hide();
            $(target).show();
        }

        $('#cps-form-submissions').on('click', '.delete-submission', function(e) {
            if (!confirm('Are you sure you want to delete this submission?')) {
                e.preventDefault();
            }
        });
    });

})(jQuery);