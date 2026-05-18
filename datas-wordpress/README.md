# WooCommerce API Sender

**Plugin Name**: DATAS WORDPRESS 
**Description**: Sends order data to an external API after a WooCommerce product is purchased.  
**Version**: 1.0.0  
**Author**: Kasper Kristiansen  
**License**: GPL2  

## Description

WooCommerce API Sender is a plugin that sends order data to an external API after a WooCommerce product is purchased. This plugin helps integrate WooCommerce with external services to automate processes like order notifications, inventory management, or external reporting systems.

Once a customer completes their order, this plugin will send the order's details (e.g., customer name, email, purchased products, quantities, and total price) to a specified external API.

## Features

- Sends order data to an external API when an order is completed.
- Provides a simple settings page to input the external API URL.
- Error logging in case of failed API requests.
- Easily integrates with WooCommerce.

## Installation

1. Download and install the plugin either through the WordPress plugin repository or by uploading the plugin files to your WordPress site.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the 'API Sender' settings page under the WordPress admin dashboard.
4. Enter the external API URL where you want to send order data.

## Usage

- After installation and activation, navigate to the **API Sender** settings page.
- Enter the external API URL in the provided text field.
- The plugin will automatically send order data to the specified API when a WooCommerce order is completed.

### Data Sent:
- **order_id**: The ID of the order.
- **customer_name**: The full name of the customer.
- **customer_email**: The customer's email address.
- **products**: A list of products in the order, including product name, quantity, and total price.

## Support

If you encounter any issues or have any questions, feel free to open an issue on the plugin's support page or contact the author via email.

## Changelog

### 1.0.0
- Initial release.
- Sends order data to an external API after a WooCommerce product is purchased.

## License

This plugin is licensed under the [GPL2](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html) license.

---

**Author**: Kasper Kristiansen  
**Email**: info@datas.dk
