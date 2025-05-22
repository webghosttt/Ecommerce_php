<?php
include('../includes/connect.php');
include('../functions/common_function.php');
include('../includes/esewa_config.php');
include('../includes/esewa_helper.php');
include('../includes/paypal_config.php');
include('../includes/paypal_helper.php');
include('../includes/khalti_config.php');
include('../includes/khalti_helper.php');
session_start();

// Debug information
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get payment details from URL
$invoice_number = $_GET['invoice_number'] ?? '';
$amount = $_GET['amount'] ?? 0;

// Get user info
$user_ip = getIPAddress();
$get_user = "SELECT * FROM user_table WHERE user_ip='$user_ip'";
$result = mysqli_query($con, $get_user);
$run_query = mysqli_fetch_array($result);
$user_id = $run_query['user_id'];

// Generate order ID
$order_id = "ORD_" . time() . "_" . $user_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }
        .payment-option {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            background-color: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .payment-option:hover {
            border-color: #007bff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .logo-container {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .payment-logo {
            max-height: 60px;
            max-width: 100%;
            object-fit: contain;
        }
        .payment-title {
            font-size: 22px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 10px;
        }
        .payment-description {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .btn-payment {
            display: block;
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-esewa {
            background-color: #60BB46;
            color: white;
            border: none;
        }
        .btn-esewa:hover {
            background-color: #4fa13a;
            color: white;
        }
        .btn-khalti {
            background-color: #5C2D91;
            color: white !important;
            border: none;
        }
        .btn-khalti:hover {
            background-color: #4A2275;
            color: white !important;
        }
        .btn-paypal {
            background-color: #0070BA;
            color: white;
            border: none;
        }
        .btn-paypal:hover {
            background-color: #005ea6;
            color: white;
        }
        .btn-cod {
            background-color: #007bff;
            color: white;
            border: none;
            text-decoration: none;
        }
        .btn-cod:hover {
            background-color: #0069d9;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Select Payment Method</h1>
        
        <div class="row">
            <!-- eSewa Payment Option -->
            <div class="col-md-3">
                <div class="payment-option">
                    <div class="logo-container">
                        <img src="https://esewa.com.np/common/images/esewa_logo.png" alt="eSewa Logo" class="payment-logo">
                    </div>
                    <h3 class="payment-title">Pay with eSewa</h3>
                    <p class="payment-description">Safe and secure online payment</p>
                    
                    <?php
                    // Create a custom button that will be styled
                    $esewa_form = get_esewa_payment_form(
                        $total_amount, // amount
                        0, // tax_amount
                        $transaction_uuid, // transaction_id
                        ESEWA_MERCHANT_ID, // merchant_code
                        ESEWA_SUCCESS_URL, // success_url
                        ESEWA_FAILURE_URL, // failure_url
                        ESEWA_SECRET_KEY // secret_key
                    );
                    
                    // Replace the default button with our styled button
                    $esewa_form = str_replace('<button type="submit" class="btn btn-success">Pay with eSewa</button>', 
                                             '<button type="submit" class="btn-payment btn-esewa">Pay with eSewa</button>', 
                                             $esewa_form);
                    
                    echo $esewa_form;
                    ?>
                </div>
            </div>
            
            <!-- Khalti Payment Option -->
            <div class="col-md-3 mb-4">
                <div class="payment-option">
                    <div class="logo-container">
                        <img src="https://raw.githubusercontent.com/khalti/khalti-sdk-web/master/assets/khalti_logo.png" alt="Khalti Logo" class="payment-logo">
                    </div>
                    <h3 class="payment-title">Pay with Khalti</h3>
                    <p class="payment-description">Quick and secure digital payment</p>
                    <?php
                    if (!function_exists('get_khalti_payment_button')) {
                        echo '<div class="alert alert-danger">Error: Khalti payment function not found. Please check includes.</div>';
                    } else {
                        try {
                            echo get_khalti_payment_button(
                                $amount,
                                $invoice_number,
                                'Invoice #' . $invoice_number
                            );
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            
            <!-- PayPal Payment Option -->
            <div class="col-md-3">
                <div class="payment-option">
                    <div class="logo-container">
                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" alt="PayPal Logo" class="payment-logo">
                    </div>
                    <h3 class="payment-title">Pay with PayPal</h3>
                    <p class="payment-description">Global secure payment service</p>
                    
                    <?php
                    // Generate order ID for PayPal
                    $paypal_order_id = 'ORDER-' . $user_id . '-' . time();
                    
                    // Create a custom PayPal button
                    $paypal_form = get_paypal_payment_form(
                        $total_amount, // amount
                        $paypal_order_id, // order_id
                        'Your Order #' . $paypal_order_id, // product_name
                        $user_id // custom_field
                    );
                    
                    // Replace the default button with our styled button
                    $paypal_form = str_replace('<button type="submit" class="btn btn-primary">Pay with PayPal</button>', 
                                              '<button type="submit" class="btn-payment btn-paypal">Pay with PayPal</button>', 
                                              $paypal_form);
                    
                    echo $paypal_form;
                    ?>
                </div>
            </div>
            
            <!-- Cash on Delivery Option -->
            <div class="col-md-3">
                <div class="payment-option">
                    <div class="logo-container">
                        <i class="fas fa-money-bill-wave fa-3x text-primary"></i>
                    </div>
                    <h3 class="payment-title">Cash on Delivery</h3>
                    <p class="payment-description">Pay when you receive your order</p>
                    
                    <a href="order.php?user_id=<?php echo $user_id ?>" class="btn-payment btn-cod">Place Order</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>