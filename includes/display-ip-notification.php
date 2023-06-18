<?php
/**
 * Function to display the notification in the admin panel.
 */
function display_ip_notification() {
    // Check if the notification has been dismissed
    if (get_option('real_ip_revealer_notification_dismissed') == 'yes') {
        return;
    }

    try {
        $ip = proxy_real_ip();
        $class = 'notice notice-success is-dismissible real-ip-revealer-notification';
        $message = sprintf( __( 'The current user\'s IP address is: %s', 'real-ip-revealer' ), $ip );

        // Add JavaScript to the footer to handle the dismissal
        add_action('admin_footer', 'add_dismiss_script');

        printf('<div class="%1$s" data-dismissible="disable-done-forever"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
    } catch (Exception $e) {
        // Handle the exception if the IP could not be retrieved
        $class = 'notice notice-error is-dismissible real-ip-revealer-notification';
        $message = __( 'Could not retrieve the current user\'s IP address.', 'real-ip-revealer' );

        // Add JavaScript to the footer to handle the dismissal
        add_action('admin_footer', 'add_dismiss_script');

        printf('<div class="%1$s" data-dismissible="disable-done-forever"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
    }
}
