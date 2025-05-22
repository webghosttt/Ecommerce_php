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
    <title>NepalBazar - Contact Us</title>
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
        
        /* Contact Page Styling */
        .contact-container {
            padding: 3rem 0;
        }
        
        .page-header {
            background-color: #fff;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
        }
        
        .page-header h2 {
            color: #0dcaf0;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .page-header p {
            color: #6c757d;
            margin-bottom: 0;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .contact-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .contact-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #0dcaf0, #0aa2c0);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1.5rem;
        }
        
        .contact-title {
            font-weight: 600;
            color: #343a40;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .contact-info {
            text-align: center;
            color: #6c757d;
            margin-bottom: 0;
        }
        
        .contact-info a {
            color: #0dcaf0;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .contact-info a:hover {
            color: #0aa2c0;
            text-decoration: underline;
        }
        
        .contact-form-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }
        
        .form-title {
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f1f1;
        }
        
        .form-floating {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border-radius: 8px;
            border: 1px solid #dfe3e8;
            padding: 1rem 0.75rem;
        }
        
        .form-control:focus {
            border-color: #0dcaf0;
            box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25);
        }
        
        .form-label {
            color: #6c757d;
        }
        
        .form-select {
            border-radius: 8px;
            border: 1px solid #dfe3e8;
            padding: 1rem 0.75rem;
            height: 58px;
        }
        
        .form-select:focus {
            border-color: #0dcaf0;
            box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25);
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #0dcaf0, #0aa2c0);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(13, 202, 240, 0.4);
        }
        
        .map-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-top: 2rem;
        }
        
        .map-container iframe {
            width: 100%;
            height: 400px;
            border: 0;
        }
        
        @media (max-width: 768px) {
            .contact-cards {
                margin-bottom: 2rem;
            }
            
            .contact-card {
                margin-bottom: 1rem;
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
                        <a class="nav-link" href="cart.php">
                            <div class="cart-icon-container">
                                <i class="fas fa-shopping-cart cart-icon"></i>
                                <span class="cart-badge"><?php cart_item(); ?></span>
                            </div>
                            Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contact.php">
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

    <!-- Contact Section -->
    <div class="container contact-container">
        <!-- Page Header -->
        <div class="page-header">
            <h2><i class="fas fa-envelope me-2"></i>Get in Touch</h2>
            <p>We'd love to hear from you! Whether you have a question about our products, pricing, or anything else, our team is ready to answer all your questions.</p>
        </div>
        
        <!-- Contact Info Cards & Contact Form -->
        <div class="row">
            <!-- Contact Info Cards -->
            <div class="col-lg-4 contact-cards">
                <div class="row gy-4">
                    <!-- Email Card -->
                    <div class="col-md-12">
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h4 class="contact-title">Email Us</h4>
                            <p class="contact-info">
                                <a href="mailto:info@nepalbazar.com">info@nepalbazar.com</a><br>
                                <a href="mailto:support@nepalbazar.com">support@nepalbazar.com</a>
                            </p>
                        </div>
                    </div>
                    <!-- Phone Card -->
                    <div class="col-md-12">
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <h4 class="contact-title">Call Us</h4>
                            <p class="contact-info">
                                <a href="tel:+9779812345678">+977 9865511417</a><br>
                                <a href="tel:+97714123456">+977 9827638422</a>
                            </p>
                        </div>
                    </div>
                    <!-- Address Card -->
                    <div class="col-md-12">
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h4 class="contact-title">Visit Us</h4>
                            <p class="contact-info">
                                NepalBazar Headquarters<br>
                                123 Durbar Marg, Kathmandu<br>
                                Nepal, 44600
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="contact-form-container">
                    <h3 class="form-title">Send Us a Message</h3>
                    
                    <?php
                    // Process form submission
                    if(isset($_POST['submit_contact'])) {
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $subject = $_POST['subject'];
                        $message = $_POST['message'];
                        
                        // You can add database insertion code here if needed
                        // For now, we'll just show a success message
                        echo '<div class="alert alert-success mb-4">
                                <i class="fas fa-check-circle me-2"></i>Thank you for contacting us! We will get back to you shortly.
                              </div>';
                    }
                    ?>
                    
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <select class="form-select" id="subject" name="subject" aria-label="Subject">
                                <option selected value="General Inquiry">General Inquiry</option>
                                <option value="Product Question">Product Question</option>
                                <option value="Order Status">Order Status</option>
                                <option value="Returns & Refunds">Returns & Refunds</option>
                                <option value="Technical Support">Technical Support</option>
                                <option value="Other">Other</option>
                            </select>
                            <label for="subject">Subject</label>
                        </div>
                        
                        <div class="form-floating mb-4">
                            <textarea class="form-control" placeholder="Your Message" id="message" name="message" style="height: 150px" required></textarea>
                            <label for="message">Your Message</label>
                        </div>
                        
                        <button type="submit" name="submit_contact" class="submit-btn">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.0501662483087!2d85.30940497575361!3d27.717323275373282!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19016c575749%3A0xfd0e906e3b2fb36e!2sDurbar%20Marg%2C%20Kathmandu%2044600!5e0!3m2!1sen!2snp!4v1685508641017!5m2!1sen!2snp" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include "./includes/footer.php"; ?>
</div>

<!-- Bootstrap JS link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html> 