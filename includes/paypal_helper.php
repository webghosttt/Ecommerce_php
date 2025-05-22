<?php
/**
 * Helper functions for PayPal integration
 */

/**
 * Create properly formatted PayPal payment form
 * 
 * @param float $amount Total amount to charge
 * @param string $order_id Unique order identifier
 * @param string $product_name Name of the product/order
 * @param string $custom_field Custom field for order tracking (e.g. user ID)
 * @return string HTML form for PayPal payment
 */
function get_paypal_payment_form($amount, $order_id, $product_name, $custom_field = '') {
    // Convert to USD if necessary (assuming 1 NPR = 0.0075 USD)
    $usd_amount = $amount * 0.0075;
    
    // Round to 2 decimal places
    $usd_amount = round($usd_amount, 2);
    
    // Build form HTML
    $form = '<form action="' . PAYPAL_URL . '" method="post">';
    
    // Required hidden fields
    $form .= '<input type="hidden" name="cmd" value="_xclick">';
    $form .= '<input type="hidden" name="business" value="' . PAYPAL_BUSINESS_EMAIL . '">';
    $form .= '<input type="hidden" name="item_name" value="' . htmlspecialchars($product_name) . '">';
    $form .= '<input type="hidden" name="amount" value="' . $usd_amount . '">';
    $form .= '<input type="hidden" name="currency_code" value="' . PAYPAL_CURRENCY . '">';
    
    // PayPal will send the user to this URL after a successful payment
    $form .= '<input type="hidden" name="return" value="' . PAYPAL_RETURN_URL . '">';
    
    // PayPal will send the user to this URL if they cancel the payment
    $form .= '<input type="hidden" name="cancel_return" value="' . PAYPAL_CANCEL_URL . '">';
    
    // PayPal will send payment notifications to this URL
    $form .= '<input type="hidden" name="notify_url" value="' . PAYPAL_NOTIFY_URL . '">';
    
    // Additional fields to help with order tracking
    $form .= '<input type="hidden" name="invoice" value="' . $order_id . '">';
    
    if (!empty($custom_field)) {
        $form .= '<input type="hidden" name="custom" value="' . $custom_field . '">';
    }
    
    // No shipping required for digital goods
    $form .= '<input type="hidden" name="no_shipping" value="1">';
    
    // Submit button
    $form .= '<button type="submit" class="btn btn-primary">Pay with PayPal</button>';
    $form .= '</form>';
    
    return $form;
}

/**
 * Create a PayPal payment button for multiple items
 * 
 * @param array $items Array of items, each with 'name', 'quantity', 'price'
 * @param string $order_id Unique order identifier
 * @param float $shipping Shipping cost (optional)
 * @param float $tax Tax amount (optional)
 * @param string $custom_field Custom field for tracking (optional)
 * @return string HTML form for PayPal payment
 */
function get_paypal_cart_form($items, $order_id, $shipping = 0, $tax = 0, $custom_field = '') {
    // Build the PayPal form
    $form = '<form action="' . PAYPAL_URL . '" method="post">';
    
    // Required fields
    $form .= '<input type="hidden" name="cmd" value="_cart">';
    $form .= '<input type="hidden" name="upload" value="1">'; // Multiple items
    $form .= '<input type="hidden" name="business" value="' . PAYPAL_BUSINESS_EMAIL . '">';
    $form .= '<input type="hidden" name="invoice" value="' . htmlspecialchars($order_id) . '">';
    $form .= '<input type="hidden" name="currency_code" value="' . PAYPAL_CURRENCY . '">';
    
    // URLs
    $form .= '<input type="hidden" name="return" value="' . PAYPAL_RETURN_URL . '">';
    $form .= '<input type="hidden" name="cancel_return" value="' . PAYPAL_CANCEL_URL . '">';
    
    // Add each item
    $i = 1;
    foreach ($items as $item) {
        $form .= '<input type="hidden" name="item_name_' . $i . '" value="' . htmlspecialchars($item['name']) . '">';
        $form .= '<input type="hidden" name="quantity_' . $i . '" value="' . $item['quantity'] . '">';
        $form .= '<input type="hidden" name="amount_' . $i . '" value="' . $item['price'] . '">';
        $i++;
    }
    
    // Add shipping and tax if provided
    if ($shipping > 0) {
        $form .= '<input type="hidden" name="handling_cart" value="' . $shipping . '">';
    }
    
    if ($tax > 0) {
        $form .= '<input type="hidden" name="tax_cart" value="' . $tax . '">';
    }
    
    // Additional fields
    if (!empty($custom_field)) {
        $form .= '<input type="hidden" name="custom" value="' . htmlspecialchars($custom_field) . '">';
    }
    
    // Optional settings
    $form .= '<input type="hidden" name="no_shipping" value="1">'; // Do not prompt for shipping address
    $form .= '<input type="hidden" name="no_note" value="1">'; // Do not prompt for note
    
    // Button
    $form .= '<button type="submit" class="btn btn-primary">Pay with PayPal</button>';
    $form .= '</form>';
    
    return $form;
}

/**
 * Verify PayPal IPN (Instant Payment Notification)
 * 
 * @param array $post_data $_POST data from PayPal
 * @return bool True if verification is successful
 */
function verify_paypal_ipn($post_data) {
    // Prepare the request data
    $req = 'cmd=_notify-validate';
    
    foreach ($post_data as $key => $value) {
        $value = urlencode(stripslashes($value));
        $req .= "&$key=$value";
    }
    
    // Set up the request
    $ch = curl_init(PAYPAL_URL);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Connection: Close',
        'User-Agent: NepalBazar-Store'
    ));
    
    // Execute the request
    $res = curl_exec($ch);
    
    if (!$res) {
        curl_close($ch);
        return false;
    }
    
    curl_close($ch);
    
    // Check if the payment is verified
    if (strcmp($res, "VERIFIED") == 0) {
        return true;
    }
    
    return false;
}
?> 