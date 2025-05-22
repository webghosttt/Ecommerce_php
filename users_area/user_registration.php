<?php
include('../includes/connect.php');
include('../functions/common_function.php');

$errors = []; // Array to store validation errors

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_register'])) {
    $user_username = mysqli_real_escape_string($con, $_POST['user_username']);
    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $user_password = $_POST['user_password'];
    $conf_user_password = $_POST['conf_user_password'];
    $user_address = mysqli_real_escape_string($con, $_POST['user_address']);
    $user_contact = mysqli_real_escape_string($con, $_POST['user_contact']);
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    $user_ip = getIPAddress();

    // Validate mobile number (should start with 98 and be exactly 10 digits)
    if (!preg_match('/^98\d{8}$/', $user_contact)) {
        $errors[] = "Invalid contact number. It must start with 98 and be exactly 10 digits.";
    }

    // Check if passwords matchimage.png
    if ($user_password != $conf_user_password) {
        $errors[] = "Passwords do not match.";
    }

    // Validate password strength (e.g., minimum 8 characters)
    if (strlen($user_password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }   

    // Check if username or email already exists
    $select_query = "SELECT * FROM `user_table` WHERE username=? OR user_email=?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, "ss", $user_username, $user_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $rows_count = mysqli_stmt_num_rows($stmt);

    if ($rows_count > 0) {
        $errors[] = "Username or email already exists.";
    }

    // Validate image file type and size
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024; // 2MB
    if (!in_array($_FILES['user_image']['type'], $allowed_types)) {
        $errors[] = "Invalid file type. Only JPEG, PNG, and GIF images are allowed.";
    } elseif ($_FILES['user_image']['size'] > $max_size) {
        $errors[] = "File size exceeds the maximum limit of 2MB.";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Move uploaded file
        $upload_dir = './user_images/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $user_image_path = $upload_dir . basename($user_image);
        if (move_uploaded_file($user_image_tmp, $user_image_path)) {
            // Hash the password
            $hash_password = password_hash($user_password, PASSWORD_DEFAULT);

            // Insert user data
            $insert_query = "INSERT INTO `user_table` (username, user_email, user_password, user_image, user_ip, user_address, user_mobile) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $insert_query);
            mysqli_stmt_bind_param($stmt, "sssssss", $user_username, $user_email, $hash_password, $user_image, $user_ip, $user_address, $user_contact);
            $sql_execute = mysqli_stmt_execute($stmt);

            if ($sql_execute) {
                echo "<script>alert('Registration successful!'); window.location.href='user_login.php';</script>";
            } else {
                $errors[] = "Registration failed. Please try again.";
            }
        } else {
            $errors[] = "Failed to upload image.";
        }
    }

    // Display errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NepalBazar - Create Your Account</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <a href="../index.php" class="d-block mb-3">
                            <img src="../image/logo.png" alt="NepalBazar Logo" class="img-fluid" style="max-height: 60px;">
                        </a>
                        <h3 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create Your Account</h3>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <p class="text-muted">Join NepalBazar to enjoy a premium shopping experience</p>
                        </div>
                        
                        <form action="" method="post" enctype="multipart/form-data" class="auth-form">
                            <div class="row">
                                <!-- Username field -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" id="user_username" class="form-control" placeholder="Enter your username" required name="user_username" value="<?php echo isset($_POST['user_username']) ? htmlspecialchars($_POST['user_username']) : ''; ?>">
                                        <label for="user_username"><i class="fas fa-user me-2"></i>Username</label>
                                    </div>
                                </div>
                                
                                <!-- Email field -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="email" id="user_email" class="form-control" placeholder="Enter your email" required name="user_email" value="<?php echo isset($_POST['user_email']) ? htmlspecialchars($_POST['user_email']) : ''; ?>">
                                        <label for="user_email"><i class="fas fa-envelope me-2"></i>Email</label>
                                    </div>
                                </div>
                                
                                <!-- Image field -->
                                <div class="col-md-12 mb-4">
                                    <label for="user_image" class="form-label"><i class="fas fa-image me-2"></i>Profile Picture</label>
                                    <input type="file" id="user_image" class="form-control" required name="user_image">
                                </div>
                                
                                <!-- Password field -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="password" id="user_password" class="form-control" placeholder="Enter your password" required name="user_password">
                                        <label for="user_password"><i class="fas fa-lock me-2"></i>Password</label>
                                    </div>
                                </div>
                                
                                <!-- Confirm Password field -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="password" id="conf_user_password" class="form-control" placeholder="Confirm password" required name="conf_user_password">
                                        <label for="conf_user_password"><i class="fas fa-key me-2"></i>Confirm Password</label>
                                    </div>
                                </div>
                                
                                <!-- Address field -->
                                <div class="col-md-12 mb-4">
                                    <div class="form-floating">
                                        <input type="text" id="user_address" class="form-control" placeholder="Enter your address" required name="user_address" value="<?php echo isset($_POST['user_address']) ? htmlspecialchars($_POST['user_address']) : ''; ?>">
                                        <label for="user_address"><i class="fas fa-map-marker-alt me-2"></i>Address</label>
                                    </div>
                                </div>
                                
                                <!-- Contact field -->
                                <div class="col-md-12 mb-4">
                                    <div class="form-floating">
                                        <input type="text" id="user_contact" class="form-control" placeholder="Enter your mobile number" required name="user_contact" value="<?php echo isset($_POST['user_contact']) ? htmlspecialchars($_POST['user_contact']) : ''; ?>">
                                        <label for="user_contact"><i class="fas fa-phone me-2"></i>Contact Number</label>
                                    </div>
                                </div>
                                
                                <!-- Terms and Conditions -->
                                <div class="col-12 mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary py-3 fw-bold" name="user_register">
                                            <i class="fas fa-user-plus me-2"></i>Create Account
                                        </button>
                                    </div>
                                    <div class="text-center mt-4">
                                        <p class="mb-0">Already have an account? <a href="user_login.php" class="text-primary fw-bold">Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>