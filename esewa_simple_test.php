<?php
include('./includes/esewa_config.php');

// The exact example values from eSewa documentation
$total_amount = '110';
$transaction_uuid = '241028';
$product_code = 'EPAYTEST';

// Expected signature from documentation
$expected_signature = 'i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=';

// The string we need to sign
$string_to_sign = $total_amount . ',' . $transaction_uuid . ',' . $product_code;

// Generate HMAC with SHA256
$hash = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, true);
$signature = base64_encode($hash);

// Display results
echo "<h1>eSewa Simple Signature Test</h1>";
echo "<p>String to sign: <code>$string_to_sign</code></p>";
echo "<p>Secret key: <code>" . htmlspecialchars(ESEWA_SECRET_KEY) . "</code></p>";
echo "<p>Generated signature: <code>$signature</code></p>";
echo "<p>Expected signature: <code>$expected_signature</code></p>";

// Check if signatures match
if ($signature === $expected_signature) {
    echo "<p style='color: green; font-weight: bold;'>MATCH: Signatures match exactly!</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>ERROR: Signatures do not match.</p>";
}

// Test with new transaction for actual payment form
$actual_amount = '100';
$actual_tax = '0';
$actual_total = '100';
$actual_transaction_uuid = date('YmdHis') . rand(1000, 9999);

// Generate actual form string to sign
$actual_string = $actual_total . ',' . $actual_transaction_uuid . ',' . ESEWA_MERCHANT_ID;
$actual_hash = hash_hmac('sha256', $actual_string, ESEWA_SECRET_KEY, true);
$actual_signature = base64_encode($actual_hash);

echo "<h2>Test Form with Exact Values</h2>";
echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input type='hidden' name='amount' value='" . $actual_amount . "'>";
echo "<input type='hidden' name='tax_amount' value='" . $actual_tax . "'>";
echo "<input type='hidden' name='total_amount' value='" . $actual_total . "'>";
echo "<input type='hidden' name='transaction_uuid' value='" . $actual_transaction_uuid . "'>";
echo "<input type='hidden' name='product_service_charge' value='0'>";
echo "<input type='hidden' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' name='product_code' value='" . ESEWA_MERCHANT_ID . "'>";
echo "<input type='hidden' name='success_url' value='" . ESEWA_SUCCESS_URL . "'>";
echo "<input type='hidden' name='failure_url' value='" . ESEWA_FAILURE_URL . "'>";
echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' name='signature' value='" . $actual_signature . "'>";
echo "<button type='submit'>Pay with eSewa</button>";
echo "</form>";

// Also display for verification exactly what was sent
echo "<h3>Form Values:</h3>";
echo "<pre>";
echo "amount: " . $actual_amount . "\n";
echo "tax_amount: " . $actual_tax . "\n";
echo "total_amount: " . $actual_total . "\n";
echo "transaction_uuid: " . $actual_transaction_uuid . "\n";
echo "product_code: " . ESEWA_MERCHANT_ID . "\n";
echo "string_to_sign: " . $actual_string . "\n";
echo "signature: " . $actual_signature . "\n";
echo "signed_field_names: total_amount,transaction_uuid,product_code\n";
echo "</pre>";
?> 