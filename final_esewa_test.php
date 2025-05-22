<?php
include('./includes/esewa_config.php');
include('./includes/esewa_helper.php');

echo "<h1>eSewa Final Signature Test</h1>";

// Test values from documentation
$total_amount = '110';
$transaction_uuid = '241028';
$product_code = 'EPAYTEST';
$expected_signature = 'i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=';

// Test with direct implementation
$string_to_sign = $total_amount . ',' . $transaction_uuid . ',' . $product_code;
$direct_hash = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, true);
$direct_signature = base64_encode($direct_hash);

// Test with helper function
$values_array = [$total_amount, $transaction_uuid, $product_code];
$helper_signature = generate_esewa_signature($values_array, ESEWA_SECRET_KEY);

// Display results
echo "<h2>Test with Exact Documentation Values</h2>";
echo "<p>String to sign: <code>" . htmlspecialchars($string_to_sign) . "</code></p>";
echo "<p>Secret key: <code>" . htmlspecialchars(ESEWA_SECRET_KEY) . "</code></p>";
echo "<p>Expected signature: <code>" . $expected_signature . "</code></p>";
echo "<p>Direct signature: <code>" . $direct_signature . "</code></p>";
echo "<p>Helper signature: <code>" . $helper_signature . "</code></p>";

$direct_matches = ($direct_signature === $expected_signature);
$helper_matches = ($helper_signature === $expected_signature);

echo "<p>Direct implementation " . ($direct_matches ? "✅ MATCHES" : "❌ DOES NOT MATCH") . " the expected signature.</p>";
echo "<p>Helper function " . ($helper_matches ? "✅ MATCHES" : "❌ DOES NOT MATCH") . " the expected signature.</p>";

// Create test form with exact documentation values
echo "<h2>Test Form with Exact Documentation Values</h2>";
echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input type='hidden' name='amount' value='100'>";
echo "<input type='hidden' name='tax_amount' value='10'>";
echo "<input type='hidden' name='total_amount' value='" . $total_amount . "'>";
echo "<input type='hidden' name='transaction_uuid' value='" . $transaction_uuid . "'>";
echo "<input type='hidden' name='product_service_charge' value='0'>";
echo "<input type='hidden' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' name='product_code' value='" . $product_code . "'>";
echo "<input type='hidden' name='success_url' value='" . ESEWA_SUCCESS_URL . "'>";
echo "<input type='hidden' name='failure_url' value='" . ESEWA_FAILURE_URL . "'>";
echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' name='signature' value='" . $direct_signature . "'>";
echo "<button type='submit'>Test with Exact Documentation Values</button>";
echo "</form>";

// Now create a test with a new transaction using our helper
$new_amount = '100';
$new_tax = '0'; 
$new_total = '100';
$new_transaction_uuid = date('Ymd') . '-' . rand(100000, 999999);
$new_values = [$new_total, $new_transaction_uuid, ESEWA_MERCHANT_ID];
$new_signature = generate_esewa_signature($new_values, ESEWA_SECRET_KEY);

echo "<h2>Test with New Transaction</h2>";
echo "<p>We'll create a new test transaction with these values:</p>";
echo "<ul>";
echo "<li>Amount: $new_amount</li>";
echo "<li>Tax Amount: $new_tax</li>";
echo "<li>Total Amount: $new_total</li>";
echo "<li>Transaction UUID: $new_transaction_uuid</li>";
echo "<li>Product Code: " . ESEWA_MERCHANT_ID . "</li>";
echo "<li>String to sign: " . implode(',', $new_values) . "</li>";
echo "<li>Generated signature: $new_signature</li>";
echo "</ul>";

echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input type='hidden' name='amount' value='" . $new_amount . "'>";
echo "<input type='hidden' name='tax_amount' value='" . $new_tax . "'>";
echo "<input type='hidden' name='total_amount' value='" . $new_total . "'>";
echo "<input type='hidden' name='transaction_uuid' value='" . $new_transaction_uuid . "'>";
echo "<input type='hidden' name='product_service_charge' value='0'>";
echo "<input type='hidden' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' name='product_code' value='" . ESEWA_MERCHANT_ID . "'>";
echo "<input type='hidden' name='success_url' value='" . ESEWA_SUCCESS_URL . "'>";
echo "<input type='hidden' name='failure_url' value='" . ESEWA_FAILURE_URL . "'>";
echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' name='signature' value='" . $new_signature . "'>";
echo "<button type='submit'>Test with New Transaction</button>";
echo "</form>";
?> 