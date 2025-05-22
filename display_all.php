<!-- connect file -->
<?php
include('includes/connect.php');
include('functions/common_function.php');
session_start();

// Cart handling
if(isset($_GET['add_to_cart'])){
    $product_id = $_GET['add_to_cart'];
    $ip = getIPAddress();
    
    $select_query = "SELECT * FROM `cart_details` WHERE ip_address='$ip' AND product_id=$product_id";
    $result_query = mysqli_query($con, $select_query);
    $num_of_rows = mysqli_num_rows($result_query);
    
    if($num_of_rows > 0){
        echo "<script>alert('This item is already present inside cart')</script>";
        echo "<script>window.open('display_all.php','_self')</script>";
    } else {
        $insert_query = "INSERT INTO `cart_details` (product_id, ip_address, quantity) VALUES ($product_id, '$ip', 1)";
        $result_query = mysqli_query($con, $insert_query);
        echo "<script>alert('Item is added to cart')</script>";
        echo "<script>window.open('display_all.php','_self')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NepalBazar - All Products</title>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Range slider CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* Color Variables for Consistency */
        :root {
            --primary-light: #0dcaf0;
            --primary-dark: #0aa2c0;
            --primary-gradient: linear-gradient(135deg, #0dcaf0, #0aa2c0);
            --secondary-dark: #343a40;
            --accent-color: #ff6b6b;
        }
        
        /* Override Bootstrap's primary color */
        .btn-primary, .bg-primary, .text-primary, .btn-outline-primary:hover {
            background: var(--primary-gradient) !important;
            border-color: var(--primary-dark) !important;
        }
        
        .btn-outline-primary {
            border-color: var(--primary-dark) !important;
            color: var(--primary-dark) !important;
        }
        
        .btn-outline-primary:hover {
            color: white !important;
        }
        
        .text-primary {
            background: var(--primary-gradient) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }
        
        .btn-info {
            background: var(--primary-gradient) !important;
            border-color: var(--primary-dark) !important;
            color: white !important;
        }
        
        .btn-info:hover {
            background: linear-gradient(135deg, #0aa2c0, #0993b0) !important;
            border-color: #0993b0 !important;
        }
        
        .collection-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('image/collection-banner.jpg');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            color: white;
            margin-bottom: 2rem;
        }

        .price-filter {
            margin: 1.5rem 0;
        }

        .noUi-connect {
            background-color: var(--primary-dark);
        }

        .filter-card {
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 1.5rem;
            border: none;
            box-shadow: var(--shadow);
        }

        .filter-card .card-header {
            background: var(--primary-gradient);
            color: white;
            font-weight: 500;
            padding: 1rem;
            border: none;
        }

        .filter-option {
            padding: 0.5rem 0;
            transition: var(--transition);
            border-radius: var(--border-radius);
        }

        .filter-option:hover {
            background-color: #f0f0f0;
            padding-left: 0.5rem;
        }

        .category-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background-color: #f0f0f0;
            border-radius: 20px;
            margin: 0.25rem;
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .category-badge:hover {
            background: var(--primary-gradient);
            color: white;
        }

        .sorting-bar {
            background-color: #f9f9f9;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: var(--border-radius);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .view-options .btn {
            padding: 0.4rem 0.6rem;
            margin-left: 0.5rem;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-gradient);
            border-color: var(--primary-dark);
        }

        .pagination .page-link {
            color: var(--primary-dark);
        }

        .price-display {
            font-weight: 500;
            color: var(--primary-dark);
        }

        .products-found {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .quick-view-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: var(--transition);
            z-index: 1;
        }

        .card:hover .quick-view-btn {
            opacity: 1;
        }

        .card:hover .card-img-top {
            opacity: 0.7;
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
        
        .user-welcome {
            display: flex;
            align-items: center;
            color: white;
        }
        
        .user-welcome i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        /* Search form styling */
        .search-form input {
            border-radius: 50px 0 0 50px;
            border: none;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            max-width: 200px;
        }
        
        .search-form button {
            border-radius: 0 50px 50px 0;
            border: 1px solid white;
            background: transparent;
            color: white;
            padding: 0.5rem 1rem;
        }
        
        .search-form button:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border-color: white;
        }
    </style>
</head>
<body>
<!-- Header -->
<div class="container-fluid p-0">
    <!-- Navigation -->
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
                        <a class="nav-link active" href="display_all.php">
                            <i class="fas fa-store me-1"></i>Product
                        </a>
                    </li>
                    <?php
                    if(isset($_SESSION['username'])){
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='./users_area/profile.php'>
                                <i class='fas fa-user-circle me-1'></i>My Account
                            </a>
                        </li>";
                    } else {
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='./users_area/user_registration.php'>
                                <i class='fas fa-user-plus me-1'></i>Register
                            </a>
                        </li>";
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
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
                
                <form class="d-flex search-form ms-2" action="search_product.php" method="get">
                    <input class="form-control" type="search" placeholder="Search products..." aria-label="Search" name="search_data">
                    <button type="submit" class="btn btn-outline-light" name="search_data_product">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>
      
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
            <div class="ms-auto">
                <span class="text-light">
                    <i class="fas fa-money-bill-wave me-1"></i>Total: Rs. <?php total_cart_price();?>/-
                </span>
            </div>
        </div>
    </div>

    <!-- Collection Banner -->
    <div class="collection-banner text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Shop Our Collection</h1>
            <p class="lead">Discover the latest products at amazing prices</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <!-- Category Filter -->
                <div class="card filter-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Categories</h5>
                        <button class="btn btn-sm text-white" type="button" data-bs-toggle="collapse" data-bs-target="#categoryCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="categoryCollapse">
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="filter-option">
                                    <a href="display_all.php" class="text-dark text-decoration-none d-block">
                                        <i class="fas fa-circle-dot me-2 text-primary"></i>All Categories
                                    </a>
                                </li>
                                <?php
                                // Getting unique categories for sidebar
                                $select_categories = "SELECT * FROM `categories`";
                                $result_categories = mysqli_query($con, $select_categories);
                                while($row_data = mysqli_fetch_assoc($result_categories)) {
                                    $category_title = $row_data['category_title'];
                                    $category_id = $row_data['category_id'];
                                    echo "<li class='filter-option'>
                                        <a href='display_all.php?category=$category_id' class='text-dark text-decoration-none d-block'>
                                            <i class='fas fa-caret-right me-2'></i>$category_title
                                        </a>
                                    </li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Brand Filter -->
                <div class="card filter-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Brands</h5>
                        <button class="btn btn-sm text-white" type="button" data-bs-toggle="collapse" data-bs-target="#brandCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="brandCollapse">
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="filter-option">
                                    <a href="display_all.php" class="text-dark text-decoration-none d-block">
                                        <i class="fas fa-circle-dot me-2 text-primary"></i>All Brands
                                    </a>
                                </li>
                                <?php
                                // Getting unique brands for sidebar
                                $select_brands = "SELECT * FROM `brands`";
                                $result_brands = mysqli_query($con, $select_brands);
                                while($row_data = mysqli_fetch_assoc($result_brands)) {
                                    $brand_title = $row_data['brand_title'];
                                    $brand_id = $row_data['brand_id'];
                                    echo "<li class='filter-option'>
                                        <a href='display_all.php?brand=$brand_id' class='text-dark text-decoration-none d-block'>
                                            <i class='fas fa-caret-right me-2'></i>$brand_title
                                        </a>
                                    </li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="card filter-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Price Range</h5>
                        <button class="btn btn-sm text-white" type="button" data-bs-toggle="collapse" data-bs-target="#priceCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="priceCollapse">
                        <div class="card-body">
                            <div id="price-slider" class="price-filter"></div>
                            <div class="d-flex justify-content-between mt-2">
                                <div>Rs. <span id="price-min">500</span></div>
                                <div>Rs. <span id="price-max">50000</span></div>
                            </div>
                            <button class="btn btn-info w-100 mt-3" id="apply-price-filter">
                                <i class="fas fa-filter me-2"></i>Apply Filter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Popular Tags -->
                <div class="card filter-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-hashtag me-2"></i>Popular Tags</h5>
                        <button class="btn btn-sm text-white" type="button" data-bs-toggle="collapse" data-bs-target="#tagsCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="tagsCollapse">
                        <div class="card-body">
                            <a href="#" class="category-badge text-decoration-none text-dark">Electronics</a>
                            <a href="#" class="category-badge text-decoration-none text-dark">Clothing</a>
                            <a href="#" class="category-badge text-decoration-none text-dark">Shoes</a>
                            <a href="#" class="category-badge text-decoration-none text-dark">Watches</a>
                            <a href="#" class="category-badge text-decoration-none text-dark">Accessories</a>
                            <a href="#" class="category-badge text-decoration-none text-dark">Mobiles</a>
                            <a href="#" class="category-badge text-decoration-none text-dark">Laptops</a>
                            <a href="#" class="category-badge text-decoration-none text-dark">Cameras</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Display -->
            <div class="col-lg-9">
                <!-- Sorting and display options -->
                <div class="sorting-bar mb-4">
                    <div>
                        <span class="products-found">
                            <i class="fas fa-box-open me-1"></i> Showing <span class="fw-bold">1-12</span> of <span class="fw-bold">68</span> products
                        </span>
                    </div>
                    <div class="d-flex align-items-center">
                        <label class="me-2">Sort by:</label>
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>Featured</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Name: A to Z</option>
                            <option>Name: Z to A</option>
                            <option>Latest</option>
                        </select>
                        <div class="view-options ms-3">
                            <button class="btn btn-outline-secondary active">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products grid -->
                <div class="row g-4">
                    <?php
                    // Calling product display functions
                    get_all_products();
                    get_unique_categories();
                    get_unique_brand();
                    ?>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h3>Subscribe to Our Newsletter</h3>
                    <p class="text-muted">Get the latest updates, deals and exclusive offers directly to your inbox!</p>
                    <div class="input-group mt-3">
                        <input type="email" class="form-control" placeholder="Your email address">
                        <button class="btn btn-info" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include("./includes/footer.php"); ?>
</div>

<!-- Bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- noUiSlider -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>

<!-- Custom Scripts -->
<script>
    // Initialize price range slider
    document.addEventListener('DOMContentLoaded', function() {
        const priceSlider = document.getElementById('price-slider');
        const priceMin = document.getElementById('price-min');
        const priceMax = document.getElementById('price-max');
        
        if (priceSlider) {
            noUiSlider.create(priceSlider, {
                start: [500, 50000],
                connect: true,
                step: 500,
                range: {
                    'min': 0,
                    'max': 100000
                }
            });
            
            priceSlider.noUiSlider.on('update', function(values, handle) {
                if (handle === 0) {
                    priceMin.textContent = Math.round(values[handle]);
                } else {
                    priceMax.textContent = Math.round(values[handle]);
                }
            });
            
            // Apply price filter button
            document.getElementById('apply-price-filter').addEventListener('click', function() {
                const values = priceSlider.noUiSlider.get();
                const min = Math.round(values[0]);
                const max = Math.round(values[1]);
                window.location.href = `display_all.php?min_price=${min}&max_price=${max}`;
            });
        }
        
        // Animation for products
        const products = document.querySelectorAll('.card');
        products.forEach((product, index) => {
            setTimeout(() => {
                product.classList.add('fade-in');
            }, 100 * index);
        });
    });
</script>
</body>
</html>