<?php
namespace WCC\CustomCheckout;

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-checkout-controller.php';

class Plugin {

    public function init() {
        add_filter('template_include', [$this, 'load_custom_checkout_template'], 99);

        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        new CheckoutController();
    }

    public function enqueue_styles() {
        if (function_exists('is_checkout') && is_checkout()):
            wp_enqueue_style(
                'bootstrap-css',
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'
            );
            wp_enqueue_style(
                'checkout-css',
                plugin_dir_url(__FILE__) . '../assets/css/style.css',
                [],
                '1.2'
            );
        endif;
    }

    public function enqueue_scripts() {
        if (function_exists('is_checkout') && is_checkout()):
            wp_enqueue_script(
                'checkout-js',
                plugin_dir_url(__FILE__) . '../assets/js/custom-checkout.js',
                ['jquery'],
                '1.1',
                true
            );
        endif;
    }

    public function load_custom_checkout_template($template) {
        if (is_checkout() && !is_order_received_page()):
            return plugin_dir_path(__FILE__) . '../templates/custom-checkout.php';
        endif;
        return $template;
    }

}
