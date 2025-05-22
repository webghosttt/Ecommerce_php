<?php
include('../includes/connect.php');
include('../includes/paypal_config.php');
include('../includes/paypal_helper.php');
include('../functions/common_function.php');

// Read POST data
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$post_data = array();

foreach ($raw_post_array as $keyval) {
    $keyval = explode('=', $keyval);
    if (count($keyval) == 2) {
        $post_data[$keyval[0]] = urldecode($keyval[1]);
    }
}

// Verify the payment
if (verify_paypal_ipn($post_data)) {
    // Get PayPal transaction data
    $payment_status = $post_data['payment_status'] ?? '';
    $txn_id = $post_data['txn_id'] ?? '';
    $receiver_email = $post_data['receiver_email'] ?? '';
    $payer_email = $post_data['payer_email'] ?? '';
    $invoice = $post_data['invoice'] ?? '';
    $payment_amount = $post_data['mc_gross'] ?? 0;
    $payment_currency = $post_data['mc_currency'] ?? '';
    $custom = $post_data['custom'] ?? '';
    
    // Validate required fields
    if (empty($payment_status) || empty($txn_id) || empty($invoice)) {
        exit();
    }
    
    // Check that receiver_email is your PayPal business email
    if ($receiver_email != PAYPAL_BUSINESS_EMAIL) {
        exit();
    }
    
    // Check payment status
    if ($payment_status == 'Completed') {
        // Payment is complete - update order status in the database
        $user_id = $custom; // This should be the user_id passed from the payment form
        
        // Check if transaction already processed
        $check_txn = "SELECT * FROM `user_orders` WHERE payment_reference = '$txn_id'";
        $result_txn = mysqli_query($con, $check_txn);
        
        if (mysqli_num_rows($result_txn) == 0) {
            // Update order status
            $update_query = "UPDATE `user_orders` SET order_status = 'complete', payment_reference = '$txn_id' 
                            WHERE invoice_number = '$invoice' AND user_id = '$user_id'";
            mysqli_query($con, $update_query);
            
            // You can also update pending_orders table if needed
            $update_pending = "UPDATE `orders_pending` SET order_status = 'complete' 
                              WHERE invoice_number = '$invoice' AND user_id = '$user_id'";
            mysqli_query($con, $update_pending);
            
            // Log successful payment
            $log_payment = "INSERT INTO `payment_logs` (txn_id, payment_method, amount, status, date) 
                           VALUES ('$txn_id', 'PayPal', '$payment_amount', 'Completed', NOW())";
            mysqli_query($con, $log_payment);
        }
    }
    
    // For other payment statuses (Pending, Failed, etc.), you can handle accordingly
} else {
    // IPN validation failed - log for investigation
    $error_log = "INSERT INTO `payment_logs` (payment_method, status, date, notes) 
                 VALUES ('PayPal', 'Invalid IPN', NOW(), 'IPN verification failed')";
    mysqli_query($con, $error_log);
}
?> 