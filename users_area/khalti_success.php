<?php
include('../includes/connect.php');
include('../includes/khalti_helper.php');
session_start();

if (!isset($_GET['token']) || !isset($_GET['amount'])) {
    echo "<script>alert('Invalid payment data received'); window.location.href='checkout.php';</script>";
    exit();
}

$token = $_GET['token'];
$amount = $_GET['amount'];

// Verify the payment with Khalti
$response = verify_khalti_payment($token, $amount);

if (isset($response['error'])) {
    echo "<script>alert('Payment verification failed: " . addslashes($response['error']) . "'); window.location.href='checkout.php';</script>";
    exit();
}

if (isset($response['idx'])) {
    // Payment successful
    $user_id = $_SESSION['user_id'] ?? 0;
    $invoice_number = $_SESSION['invoice_number'] ?? '';
    $amount_paid = $amount / 100; // Convert paisa back to rupees
    $payment_mode = "Khalti";
    $order_date = date('Y-m-d H:i:s');
    $order_status = "Pending";

    // Insert order into database
    $insert_order = "INSERT INTO `user_orders` (user_id, amount, invoice_number, total_products, order_date, order_status, payment_mode) 
                     VALUES ($user_id, $amount_paid, '$invoice_number', 0, '$order_date', '$order_status', '$payment_mode')";
    
    if (mysqli_query($con, $insert_order)) {
        // Clear cart after successful order
        $delete_cart = "DELETE FROM `cart_details` WHERE ip_address='" . getIPAddress() . "'";
        mysqli_query($con, $delete_cart);
        
        echo "<script>alert('Payment successful! Your order has been placed.'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error saving order details. Please contact support.'); window.location.href='checkout.php';</script>";
    }
} else {
    echo "<script>alert('Payment verification failed. Please try again.'); window.location.href='checkout.php';</script>";
}
?> 