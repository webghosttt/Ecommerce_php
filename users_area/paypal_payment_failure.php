<?php
include('../includes/connect.php');
include('../functions/common_function.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    echo "<script>window.open('user_login.php','_self')</script>";
    exit();
}

// Get user details
$user_email = $_SESSION['user_email'];
$get_user = "SELECT * FROM user_table WHERE user_email='$user_email'";
$result = mysqli_query($con, $get_user);
$row_fetch = mysqli_fetch_assoc($result);
$user_id = $row_fetch['user_id'];
$user_name = $row_fetch['username'];

// Update order status in the database to 'Failed'
$update_order = "UPDATE user_orders SET order_status='Failed' WHERE user_id=$user_id AND order_status='pending'";
$result_orders = mysqli_query($con, $update_order);

// Display message and redirect
echo "<script>alert('Payment failed or was cancelled. Please try again or choose a different payment method.')</script>";
echo "<script>window.open('profile.php?my_orders','_self')</script>";
?> 