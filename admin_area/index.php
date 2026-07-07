<!-- connect file -->
<?php
include('../includes/connect.php');
include('../functions/common_function.php');
@session_start();

// ── Real Data Queries for Dashboard ──

// Total Orders
$result_orders = mysqli_query($con, "SELECT COUNT(*) as total FROM user_orders");
$total_orders = mysqli_fetch_assoc($result_orders)['total'];

// Total Customers
$result_customers = mysqli_query($con, "SELECT COUNT(*) as total FROM user_table");
$total_customers = mysqli_fetch_assoc($result_customers)['total'];

// Pending Orders
$result_pending_nav = mysqli_query($con, "SELECT COUNT(*) as total FROM user_orders WHERE order_status='pending'");
$pending_count = mysqli_fetch_assoc($result_pending_nav)['total'];

// Completed Orders
$result_completed = mysqli_query($con, "SELECT COUNT(*) as total FROM user_orders WHERE order_status='Complete'");
$completed_orders = mysqli_fetch_assoc($result_completed)['total'];

// Total Revenue (from payments table)
$result_revenue = mysqli_query($con, "SELECT SUM(amount) as total FROM user_payments");
$total_revenue = mysqli_fetch_assoc($result_revenue)['total'] ?? 0;

// Total Products
$result_products = mysqli_query($con, "SELECT COUNT(*) as total FROM products");
$total_products = mysqli_fetch_assoc($result_products)['total'];

// Total Categories
$result_categories = mysqli_query($con, "SELECT COUNT(*) as total FROM categories");
$total_categories = mysqli_fetch_assoc($result_categories)['total'];

// Total Brands
$result_brands = mysqli_query($con, "SELECT COUNT(*) as total FROM brands");
$total_brands = mysqli_fetch_assoc($result_brands)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NepalBazar - Admin Dashboard</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-sidebar {
            height: calc(100vh - 76px);
            position: sticky;
            top: 76px;
            overflow-y: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 100;
            background-color: #f8f9fa;
        }
        
        .admin-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        
        .admin-sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.2);
            border-radius: 10px;
        }
        
        .dashboard-stats .card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .dashboard-stats .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 24px;
            color: white;
        }
        
        .admin-content-area {
            min-height: calc(100vh - 76px);
            padding: 20px;
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <!-- Admin Dashboard Layout -->
    <div class="container-fluid p-0">
        <!-- Navigation Header -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                    <img src="../image/logo.png" alt="NepalBazar Logo" class="me-2" height="40">
                    <span class="fw-bold">Admin Panel</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="adminNavbar">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php" target="_blank">
                                <i class="fas fa-store me-1"></i> View Store
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?list_orders">
                                <i class="fas fa-bell me-1"></i>
                                <?php if($pending_count > 0) { ?>
                                    <span class="badge bg-danger rounded-pill"><?php echo $pending_count; ?></span>
                                <?php } ?>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="index.php?profile"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-lg-2 admin-sidebar py-3">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3" style="width: 80px; height: 80px; background-color: #0d6efd; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                        <i class="fas fa-user-tie text-white" style="font-size: 40px;"></i>
                    </div>
                    <h5 class="fw-bold">Admin User</h5>
                    <p class="text-muted small">Administrator</p>
                </div>
                
                <div class="list-group list-group-flush">
                    <a href="index.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <div class="list-group-item bg-light fw-bold small text-uppercase text-muted">
                        Products
                    </div>
                    <a href="insert_product.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle me-2"></i> Add Product
                    </a>
                    <a href="index.php?view_products" class="list-group-item list-group-item-action">
                        <i class="fas fa-boxes me-2"></i> View Products
                    </a>
                    
                    <div class="list-group-item bg-light fw-bold small text-uppercase text-muted">
                        Categories
                    </div>
                    <a href="index.php?insert_category" class="list-group-item list-group-item-action">
                        <i class="fas fa-folder-plus me-2"></i> Add Category
                    </a>
                    <a href="index.php?view_categories" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i> View Categories
                    </a>
                    
                    <div class="list-group-item bg-light fw-bold small text-uppercase text-muted">
                        Brands
                    </div>
                    <a href="index.php?insert_brand" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags me-2"></i> Add Brand
                    </a>
                    <a href="index.php?view_brands" class="list-group-item list-group-item-action">
                        <i class="fas fa-tag me-2"></i> View Brands
                    </a>
                    
                    <div class="list-group-item bg-light fw-bold small text-uppercase text-muted">
                        Orders & Customers
                    </div>
                    <a href="index.php?list_orders" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-bag me-2"></i> All Orders
                        <span class="badge bg-primary rounded-pill float-end"><?php echo $total_orders; ?></span>
                    </a>
                    <a href="index.php?list_payments" class="list-group-item list-group-item-action">
                        <i class="fas fa-money-bill-wave me-2"></i> All Payments
                    </a>
                    <a href="index.php?list_users" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i> Customers
                        <span class="badge bg-success rounded-pill float-end"><?php echo $total_customers; ?></span>
                    </a>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="col-lg-10 admin-content-area">
                <?php
                // Display dashboard stats if we're on the main page
                if(!isset($_GET['insert_category']) && 
                   !isset($_GET['insert_brand']) && 
                   !isset($_GET['view_products']) && 
                   !isset($_GET['edit_products']) && 
                   !isset($_GET['delete_products']) && 
                   !isset($_GET['view_categories']) && 
                   !isset($_GET['view_brands']) && 
                   !isset($_GET['edit_categories']) && 
                   !isset($_GET['edit_brands']) && 
                   !isset($_GET['delete_categories']) && 
                   !isset($_GET['delete_brands']) && 
                   !isset($_GET['list_orders']) && 
                   !isset($_GET['delete_orders']) && 
                   !isset($_GET['list_payments']) && 
                   !isset($_GET['delete_payments']) && 
                   !isset($_GET['list_users']) && 
                   !isset($_GET['profile']) &&
                   !isset($_GET['delete_users'])) {
                ?>
                <!-- Dashboard Overview -->
                <h1 class="fw-bold mb-4">Dashboard Overview</h1>
                
                <!-- Stats Cards -->
                <div class="row dashboard-stats mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-primary">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="text-muted mb-0">Total Orders</h6>
                                        <h2 class="fw-bold my-1"><?php echo $total_orders; ?></h2>
                                        <span class="text-muted small"><?php echo $completed_orders; ?> completed, <?php echo $pending_count; ?> pending</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-success">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="text-muted mb-0">Total Revenue</h6>
                                        <h2 class="fw-bold my-1">Rs. <?php echo number_format($total_revenue, 0); ?></h2>
                                        <span class="text-muted small">From <?php echo $total_orders; ?> orders</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-warning">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="text-muted mb-0">Customers</h6>
                                        <h2 class="fw-bold my-1"><?php echo $total_customers; ?></h2>
                                        <span class="text-muted small">Registered users</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-danger">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="text-muted mb-0">Products</h6>
                                        <h2 class="fw-bold my-1"><?php echo $total_products; ?></h2>
                                        <span class="text-muted small"><?php echo $total_categories; ?> categories, <?php echo $total_brands; ?> brands</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders & Activities -->
                <div class="row mb-4">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <div class="card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Orders</h5>
                                <a href="index.php?list_orders" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch recent orders with real data
                                            $get_recent_orders = "SELECT o.*, u.username 
                                                                FROM user_orders o
                                                                LEFT JOIN user_table u ON o.user_id = u.user_id
                                                                ORDER BY o.order_date DESC LIMIT 5";
                                            $result_recent_orders = mysqli_query($con, $get_recent_orders);
                                            
                                            if ($result_recent_orders && mysqli_num_rows($result_recent_orders) > 0) {
                                                while($row_order = mysqli_fetch_assoc($result_recent_orders)) {
                                                    $order_id = $row_order['order_id'];
                                                    $user_name = $row_order['username'] ? $row_order['username'] : 'Unknown';
                                                    $order_date = date('d M Y', strtotime($row_order['order_date']));
                                                    $amount = $row_order['amount_due'];
                                                    $order_status = $row_order['order_status'];
                                                    
                                                    // Status badge color
                                                    $status_class = 'bg-secondary';
                                                    if($order_status == 'Complete') $status_class = 'bg-success';
                                                    elseif($order_status == 'pending') $status_class = 'bg-warning';
                                                    elseif($order_status == 'Processing') $status_class = 'bg-info';
                                            ?>
                                            <tr>
                                                <td>#ORD-<?php echo str_pad($order_id, 4, '0', STR_PAD_LEFT); ?></td>
                                                <td><?php echo $user_name; ?></td>
                                                <td><?php echo $order_date; ?></td>
                                                <td>Rs. <?php echo number_format($amount, 0); ?></td>
                                                <td><span class="badge <?php echo $status_class; ?>"><?php echo $order_status; ?></span></td>
                                                <td>
                                                    <a href="index.php?view_order=<?php echo $order_id; ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='6' class='text-center text-muted py-4'>No orders yet</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Activities</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <?php
                                    // Recent customer
                                    $result_recent_user = mysqli_query($con, "SELECT * FROM user_table ORDER BY user_id DESC LIMIT 1");
                                    if ($result_recent_user && mysqli_num_rows($result_recent_user) > 0) {
                                        $row_user = mysqli_fetch_assoc($result_recent_user);
                                    ?>
                                    <li class="list-group-item d-flex align-items-center py-3">
                                        <div class="activity-icon bg-primary text-white rounded-circle p-3 me-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0">New customer registered: <?php echo $row_user['username']; ?></p>
                                            <small class="text-muted">Latest registered user</small>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    
                                    <?php
                                    // Recent payment
                                    $result_recent_payment = mysqli_query($con, "SELECT * FROM user_payments ORDER BY payment_id DESC LIMIT 1");
                                    if ($result_recent_payment && mysqli_num_rows($result_recent_payment) > 0) {
                                        $row_payment = mysqli_fetch_assoc($result_recent_payment);
                                    ?>
                                    <li class="list-group-item d-flex align-items-center py-3">
                                        <div class="activity-icon bg-success text-white rounded-circle p-3 me-3">
                                            <i class="fas fa-money-bill"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0">Payment of Rs. <?php echo number_format($row_payment['amount'], 0); ?> received</p>
                                            <small class="text-muted">Via <?php echo $row_payment['payment_mode']; ?> • <?php echo date('d M Y', strtotime($row_payment['date'])); ?></small>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    
                                    <?php
                                    // Recent order
                                    $result_recent_order = mysqli_query($con, "SELECT o.*, u.username FROM user_orders o LEFT JOIN user_table u ON o.user_id = u.user_id ORDER BY o.order_id DESC LIMIT 1");
                                    if ($result_recent_order && mysqli_num_rows($result_recent_order) > 0) {
                                        $row_order = mysqli_fetch_assoc($result_recent_order);
                                    ?>
                                    <li class="list-group-item d-flex align-items-center py-3">
                                        <div class="activity-icon bg-warning text-white rounded-circle p-3 me-3">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0">Order #ORD-<?php echo str_pad($row_order['order_id'], 4, '0', STR_PAD_LEFT); ?> by <?php echo $row_order['username'] ? $row_order['username'] : 'Customer'; ?></p>
                                            <small class="text-muted">Rs. <?php echo number_format($row_order['amount_due'], 0); ?> • <?php echo date('d M Y', strtotime($row_order['order_date'])); ?></small>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    
                                    <?php
                                    // Recent product
                                    $result_recent_product = mysqli_query($con, "SELECT * FROM products ORDER BY product_id DESC LIMIT 1");
                                    if ($result_recent_product && mysqli_num_rows($result_recent_product) > 0) {
                                        $row_product = mysqli_fetch_assoc($result_recent_product);
                                    ?>
                                    <li class="list-group-item d-flex align-items-center py-3">
                                        <div class="activity-icon bg-info text-white rounded-circle p-3 me-3">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0">Product added: <?php echo substr($row_product['product_title'], 0, 30); ?></p>
                                            <small class="text-muted">Rs. <?php echo number_format($row_product['product_price'], 0); ?></small>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                } else {
                // Include specific pages based on GET parameters
                if(isset($_GET['insert_category'])) {
                    include('insert_categories.php');
                }
                if(isset($_GET['insert_brand'])) {
                    include('insert_brands.php');
                }
                if(isset($_GET['view_products'])) {
                    include('view_products.php');
                }
                if(isset($_GET['edit_products'])) {
                    include('edit_products.php');
                }
                if(isset($_GET['delete_products'])) {
                    include('delete_products.php');
                }
                if(isset($_GET['view_categories'])) {
                    include('view_categories.php');
                }
                if(isset($_GET['view_brands'])) {
                    include('view_brands.php');
                }
                if(isset($_GET['edit_categories'])) {
                    include('edit_categories.php');
                }
                if(isset($_GET['edit_brands'])) {
                    include('edit_brands.php');
                }
                if(isset($_GET['delete_categories'])) {
                    include('delete_categories.php');
                }
                if(isset($_GET['delete_brands'])) {
                    include('delete_brands.php');
                }
                if(isset($_GET['list_orders'])) {
                    include('list_orders.php');
                }
                if(isset($_GET['delete_orders'])) {
                    include('delete_orders.php');
                }
                if(isset($_GET['list_payments'])) {
                    include('list_payments.php');
                }
                if(isset($_GET['delete_payments'])) {
                    include('delete_payments.php');
                }
                if(isset($_GET['list_users'])) {
                    include('list_users.php');
                }
                if(isset($_GET['delete_users'])) {
                    include('delete_users.php');
                }
                if(isset($_GET['profile'])) {
                    include('profile.php');
                }
                }
                ?>
            </div>
        </div>
        
        <!-- Footer -->
        <footer class="bg-white text-center p-3 border-top">
            <p class="mb-0">&copy; 2025 NepalBazar Admin Panel. All rights reserved.</p>
        </footer>
    </div>

    <!-- Bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>