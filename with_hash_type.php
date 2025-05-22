<?php
include('./includes/esewa_config.php');

echo "<h1>eSewa Test with Hash Type</h1>";

// Test values
$amount = "100";
$tax_amount = "0";
$total_amount = "100";
$transaction_uuid = date('YmdHis') . rand(1000, 9999);
$product_code = ESEWA_MERCHANT_ID;

// Generate signature
$string_to_sign = $total_amount . "," . $transaction_uuid . "," . $product_code;
$hash = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, true);
$signature = base64_encode($hash);

echo "<p>Generated signature: <code>$signature</code></p>";

// Create form with hash type parameter
echo "<h2>Test Form with Hash Type Parameter</h2>";
echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input type='hidden' name='amount' value='" . $amount . "'>";
echo "<input type='hidden' name='tax_amount' value='" . $tax_amount . "'>";
echo "<input type='hidden' name='total_amount' value='" . $total_amount . "'>";
echo "<input type='hidden' name='transaction_uuid' value='" . $transaction_uuid . "'>";
echo "<input type='hidden' name='product_service_charge' value='0'>";
echo "<input type='hidden' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' name='product_code' value='" . $product_code . "'>";
echo "<input type='hidden' name='success_url' value='" . ESEWA_SUCCESS_URL . "'>";
echo "<input type='hidden' name='failure_url' value='" . ESEWA_FAILURE_URL . "'>";
echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' name='signature' value='" . $signature . "'>";
echo "<input type='hidden' name='vpc_SecureHashType' value='SHA256'>";
echo "<button type='submit'>Test with Hash Type Parameter</button>";
echo "</form>";

// Another variant
echo "<h2>Test Form with Alternative Hash Type Parameter</h2>";
echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input type='hidden' name='amount' value='" . $amount . "'>";
echo "<input type='hidden' name='tax_amount' value='" . $tax_amount . "'>";
echo "<input type='hidden' name='total_amount' value='" . $total_amount . "'>";
echo "<input type='hidden' name='transaction_uuid' value='" . $transaction_uuid . "'>";
echo "<input type='hidden' name='product_service_charge' value='0'>";
echo "<input type='hidden' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' name='product_code' value='" . $product_code . "'>";
echo "<input type='hidden' name='success_url' value='" . ESEWA_SUCCESS_URL . "'>";
echo "<input type='hidden' name='failure_url' value='" . ESEWA_FAILURE_URL . "'>";
echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' name='signature' value='" . $signature . "'>";
echo "<input type='hidden' name='SecureHashType' value='SHA256'>";
echo "<button type='submit'>Test with Alternative Hash Type Parameter</button>";
echo "</form>";

// Try with a different transaction_uuid format
$simple_uuid = rand(100000, 999999);
$simple_string = $total_amount . "," . $simple_uuid . "," . $product_code;
$simple_hash = hash_hmac('sha256', $simple_string, ESEWA_SECRET_KEY, true);
$simple_signature = base64_encode($simple_hash);

echo "<h2>Test with Simple Transaction UUID</h2>";
echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input type='hidden' name='amount' value='" . $amount . "'>";
echo "<input type='hidden' name='tax_amount' value='" . $tax_amount . "'>";
echo "<input type='hidden' name='total_amount' value='" . $total_amount . "'>";
echo "<input type='hidden' name='transaction_uuid' value='" . $simple_uuid . "'>";
echo "<input type='hidden' name='product_service_charge' value='0'>";
echo "<input type='hidden' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' name='product_code' value='" . $product_code . "'>";
echo "<input type='hidden' name='success_url' value='" . ESEWA_SUCCESS_URL . "'>";
echo "<input type='hidden' name='failure_url' value='" . ESEWA_FAILURE_URL . "'>";
echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' name='signature' value='" . $simple_signature . "'>";
echo "<button type='submit'>Test with Simple UUID</button>";
echo "</form>";
?> 