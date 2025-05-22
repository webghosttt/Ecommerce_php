<?php
// Prevent multiple inclusions
if (!defined('KHALTI_CONFIG_INCLUDED')) {
    define('KHALTI_CONFIG_INCLUDED', true);
    
    // Khalti Configuration
    define('KHALTI_PUBLIC_KEY', 'test_public_key_dc74e0fd57cb46cd93832aee0a390234');
    define('KHALTI_SECRET_KEY', 'test_secret_key_ce25645c459b4502a6a13c11b6b3f626');

    // Khalti API endpoints
    define('KHALTI_VERIFY_URL', 'https://khalti.com/api/v2/payment/verify/');
    
    // Return URLs (make sure these match your actual URLs)
    define('KHALTI_SUCCESS_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/Ecommerce%20Website/users_area/khalti_success.php');
    define('KHALTI_FAILURE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/Ecommerce%20Website/users_area/khalti_failure.php');
    
    // Debug mode (set to true to see detailed errors)
    define('KHALTI_DEBUG', true);
}
?> 