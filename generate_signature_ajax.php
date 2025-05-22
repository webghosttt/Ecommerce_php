<?php
include('./includes/esewa_config.php');

// Get the string to sign from GET parameter
$string_to_sign = isset($_GET['string']) ? $_GET['string'] : '';

// Generate signature
$hash = hash_hmac('sha256', $string_to_sign, ESEWA_SECRET_KEY, true);
$signature = base64_encode($hash);

// Return just the signature
echo $signature;
?> 