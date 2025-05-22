<?php
include('../includes/connect.php');
include('../functions/common_function.php');
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NepalBazar - User Login</title>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-6">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <a href="../index.php" class="d-block mb-3">
                            <img src="../image/logo.png" alt="NepalBazar Logo" class="img-fluid" style="max-height: 60px;">
                        </a>
                        <h3 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>User Login</h3>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="my-4">
                                <img src="login.jpg" alt="User Profile" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #0d6efd;">
                                <p class="text-muted">Welcome back! Please login to your account</p>
                            </div>
                        </div>
                        
                        <form action="" method="post" class="auth-form">
                            <!-- Username field -->
                            <div class="form-floating mb-4">
                                <input type="text" id="user_username" class="form-control" placeholder="Enter your username" required name="user_username">
                                <label for="user_username"><i class="fas fa-user me-2"></i>Username</label>
                            </div>
                            
                            <!-- Password field -->
                            <div class="form-floating mb-4">
                                <input type="password" id="user_password" class="form-control" placeholder="Enter your password" required name="user_password">
                                <label for="user_password"><i class="fas fa-lock me-2"></i>Password</label>
                            </div>
                            
                            <!-- Remember me checkbox -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="remember_me">
                                <label class="form-check-label" for="remember_me">
                                    Remember me
                                </label>
                                <a href="#" class="float-end text-decoration-none">Forgot password?</a>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-3 fw-bold" name="user_login">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </div>
                            
                            <div class="text-center mt-4">
                                <p class="mb-0">Don't have an account? <a href="user_registration.php" class="text-primary fw-bold">Register Now</a></p>
                            </div>
                        </form>
                        
                        <!-- Social Login Options -->
                        <div class="my-4">
                            <div class="text-center text-muted mb-3">
                                <span>Or login with</span>
                            </div>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="btn btn-outline-primary px-4">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-danger px-4">
                                    <i class="fab fa-google"></i>
                                </a>
                                <a href="#" class="btn btn-outline-dark px-4">
                                    <i class="fab fa-apple"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center py-3 bg-light border-0">
                        <a href="../index.php" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i>Return to Homepage
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
if (isset($_POST['user_login'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];
    
    $select_query = "SELECT * FROM `user_table` WHERE username='$user_username'";
    $result = mysqli_query($con, $select_query);
    $row_count = mysqli_num_rows($result);
    $row_data = mysqli_fetch_assoc($result);
    $user_ip = getIPAddress();

    // cart item
    $select_query_cart = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
    $select_cart = mysqli_query($con, $select_query_cart);
    $row_count_cart = mysqli_num_rows($select_cart);
    
    if ($row_count > 0) {
        $_SESSION['username'] = $user_username;
        if (password_verify($user_password, $row_data['user_password'])) {
            if($row_count == 1 && $row_count_cart == 0) {
                $_SESSION['username'] = $user_username;
                echo "<script>alert('Login Successfully')</script>";
                echo "<script>window.open('profile.php','_self')</script>";
            } else {
                echo "<script>alert('Login Successfully')</script>";
                echo "<script>window.open('../index.php','_self')</script>";
            }
        } else {
            echo "<script>alert('Invalid credentials')</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials')</script>";
    }
}
?>
