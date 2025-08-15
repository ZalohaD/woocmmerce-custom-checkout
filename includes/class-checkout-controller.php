<?php
namespace WCC\CustomCheckout;

if (!defined('ABSPATH')) exit;

class CheckoutController {

    public function __construct() {
        add_action('template_redirect', [$this, 'handle_checkout_submit']);
    }

    public function handle_checkout_submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])):

            if ( ! isset($_POST['woocommerce-process-checkout-nonce']) ||
                ! wp_verify_nonce($_POST['woocommerce-process-checkout-nonce'], 'woocommerce-process_checkout') ) {
                wc_add_notice(__('Security check failed. Please try again.'), 'error');
                return;
            }

            $name = sanitize_text_field($_POST['billing_first_name'] ?? '');
            $address = sanitize_text_field($_POST['billing_address_1'] ?? '');
            $email = sanitize_email($_POST['billing_email'] ?? '');
            $payment_method = sanitize_key($_POST['payment_method'] ?? '');

            if (!$name || !$address || !is_email($email)):
                wc_add_notice(__('Please fill all required fields correctly.'), 'error');
                return;
            endif;

            $order = wc_create_order();

            foreach (WC()->cart->get_cart() as $item):
                $product = wc_get_product($item['product_id']);
                if ($product) $order->add_product($product, $item['quantity']);
            endforeach;

            $order->set_billing_first_name($name);
            $order->set_billing_address_1($address);
            $order->set_billing_email($email);

            $gateways = WC()->payment_gateways()->get_available_payment_gateways();
            if (!isset($gateways[$payment_method])) $payment_method = key($gateways);

            $order->set_payment_method($payment_method);
            $order->calculate_totals();
            $order->save();
            WC()->cart->empty_cart();

            wp_safe_redirect($order->get_checkout_order_received_url());
            exit;
        endif;
    }
}
