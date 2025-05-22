<?php
/**
 * Helper functions for eSewa integration
 */

/**
 * Generate HMAC signature for eSewa API v2
 * 
 * @param array $params Array of parameters to be signed
 * @param string $secret_key eSewa secret key
 * @return string Base64 encoded signature
 */
function generate_esewa_signature($params, $secret_key) {
    // Convert array to comma-separated string
    $message = implode(",", $params);
    
    // Generate HMAC with SHA256
    $hash = hash_hmac('sha256', $message, $secret_key, true);
    
    // Return Base64 encoded string
    return base64_encode($hash);
}

/**
 * Create properly formatted eSewa payment form
 * 
 * @param float $amount Base amount
 * @param float $tax_amount Tax amount (default 0)
 * @param string $transaction_id Unique transaction identifier
 * @param string $merchant_code eSewa merchant code
 * @param string $success_url Success URL
 * @param string $failure_url Failure URL
 * @param string $secret_key eSewa secret key
 * @return string HTML form for eSewa payment
 */
function get_esewa_payment_form($amount, $tax_amount, $transaction_id, $merchant_code, $success_url, $failure_url, $secret_key) {
    // Calculate total amount
    $total_amount = $amount + $tax_amount;
    
    // Important: The order of these values MUST match the order in signed_field_names
    // This is critical for the signature to be valid per eSewa's requirements
    $signed_fields = ['total_amount', 'transaction_uuid', 'product_code'];
    $sign_values = [(string)$total_amount, $transaction_id, $merchant_code];
    
    // Generate signature
    $signature = generate_esewa_signature($sign_values, $secret_key);
    
    // Build form HTML
    $form = '<form action="' . ESEWA_URL . '" method="POST">';
    $form .= '<input type="hidden" name="amount" value="' . $amount . '">';
    $form .= '<input type="hidden" name="tax_amount" value="' . $tax_amount . '">';
    $form .= '<input type="hidden" name="total_amount" value="' . $total_amount . '">';
    $form .= '<input type="hidden" name="transaction_uuid" value="' . $transaction_id . '">';
    $form .= '<input type="hidden" name="product_service_charge" value="0">';
    $form .= '<input type="hidden" name="product_delivery_charge" value="0">';
    $form .= '<input type="hidden" name="product_code" value="' . $merchant_code . '">';
    $form .= '<input type="hidden" name="success_url" value="' . $success_url . '">';
    $form .= '<input type="hidden" name="failure_url" value="' . $failure_url . '">';
    $form .= '<input type="hidden" name="signed_field_names" value="' . implode(',', $signed_fields) . '">';
    $form .= '<input type="hidden" name="signature" value="' . $signature . '">';
    $form .= '<button type="submit" class="btn btn-success">Pay with eSewa</button>';
    $form .= '</form>';
    
    return $form;
}
?> 