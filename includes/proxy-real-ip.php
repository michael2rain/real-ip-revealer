<?php
/**
 * Function to get the real IP from the client when behind a proxy.
 * It checks a list of headers in order and returns the first valid public IP found.
 */
function proxy_real_ip() {
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
        // Throw an exception if no valid IP is found
        throw new Exception('Proxy Real IP: No valid IP found in headers');
        $_SERVER['REMOTE_ADDR'] = $_SERVER['SERVER_ADDR']; // Fallback to server IP
    }

    return $_SERVER['REMOTE_ADDR']; // Return the client IP as seen by the server
}