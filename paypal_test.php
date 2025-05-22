<?php
include('./includes/connect.php');
include('./includes/paypal_config.php');
include('./includes/paypal_helper.php');

echo "<h1>PayPal Payment Test</h1>";

// Test single item payment
$order_id = 'TEST-' . time();
$product_name = 'Test Product';
$amount = 10.00;

echo "<h2>Test Single Item Payment</h2>";
echo "<p>This will create a payment for a single item:</p>";
echo "<ul>";
echo "<li>Order ID: <code>$order_id</code></li>";
echo "<li>Product Name: <code>$product_name</code></li>";
echo "<li>Amount: <code>$$amount</code></li>";
echo "</ul>";

// Generate and display the PayPal form
echo get_paypal_payment_form($amount, $order_id, $product_name);

// Test cart payment
$items = array(
    array('name' => 'Test Product 1', 'quantity' => 2, 'price' => 5.00),
    array('name' => 'Test Product 2', 'quantity' => 1, 'price' => 10.00)
);
$cart_order_id = 'CART-' . time();
$shipping = 2.50;
$tax = 1.50;

echo "<h2>Test Cart Payment</h2>";
echo "<p>This will create a payment for multiple items:</p>";
echo "<ul>";
echo "<li>Order ID: <code>$cart_order_id</code></li>";
echo "<li>Items:</li>";
echo "<ul>";
foreach ($items as $item) {
    echo "<li>{$item['name']} - {$item['quantity']} x \${$item['price']}</li>";
}
echo "</ul>";
echo "<li>Shipping: <code>$$shipping</code></li>";
echo "<li>Tax: <code>$$tax</code></li>";
echo "<li>Total: <code>$" . (($items[0]['quantity'] * $items[0]['price']) + ($items[1]['quantity'] * $items[1]['price']) + $shipping + $tax) . "</code></li>";
echo "</ul>";

// Generate and display the PayPal cart form
echo get_paypal_cart_form($items, $cart_order_id, $shipping, $tax);
?> 