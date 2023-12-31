<?php

/**
 * Real IP Revealer
 *
 * Plugin Name: Real IP Revealer
 * Description: WordPress plugin that uncovers and assigns the true client IP address in environments with Cloudflare or reverse proxies.
 * Version:     1.1.4
 * Author:      Michael Barrera
 * Author URI:  https://github.com/michael2rain/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 5.2
 * Requires PHP: 7.4
 */

// Avoid direct calls to this file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Check if WooCommerce is active
if (class_exists('WooCommerce')) {
    // If WooCommerce is active, hook your function to WooCommerce's checkout process
    add_action('woocommerce_checkout_order_processed', 'rir_proxy_real_ip', 10, 1);
} else {
    // If WooCommerce is not active, hook your function to the 'init' action
    add_action('init', 'rir_proxy_real_ip');
}

/**
 * Function to get the real IP from the client when behind a proxy.
 * It checks a list of headers in order and returns the first valid public IP found.
 * @param int $order_id The ID of the order being processed (only when hooked to WooCommerce).
 */
function rir_proxy_real_ip($order_id = null) {
    $ip_addr = null;

    // Define the order of the headers to be checked
    $headers = ['HTTP_CF_CONNECTING_IP', 'X_REAL_IP', 'HTTP_X_REAL_IP', 'X_FORWARDED_FOR', 'HTTP_X_FORWARDED_FOR'];

    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ips = explode(',', $_SERVER[$header]);
            foreach ($ips as $ip) {
                $ip = trim($ip); // Remove any whitespace
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    $ip_addr = $ip;
                    break 2; // Break the entire loop as soon as we get a valid public IP
                }
            }
        }
    }

    if ($ip_addr !== null) {
        $_SERVER['REMOTE_ADDR'] = $ip_addr;
    } else {
        error_log('Proxy Real IP: No valid IP found in headers');
        $_SERVER['REMOTE_ADDR'] = $_SERVER['SERVER_ADDR']; // Fallback to server IP
    }

    // If this function is hooked to WooCommerce and we have an order ID, update the order meta with the real IP
    if ($order_id && $ip_addr) {
        update_post_meta($order_id, '_customer_ip_address', $ip_addr);
    }

    return $_SERVER['REMOTE_ADDR']; // Return the client IP as seen by the server
}

/**
 * Function to display the notification in the admin panel.
 */
function rir_display_ip_notification() {
    // Check if the notification has been dismissed
    if (get_option('real_ip_revealer_notification_dismissed') == 'yes') {
        return;
    }

    $ip = rir_proxy_real_ip();
    if ($ip !== $_SERVER['SERVER_ADDR']) { // If we have a valid client IP
        $class = 'notice notice-success is-dismissible real-ip-revealer-notification';
        $message = sprintf(__('The current user\'s IP address is: %s', 'real-ip-revealer'), $ip);
    } else { // If we fell back to the server IP
        $class = 'notice notice-error is-dismissible real-ip-revealer-notification';
        $message = __('Could not retrieve the current user\'s IP address.', 'real-ip-revealer');
    }

    // Add JavaScript to the footer to handle the dismissal
    add_action('admin_footer', 'rir_add_dismiss_script');

    printf('<div class="%1$s" data-dismissible="disable-done-forever"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
}

// Use AJAX to permanently dismiss the notification
add_action('wp_ajax_real_ip_revealer_dismiss_notification', function() {
    update_option('real_ip_revealer_notification_dismissed', 'yes');
});

function rir_add_dismiss_script() {
    echo '
    <script>
    jQuery(document).on("click", ".real-ip-revealer-notification .notice-dismiss", function() {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: "real_ip_revealer_dismiss_notification"
            }
        });
    });
    </script>
    ';
}