<?php
include('../includes/connect.php');
include('../includes/esewa_config.php');
include('../functions/common_function.php');
session_start();

// In the new API, the response might be Base64 encoded
$encoded_response = $_GET['data'] ?? '';
$error_message = 'Payment process was not completed';

if(!empty($encoded_response)) {
    // Try to decode the response
    $decoded_response = base64_decode($encoded_response);
    $response_data = json_decode($decoded_response, true);
    
    if($response_data && isset($response_data['status'])) {
        $status = $response_data['status'];
        $transaction_uuid = $response_data['transaction_uuid'] ?? 'Unknown';
        
        // Log failure information if needed
        $error_message = "Payment failed with status: " . $status;
        
        // You can log this information to a database table if needed
        /*
        $insert_failure_log = "INSERT INTO `payment_failures` (transaction_id, status, date) 
                             VALUES ('$transaction_uuid', '$status', NOW())";
        mysqli_query($con, $insert_failure_log);
        */
    }
} else {
    // Handle old-style parameters or direct redirects
    $transaction_uuid = $_GET['pid'] ?? 'Unknown';
    $error_message = $_GET['q'] ?? 'Payment process was not completed';
}

// Redirect with appropriate message
echo "<script>
    alert('$error_message. Please try again or select a different payment method.');
    window.location.href='../cart.php';
</script>";
?> 