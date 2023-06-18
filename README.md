# Real IP Revealer

Real IP Revealer is a WordPress plugin that uncovers and assigns the true client IP address in environments with Cloudflare or reverse proxies. Enhance the accuracy of your logs and analytics by ensuring user IP addresses are correctly recorded, regardless of the network infrastructure you're using.

## Features

- Extracts the real IP address from various HTTP headers.
- Supports environments using Cloudflare and reverse proxies.
- Enhances the accuracy of your website logs and analytics.

## Installation

1. Upload the 'real-ip-revealer' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

Once activated, the plugin will automatically extract the real IP address from the HTTP headers for each request to your website. The IP address will be stored in the `$_SERVER['REMOTE_ADDR']` variable.

## Support

If you have any issues or questions, please open an issue on our GitHub page.

## Contributing

Contributions are welcome! Please open a pull request on our GitHub page.

## License

This project is licensed under the GPL-2.0 License - see the LICENSE file for details.
