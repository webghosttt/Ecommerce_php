<?php
include('./includes/esewa_config.php');

echo "<h1>eSewa Exact Signature Test</h1>";

// Test values exactly from documentation example
$test_total_amount = "110";
$test_transaction_uuid = "241028";
$test_product_code = "EPAYTEST";

// 1. Test with exact values from documentation
echo "<h2>Test with documentation example values</h2>";
$doc_string_to_sign = $test_total_amount . "," . $test_transaction_uuid . "," . $test_product_code;
echo "<p>String to sign from docs: <code>" . htmlspecialchars($doc_string_to_sign) . "</code></p>";
echo "<p>Secret key from config: <code>" . htmlspecialchars(ESEWA_SECRET_KEY) . "</code></p>";
echo "<p>Expected signature from docs: <code>i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=</code></p>";

// Generate signature
$doc_hash = hash_hmac('sha256', $doc_string_to_sign, ESEWA_SECRET_KEY, true);
$doc_signature = base64_encode($doc_hash);
echo "<p>Generated signature: <code>" . $doc_signature . "</code></p>";

// 2. Test with trimmed values
echo "<h2>Test with trimmed values</h2>";
$trimmed_key = trim(ESEWA_SECRET_KEY);
$doc_hash_trimmed = hash_hmac('sha256', $doc_string_to_sign, $trimmed_key, true);
$doc_signature_trimmed = base64_encode($doc_hash_trimmed);
echo "<p>Generated signature with trimmed key: <code>" . $doc_signature_trimmed . "</code></p>";

// 3. Test with different string encodings
echo "<h2>Testing different string encodings</h2>";

// UTF-8
$utf8_hash = hash_hmac('sha256', utf8_encode($doc_string_to_sign), ESEWA_SECRET_KEY, true);
$utf8_signature = base64_encode($utf8_hash);
echo "<p>UTF-8 encoded string: <code>" . $utf8_signature . "</code></p>";

// Try without the raw output flag
$hex_hash = hash_hmac('sha256', $doc_string_to_sign, ESEWA_SECRET_KEY, false);
echo "<p>Hex output (not base64): <code>" . $hex_hash . "</code></p>";

// 4. Create a test form with exact documentation values
echo "<h2>Test Form with Documentation Values</h2>";
echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input value='100' name='amount' type='hidden'>";
echo "<input value='10' name='tax_amount' type='hidden'>";
echo "<input value='" . $test_total_amount . "' name='total_amount' type='hidden'>";
echo "<input value='" . $test_transaction_uuid . "' name='transaction_uuid' type='hidden'>";
echo "<input value='0' name='product_service_charge' type='hidden'>";
echo "<input value='0' name='product_delivery_charge' type='hidden'>";
echo "<input value='" . $test_product_code . "' name='product_code' type='hidden'>";
echo "<input value='" . ESEWA_SUCCESS_URL . "' type='hidden' name='success_url'>";
echo "<input value='" . ESEWA_FAILURE_URL . "' type='hidden' name='failure_url'>";
echo "<input value='total_amount,transaction_uuid,product_code' name='signed_field_names' type='hidden'>";
echo "<input value='" . $doc_signature . "' name='signature' type='hidden'>";
echo "<button type='submit'>Test with Documentation Values</button>";
echo "</form>";

// 5. Try different field order
echo "<h2>Testing different field order</h2>";
$reversed_string = $test_product_code . "," . $test_transaction_uuid . "," . $test_total_amount;
echo "<p>Reversed order string: <code>" . htmlspecialchars($reversed_string) . "</code></p>";
$reversed_hash = hash_hmac('sha256', $reversed_string, ESEWA_SECRET_KEY, true);
$reversed_signature = base64_encode($reversed_hash);
echo "<p>Signature with reversed order: <code>" . $reversed_signature . "</code></p>";

// 6. Try with your actual values but in a simple test
echo "<h2>Test with your actual values</h2>";
$amount = "100";
$tax_amount = "0";
$total_amount = "100";
$transaction_uuid = date('YmdHis') . rand(1000, 9999);
$product_code = ESEWA_MERCHANT_ID;

$string_to_sign = $total_amount . "," . $transaction_uuid . "," . $product_code;
echo "<p>String to sign: <code>" . htmlspecialchars($string_to_sign) . "</code></p>";

$hash = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, true);
$signature = base64_encode($hash);
echo "<p>Generated signature: <code>" . $signature . "</code></p>";

// Create test form
echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input value='" . $amount . "' name='amount' type='hidden'>";
echo "<input value='" . $tax_amount . "' name='tax_amount' type='hidden'>";
echo "<input value='" . $total_amount . "' name='total_amount' type='hidden'>";
echo "<input value='" . $transaction_uuid . "' name='transaction_uuid' type='hidden'>";
echo "<input value='0' name='product_service_charge' type='hidden'>";
echo "<input value='0' name='product_delivery_charge' type='hidden'>";
echo "<input value='" . $product_code . "' name='product_code' type='hidden'>";
echo "<input value='" . ESEWA_SUCCESS_URL . "' type='hidden' name='success_url'>";
echo "<input value='" . ESEWA_FAILURE_URL . "' type='hidden' name='failure_url'>";
echo "<input value='total_amount,transaction_uuid,product_code' name='signed_field_names' type='hidden'>";
echo "<input value='" . $signature . "' name='signature' type='hidden'>";
echo "<button type='submit'>Test with Your Values</button>";
echo "</form>";

// Display debugging info about PHP and server
echo "<h2>PHP Info</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>OpenSSL Version: " . OPENSSL_VERSION_TEXT . "</p>";
?> 