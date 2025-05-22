<?php
include('../includes/connect.php');
include('../includes/esewa_config.php');
include('../includes/esewa_helper.php');
include('../includes/paypal_config.php');
include('../includes/paypal_helper.php');
include('../includes/khalti_helper.php');
include('../functions/common_function.php');
session_start();

// Check if user is logged in
if(!isset($_SESSION['username'])) {
    echo "<script>alert('Please login to proceed to checkout'); window.location.href='user_login.php';</script>";
    exit();
}

// Get user information
$username = $_SESSION['username'];
$select_query = "SELECT * FROM `user_table` WHERE username = '$username'";
$result_query = mysqli_query($con, $select_query);
$user_data = mysqli_fetch_assoc($result_query);
$user_id = $user_data['user_id'] ?? 0;

// Calculate order total
$user_ip = getIPAddress();
$total_price = 0;
$cart_items = array();
$cart_query = "SELECT * FROM `cart_details` WHERE ip_address = '$user_ip'";
$result_cart = mysqli_query($con, $cart_query);
$count_cart = mysqli_num_rows($result_cart);

if($count_cart == 0) {
    echo "<script>alert('Your cart is empty. Please add items to cart before checkout.'); window.location.href='../index.php';</script>";
    exit();
}

// Add debug information
$debug_info = [];

while($row = mysqli_fetch_array($result_cart)) {
    $product_id = $row['product_id'];
    // Get quantity or default to 1 if column doesn't exist
    $quantity = isset($row['quantity']) && $row['quantity'] > 0 ? $row['quantity'] : 1;
    
    $select_products = "SELECT * FROM `products` WHERE product_id = '$product_id'";
    $result_products = mysqli_query($con, $select_products);
    
    while($row_product = mysqli_fetch_array($result_products)) {
        $product_price = $row_product['product_price'];
        $product_title = $row_product['product_title'];
        
        // Ensure product_price is a valid number
        $product_price = is_numeric($product_price) ? floatval($product_price) : 0;
        
        // Convert quantity to integer to ensure proper calculation
        $quantity_num = intval($quantity);
        
        // Calculate subtotal
        $subtotal = $product_price * $quantity_num;
        
        // Add to running total
        $total_price += $subtotal;
        
        // Collect debug information
        $debug_info[] = [
            'product_id' => $product_id,
            'product_title' => $product_title,
            'quantity' => $quantity_num,
            'price' => $product_price,
            'subtotal' => $subtotal
        ];
        
        // Add to cart items array
        $cart_items[] = array(
            'id' => $product_id,
            'name' => $product_title,
            'price' => $product_price,
            'quantity' => $quantity_num
        );
    }
}

// Ensure total_price is a valid positive number
$total_price = max(0, $total_price);

// Store debug info in session for troubleshooting if needed
$_SESSION['debug_cart_calculation'] = $debug_info;

// Generate invoice number
$invoice_number = 'INV_' . $user_id . '_' . time();
$_SESSION['invoice_number'] = $invoice_number;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - NepalBazar Store</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .checkout-container {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
        }
        .order-summary {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .shipping-info {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .payment-section {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .product-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .product-item:last-child {
            border-bottom: none;
        }
        .btn-khalti {
            background-color: #5C2D91;
            color: white !important;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
        }
        .btn-khalti:hover {
            background-color: #4A2275;
        }
    </style>
</head>
<body>
    <div class="container checkout-container my-5">
        <h1 class="text-center mb-4">Checkout</h1>
        
        <div class="order-summary">
            <h3>Order Summary <span class="badge bg-info float-end">Invoice #<?php echo $invoice_number; ?></span></h3>
            <div class="product-list mt-4">
                <?php foreach($cart_items as $item): ?>
                <div class="product-item">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5><?php echo $item['name']; ?></h5>
                            <p class="text-muted">Quantity: <?php echo $item['quantity']; ?></p>
                        </div>
                        <div class="col-md-4 text-end">
                            <p class="fw-bold">Rs. <?php echo $item['price'] * $item['quantity']; ?>/-</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="d-flex justify-content-between mt-4">
                    <h4>Total:</h4>
                    <h4>Rs. <?php echo $total_price; ?>/-</h4>
                </div>
            </div>
        </div>
        
        <div class="shipping-info">
            <h3>Shipping Information</h3>
            <div class="row mt-3">
                <div class="col-md-6">
                    <p><strong>Name:</strong> <?php echo $user_data['username']; ?></p>
                    <p><strong>Email:</strong> <?php echo $user_data['user_email']; ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Address:</strong> <?php echo $user_data['user_address']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $user_data['user_mobile']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="payment-section">
            <h3 class="mb-4">Select Payment Method</h3>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <img src="../image/esewa.png" alt="eSewa" style="max-width: 120px;" class="mb-3">
                            <h5>Pay with eSewa</h5>
                            <p>Safe and secure online payment</p>
                            <?php 
                            echo get_esewa_payment_form(
                                $total_price,
                                0,
                                $invoice_number,
                                ESEWA_MERCHANT_ID,
                                ESEWA_SUCCESS_URL,
                                ESEWA_FAILURE_URL,
                                ESEWA_SECRET_KEY
                            );
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Khalti Payment Option -->
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="bg-light p-3 mb-3 d-flex align-items-center justify-content-center" style="height: 120px;">
                                <h3 class="text-primary m-0" style="color: #5C2D91 !important;">Khalti</h3>
                            </div>
                            <h5>Pay with Khalti</h5>
                            <p>Quick and secure digital payment</p>
                            <?php
                            if (!function_exists('get_khalti_payment_button')) {
                                echo '<div class="alert alert-danger">Error: Khalti payment function not found</div>';
                            } else {
                                try {
                                    // Validate total price
                                    if ($total_price <= 0) {
                                        throw new Exception('Invalid order amount');
                                    }
                                    
                                    // Generate Khalti payment button
                                    $khalti_button = get_khalti_payment_button(
                                        $total_price,
                                        $invoice_number,
                                        'Order #' . $invoice_number
                                    );
                                    
                                    // Add error handling for Khalti SDK loading
                                    echo $khalti_button;
                                    echo "
                                    <script>
                                        window.addEventListener('load', function() {
                                            if (typeof KhaltiCheckout === 'undefined') {
                                                document.getElementById('khalti-payment-button-" . $invoice_number . "').style.display = 'none';
                                                document.getElementById('khalti-payment-button-" . $invoice_number . "').insertAdjacentHTML('afterend', 
                                                    '<div class=\"alert alert-danger mt-2\">Error: Khalti payment service is currently unavailable</div>'
                                                );
                                            }
                                        });
                                    </script>";
                                } catch (Exception $e) {
                                    echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" alt="PayPal" style="max-width: 120px;" class="mb-3">
                            <h5>Pay with PayPal</h5>
                            <p>Global secure payment service</p>
                            <?php
                            echo get_paypal_payment_form(
                                $total_price,
                                $invoice_number,
                                'Order #' . $invoice_number,
                                $user_id
                            );
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="bg-light p-3 mb-3 d-flex align-items-center justify-content-center" style="height: 120px;">
                                <h3 class="text-primary m-0">Cash on Delivery</h3>
                            </div>
                            <h5>Cash on Delivery</h5>
                            <p>Pay when you receive your order</p>
                            <a href="order.php?user_id=<?php echo $user_id; ?>&invoice_number=<?php echo $invoice_number; ?>" class="btn btn-primary w-100">Place Order</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="../cart.php" class="btn btn-outline-secondary">Back to Cart</a>
            <a href="../index.php" class="btn btn-outline-info">Continue Shopping</a>
        </div>
        
        <?php
        // Show debug information for admins (can be removed in production)
        if(isset($_GET['debug']) && $_GET['debug'] == 'true'): 
        ?>
        <div class="card mt-5">
            <div class="card-header bg-secondary text-white">
                <h4>Debug Information</h4>
            </div>
            <div class="card-body">
                <h5>Cart Calculation Details</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($debug_info as $item): ?>
                        <tr>
                            <td><?php echo $item['product_id']; ?></td>
                            <td><?php echo $item['product_title']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo $item['subtotal']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total:</strong></td>
                            <td><strong><?php echo $total_price; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                
                <h5 class="mt-4">Session and Request Information</h5>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Session Data</h6>
                        <pre><?php print_r($_SESSION); ?></pre>
                    </div>
                    <div class="col-md-6">
                        <h6>GET/POST Data</h6>
                        <pre>GET: <?php print_r($_GET); ?></pre>
                        <pre>POST: <?php print_r($_POST); ?></pre>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>