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
    <title>Ecommerce Website-Cart details</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            overflow-x: hidden;
        }

        .cart_img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<div class="container-fluid p-0">
    <!-- First Child -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container-fluid">
            <img src="./image/logo.png" alt="" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="display_all.php">Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="./users_area/user_registration.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Calling cart function -->
    <?php cart(); ?>

    <!-- Second Child -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <ul class="navbar-nav me-auto">
            <?php
            if (!isset($_SESSION['username'])) {
                echo "<li class='nav-item'><a class='nav-link' href='#'>Welcome Guest</a></li>";
            } else {
                echo "<li class='nav-item'><a class='nav-link' href='#'>Welcome " . $_SESSION['username'] . "</a></li>";
            }

            if (!isset($_SESSION['username'])) {
                echo "<li class='nav-item'><a class='nav-link' href='./users_area/user_login.php'>Login</a></li>";
            } else {
                echo "<li class='nav-item'><a class='nav-link' href='./users_area/logout.php'>Logout</a></li>";
            }
            ?>
        </ul>
    </nav>

    <!-- Third Child -->
    <div class="bg-light">
        <h3 class="text-center">NepalBazar Store</h3>
        <p class="text-center">Collaborating for a Better Shopping Experience</p>
    </div>

    <!-- Cart Table and Subtotal -->
    <div class="container">
        <div class="row">
            <form action="" method="post">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Product Title</th>
                            <th>Product Image</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Remove</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        global $con;
                        $get_ip_add = getIPAddress();
                        $total_price = 0;

                        $cart_query = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip_add'";
                        $result = mysqli_query($con, $cart_query);

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
                                    <td><?php echo $product_title; ?></td>
                                    <td><img src="./image/<?php echo $product_image1; ?>" alt="" class="cart_img"></td>
                                    <td>
                                        <input type="number" name="qty[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>" class="form-input w-50">
                                    </td>
                                    <td><?php echo $product_total; ?>/-</td>
                                    <td><input type="checkbox" name="remove_item[]" value="<?php echo $product_id; ?>"></td>
                                    <td>
                                        <input type="submit" value="Update" class="bg-info px-3 py-2 border-0 mx-3" name="update_single[<?php echo $product_id; ?>]">
                                        <input type="submit" value="Remove" class="bg-danger px-3 py-2 border-0 mx-3" name="remove_cart">
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Subtotal and Buttons -->
                <div class="d-flex mb-3">
                    <h4 class="px-3">Sub-total: <strong class="text-info"><?php echo $total_price; ?>/-</strong></h4>
                    <a href="index.php"><button type="button" class="bg-info px-3 py-2 border-0 mx-3">Continue Shopping</button></a>
                    <a href="./users_area/checkout.php" class="text-light"><button type="button" class="bg-secondary px-3 py-2 border-0 text-light">Checkout</button></a>
                </div>

                <!-- Update Cart Logic -->
                <?php
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
    </div>

    <!-- Include Footer -->
    <?php include "./includes/footer.php"; ?>
</div>

<!-- Bootstrap JS link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
