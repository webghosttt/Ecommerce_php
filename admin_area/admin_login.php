
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
<h2 class="text-center mb-3">Admin Login</h2>
<div class="row d-flex justify-content-center">
    <div class="col-lg-6 col-xl-5">
<img src="../image/reg.jpg" alt="Admin Registration" class="img-fluid">
        

    </div>
    <div class="col-lg-6 col-xl-5">
    <form action="" method="post">
            <div class="form-outline mb-4">
                <label for="Username" class="form-label">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter Your Username" required="required" class="form-control">
            </div>
           
            <div class="form-outline mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your password" required="required" class="form-control">
            </div>
        
            <div>
                <input type="submit" class="bg-info py-2 px-3 border-0" name="admin_login" value="Login">
                <p class="small fw-bold mt-2 pf-1 ">Don't have an account? <a href="admin_registration.php" class="link-danger">Register</a></p>
            </div>
        </form>
    </div>
</div>
    </div>
</body>
</html>
<?php
session_start();
include('../includes/connect.php'); // Include the database connection

if (isset($_POST['admin_login'])) {
    $admin_name = mysqli_real_escape_string($con, $_POST['admin_name']);
    $admin_password = mysqli_real_escape_string($con, $_POST['admin_password']);

    // Select query to fetch admin data
    $select_query = "SELECT * FROM `admin_table` WHERE admin_name='$admin_name'";
    $result = mysqli_query($con, $select_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row_data = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($admin_password, $row_data['admin_password'])) {
            $_SESSION['admin_name'] = $admin_name;
            echo "<script>alert('Login Successful');</script>";
            echo "<script>window.open('index.php', '_self');</script>";
        } else {
            echo "<script>alert('Invalid Password');</script>";
        }
    } else {
        echo "<script>alert('Invalid Username');</script>";
    }
}
?>

