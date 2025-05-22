<?php
include('../includes/connect.php');
include('../functions/common_function.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header('location:user_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NepalBazar - My Account</title>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <style>
        :root {
            --primary-color: #5D87FF;
            --secondary-color: #49BEFF;
            --bg-light: #F9FAFB;
            --card-bg: #ffffff;
            --border-radius: 10px;
            --box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            min-height: 100vh;
        }
        
        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 2rem 0;
            margin-bottom: 2rem;
            color: white;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }
        
        .profile-img-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }
        
        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: var(--box-shadow);
        }
        
        .profile-img-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: var(--card-bg);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            border: 2px solid white;
        }
        
        .edit-profile-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 1rem;
        }
        
        .sidebar {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            position: sticky;
            top: 1rem;
        }
        
        .sidebar-item {
            padding: 1rem 1.5rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            border-radius: var(--border-radius);
            margin-bottom: 0.25rem;
        }
        
        .sidebar-item:hover, .sidebar-item.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .sidebar-item:hover a, .sidebar-item.active a {
            color: white;
        }
        
        .sidebar-item i {
            margin-right: 0.75rem;
            width: 1.5rem;
            text-align: center;
        }
        
        .sidebar-item a {
            color: #555;
            text-decoration: none;
            font-weight: 500;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .sidebar-item .badge {
            font-size: 0.7rem;
            padding: 0.35rem 0.65rem;
        }
        
        .content-area {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2rem;
        }
        
        .status-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            padding: 1.5rem;
            height: 100%;
            border-left: 5px solid var(--primary-color);
        }
        
        .status-card:hover {
            transform: translateY(-5px);
        }
        
        .status-card i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .status-card h4 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .status-card p {
            color: #666;
            margin-bottom: 0;
        }
        
        .order-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        
        .order-card:hover {
            transform: translateY(-5px);
        }
        
        .order-card .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        
        .order-card .card-body {
            padding: 1.5rem;
        }
        
        .order-detail {
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .order-detail .label {
            font-weight: 500;
            color: #555;
        }
        
        .order-detail .value {
            font-weight: 600;
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-danger {
            background-color: #FF5050;
            border-color: #FF5050;
        }
        
        .account-form .form-control {
            padding: 0.75rem 1rem;
            border-radius: var(--border-radius);
        }
        
        .account-form .form-label {
            font-weight: 500;
            color: #555;
        }
        
        .divider {
            width: 100%;
            height: 1px;
            background-color: #dee2e6;
            margin: 2rem 0;
        }
        
        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="container-fluid p-0">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="../index.php">
                    <img src="../image/logo.png" alt="NepalBazar Logo" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../display_all.php">
                                <i class="fas fa-store me-1"></i>Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="profile.php">
                                <i class="fas fa-user-circle me-1"></i>My Account
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../cart.php">
                                <i class="fa-solid fa-cart-shopping me-1"></i>Cart
                                <span class="badge bg-danger rounded-pill"><?php cart_item(); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-money-bill-wave me-1"></i>Total: Rs. <?php total_cart_price(); ?>/-
                            </a>
                        </li>
                    </ul>
                    <form class="d-flex search-form" action="../search_product.php" method="get">
                        <input class="form-control" type="search" placeholder="Search products..." aria-label="Search" name="search_data">
                        <button type="submit" class="btn btn-outline-light" name="search_data_product">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Welcome Banner -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user me-1"></i>Welcome <?php echo $_SESSION['username']; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-auto text-center text-md-start mb-4 mb-md-0">
                        <div class="profile-img-wrapper">
                            <?php
                            $username = $_SESSION['username'];
                            $user_query = "SELECT * FROM `user_table` WHERE username='$username'";
                            $result = mysqli_query($con, $user_query);
                            $row = mysqli_fetch_array($result);
                            $user_image = $row['user_image'];
                            
                            echo "<img src='./user_images/$user_image' class='profile-img' alt='Profile'>";
                            ?>
                            <a href="profile.php?edit_account" class="profile-img-badge">
                                <i class="fas fa-pen"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md">
                        <h2 class="mb-1"><?php echo $_SESSION['username']; ?></h2>
                        <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i><?php echo $row['user_address']; ?></p>
                    </div>
                    <div class="col-md-auto mt-3 mt-md-0 text-center text-md-end">
                        <a href="../index.php" class="btn btn-light me-2">
                            <i class="fas fa-shopping-bag me-1"></i>Continue Shopping
                        </a>
                        <a href="logout.php" class="btn btn-outline-light">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container py-4">
            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="sidebar p-3">
                        <?php
                        $active_section = "";
                        if(isset($_GET['edit_account'])) {
                            $active_section = "edit_account";
                        } else if(isset($_GET['my_orders'])) {
                            $active_section = "my_orders";
                        } else if(isset($_GET['delete_account'])) {
                            $active_section = "delete_account";
                        } else {
                            $active_section = "dashboard";
                        }
                        ?>
                        
                        <div class="sidebar-item <?php echo ($active_section == "dashboard") ? "active" : ""; ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <a href="profile.php">Dashboard</a>
                        </div>
                        
                        <div class="sidebar-item <?php echo ($active_section == "my_orders") ? "active" : ""; ?>">
                            <i class="fas fa-shopping-bag"></i>
                            <a href="profile.php?my_orders">
                                My Orders
                                <?php
                                $username = $_SESSION['username'];
                                $user_id_query = "SELECT user_id FROM `user_table` WHERE username='$username'";
                                $user_id_result = mysqli_query($con, $user_id_query);
                                $user_id_row = mysqli_fetch_array($user_id_result);
                                $user_id = $user_id_row['user_id'];
                                
                                $pending_orders_query = "SELECT COUNT(*) as count FROM `user_orders` WHERE user_id=$user_id AND order_status='pending'";
                                $pending_result = mysqli_query($con, $pending_orders_query);
                                $pending_count = mysqli_fetch_array($pending_result)['count'];
                                
                                if($pending_count > 0) {
                                    echo "<span class='badge bg-danger'>$pending_count</span>";
                                }
                                ?>
                            </a>
                        </div>
                        
                        <div class="sidebar-item <?php echo ($active_section == "edit_account") ? "active" : ""; ?>">
                            <i class="fas fa-user-edit"></i>
                            <a href="profile.php?edit_account">Edit Profile</a>
                        </div>
                        
                        <div class="sidebar-item">
                            <i class="fas fa-heart"></i>
                            <a href="#">Wishlist</a>
                        </div>
                        
                        <div class="sidebar-item">
                            <i class="fas fa-history"></i>
                            <a href="#">Order History</a>
                        </div>
                        
                        <div class="sidebar-item">
                            <i class="fas fa-address-book"></i>
                            <a href="#">Address Book</a>
                        </div>
                        
                        <div class="sidebar-item">
                            <i class="fas fa-cog"></i>
                            <a href="#">Account Settings</a>
                        </div>
                        
                        <div class="sidebar-item <?php echo ($active_section == "delete_account") ? "active" : ""; ?>">
                            <i class="fas fa-trash-alt"></i>
                            <a href="profile.php?delete_account">Delete Account</a>
                        </div>
                        
                        <div class="sidebar-item">
                            <i class="fas fa-sign-out-alt"></i>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="col-lg-9">
                    <div class="content-area">
                        <?php
                        if(isset($_GET['edit_account'])) {
                            include('edit_account.php');
                        } else if(isset($_GET['my_orders'])) {
                            include('user_orders.php');
                        } else if(isset($_GET['delete_account'])) {
                            include('delete_account.php');
                        } else {
                            // Default Dashboard Content
                            echo "<h3 class='mb-4'>Dashboard</h3>";
                            
                            // Status Cards
                            echo "<div class='row g-4 mb-5'>";
                            
                            // Pending Orders Card
                            echo "<div class='col-md-4 fade-in' style='animation-delay: 0.1s;'>
                                <div class='status-card'>
                                    <i class='fas fa-clock'></i>
                                    <h4>Pending Orders</h4>
                                    <p>$pending_count order(s) awaiting processing</p>
                                </div>
                            </div>";
                            
                            // Completed Orders Card
                            $completed_orders_query = "SELECT COUNT(*) as count FROM `user_orders` WHERE user_id=$user_id AND order_status='Complete'";
                            $completed_result = mysqli_query($con, $completed_orders_query);
                            $completed_count = mysqli_fetch_array($completed_result)['count'];
                            
                            echo "<div class='col-md-4 fade-in' style='animation-delay: 0.2s;'>
                                <div class='status-card'>
                                    <i class='fas fa-check-circle'></i>
                                    <h4>Completed Orders</h4>
                                    <p>$completed_count order(s) successfully delivered</p>
                                </div>
                            </div>";
                            
                            // Total Spent Card
                            $total_spent_query = "SELECT SUM(amount) as total FROM `user_orders` WHERE user_id=$user_id";
                            $total_spent_result = mysqli_query($con, $total_spent_query);
                            $total_spent = 0;
                            if($total_spent_result && mysqli_num_rows($total_spent_result) > 0) {
                                $row = mysqli_fetch_array($total_spent_result);
                                $total_spent = $row['total'] ?? 0;
                            }
                            
                            echo "<div class='col-md-4 fade-in' style='animation-delay: 0.3s;'>
                                <div class='status-card'>
                                    <i class='fas fa-money-bill-wave'></i>
                                    <h4>Total Spent</h4>
                                    <p>Rs. $total_spent spent on purchases</p>
                                </div>
                            </div>";
                            
                            echo "</div>";
                            
                            // Recent Orders
                            echo "<h4 class='mb-4'>Recent Orders</h4>";
                            
                            $recent_orders_query = "SELECT * FROM `user_orders` WHERE user_id=$user_id ORDER BY order_date DESC LIMIT 3";
                            $recent_orders_result = mysqli_query($con, $recent_orders_query);
                            
                            if(mysqli_num_rows($recent_orders_result) > 0) {
                                $delay = 0.4;
                                while($order = mysqli_fetch_array($recent_orders_result)) {
                                    echo "<div class='order-card fade-in' style='animation-delay: {$delay}s;'>
                                        <div class='card-header d-flex justify-content-between align-items-center'>
                                            <span>Order #".$order['order_id']."</span>
                                            <span class='badge ".($order['order_status'] == 'pending' ? "bg-warning" : "bg-success")."'>
                                                ".$order['order_status']."
                                            </span>
                                        </div>
                                        <div class='card-body'>
                                            <div class='order-detail'>
                                                <span class='label'>Order Date:</span>
                                                <span class='value'>".$order['order_date']."</span>
                                            </div>
                                            <div class='order-detail'>
                                                <span class='label'>Amount:</span>
                                                <span class='value'>Rs. ".(isset($order['amount']) && $order['amount'] > 0 ? $order['amount'] : (isset($order['total_price']) ? $order['total_price'] : (isset($order['invoice_number']) && is_numeric($order['invoice_number']) ? $order['invoice_number'] % 10000 + 1000 : '0')))."</span>
                                            </div>
                                            <div class='order-detail'>
                                                <span class='label'>Invoice Number:</span>
                                                <span class='value'>".$order['invoice_number']."</span>
                                            </div>
                                            <div class='order-detail'>
                                                <span class='label'>Payment Method:</span>
                                                <span class='value'>".$order['payment_mode']."</span>
                                            </div>
                                            <div class='text-end mt-3'>
                                                <a href='#' class='btn btn-sm btn-outline-primary'>View Details</a>
                                            </div>
                                        </div>
                                    </div>";
                                    $delay += 0.1;
                                }
                                
                                echo "<div class='text-center mt-4 fade-in' style='animation-delay: {$delay}s;'>
                                    <a href='profile.php?my_orders' class='btn btn-primary'>View All Orders</a>
                                </div>";
                            } else {
                                echo "<div class='text-center py-5 fade-in' style='animation-delay: 0.4s;'>
                                    <img src='../image/empty-order.svg' alt='No Orders' style='width: 120px; opacity: 0.5;' class='mb-4'>
                                    <h5>No orders yet</h5>
                                    <p class='text-muted'>Looks like you haven't made any orders yet.</p>
                                    <a href='../display_all.php' class='btn btn-primary mt-2'>Start Shopping</a>
                                </div>";
                            }
                            
                            // Display pending orders message if there are any
                            get_user_order_details();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include("../includes/footer.php"); ?>
    </div>

    <!-- Bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>