<?php
// PayPal Configuration for Test/Sandbox Environment
define('PAYPAL_CLIENT_ID', 'Acnzv-GEpnxDb4WXx9B2UkXkwWiU12jMWOl8OHwvOpy7CZNkJmEfMUS2S2__c173K9fK3Q0M0ZoKX5Uq');
define('PAYPAL_CLIENT_SECRET', 'ENwqrjh9QnvO39UfJ-IiVyFLQe3XIDl02M7yL1QLcpzD-KrV7BbZXCQyQXLw12SFJO_9ISUVhFyKv5tu');

// URLs for test environment (Sandbox)
define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
define('PAYPAL_SDK_URL', 'https://www.paypal.com/sdk/js');

// Checkout URLs
define('PAYPAL_RETURN_URL', 'http://localhost/Ecommerce%20Website/users_area/paypal_payment_success.php');
define('PAYPAL_CANCEL_URL', 'http://localhost/Ecommerce%20Website/users_area/paypal_payment_cancel.php');
define('PAYPAL_NOTIFY_URL', 'http://localhost/Ecommerce%20Website/users_area/paypal_ipn_listener.php');

// PayPal settings
define('PAYPAL_CURRENCY', 'USD');
define('PAYPAL_BUSINESS_EMAIL', 'sb-2mwkh40533644@business.example.com');
?> 