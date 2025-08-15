<?php
namespace WCC\CustomCheckout;

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'class-checkout-controller.php';


class Plugin {

    public function init() {
        add_filter('template_include', [$this, 'load_custom_checkout_template']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);

        new CheckoutController();
    }

    public function enqueue_styles() {
        if(is_checkout()):
            wp_enqueue_style(
                'bootstrap-css',
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'
            );
            wp_enqueue_style(
                'checkout-css',
                plugin_dir_url(__DIR__) . 'assets/css/style.css', false, '1.2'
            );
        endif;
    }

    public function enqueue_scripts()
    {
        if(is_checkout()):
            wp_enqueue_script(
                'checkout-js',
                plugin_dir_url(__DIR__) . 'assets/js/custom-checkout.js', array(), '1.1',
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
