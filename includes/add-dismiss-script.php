<?php
function add_dismiss_script() {
    echo "
    <script>
    jQuery(document).on('click', '.real-ip-revealer-notification .notice-dismiss', function() {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: 'real_ip_revealer_dismiss_notification'
            }
        });
    });
    </script>
    ";
}
