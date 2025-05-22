<?php
// eSewa Configuration for test environment
define('ESEWA_ID', '9806800001');
define('ESEWA_PASSWORD', 'Nepal@123');
define('ESEWA_MERCHANT_ID', 'EPAYTEST');
define('ESEWA_TOKEN', '123456');

// The secret key must match exactly as provided in eSewa documentation
// Ensure there are no whitespace issues or character encoding problems
define('ESEWA_SECRET_KEY', '8gBm/:&EnhH.1/q');

// URLs for test environment (updated to the latest version)
define('ESEWA_URL', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form');
define('ESEWA_VERIFICATION_URL', 'https://rc.esewa.com.np/api/epay/transaction/status/');

// Success and failure URLs
define('ESEWA_SUCCESS_URL', 'http://localhost/Ecommerce%20Website/users_area/esewa_payment_success.php');
define('ESEWA_FAILURE_URL', 'http://localhost/Ecommerce%20Website/users_area/esewa_payment_failure.php');
?> 