<?php
include "includes/connect.php";
include "functions/common_function.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NepalBazar - Your Shopping Cart</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            overflow-x: hidden;
            background-color: #f9fafb;
        }
        
        /* Navbar Styling */
        .main-navbar {
            background: linear-gradient(135deg, #0dcaf0, #0aa2c0) !important;
            padding: 0.75rem 1rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 120px;
            height: auto;
            transition: all 0.3s ease;
        }
        
        .logo:hover {
            transform: scale(1.05);
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 0.75rem 1.25rem !important;
            border-radius: 50px;
            margin: 0 0.2rem;
            transition: all 0.3s ease;
            position: relative;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }
        
        .nav-link::after {
            content: "";
            position: absolute;
            bottom: 10px;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after, .nav-link.active::after {
            width: 40%;
        }
        
        .cart-icon-container {
            position: relative;
            display: inline-block;
        }
        
        .cart-icon {
            font-size: 1.2rem;
            margin-right: 0.25rem;
        }
        
        .cart-badge {
            position: absolute;
            top: -10px;
            right: -5px;
            background-color: #ff6b6b;
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        .secondary-navbar {
            background: linear-gradient(135deg, #6c757d, #343a40) !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 2rem;
        }
        
        .secondary-navbar .nav-link {
            padding: 0.5rem 1rem !important;
            font-size: 0.9rem;
        }
        
        .user-welcome {
            display: flex;
            align-items: center;
        }
        
        .user-welcome i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        .auth-links {
            margin-left: auto;
            display: flex;
        }
        
        .auth-link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            margin-left: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        
        .auth-link i {
            margin-right: 0.5rem;
        }
        
        .auth-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateY(-2px);
        }
        
        .cart-container {
            padding: 2rem 0;
        }
        
        .cart-header {
            background-color: #fff;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
        }
        
        .cart-header h2 {
            color: #0dcaf0;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .cart-header p {
            color: #6c757d;
            margin-bottom: 0;
        }
        
        .cart-progress {
            max-width: 600px;
            margin: 1.5rem auto;
        }
        
        .progress-step {
            position: relative;
            text-align: center;
        }
        
        .step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #0dcaf0;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 1.25rem;
            position: relative;
            z-index: 2;
        }
        
        .step-text {
            font-size: 0.85rem;
            font-weight: 500;
            color: #6c757d;
        }
        
        .active .step-icon {
            background-color: #0aa2c0;
            box-shadow: 0 0 15px rgba(13, 202, 240, 0.5);
        }
        
        .active .step-text {
            color: #0aa2c0;
            font-weight: 700;
        }
        
        .cart-table-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .cart-table {
            margin-bottom: 0;
        }
        
        .cart-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
            border-bottom: none;
        }
        
        .cart_img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            border-radius: 8px;
            padding: 0.5rem;
            background-color: #f8f9fa;
            transition: transform 0.3s ease;
        }
        
        .cart_img:hover {
            transform: scale(1.1);
        }
        
        .product-title {
            font-weight: 600;
            color: #343a40;
            margin-bottom: 0.25rem;
        }
        
        .qty-input {
            max-width: 100px;
            padding: 0.5rem;
            border-radius: 8px;
            border: 1px solid #dfe3e8;
            text-align: center;
        }
        
        .price-text {
            font-weight: 700;
            color: #0dcaf0;
            font-size: 1.1rem;
        }
        
        .action-btn {
            border-radius: 50px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            color: white;
        }
        
        .update-btn {
            background-color: #0dcaf0;
        }
        
        .update-btn:hover {
            background-color: #0aa2c0;
            transform: translateY(-2px);
        }
        
        .remove-btn {
            background-color: #ff6b6b;
        }
        
        .remove-btn:hover {
            background-color: #ff4757;
            transform: translateY(-2px);
        }
        
        .cart-summary {
            background-color: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-top: 2rem;
        }
        
        .summary-title {
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f1f1;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }
        
        .summary-label {
            color: #6c757d;
        }
        
        .summary-value {
            font-weight: 600;
            color: #343a40;
        }
        
        .summary-total {
            font-weight: 700;
            color: #0dcaf0;
            font-size: 1.2rem;
        }
        
        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            gap: 1rem;
        }
        
        .action-continue, .action-checkout {
            flex: 1;
            border-radius: 8px;
            padding: 1rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .action-continue {
            background-color: #f8f9fa;
            color: #343a40;
            border: 1px solid #dfe3e8;
        }
        
        .action-continue:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
        }
        
        .action-checkout {
            background-color: #6c757d;
            color: white;
            border: 1px solid #6c757d;
        }
        
        .action-checkout:hover {
            background-color: #343a40;
            transform: translateY(-2px);
        }
        
        .empty-cart {
            text-align: center;
            padding: 3rem 1rem;
        }
        
        .empty-cart i {
            font-size: 5rem;
            color: #dfe3e8;
            margin-bottom: 1.5rem;
        }
        
        .empty-cart h3 {
            color: #343a40;
            margin-bottom: 1rem;
        }
        
        .empty-cart p {
            color: #6c757d;
            margin-bottom: 2rem;
        }
        
        .empty-cart .btn {
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .cart-actions {
                flex-direction: column;
            }
            
            .product-title {
                font-size: 0.9rem;
            }
            
            .cart-table th {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
<!-- Navbar -->
<div class="container-fluid p-0">
    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="container">
            <div class="logo-container">
                <a href="index.php">
                    <img src="./image/logo.png" alt="NepalBazar Logo" class="logo">
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="display_all.php">
                            <i class="fas fa-store me-1"></i>Shop
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="cart.php">
                            <div class="cart-icon-container">
                                <i class="fas fa-shopping-cart cart-icon"></i>
                                <span class="cart-badge"><?php cart_item(); ?></span>
                            </div>
                            Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">
                            <i class="fas fa-envelope me-1"></i>Contact
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex">
                    <?php if (!isset($_SESSION['username'])) { ?>
                    <a href="./users_area/user_registration.php" class="btn btn-outline-light me-2">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                    <a href="./users_area/user_login.php" class="btn btn-light">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                    <?php } else { ?>
                    <a href="./users_area/profile.php" class="btn btn-outline-light me-2">
                        <i class="fas fa-user me-1"></i>Profile
                    </a>
                    <a href="./users_area/logout.php" class="btn btn-light">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Calling cart function -->
    <?php cart(); ?>

    <!-- Secondary Navbar -->
    <div class="secondary-navbar py-2">
        <div class="container d-flex align-items-center">
            <div class="user-welcome">
                <?php
                if (!isset($_SESSION['username'])) {
                    echo "<i class='fas fa-user-circle'></i> Welcome Guest";
                } else {
                    echo "<i class='fas fa-user-circle'></i> Welcome " . $_SESSION['username'];
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Main Cart Section -->
    <div class="container cart-container">
        <!-- Cart Header -->
        <div class="cart-header">
            <h2><i class="fa-solid fa-shopping-cart me-2"></i>Your Shopping Cart</h2>
            <p>Review your items and proceed to checkout</p>
            
            <!-- Checkout Progress -->
            <div class="cart-progress mt-4">
                <div class="row">
                    <div class="col-4 progress-step active">
                        <div class="step-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="step-text">Cart</div>
                    </div>
                    <div class="col-4 progress-step">
                        <div class="step-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="step-text">Payment</div>
                    </div>
                    <div class="col-4 progress-step">
                        <div class="step-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="step-text">Confirmation</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cart Content -->
        <div class="row">
            <div class="col-lg-8">
                <form action="" method="post">
                    <?php
                    global $con;
                    $get_ip_add = getIPAddress();
                    $total_price = 0;

                    $cart_query = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip_add'";
                    $result = mysqli_query($con, $cart_query);
                    $result_count = mysqli_num_rows($result);
                    
                    if ($result_count > 0) {
                        echo '<div class="cart-table-container">
                                <table class="table cart-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Image</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Remove</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    
                        while ($row = mysqli_fetch_array($result)) {
                            $product_id = $row["product_id"];
                            $quantity = $row["quantity"] > 0 ? $row["quantity"] : 1;

                            $select_products = "SELECT * FROM `products` WHERE product_id='$product_id'";
                            $result_products = mysqli_query($con, $select_products);

                            while ($row_product_price = mysqli_fetch_array($result_products)) {
                                $product_price = $row_product_price["product_price"];
                                $product_title = $row_product_price["product_title"];
                                $product_image1 = $row_product_price["product_image1"];
                                $product_total = $product_price * $quantity;
                                $total_price += $product_total;
                                ?>
                                <tr>
                                    <td>
                                        <div class="product-title"><?php echo $product_title; ?></div>
                                    </td>
                                    <td>
                                        <img src="./image/<?php echo $product_image1; ?>" alt="" class="cart_img">
                                    </td>
                                    <td>
                                        <input type="number" name="qty[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>" min="1" class="form-control qty-input">
                                    </td>
                                    <td>
                                        <div class="price-text">Rs. <?php echo $product_total; ?>/-</div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="remove_item[]" value="<?php echo $product_id; ?>" class="form-check-input" id="remove_<?php echo $product_id; ?>">
                                            <label class="form-check-label" for="remove_<?php echo $product_id; ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit" class="action-btn update-btn mb-2" name="update_single[<?php echo $product_id; ?>]">
                                            <i class="fas fa-sync-alt me-1"></i> Update
                                        </button>
                                        <button type="submit" class="action-btn remove-btn" name="remove_cart">
                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        echo '</tbody>
                            </table>
                        </div>';
                    } else {
                        echo '<div class="empty-cart">
                                <i class="fas fa-shopping-cart"></i>
                                <h3>Your Cart is Empty</h3>
                                <p>Looks like you haven\'t added anything to your cart yet.</p>
                                <a href="display_all.php" class="btn btn-info">Continue Shopping</a>
                              </div>';
                    }
                    ?>
                    
                    <?php
                    if ($result_count > 0) {
                        echo '
                        <!-- Order Summary For Mobile -->
                        <div class="cart-summary d-lg-none">
                            <h4 class="summary-title">Order Summary</h4>
                            <div class="summary-item">
                                <div class="summary-label">Subtotal</div>
                                <div class="summary-value">Rs. '.$total_price.'/-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Shipping</div>
                                <div class="summary-value">Free</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Tax</div>
                                <div class="summary-value">Rs. 0/-</div>
                            </div>
                            <hr>
                            <div class="summary-item">
                                <div class="summary-label">Total</div>
                                <div class="summary-total">Rs. '.$total_price.'/-</div>
                            </div>
                            
                            <div class="cart-actions">
                                <a href="index.php" class="action-continue">
                                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                </a>
                                <a href="./users_area/checkout.php" class="action-checkout">
                                    Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>';
                    }
                    ?>
                    
                    <?php
                    // Update Cart Logic
                    if (isset($_POST['update_single'])) {
                        foreach ($_POST['update_single'] as $product_id => $value) {
                            if (isset($_POST['qty'][$product_id])) {
                                $new_quantity = (int)$_POST['qty'][$product_id];
                                $update_cart = "UPDATE `cart_details` SET quantity='$new_quantity' WHERE product_id='$product_id' AND ip_address='$get_ip_add'";
                                mysqli_query($con, $update_cart);
                                echo "<script>alert('Cart updated successfully!'); window.location.href='cart.php';</script>";
                            }
                        }
                    }

                    // Remove Item Logic
                    if (isset($_POST['remove_cart']) && isset($_POST['remove_item'])) {
                        foreach ($_POST['remove_item'] as $product_id) {
                            $delete_query = "DELETE FROM `cart_details` WHERE product_id='$product_id' AND ip_address='$get_ip_add'";
                            mysqli_query($con, $delete_query);
                            echo "<script>alert('Item removed successfully!'); window.location.href='cart.php';</script>";
                        }
                    }
                    ?>
                </form>
            </div>
            
            <?php if ($result_count > 0) { ?>
            <!-- Order Summary For Desktop -->
            <div class="col-lg-4 d-none d-lg-block">
                <div class="cart-summary">
                    <h4 class="summary-title">Order Summary</h4>
                    <div class="summary-item">
                        <div class="summary-label">Subtotal</div>
                        <div class="summary-value">Rs. <?php echo $total_price; ?>/-</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Shipping</div>
                        <div class="summary-value">Free</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Tax</div>
                        <div class="summary-value">Rs. 0/-</div>
                    </div>
                    <hr>
                    <div class="summary-item">
                        <div class="summary-label">Total</div>
                        <div class="summary-total">Rs. <?php echo $total_price; ?>/-</div>
                    </div>
                    
                    <div class="cart-actions">
                        <a href="index.php" class="action-continue">
                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                        </a>
                        <a href="./users_area/checkout.php" class="action-checkout">
                            Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Payment Methods -->
                <div class="cart-summary mt-4">
                    <h4 class="summary-title">We Accept</h4>
                    <div class="d-flex justify-content-between mt-3">
                        <img src="https://cdn-icons-png.flaticon.com/128/196/196578.png" alt="Visa" width="50">
                        <img src="https://cdn-icons-png.flaticon.com/128/196/196561.png" alt="MasterCard" width="50">
                        <img src="https://cdn-icons-png.flaticon.com/128/196/196565.png" alt="PayPal" width="50">
                        <img src="https://cdn-icons-png.flaticon.com/128/5968/5968220.png" alt="American Express" width="50">
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include "./includes/footer.php"; ?>
</div>

<!-- Bootstrap JS link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
