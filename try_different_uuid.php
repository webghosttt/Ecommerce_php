<?php
include('./includes/esewa_config.php');

echo "<h1>eSewa Transaction UUID Format Test</h1>";

// Try a few different formats for the transaction_uuid
$transaction_formats = [
    'docs_format' => '241028',
    'numeric_only' => '123456789',
    'hyphenated' => date('Ymd') . '-' . rand(1000, 9999),
    'timestamp_with_random' => date('YmdHis') . rand(1000, 9999),
    'with_prefix' => 'TR' . date('YmdHis'),
    'alphanumeric' => 'abc123' . rand(1000, 9999)
];

$amount = "100";
$tax_amount = "0";
$total_amount = "100";

echo "<p>All forms use these values:</p>";
echo "<ul>";
echo "<li>amount: <code>$amount</code></li>";
echo "<li>tax_amount: <code>$tax_amount</code></li>";
echo "<li>total_amount: <code>$total_amount</code></li>";
echo "<li>product_code: <code>" . ESEWA_MERCHANT_ID . "</code></li>";
echo "<li>Secret key: <code>" . htmlspecialchars(ESEWA_SECRET_KEY) . "</code></li>";
echo "</ul>";

foreach ($transaction_formats as $format_name => $transaction_uuid) {
    // Generate the signature
    $string_to_sign = $total_amount . "," . $transaction_uuid . "," . ESEWA_MERCHANT_ID;
    $hash = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, true);
    $signature = base64_encode($hash);
    
    echo "<h2>Test Form with $format_name format</h2>";
    echo "<p>Transaction UUID: <code>$transaction_uuid</code></p>";
    echo "<p>String to sign: <code>" . htmlspecialchars($string_to_sign) . "</code></p>";
    echo "<p>Generated signature: <code>$signature</code></p>";
    
    // Create the form
    echo "<form action='" . ESEWA_URL . "' method='POST'>";
    echo "<input type='hidden' name='amount' value='" . $amount . "'>";
    echo "<input type='hidden' name='tax_amount' value='" . $tax_amount . "'>";
    echo "<input type='hidden' name='total_amount' value='" . $total_amount . "'>";
    echo "<input type='hidden' name='transaction_uuid' value='" . $transaction_uuid . "'>";
    echo "<input type='hidden' name='product_service_charge' value='0'>";
    echo "<input type='hidden' name='product_delivery_charge' value='0'>";
    echo "<input type='hidden' name='product_code' value='" . ESEWA_MERCHANT_ID . "'>";
    echo "<input type='hidden' name='success_url' value='" . ESEWA_SUCCESS_URL . "'>";
    echo "<input type='hidden' name='failure_url' value='" . ESEWA_FAILURE_URL . "'>";
    echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
    echo "<input type='hidden' name='signature' value='" . $signature . "'>";
    echo "<button type='submit'>Test with $format_name format</button>";
    echo "</form>";
}

// Also try with the exact example values from documentation
$doc_total_amount = "110";
$doc_transaction_uuid = "241028";
$doc_product_code = "EPAYTEST";

// Generate signature with doc values
$doc_string_to_sign = $doc_total_amount . "," . $doc_transaction_uuid . "," . $doc_product_code;
$doc_hash = hash_hmac('sha256', $doc_string_to_sign, ESEWA_SECRET_KEY, true);
$doc_signature = base64_encode($doc_hash);

echo "<h2>Test with Exact Documentation Values</h2>";
echo "<p>This uses the exact values from the eSewa documentation:</p>";
echo "<ul>";
echo "<li>total_amount: <code>$doc_total_amount</code></li>";
echo "<li>transaction_uuid: <code>$doc_transaction_uuid</code></li>";
echo "<li>product_code: <code>$doc_product_code</code></li>";
echo "</ul>";

echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input type='hidden' name='amount' value='100'>";
echo "<input type='hidden' name='tax_amount' value='10'>";
echo "<input type='hidden' name='total_amount' value='" . $doc_total_amount . "'>";
echo "<input type='hidden' name='transaction_uuid' value='" . $doc_transaction_uuid . "'>";
echo "<input type='hidden' name='product_service_charge' value='0'>";
echo "<input type='hidden' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' name='product_code' value='" . $doc_product_code . "'>";
echo "<input type='hidden' name='success_url' value='" . ESEWA_SUCCESS_URL . "'>";
echo "<input type='hidden' name='failure_url' value='" . ESEWA_FAILURE_URL . "'>";
echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' name='signature' value='" . $doc_signature . "'>";
echo "<button type='submit'>Test with Exact Documentation Values</button>";
echo "</form>";

// Try with the exact signature from the documentation
$expected_signature = 'i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=';

echo "<h2>Test with eSewa's Provided Signature</h2>";
echo "<p>This uses the exact signature value provided in the documentation:</p>";

echo "<form action='" . ESEWA_URL . "' method='POST'>";
echo "<input type='hidden' name='amount' value='100'>";
echo "<input type='hidden' name='tax_amount' value='10'>";
echo "<input type='hidden' name='total_amount' value='" . $doc_total_amount . "'>";
echo "<input type='hidden' name='transaction_uuid' value='" . $doc_transaction_uuid . "'>";
echo "<input type='hidden' name='product_service_charge' value='0'>";
echo "<input type='hidden' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' name='product_code' value='" . $doc_product_code . "'>";
echo "<input type='hidden' name='success_url' value='" . ESEWA_SUCCESS_URL . "'>";
echo "<input type='hidden' name='failure_url' value='" . ESEWA_FAILURE_URL . "'>";
echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' name='signature' value='" . $expected_signature . "'>";
echo "<button type='submit'>Test with eSewa's Provided Signature</button>";
echo "</form>";
?> 