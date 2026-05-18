<?php
/**
 * Plugin Name: DATAS WORDPRESS
 * Description: Sends order data to an external API when an order is created, updated, or deleted.
 * Version: 1.3.1
 * Author: Kasper Kristiansen
 * Author URI: https://www.datas.dk
 * Text Domain: datas-wordpress
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register menu
add_action('admin_menu', function () {
    add_menu_page(
        __('Datas', 'datas-wordpress'),
        __('Datas', 'datas-wordpress'),
        'manage_options',
        'datas-woocommerce',
        'datas_woocommerce_main_page',
        plugin_dir_url(__FILE__) . 'assets/icon.png',
        56
    );

    add_submenu_page(
        'datas-woocommerce',
        __('WooCommerce', 'datas-wordpress'),
        __('WooCommerce', 'datas-wordpress'),
        'manage_options',
        'api-sender-settings',
        'api_sender_settings_page'
    );
});

// Callback for main menu page
function datas_woocommerce_main_page()
{
    include plugin_dir_path(__FILE__) . 'templates/main-page.php';
}

// Callback for sub-menu page
function api_sender_settings_page()
{
    include plugin_dir_path(__FILE__) . 'templates/api-settings.php';
}

// Function to send order data to the API
function send_order_data_to_api($order_id, $action)
{
    $host = $_SERVER["HTTP_HOST"];

    $api_urls = [
        'created' => get_option('api_sender_create_url', "https://" . $host . "/api/wordpress/woocommerce/create-order"),
        'updated' => get_option('api_sender_update_url', "https://" . $host . "/api/wordpress/woocommerce/update-order"),
        'deleted' => get_option('api_sender_delete_url', "https://" . $host . "/api/wordpress/woocommerce/delete-order"),
    ];

    $methods = [
        'created' => 'POST',
        'updated' => 'PATCH',
        'deleted' => 'DELETE',
    ];

    $api_url = $api_urls[$action] ?? '';
    $method = $methods[$action] ?? 'POST';

    if (empty($api_url)) {
        return;
    }

    $order = wc_get_order($order_id);
    if (!$order) {
        return;
    }

    $data = [
        'order_id' => $order->get_id(),
        'action' => $action,
        'customer' => [
            'billing' => [
                'first_name' => $order->get_billing_first_name(),
                'last_name'  => $order->get_billing_last_name(),
                'email'      => $order->get_billing_email(),
                'phone'      => $order->get_billing_phone(),
            ],
        ],
        'products' => [],
    ];

    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        $data['products'][] = [
            'id'   => $product ? $product->get_id() : null,
            'name' => $item->get_name(),
            'sku'  => $product ? $product->get_sku() : null,
        ];
    }

    wp_remote_request($api_url, [
        'method'    => $method,
        'body'      => wp_json_encode($data),
        'headers'   => ['Content-Type' => 'application/json'],
    ]);
}

// Hooks for WooCommerce order events
add_action('woocommerce_new_order', function ($order_id) {
    send_order_data_to_api($order_id, 'created');
});
add_action('woocommerce_update_order', function ($order_id) {
    send_order_data_to_api($order_id, 'updated');
});
add_action('woocommerce_delete_order', function ($order_id) {
    send_order_data_to_api($order_id, 'deleted');
});

// Ensure nonce field is only available after WordPress has fully loaded
add_action('admin_init', function () {
    if (!isset($_GET['page']) || $_GET['page'] !== 'api-sender-settings') {
        return;
    }
    wp_nonce_field('datas_save_webhook', 'datas_nonce');
});
