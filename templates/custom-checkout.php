<?php
defined('ABSPATH') || exit;
get_header();
$gateways = WC()->payment_gateways()->get_available_payment_gateways();
?>

<div class="custom-checkout-page">
    <div class="container">
        <div class="checkout-wrapper">
            <h1 class="checkout-title">Checkout</h1>

            <form method="post" id="custom-checkout-form" class="checkout-form">
                <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>

                <div class="checkout-content">
                    <div class="billing-section">
                        <div class="section-card">
                            <h2 class="section-title">Billing Details</h2>

                            <div class="form-group">
                                <label for="billing_name">Name <span class="required">*</span></label>
                                <input type="text" id="billing_name" name="billing_first_name" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label for="billing_address">Address <span class="required">*</span></label>
                                <input type="text" id="billing_address" name="billing_address_1" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label for="billing_email">Email <span class="required">*</span></label>
                                <input type="email" id="billing_email" name="billing_email" class="form-input" required>
                            </div>
                        </div>

                        <div class="payment-methods">
                            <?php if (!empty($gateways)): ?>
                                <?php $first_gateway = true; ?>
                                <?php foreach ($gateways as $gateway_id => $gateway): ?>
                                    <div class="payment-method" data-payment-method="<?php echo esc_attr($gateway->id); ?>">
                                        <input type="radio" id="payment_<?php echo esc_attr($gateway->id); ?>"
                                               name="payment_method" value="<?php echo esc_attr($gateway->id); ?>"
                                            <?php echo $first_gateway ? 'checked' : ''; ?> required>
                                        <label for="payment_<?php echo esc_attr($gateway->id); ?>">
                                            <?php echo esc_html($gateway->get_title()); ?>
                                        </label>
                                        <?php if ($gateway->get_description()): ?>
                                            <div class="payment-description">
                                                <?php echo wp_kses_post($gateway->get_description()); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php $first_gateway = false; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="no-payment-methods">No payment methods available.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="order-section">
                        <div class="section-card">
                            <h2 class="section-title">Your Order</h2>

                            <?php if (!WC()->cart->is_empty()): ?>
                                <div class="order-items">
                                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $item):
                                        $product = $item['data'];
                                        $product_name = $product->get_name();
                                        $product_price = $product->get_price();
                                        $product_link = $product->get_permalink();
                                        $product_image = $product->get_image('thumbnail');
                                        $quantity = $item['quantity'];
                                        $line_total = $product_price * $quantity;
                                        ?>
                                        <div class="order-item">
                                            <a href="<?php echo esc_url($product_link); ?>" class="item-link">
                                                <div class="item-details">
                                                    <div class="item-image">
                                                        <?php if ($product_image): ?>
                                                            <?php echo $product_image; ?>
                                                        <?php else: ?>
                                                            <div class="no-image">
                                                                <span>No Image</span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="item-info">
                                                        <span class="item-name"><?php echo esc_html($product_name); ?></span>
                                                        <span class="item-quantity">× <?php echo $quantity; ?></span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="item-price">
                                                <?php echo wc_price($line_total); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="order-totals">
                                    <div class="total-row subtotal">
                                        <span class="total-label">Subtotal:</span>
                                        <span class="total-value"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                                    </div>

                                    <?php if (WC()->cart->get_shipping_total() > 0): ?>
                                        <div class="total-row">
                                            <span class="total-label">Shipping:</span>
                                            <span class="total-value"><?php echo wc_price(WC()->cart->get_shipping_total()); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (WC()->cart->get_total_tax() > 0): ?>
                                        <div class="total-row">
                                            <span class="total-label">Tax:</span>
                                            <span class="total-value"><?php echo wc_price(WC()->cart->get_total_tax()); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="total-row total">
                                        <span class="total-label">Total:</span>
                                        <span class="total-value"><?php echo WC()->cart->get_total(); ?></span>
                                    </div>
                                </div>

                                <button type="submit" name="place_order" class="place-order-btn">
                                    Place Order
                                </button>
                            <?php else: ?>
                                <div class="empty-cart">
                                    <p>Your cart is empty.</p>
                                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="continue-shopping">
                                        Continue Shopping
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>