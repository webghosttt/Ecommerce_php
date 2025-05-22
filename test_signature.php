<?php
include('./includes/connect.php');
include('./includes/esewa_config.php');

echo "<h1>eSewa Signature Test</h1>";

// Values for testing
$total_amount = "100";
$transaction_uuid = "123456789";
$product_code = "EPAYTEST";

// The string we need to sign
$string_to_sign = $total_amount . "," . $transaction_uuid . "," . $product_code;
echo "<p>String to Sign: <strong>" . htmlspecialchars($string_to_sign) . "</strong></p>";

// The secret key
echo "<p>Secret Key: <strong>" . htmlspecialchars(ESEWA_SECRET_KEY) . "</strong></p>";

// Generate signature using different methods to debug
echo "<h2>Signature Generation Methods</h2>";
echo "<ul>";

// Method 1: Direct HMAC and base64
$hash1 = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, true);
$signature1 = base64_encode($hash1);
echo "<li>Method 1 (Direct HMAC + base64): <code>" . $signature1 . "</code></li>";

// Method 2: String conversion to make sure no character encoding issues
$hash2 = hash_hmac('sha256', $string_to_sign, strval(ESEWA_SECRET_KEY), true);
$signature2 = base64_encode($hash2);
echo "<li>Method 2 (With strval): <code>" . $signature2 . "</code></li>";

// Method 3: Using bin2hex to inspect raw bytes
$hash3 = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, true);
echo "<li>Method 3 (Raw binary as hex): <code>" . bin2hex($hash3) . "</code></li>";

// Method 4: Using raw output of hash_hmac
$hash4_hex = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, false);
echo "<li>Method 4 (Hex output): <code>" . $hash4_hex . "</code></li>";

// Example from documentation
$expected = "i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=";
echo "<li>Example from documentation for comparison: <code>" . $expected . "</code></li>";
echo "</ul>";

// Create a test form
echo "<h2>Test Form</h2>";
echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input value='" . $total_amount . "' name='amount' type='hidden'>";
echo "<input value='0' name='tax_amount' type='hidden'>";
echo "<input value='" . $total_amount . "' name='total_amount' type='hidden'>";
echo "<input value='" . $transaction_uuid . "' name='transaction_uuid' type='hidden'>";
echo "<input value='0' name='product_service_charge' type='hidden'>";
echo "<input value='0' name='product_delivery_charge' type='hidden'>";
echo "<input value='" . $product_code . "' name='product_code' type='hidden'>";
echo "<input value='" . ESEWA_SUCCESS_URL . "' type='hidden' name='success_url'>";
echo "<input value='" . ESEWA_FAILURE_URL . "' type='hidden' name='failure_url'>";
echo "<input value='total_amount,transaction_uuid,product_code' name='signed_field_names' type='hidden'>";
echo "<input value='" . $signature1 . "' name='signature' type='hidden'>";
echo "<input type='submit' value='Test eSewa Payment'>";
echo "</form>";

// Documentation
echo "<h2>Documentation Notes</h2>";
echo "<p>According to eSewa docs, the signature should be created with:</p>";
echo "<ol>";
echo "<li>HMAC-SHA256 algorithm</li>";
echo "<li>Secret key provided by eSewa (for testing: 8gBm/:&EnhH.1/q)</li>";
echo "<li>Input string: comma-separated values from signed_field_names (in same order)</li>";
echo "<li>Base64 encoding of the resulting hash</li>";
echo "</ol>";

?> 