<?php
include('./includes/connect.php');
include('./includes/khalti_helper.php');

echo "<h1>Khalti Payment Test</h1>";

// Test single item payment
$order_id = 'TEST-' . time();
$product_name = 'Test Product';
$amount = 10.00;

echo "<h2>Test Single Item Payment</h2>";
echo "<p>This will create a payment for a single item:</p>";
echo "<ul>";
echo "<li>Order ID: <code>$order_id</code></li>";
echo "<li>Product Name: <code>$product_name</code></li>";
echo "<li>Amount: <code>NPR $amount</code></li>";
echo "</ul>";

// Generate and display the Khalti payment button
echo get_khalti_payment_button($amount, $order_id, $product_name);
?> 