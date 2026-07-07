<?php
include('../includes/connect.php');
include('../functions/common_function.php');
session_start();

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $select_data = "SELECT * FROM `user_orders` WHERE order_id=$order_id";
    $result = mysqli_query($con, $select_data);
    $row_fetch = mysqli_fetch_assoc($result);
    $invoice_number = $row_fetch['invoice_number'];
    $amount_due = $row_fetch['amount_due'];
}

if (isset($_POST['confirm_payment'])) {
    $invoice_number = $_POST['invoice_number'];
    $amount = $_POST['amount'];
    $payment_mode = $_POST['payment_mode'];

    // Validate payment mode
    if ($payment_mode == "Select Payment Mode") {
        die("<h3 class='text-center text-danger'>Please select a valid payment mode.</h3>");
    }

    // Insert into database
    $insert_query = "INSERT INTO `user_payments` (order_id, invoice_number, amount, payment_mode) 
                     VALUES ('$order_id', '$invoice_number', '$amount', '$payment_mode')";
    $result = mysqli_query($con, $insert_query);

    if ($result) {
        echo "<h3 class='text-center text-light'>Successfully completed the payment</h3>";
        echo "<script>window.open('profile.php?my_orders', '_self')</script>";
    } else {
        die("<h3 class='text-center text-danger'>Error: " . mysqli_error($con) . "</h3>");
    }
    $update_orders = "UPDATE `user_orders` SET order_status='Complete' WHERE order_id=$order_id";
    $result_orders = mysqli_query($con, $update_orders);

    if ($payment_mode == 'Khalti') {
        // Redirect to Khalti payment page
        echo "<script>window.location.href='payment.php?invoice_number=$invoice_number&amount=$amount';</script>";
    } else if ($payment_mode == 'Esewa') {
        // Redirect to eSewa payment page
        echo "<script>window.location.href='payment.php?invoice_number=$invoice_number&amount=$amount';</script>";
    } else if ($payment_mode == 'Cash on delivery') {
        echo "<script>window.location.href='order.php?user_id=$user_id';</script>";
    } else {
        echo "<script>window.location.href='order.php?user_id=$user_id';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --primary-color: #5D87FF;
            --secondary-color: #49BEFF;
            --bg-gradient: linear-gradient(135deg, rgba(73, 93, 140, 0.85), rgba(75, 110, 168, 0.85));
            --card-bg: #ffffff;
            --border-radius: 12px;
            --box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-image: var(--bg-gradient), url('../image/payment-bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .payment-container {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 3rem;
            width: 100%;
            max-width: 600px;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }
        
        .payment-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }
        
        .payment-header {
            margin-bottom: 2.5rem;
            text-align: center;
        }
        
        .payment-header h1 {
            color: #333;
            font-weight: 600;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .payment-header p {
            color: #6c757d;
            font-size: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            animation: slideInUp 0.5s ease-out forwards;
            opacity: 0;
        }
        
        .form-group:nth-child(1) {
            animation-delay: 0.2s;
        }
        
        .form-group:nth-child(2) {
            animation-delay: 0.4s;
        }
        
        .form-group:nth-child(3) {
            animation-delay: 0.6s;
        }
        
        .form-group:nth-child(4) {
            animation-delay: 0.8s;
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control, .form-select {
            padding: 0.85rem 1rem;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(93, 135, 255, 0.25);
        }
        
        .form-control[readonly] {
            background-color: #f8f9fa;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ced4da;
            color: #495057;
        }
        
        .btn-payment {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.85rem 2rem;
            font-weight: 500;
            transition: var(--transition);
            width: 100%;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .btn-payment::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .btn-payment:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(93, 135, 255, 0.3);
        }
        
        .btn-payment:hover::before {
            left: 100%;
        }
        
        .icon-container {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            animation: bounceIn 1s ease-out;
        }
        
        .payment-icon {
            font-size: 2.2rem;
            color: var(--primary-color);
            background: linear-gradient(145deg, #f5f7ff, #e2e6f0);
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 8px 8px 15px #d1d9e6, -8px -8px 15px #ffffff;
            position: relative;
            z-index: 1;
        }
        
        .payment-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(to right bottom, var(--primary-color), var(--secondary-color));
            opacity: 0.2;
            z-index: -1;
        }
        
        .payment-methods {
            display: flex;
            justify-content: center;
            gap: 1.2rem;
            margin-top: 2rem;
            animation: fadeIn 1.5s ease-out;
        }
        
        .payment-methods i {
            font-size: 1.8rem;
            color: #6c757d;
            transition: var(--transition);
        }
        
        .payment-methods i:hover {
            color: var(--primary-color);
            transform: scale(1.1);
        }
        
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1.5rem;
            color: #6c757d;
            font-size: 0.85rem;
            animation: fadeIn 2s ease-out;
        }
        
        .security-badge i {
            margin-right: 0.5rem;
            color: #28a745;
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        @keyframes slideInUp {
            0% { 
                opacity: 0;
                transform: translateY(20px);
            }
            100% { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .payment-container {
                padding: 2rem;
            }
            
            .payment-header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="icon-container">
            <div class="payment-icon">
                <i class="fas fa-credit-card"></i>
            </div>
        </div>
        <div class="payment-header">
            <h1>Confirm Payment</h1>
            <p>Complete your purchase by confirming payment details</p>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <label class="form-label">Invoice Number</label>
                <input type="text" class="form-control" name="invoice_number" value="<?php echo $invoice_number ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Amount</label>
                <div class="input-group">
                    <span class="input-group-text">₹</span>
                    <input type="text" class="form-control" name="amount" value="<?php echo $amount_due ?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Payment Method</label>
                <select name="payment_mode" id="payment_mode" class="form-select">
                    <option>Select Payment Mode</option>
                    <!-- <option>Esewa</option>
                    <option>Khalti</option> -->
                    <option>Cash on delivery</option>
                    <option>Payoffline</option>
                </select>
            </div>
            <div class="form-group mb-0">
                <button type="submit" class="btn-payment" name="confirm_payment">Confirm Payment</button>
            </div>
        </form>
        <div class="payment-methods mt-4 text-center">
            <i class="fab fa-cc-visa"></i>
            <i class="fab fa-cc-mastercard"></i>
            <i class="fab fa-cc-amex"></i>
            <i class="fab fa-cc-paypal"></i>
        </div>
    </div>
</body>
</html>
