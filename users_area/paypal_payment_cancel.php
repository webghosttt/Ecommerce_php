<?php
include('../includes/connect.php');
include('../functions/common_function.php');
session_start();

// Log the cancellation if needed
$user_ip = getIPAddress();
$date = date('Y-m-d H:i:s');

// You can log canceled transactions in a separate table if needed
// $log_cancel = "INSERT INTO payment_logs (ip_address, payment_method, status, date) VALUES ('$user_ip', 'PayPal', 'Canceled', '$date')";
// mysqli_query($con, $log_cancel);

// Redirect to checkout with message
echo "<script>alert('Payment was canceled. Your cart items are still available.'); window.location.href='../cart.php';</script>";
exit();
?> 