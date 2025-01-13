<?php
include('../includes/connect.php');
include('../functions/common_function.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body{
            overflow:hidden;
        }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
<h2 class="text-center mb-3">Admin Registration</h2>
<div class="row d-flex justify-content-center">
    <div class="col-lg-6 col-xl-5">
<img src="../image/reg1.jpg" alt="Admin Registration" class="img-fluid">
        

    </div>
    <div class="col-lg-6 col-xl-5">
    <form action="" method="post">
            <div class="form-outline mb-4">
                <label for="Username" class="form-label">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter Your Username" required="required" class="form-control">
            </div>
            <div class="form-outline mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email" required="required" class="form-control">
            </div>
            <div class="form-outline mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your password" required="required" class="form-control">
            </div>
            <div class="form-outline mb-4">
                <label for="confirm_password" class="form-label"> Confirm Password</label>
                <input type="confirm_password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required="required" class="form-control">
            </div>
            <div>
                <input type="submit" class="bg-info py-2 px-3 border-0" name="admin_registration" value="Register">
                <p class="small fw-bold mt-2 pf-1 ">Already have an account? <a href="admin_login.php" class="link-danger">Login</a></p>
            </div>
        </form>
    </div>
</div>
    </div>
</body>
</html>

<!-- php code -->
<?php

if (isset($_POST['admin_registration'])) {
    // Retrieve and sanitize form inputs
    $admin_name = mysqli_real_escape_string($con, $_POST['username']);
    $admin_email = mysqli_real_escape_string($con, $_POST['email']);
    $admin_password = mysqli_real_escape_string($con, $_POST['password']);
    $conf_admin_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    // Hash the password
    $hash_password = password_hash($admin_password, PASSWORD_DEFAULT);

    // Check for existing username or email
    $select_query = "SELECT * FROM `admin_table` WHERE admin_name='$admin_name' OR admin_email='$admin_email'";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);

    if ($rows_count > 0) {
        echo "<script>alert('Username or email already exists')</script>";
    } elseif ($admin_password !== $conf_admin_password) {
        echo "<script>alert('Passwords do not match')</script>";
    } else {
        // Insert admin into the database
        $insert_query = "INSERT INTO `admin_table` (admin_name, admin_email, admin_password) 
                         VALUES ('$admin_name', '$admin_email', '$hash_password')";
        $sql_execute = mysqli_query($con, $insert_query);

        if ($sql_execute) {
            echo "<script>alert('Registration successful!');</script>";
            echo "<script>window.open('admin_login.php', '_self');</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }
    }
}
?>

