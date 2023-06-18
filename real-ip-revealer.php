<?php

/**
 * Real IP Revealer
 *
 * Plugin Name: Real IP Revealer
 * Description: WordPress plugin that uncovers and assigns the true client IP address in environments with Cloudflare or reverse proxies.
 * Version:     1.1.2
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

// Include the function files
include 'includes/proxy-real-ip.php';
include 'includes/display-ip-notification.php';
include 'includes/add-dismiss-script.php';

// Hook the 'proxy_real_ip' function to the 'init' action
add_action('init', 'proxy_real_ip');

// Hook the 'display_ip_notification' function to the 'admin_notices' action
add_action('admin_notices', 'display_ip_notification');

// Use AJAX to permanently dismiss the notification
add_action('wp_ajax_real_ip_revealer_dismiss_notification', function() {
    update_option('real_ip_revealer_notification_dismissed', 'yes');
});