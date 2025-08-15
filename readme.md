# WCC Custom Checkout

**Version:** 1.0  
**Author:** Zaloha Denys  
**Description:** WooCommerce checkout plugin.

---

## Overview

This plugin replaces the default WooCommerce Checkout page with a fully custom version.

### Features

- Supports all active WooCommerce payment gateways.
- Displays the list of products in the cart and the total amount.
- Includes fields: **Name, Address, Email** (Email validation included; other fields are required but without extra validation).
- Checkout logic is handled by a separate controller (`CheckoutController`) to keep the template clean.
- Supports both simple and variable products.

---

## Installation

1. Upload the plugin folder to `/wp-content/plugins/wcc-custom-checkout/`.
2. Activate the plugin through the **Plugins** menu in WordPress admin.
3. The WooCommerce checkout page will automatically be replaced with the custom template.

---

## Usage

- All active payment methods are available for selection.
- Fill out the checkout form and click **Place Order**.
- The order will be created in WooCommerce, and the user will be redirected to the order confirmation page.

---

## Notes

- The code follows WordPress coding standards and best practices.
- All custom logic is handled in PHP; no AJAX is used.
- Mobile-specific styling is minimal, but the layout is responsive due to Bootstrap.

---

## Changelog

**1.0**
- Initial release with custom checkout page and separated controller logic.
