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
        echo "<script>window.open('index.php','_self')</script>";
    } else {
        $insert_query = "INSERT INTO `cart_details` (product_id, ip_address, quantity) VALUES ($product_id, '$ip', 1)";
        $result_query = mysqli_query($con, $insert_query);
        echo "<script>alert('Item is added to cart')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NepalBazar - Premium Shopping Experience</title>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <!-- font awesome link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <!-- Google Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <!-- Custom CSS -->
     <link rel="stylesheet" href="style.css">
     <style>
        /* Navbar Styling */
        .main-navbar {
            background: linear-gradient(135deg, #0dcaf0, #0aa2c0) !important;
            padding: 0.75rem 1rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
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
        
        /* End of color overrides */
        
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
                        <a class="nav-link active" href="index.php">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="display_all.php">
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

    <!-- Hero Section -->
    <div class="hero-section py-5 text-center bg-light fade-in">
        <div class="container">
            <h1 class="store-title mb-3">NepalBazar Store</h1>
            <p class="lead mb-4">Discover quality products at amazing prices</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="hero-features d-flex justify-content-around mb-4">
                        <div class="feature-item">
                            <i class="fas fa-shipping-fast text-primary fa-2x mb-2"></i>
                            <p>Fast Delivery</p>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt text-primary fa-2x mb-2"></i>
                            <p>Secure Payments</p>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-undo text-primary fa-2x mb-2"></i>
                            <p>Easy Returns</p>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-headset text-primary fa-2x mb-2"></i>
                            <p>24/7 Support</p>
                        </div>
                    </div>
                </div>
            </div>
            <a href="display_all.php" class="btn btn-info btn-lg px-4">Shop Now <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="container py-5">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold">Featured Products</h2>
            <p class="text-muted">Handpicked products for you</p>
            <div class="section-divider mx-auto"></div>
        </div>

        <div class="row g-4">
            <div class="col-md-9">
                <!-- Products grid -->
                <div class="row g-4">
                    <?php
                    // calling function
                    getproducts();
                    get_unique_categories();
                    get_unique_brand();
                    ?>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Sidebar -->
                <div class="sidebar bg-secondary">
                    <!-- Brands -->
                    <ul class="navbar-nav text-light me-auto text-center">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <h4><i class="fas fa-truck me-2"></i>Brands</h4>
                            </a>
                        </li>
                        <?php getbrands(); ?>
                    </ul>
                    
                    <!-- Categories -->
                    <ul class="navbar-nav text-light me-auto text-center mt-4">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <h4><i class="fas fa-list me-2"></i>Categories</h4>
                            </a>
                        </li>
                        <?php getcategories(); ?>
                    </ul>
                </div>

                <!-- Special Offer -->
                <!-- <div class="special-offer mt-4 p-3 bg-light rounded text-center">
                    <h4 class="text-danger mb-3">Special Offer</h4>
                    <p>Use code <strong>NEPAL10</strong> for 10% off!</p>
                    <div class="countdown-timer mb-2">
                        <div class="d-flex justify-content-center">
                            <div class="timer-item mx-2">
                                <span id="days" class="timer-value">02</span>
                                <span class="timer-label">Days</span>
                            </div>
                            <div class="timer-item mx-2">
                                <span id="hours" class="timer-value">12</span>
                                <span class="timer-label">Hours</span>
                            </div>
                            <div class="timer-item mx-2">
                                <span id="minutes" class="timer-value">45</span>
                                <span class="timer-label">Mins</span>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="testimonials-section py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="fw-bold">Customer Testimonials</h2>
                <p class="text-muted">What our customers say about us</p>
                <div class="section-divider mx-auto"></div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card p-4 bg-white rounded shadow-sm">
                        <div class="testimonial-rating text-warning mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"I love shopping at NepalBazar! The products are high-quality and the delivery is always on time. Highly recommended!"</p>
                        <div class="testimonial-author d-flex align-items-center mt-3">
                            <div class="testimonial-avatar me-3">
                                <img src="hello.jpg" alt="Customer" class="rounded-circle" width="50" height="50">
                            </div>
                            <div>
                                <h6 class="mb-0">Chandan Shah</h6>
                                <small class="text-muted">Regular Customer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card p-4 bg-white rounded shadow-sm">
                        <div class="testimonial-rating text-warning mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-text">"Great selection of products and excellent customer service. The eSewa payment option makes shopping so convenient!"</p>
                        <div class="testimonial-author d-flex align-items-center mt-3">
                            <div class="testimonial-avatar me-3">
                                <img src="yogendra.jpg" alt="Customer" class="rounded-circle" width="50" height="50">
                            </div>
                            <div>
                                <h6 class="mb-0">Yogendra Chand</h6>
                                <small class="text-muted">Verified Buyer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card p-4 bg-white rounded shadow-sm">
                        <div class="testimonial-rating text-warning mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"I've been shopping here for over a year. The prices are competitive and the quality never disappoints. Best online store in Nepal!"</p>
                        <div class="testimonial-author d-flex align-items-center mt-3">
                            <div class="testimonial-avatar me-3">
                                <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Customer" class="rounded-circle" width="50" height="50">
                            </div>
                            <div>
                                <h6 class="mb-0">Gyan Magar</h6>
                                <small class="text-muted">Loyal Customer</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="mb-4">About NepalBazar</h5>
                    <p>Your premier destination for quality products in Nepal. We offer a wide selection of products at competitive prices with excellent customer service.</p>
                    <div class="social-icons mt-4">
                        <a href="https://www.facebook.com/chandan.shah.1694059" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/chandan_shah17/" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/chandan-shah-731271246/" class="me-3"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php">Home</a></li>
                        <li class="mb-2"><a href="display_all.php">Products</a></li>
                        <li class="mb-2"><a href="cart.php">Cart</a></li>
                        <li class="mb-2"><a href="users_area/user_registration.php">Register</a></li>
                        <li class="mb-2"><a href="users_area/user_login.php">Login</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Kathmandu, Nepal</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +977 9865511417</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@nepalbazar.com</li>
                        <li class="mb-2"><i class="fas fa-clock me-2"></i> Sun-Fry: 10:00 AM - 8:00 PM</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Newsletter</h5>
                    <p>Subscribe to receive updates on new products and special promotions.</p>
                    <form class="mt-3">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Your Email" aria-label="Your Email">
                            <button class="btn btn-info" type="button">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2026 NepalBazar. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <img src="paypal.jpg" alt="Payment Methods" height="30">
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Custom scripts -->
<script>
    // Simple countdown timer (just for display)
    function updateCountdown() {
        const days = document.getElementById('days');
        const hours = document.getElementById('hours');
        const minutes = document.getElementById('minutes');
        
        let daysValue = parseInt(days.textContent);
        let hoursValue = parseInt(hours.textContent);
        let minutesValue = parseInt(minutes.textContent);
        
        if (minutesValue > 0) {
            minutesValue--;
        } else {
            minutesValue = 59;
            if (hoursValue > 0) {
                hoursValue--;
            } else {
                hoursValue = 23;
                if (daysValue > 0) {
                    daysValue--;
                }
            }
        }
        
        days.textContent = daysValue.toString().padStart(2, '0');
        hours.textContent = hoursValue.toString().padStart(2, '0');
        minutes.textContent = minutesValue.toString().padStart(2, '0');
    }
    
    // Update countdown every minute
    setInterval(updateCountdown, 60000);
    
    // Add animation classes on page load
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.card, .testimonial-card');
        elements.forEach((el, index) => {
            setTimeout(() => {
                el.classList.add('fade-in');
            }, 100 * index);
        });
    });
</script>
</body>
</html>