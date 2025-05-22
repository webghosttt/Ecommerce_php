<?php
echo "<h1>eSewa Exact Documentation Test</h1>";

// Using the exact values and URLs from the eSewa documentation example
$amount = "100";
$tax_amount = "10";
$total_amount = "110";
$transaction_uuid = "241028";
$product_code = "EPAYTEST";
$success_url = "https://developer.esewa.com.np/success";
$failure_url = "https://developer.esewa.com.np/failure";
$secret_key = "8gBm/:&EnhH.1/q";
$api_url = "https://rc-epay.esewa.com.np/api/epay/main/v2/form";

// Expected signature from documentation example
$expected_signature = "i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=";

// Generate signature
$string_to_sign = $total_amount . "," . $transaction_uuid . "," . $product_code;
$hash = hash_hmac('sha256', $string_to_sign, $secret_key, true);
$signature = base64_encode($hash);

echo "<p>Using exact values from eSewa documentation:</p>";
echo "<ul>";
echo "<li>amount: <code>$amount</code></li>";
echo "<li>tax_amount: <code>$tax_amount</code></li>";
echo "<li>total_amount: <code>$total_amount</code></li>";
echo "<li>transaction_uuid: <code>$transaction_uuid</code></li>";
echo "<li>product_code: <code>$product_code</code></li>";
echo "<li>success_url: <code>$success_url</code></li>";
echo "<li>failure_url: <code>$failure_url</code></li>";
echo "<li>secret_key: <code>" . htmlspecialchars($secret_key) . "</code></li>";
echo "<li>string_to_sign: <code>" . htmlspecialchars($string_to_sign) . "</code></li>";
echo "</ul>";

echo "<p>Generated signature: <code>$signature</code></p>";
echo "<p>Expected signature: <code>$expected_signature</code></p>";

if ($signature === $expected_signature) {
    echo "<p style='color: green; font-weight: bold;'>Signatures match!</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>Signatures do not match.</p>";
}

// Create form with our generated signature
echo "<h2>Test with Our Generated Signature</h2>";
echo "<form action='$api_url' method='POST'>";
echo "<input type='hidden' name='amount' value='$amount'>";
echo "<input type='hidden' name='tax_amount' value='$tax_amount'>";
echo "<input type='hidden' name='total_amount' value='$total_amount'>";
echo "<input type='hidden' name='transaction_uuid' value='$transaction_uuid'>";
echo "<input type='hidden' name='product_service_charge' value='0'>";
echo "<input type='hidden' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' name='product_code' value='$product_code'>";
echo "<input type='hidden' name='success_url' value='$success_url'>";
echo "<input type='hidden' name='failure_url' value='$failure_url'>";
echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' name='signature' value='$signature'>";
echo "<button type='submit'>Test with Our Generated Signature</button>";
echo "</form>";

// Create form with exact signature from documentation
echo "<h2>Test with Exact Documentation Signature</h2>";
echo "<form action='$api_url' method='POST'>";
echo "<input type='hidden' name='amount' value='$amount'>";
echo "<input type='hidden' name='tax_amount' value='$tax_amount'>";
echo "<input type='hidden' name='total_amount' value='$total_amount'>";
echo "<input type='hidden' name='transaction_uuid' value='$transaction_uuid'>";
echo "<input type='hidden' name='product_service_charge' value='0'>";
echo "<input type='hidden' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' name='product_code' value='$product_code'>";
echo "<input type='hidden' name='success_url' value='$success_url'>";
echo "<input type='hidden' name='failure_url' value='$failure_url'>";
echo "<input type='hidden' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' name='signature' value='$expected_signature'>";
echo "<button type='submit'>Test with Exact Documentation Signature</button>";
echo "</form>";

// Entirely mimic the example HTML form from documentation
echo "<h2>Exact HTML Form from Documentation</h2>";
echo "<p>This is the exact HTML form from the eSewa documentation.</p>";
echo "<form action='https://rc-epay.esewa.com.np/api/epay/main/v2/form' method='POST'>";
echo "<input type='hidden' id='amount' name='amount' value='100'>";
echo "<input type='hidden' id='tax_amount' name='tax_amount' value='10'>";
echo "<input type='hidden' id='total_amount' name='total_amount' value='110'>";
echo "<input type='hidden' id='transaction_uuid' name='transaction_uuid' value='241028'>";
echo "<input type='hidden' id='product_code' name='product_code' value='EPAYTEST'>";
echo "<input type='hidden' id='product_service_charge' name='product_service_charge' value='0'>";
echo "<input type='hidden' id='product_delivery_charge' name='product_delivery_charge' value='0'>";
echo "<input type='hidden' id='success_url' name='success_url' value='https://developer.esewa.com.np/success'>";
echo "<input type='hidden' id='failure_url' name='failure_url' value='https://developer.esewa.com.np/failure'>";
echo "<input type='hidden' id='signed_field_names' name='signed_field_names' value='total_amount,transaction_uuid,product_code'>";
echo "<input type='hidden' id='signature' name='signature' value='i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME='>";
echo "<button type='submit'>Complete Documentation Example</button>";
echo "</form>";
?> 