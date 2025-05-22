<?php
// The exact secret key mentioned in eSewa documentation
$doc_secret_key = "8gBm/:&EnhH.1/q";

// The exact example values from eSewa documentation
$total_amount = '110';
$transaction_uuid = '241028';
$product_code = 'EPAYTEST';

// Expected signature from documentation
$expected_signature = 'i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=';

// String to sign
$string_to_sign = $total_amount . ',' . $transaction_uuid . ',' . $product_code;

// Generate HMAC with SHA256 using the documented secret
$hash = hash_hmac('sha256', $string_to_sign, $doc_secret_key, true);
$signature = base64_encode($hash);

// Display results
echo "<h1>eSewa Secret Key Test</h1>";
echo "<p>Using the exact secret key from documentation: <code>" . htmlspecialchars($doc_secret_key) . "</code></p>";
echo "<p>String to sign: <code>$string_to_sign</code></p>";
echo "<p>Generated signature: <code>$signature</code></p>";
echo "<p>Expected signature: <code>$expected_signature</code></p>";

// Check if signatures match
if ($signature === $expected_signature) {
    echo "<p style='color: green; font-weight: bold;'>MATCH: Signatures match exactly!</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>ERROR: Signatures do not match.</p>";
}

// Try different encodings of the key
$encodings = [
    'Default' => $doc_secret_key,
    'Trim' => trim($doc_secret_key),
    'UTF-8' => utf8_encode($doc_secret_key),
    'ASCII' => mb_convert_encoding($doc_secret_key, 'ASCII')
];

echo "<h2>Testing Different Key Encodings</h2>";
echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>Encoding</th><th>Key</th><th>Signature</th><th>Match?</th></tr>";

foreach ($encodings as $name => $key) {
    $test_hash = hash_hmac('sha256', $string_to_sign, $key, true);
    $test_signature = base64_encode($test_hash);
    $matches = ($test_signature === $expected_signature);
    
    echo "<tr>";
    echo "<td>$name</td>";
    echo "<td><code>" . htmlspecialchars($key) . "</code></td>";
    echo "<td><code>$test_signature</code></td>";
    echo "<td>" . ($matches ? "✅" : "❌") . "</td>";
    echo "</tr>";
}

echo "</table>";

// Include your config
include('./includes/esewa_config.php');
echo "<h2>Comparing with Your Config</h2>";
echo "<p>Your config secret key: <code>" . htmlspecialchars(ESEWA_SECRET_KEY) . "</code></p>";

$config_hash = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, true);
$config_signature = base64_encode($config_hash);
echo "<p>Signature with your config key: <code>$config_signature</code></p>";

$config_matches = ($config_signature === $expected_signature);
echo "<p>" . ($config_matches ? "✅ Your config key matches the expected signature." : "❌ Your config key does NOT match the expected signature.") . "</p>";

// If they don't match, try to determine if it's a character encoding issue
if (!$config_matches) {
    echo "<h3>Character Comparison</h3>";
    echo "<p>Comparing each character in the keys to find differences:</p>";
    
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr><th>Position</th><th>Doc Key Char</th><th>Doc Key Hex</th><th>Your Key Char</th><th>Your Key Hex</th><th>Match?</th></tr>";
    
    $max_length = max(strlen($doc_secret_key), strlen(ESEWA_SECRET_KEY));
    for ($i = 0; $i < $max_length; $i++) {
        $doc_char = isset($doc_secret_key[$i]) ? $doc_secret_key[$i] : '';
        $your_char = isset(ESEWA_SECRET_KEY[$i]) ? ESEWA_SECRET_KEY[$i] : '';
        
        $doc_hex = $doc_char !== '' ? bin2hex($doc_char) : '';
        $your_hex = $your_char !== '' ? bin2hex($your_char) : '';
        
        $char_matches = ($doc_char === $your_char);
        
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>" . htmlspecialchars($doc_char) . "</td>";
        echo "<td>$doc_hex</td>";
        echo "<td>" . htmlspecialchars($your_char) . "</td>";
        echo "<td>$your_hex</td>";
        echo "<td>" . ($char_matches ? "✅" : "❌") . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
}
?> 