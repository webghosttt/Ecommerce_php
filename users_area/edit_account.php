<?php
if(isset($_GET['edit_account'])){
    $user_session_name=$_SESSION['username'];
    $select_query="Select * from `user_table` where username='$user_session_name'";
    $result_query=mysqli_query($con,$select_query);
    $row_fetch=mysqli_fetch_assoc($result_query);
    $user_id=$row_fetch['user_id'];
    $username=$row_fetch['username'];
    $user_email=$row_fetch['user_email'];
    $user_address=$row_fetch['user_address'];
    $user_mobile=$row_fetch['user_mobile'];

}
    if(isset($_POST['user_update'])){
    $update_id=$user_id;
    $username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_address = $_POST['user_address'];
    $user_mobile=$_POST['user_mobile'];
    $user_image=$_FILES['user_image']['name'];
    $user_image_tmp=$_FILES['user_image']['tmp_name'];
    move_uploaded_file($user_image_tmp,"./user_images/$user_image");

    // update query
    $update_data="update `user_table` set username='$username',user_email='$user_email',user_image='$user_image',user_address='$user_address',user_mobile='$user_mobile' where user_id=$update_id";
    $result_query_update=mysqli_query($con,$update_data);
    if($result_query_update){
        echo "<script>alert('Data Updated Successfully')</script>";
        echo "<script>window.open('logout.php','_self')</script>";
    }

    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <!-- Font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .edit_image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-left: 10px;
            border: 3px solid #5D87FF;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .image-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        
        .preview-label {
            margin-right: 10px;
            font-weight: 500;
            color: #555;
        }

        .account-form .form-label {
            text-align: left;
            display: block;
            width: 50%;
            margin: 0 auto 5px;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #5D87FF;
            border-color: #5D87FF;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #4a6fde;
            border-color: #4a6fde;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(93, 135, 255, 0.3);
        }
    </style>
</head>
<body>
    <h3 class="text-center text-success mb-4">Edit Account</h3>
    <form action="" method="post" enctype="multipart/form-data" class="text-center account-form">
        <div class="form-outline mb-4">
            <label class="form-label">Username</label>
            <input type="text" class="form-control w-50 m-auto" value="<?php echo $username ?>" name="user_username">
        </div>
        <div class="form-outline mb-4">
            <label class="form-label">Email</label>
            <input type="email" class="form-control w-50 m-auto" value="<?php echo $user_email ?>" name="user_email">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label class="form-label">Profile Image</label>
            <input type="file" class="form-control" name="user_image">
            <div class="image-container">
                <span class="preview-label">Current:</span>
                <?php if(!empty($user_image)): ?>
                    <img src="./user_images/<?php echo $user_image ?>" alt="Profile Image" class="edit_image">
                <?php else: ?>
                    <div class="edit_image d-flex align-items-center justify-content-center bg-light">
                        <i class="fas fa-user-circle" style="font-size: 40px; color: #5D87FF;"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-outline mb-4">
            <label class="form-label">Address</label>
            <input type="text" class="form-control w-50 m-auto" value="<?php echo $user_address ?>" name="user_address">
        </div>
        <div class="form-outline mb-4">
            <label class="form-label">Mobile</label>
            <input type="text" class="form-control w-50 m-auto" value="<?php echo $user_mobile ?>" name="user_mobile">
        </div>
        <input type="submit" value="Update" class="btn btn-primary py-2 px-4" name="user_update">
    </form>
</body>
</html>