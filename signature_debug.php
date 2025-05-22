<?php
include('./includes/connect.php');
include('./includes/esewa_config.php');
include('./includes/esewa_helper.php');

echo "<h1>eSewa Signature Debug</h1>";

// Use exact same values you're using in your actual payment
$amount = "100";
$tax_amount = "0";
$total_amount = "100";
$transaction_uuid = date('YmdHis') . rand(1000, 9999); // Generate unique ID
$product_code = ESEWA_MERCHANT_ID;

// Print all input values
echo "<h2>Input Values</h2>";
echo "<ul>";
echo "<li>amount: <code>$amount</code></li>";
echo "<li>tax_amount: <code>$tax_amount</code></li>";
echo "<li>total_amount: <code>$total_amount</code></li>";
echo "<li>transaction_uuid: <code>$transaction_uuid</code></li>";
echo "<li>product_code: <code>$product_code</code></li>";
echo "<li>secret_key: <code>" . htmlspecialchars(ESEWA_SECRET_KEY) . "</code></li>";
echo "</ul>";

// The string we need to sign - IMPORTANT: Order matters!
$sign_values = [$total_amount, $transaction_uuid, $product_code];
$string_to_sign = implode(",", $sign_values);
echo "<h2>String to Sign</h2>";
echo "<p><code>" . htmlspecialchars($string_to_sign) . "</code></p>";

// Generate signature using our helper
$signature = generate_esewa_signature($sign_values, ESEWA_SECRET_KEY);
echo "<h2>Generated Signature</h2>";
echo "<p><code>$signature</code></p>";

// Alternative signature method for testing
function alt_generate_signature($message, $secret) {
    $hash = hash_hmac('sha256', $message, $secret, true);
    return base64_encode($hash);
}

$alt_signature = alt_generate_signature($string_to_sign, ESEWA_SECRET_KEY);
echo "<h2>Alternative Signature Method</h2>";
echo "<p><code>$alt_signature</code></p>";

// Create a test form for immediate testing
echo "<h2>Test Form</h2>";
echo "<form action='" . ESEWA_URL . "' method='POST' id='esewa_form'>";
echo "<input value='" . $amount . "' name='amount' type='hidden'>";
echo "<input value='" . $tax_amount . "' name='tax_amount' type='hidden'>";
echo "<input value='" . $total_amount . "' name='total_amount' type='hidden'>";
echo "<input value='" . $transaction_uuid . "' name='transaction_uuid' type='hidden'>";
echo "<input value='0' name='product_service_charge' type='hidden'>";
echo "<input value='0' name='product_delivery_charge' type='hidden'>";
echo "<input value='" . $product_code . "' name='product_code' type='hidden'>";
echo "<input value='" . ESEWA_SUCCESS_URL . "' type='hidden' name='success_url'>";
echo "<input value='" . ESEWA_FAILURE_URL . "' type='hidden' name='failure_url'>";
echo "<input value='total_amount,transaction_uuid,product_code' name='signed_field_names' type='hidden' id='signed_fields'>";
echo "<input value='" . $signature . "' name='signature' type='hidden' id='signature'>";
echo "<button type='submit'>Test eSewa Payment</button>";
echo "</form>";

// Add a form to try with the alternative signature
echo "<h2>Test with Alternative Signature</h2>";
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
echo "<input value='" . $alt_signature . "' name='signature' type='hidden'>";
echo "<button type='submit'>Test with Alternative Signature</button>";
echo "</form>";

// Add a section to manually modify and test
echo "<h2>Custom Test</h2>";
echo "<p>Modify values and test with different formats:</p>";
echo "<form id='custom_form' action='" . ESEWA_URL . "' method='POST'>";
echo "<div style='margin-bottom: 10px;'>";
echo "<label>Signed Field Names: </label>";
echo "<input type='text' id='custom_signed_fields' name='signed_field_names' value='total_amount,transaction_uuid,product_code' style='width: 400px;'>";
echo "</div>";

echo "<div style='margin-bottom: 10px;'>";
echo "<label>String to Sign: </label>";
echo "<input type='text' id='custom_string' value='" . htmlspecialchars($string_to_sign) . "' style='width: 400px;'>";
echo "</div>";

echo "<div style='margin-bottom: 10px;'>";
echo "<button type='button' onclick='generateCustomSignature()'>Generate Signature</button>";
echo "</div>";

echo "<div style='margin-bottom: 10px;'>";
echo "<label>Generated Signature: </label>";
echo "<input type='text' id='custom_signature' name='signature' style='width: 400px;'>";
echo "</div>";

// Include all the other fields
echo "<input value='" . $amount . "' name='amount' type='hidden'>";
echo "<input value='" . $tax_amount . "' name='tax_amount' type='hidden'>";
echo "<input value='" . $total_amount . "' name='total_amount' type='hidden'>";
echo "<input value='" . $transaction_uuid . "' name='transaction_uuid' type='hidden'>";
echo "<input value='0' name='product_service_charge' type='hidden'>";
echo "<input value='0' name='product_delivery_charge' type='hidden'>";
echo "<input value='" . $product_code . "' name='product_code' type='hidden'>";
echo "<input value='" . ESEWA_SUCCESS_URL . "' type='hidden' name='success_url'>";
echo "<input value='" . ESEWA_FAILURE_URL . "' type='hidden' name='failure_url'>";

echo "<button type='submit'>Test Custom Signature</button>";
echo "</form>";

// JavaScript for custom signature generation
echo "<script>
function generateCustomSignature() {
    // This is just for visual testing - server-side signature is more secure
    var customString = document.getElementById('custom_string').value;
    fetch('generate_signature_ajax.php?string=' + encodeURIComponent(customString))
        .then(response => response.text())
        .then(data => {
            document.getElementById('custom_signature').value = data;
        });
}
</script>";
?> 