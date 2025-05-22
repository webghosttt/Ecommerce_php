<?php
include('./includes/connect.php');
include('./includes/khalti_helper.php');

if (isset($_GET['token']) && isset($_GET['amount'])) {
    $token = $_GET['token'];
    $amount = $_GET['amount'];
    
    // Verify the payment
    $response = verify_khalti_payment($token, $amount);
    
    if (isset($response['idx'])) {
        // Payment successful
        echo "<h1>Payment Successful!</h1>";
        echo "<p>Transaction ID: " . $response['idx'] . "</p>";
        echo "<p>Amount: NPR " . ($amount/100) . "</p>";
        // You can add database operations here to update order status
    } else {
        // Payment failed
        echo "<h1>Payment Failed</h1>";
        echo "<p>Error: " . (isset($response['error']) ? $response['error'] : 'Unknown error') . "</p>";
    }
} else {
    echo "<h1>Invalid Request</h1>";
    echo "<p>Required parameters are missing.</p>";
}
?> 