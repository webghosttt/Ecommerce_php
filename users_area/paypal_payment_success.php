<?php
include('../includes/connect.php');
include('../includes/paypal_config.php');
include('../includes/paypal_helper.php');
include('../functions/common_function.php');
session_start();

// Check if user is logged in
if(!isset($_SESSION['username'])) {
    echo "<script>alert('Please login to complete your purchase'); window.location.href='user_login.php';</script>";
    exit();
}

// Get user info
$username = $_SESSION['username'];
$select_query = "SELECT * FROM `user_table` WHERE username = '$username'";
$result_query = mysqli_query($con, $select_query);
$user_data = mysqli_fetch_assoc($result_query);
$user_id = $user_data['user_id'] ?? 0;

// Check if PayPal transaction data is received
if(isset($_GET['invoice']) && isset($_GET['tx'])) {
    $invoice_number = mysqli_real_escape_string($con, $_GET['invoice']);
    $paypal_transaction_id = mysqli_real_escape_string($con, $_GET['tx']);
    
    // Get cart items
    $user_ip = getIPAddress();
    $cart_query = "SELECT * FROM `cart_details` WHERE ip_address = '$user_ip'";
    $cart_result = mysqli_query($con, $cart_query);
    
    $total_price = 0;
    
    while($row = mysqli_fetch_array($cart_result)) {
        $product_id = $row['product_id'];
        $quantity = isset($row['quantity']) ? $row['quantity'] : 1;
        
        $select_products = "SELECT * FROM `products` WHERE product_id = '$product_id'";
        $result_products = mysqli_query($con, $select_products);
        
        while($row_product = mysqli_fetch_array($result_products)) {
            $product_price = $row_product['product_price'];
            $product_title = $row_product['product_title'];
            
            // Calculate subtotal
            $subtotal = $product_price * $quantity;
            $total_price += $subtotal;
            
            // Insert order
            $insert_order = "INSERT INTO `user_orders` (user_id, amount_due, invoice_number, total_products, order_date, order_status, payment_mode, payment_reference) 
                VALUES ($user_id, $subtotal, '$invoice_number', $quantity, NOW(), 'pending', 'PayPal', '$paypal_transaction_id')";
            $result_insert = mysqli_query($con, $insert_order);
            
            // Insert into pending orders if needed
            $insert_pending = "INSERT INTO `orders_pending` (user_id, invoice_number, product_id, quantity, order_status) 
                VALUES ($user_id, '$invoice_number', $product_id, $quantity, 'pending')";
            $result_pending = mysqli_query($con, $insert_pending);
        }
    }
    
    // Clear cart
    $empty_cart = "DELETE FROM `cart_details` WHERE ip_address = '$user_ip'";
    $result_empty = mysqli_query($con, $empty_cart);
    
    // Redirect to order confirmation
    echo "<script>alert('Order placed successfully!'); window.location.href='profile.php?my_orders';</script>";
    exit();
} else {
    // Redirect to home if no PayPal data
    echo "<script>alert('Payment verification failed'); window.location.href='../index.php';</script>";
    exit();
}
?> 