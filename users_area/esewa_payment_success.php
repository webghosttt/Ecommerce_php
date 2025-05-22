<?php
include('../includes/connect.php');
include('../includes/esewa_config.php');
include('../functions/common_function.php');
session_start();

// In the new API, the response is Base64 encoded
$encoded_response = $_GET['data'] ?? '';

if(empty($encoded_response)) {
    echo "<script>alert('Invalid response from eSewa!'); window.location.href='../index.php';</script>";
    exit();
}

// Decode the response
$decoded_response = base64_decode($encoded_response);
$response_data = json_decode($decoded_response, true);

// Check if we have a valid response
if(!$response_data || !isset($response_data['status']) || !isset($response_data['transaction_uuid'])) {
    echo "<script>alert('Invalid or malformed response from eSewa!'); window.location.href='../cart.php';</script>";
    exit();
}

// Get parameters from eSewa callback
$transaction_code = $response_data['transaction_code'] ?? 'Unknown';
$status = $response_data['status'] ?? 'UNKNOWN';
$total_amount = $response_data['total_amount'] ?? '0';
$transaction_uuid = $response_data['transaction_uuid'] ?? 'Unknown';
$product_code = $response_data['product_code'] ?? 'Unknown';

// Clean up the total_amount value (removing commas)
$total_amount = str_replace(',', '', $total_amount);

// Verify signature if included in response
if(isset($response_data['signature']) && isset($response_data['signed_field_names'])) {
    $received_signature = $response_data['signature'];
    $signed_field_names = explode(',', $response_data['signed_field_names']);
    
    // Build the message to verify
    $message_parts = [];
    foreach($signed_field_names as $field) {
        if(isset($response_data[$field])) {
            $message_parts[] = $response_data[$field];
        }
    }
    
    $message = implode(',', $message_parts);
    $calculated_signature = base64_encode(hash_hmac('sha256', $message, ESEWA_SECRET_KEY, true));
    
    if($received_signature !== $calculated_signature) {
        echo "<script>alert('Signature verification failed! This could be a fraudulent attempt.'); window.location.href='../cart.php';</script>";
        exit();
    }
}

// Get user info
$user_ip = getIPAddress();
$get_user = "SELECT * FROM `user_table` WHERE user_ip='$user_ip'";
$result = mysqli_query($con, $get_user);
$run_query = mysqli_fetch_array($result);
$user_id = $run_query['user_id'] ?? 0;

// Process the order if payment is successful
if($status === 'COMPLETE') {
    // Get cart items
    $cart_query = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
    $cart_result = mysqli_query($con, $cart_query);
    
    // If we have cart items
    if(mysqli_num_rows($cart_result) > 0) {
        // Insert into orders table
        $insert_order = "INSERT INTO `user_orders` (user_id, amount_due, invoice_number, total_products, order_date, order_status, payment_mode, payment_reference) 
                         VALUES ('$user_id', '$total_amount', '$transaction_uuid', 0, NOW(), 'Complete', 'eSewa', '$transaction_code')";
        $result_orders = mysqli_query($con, $insert_order);
        
        if($result_orders) {
            // Get order ID
            $order_id_query = "SELECT order_id FROM `user_orders` WHERE invoice_number='$transaction_uuid'";
            $result_order_id = mysqli_query($con, $order_id_query);
            $row_order = mysqli_fetch_assoc($result_order_id);
            $order_id_db = $row_order['order_id'] ?? 0;
            
            // Count total products for this order
            $total_products = 0;
            
            // Insert each cart item as an order item and clear cart
            while($row_cart = mysqli_fetch_array($cart_result)) {
                $product_id = $row_cart['product_id'];
                $quantity = $row_cart['quantity'] ?? 1;
                $total_products++;
                
                // Insert into order items
                $insert_order_item = "INSERT INTO `orders_pending` (user_id, invoice_number, product_id, quantity, order_status) 
                                     VALUES ('$user_id', '$transaction_uuid', '$product_id', '$quantity', 'Complete')";
                mysqli_query($con, $insert_order_item);
                
                // Update product stock if you have such functionality
                // mysqli_query($con, "UPDATE `products` SET product_stock = product_stock - $quantity WHERE product_id='$product_id'");
            }
            
            // Update total products count
            mysqli_query($con, "UPDATE `user_orders` SET total_products='$total_products' WHERE order_id='$order_id_db'");
            
            // Clear cart
            mysqli_query($con, "DELETE FROM `cart_details` WHERE ip_address='$user_ip'");
            
            // Success message and redirect
            echo "<script>alert('Payment successful! Your order has been placed.'); window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Failed to create order. Please try again.'); window.location.href='../cart.php';</script>";
        }
    } else {
        echo "<script>alert('Your cart is empty!'); window.location.href='../index.php';</script>";
    }
} else {
    echo "<script>alert('Payment was not completed. Status: " . $status . "'); window.location.href='../cart.php';</script>";
}
?> 