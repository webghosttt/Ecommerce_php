<?php
include('./includes/esewa_config.php');

echo "<h1>eSewa Curl Test</h1>";

// Test with the exact example values from documentation
$amount = "100";
$tax_amount = "10";
$total_amount = "110";
$transaction_uuid = "241028";
$product_code = "EPAYTEST";
$success_url = "https://developer.esewa.com.np/success";
$failure_url = "https://developer.esewa.com.np/failure";

// Generate signature
$string_to_sign = $total_amount . "," . $transaction_uuid . "," . $product_code;
$hash = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, true);
$signature = base64_encode($hash);

// Prepare POST data
$post_data = array(
    'amount' => $amount,
    'tax_amount' => $tax_amount,
    'total_amount' => $total_amount,
    'transaction_uuid' => $transaction_uuid,
    'product_service_charge' => "0",
    'product_delivery_charge' => "0",
    'product_code' => $product_code,
    'success_url' => $success_url,
    'failure_url' => $failure_url,
    'signed_field_names' => 'total_amount,transaction_uuid,product_code',
    'signature' => $signature
);

// Initialize curl
$ch = curl_init(ESEWA_URL);

// Set curl options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_VERBOSE, true);

// Execute curl
$response = curl_exec($ch);
$info = curl_getinfo($ch);
$error = curl_error($ch);

// Close curl
curl_close($ch);

// Display request details
echo "<h2>Request Details</h2>";
echo "<pre>";
echo "URL: " . ESEWA_URL . "\n";
echo "POST Data: \n";
print_r($post_data);
echo "</pre>";

// Display response
echo "<h2>Response Details</h2>";
echo "<pre>";
echo "HTTP Code: " . $info['http_code'] . "\n\n";
if (!empty($error)) {
    echo "Curl Error: " . $error . "\n\n";
}
echo "Response: \n" . htmlspecialchars($response);
echo "</pre>";

// Also try with cURL using the exact signature from documentation
echo "<h2>Test with Documentation Signature</h2>";

$doc_signature = "i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=";
$post_data['signature'] = $doc_signature;

$ch = curl_init(ESEWA_URL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_VERBOSE, true);

$doc_response = curl_exec($ch);
$doc_info = curl_getinfo($ch);
$doc_error = curl_error($ch);

curl_close($ch);

echo "<h2>Documentation Signature Response</h2>";
echo "<pre>";
echo "HTTP Code: " . $doc_info['http_code'] . "\n\n";
if (!empty($doc_error)) {
    echo "Curl Error: " . $doc_error . "\n\n";
}
echo "Response: \n" . htmlspecialchars($doc_response);
echo "</pre>";
?> 