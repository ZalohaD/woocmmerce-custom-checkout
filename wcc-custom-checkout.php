<?php
/**
 * Plugin Name: WCC Custom Checkout
 * Description: Plugin that replace default Woocommerce checkout with custom one
 * Version: 1.0
 * Author: Zaloha Denys
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'includes/class-plugin.php';

add_action('plugins_loaded', function() {
    if (class_exists('WooCommerce')) :
        $plugin = new \WCC\CustomCheckout\Plugin();
        $plugin->init();
    endif;
});
