<!-- connect file -->
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
    <title>Admin Dashboard</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    
    <!-- css style -->

    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-image{
            width: 100px;
            object-fit: contain;
    }
    .footer{
        position: absolute;
        bottom: 0;
    }
    body{
        overflow-x:hidden;
    }
    .product_img{
        width:100px;
        object-fit:contain;

    }
    </style>

</head>
<body>
    <!-- navbar -->
     <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../image/logo.png" alt="" class="logo">
                <nav class="navbar navbar-expand-lg ">
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <a href="" class="nav-link">Welcome Guest</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </nav>
        <!-- second child -->
         <div class="bg-light">
            <h3 class="text-center p-2">Manage Details</h3>
         </div>
         <!-- third child -->
          
          <div class="row">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
                <div class="p-3">
                    <a href="#"><img src="../image/cart.png" 
                    alt="" class="admin-image"></a>
                    <p class="text-light text-center">NepalBazar</p>
                </div>
                <div class="button text-center">
                    <button class="my-3"><a href="insert_product.php" class="nav-link text-light bg-info my-1">Interst product</a></button>
                    <button><a href="index.php?view_products" class="nav-link text-light bg-info my-1">View Product</a></button>
                    <button><a href="index.php?insert_category" class="nav-link text-light bg-info my-1">Insert Categories</a></button>
                    <button><a href="index.php?view_categories" class="nav-link text-light bg-info my-1">View Categories</a></button>
                    <button><a href="index.php?insert_brand" class="nav-link text-light bg-info my-1">Insert Brand</a></button>
                    <button><a href="index.php?view_brands" class="nav-link text-light bg-info my-1">View Brands</a></button>
                    <button><a href="index.php?list_orders" class="nav-link text-light bg-info my-1">All Orders</a></button>
                    <button><a href="index.php?list_payments" class="nav-link text-light bg-info my-1">All Payments</a></button>
                    <button><a href="index.php?list_users" class="nav-link text-light bg-info my-1">List Users</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">Logout</a></button>
                </div>
            </div>

          </div>

          <!-- fourth child -->
         <div class="container my-5">
<?php
if(isset($_GET['insert_category'])){
    include('insert_categories.php');
}
if(isset($_GET['insert_brand'])){
    include('insert_brands.php');
}
if(isset($_GET['view_products'])){
    include('view_products.php');
}
if(isset($_GET['edit_products'])){
    include('edit_products.php');
}
if(isset($_GET['delete_products'])){
    include('delete_products.php');
}
if(isset($_GET['view_categories'])){
    include('view_categories.php');
}
if(isset($_GET['view_brands'])){
    include('view_brands.php');
}
if(isset($_GET['edit_categories'])){
    include('edit_categories.php');
}
if(isset($_GET['edit_brands'])){
    include('edit_brands.php');
}
if(isset($_GET['delete_categories'])){
    include('delete_categories.php');
}
if(isset($_GET['delete_brands'])){
    include('delete_brands.php');
}
if(isset($_GET['list_orders'])){
    include('list_orders.php');
}
if(isset($_GET['delete_orders'])){
    include('delete_orders.php');
}
if(isset($_GET['list_payments'])){
    include('list_payments.php');
}
if(isset($_GET['delete_payments'])){
    include('delete_payments.php');
}
if(isset($_GET['list_users'])){
    include('list_users.php');
}
if(isset($_GET['delete_users'])){
    include('delete_users.php');
}
?>
        </div>

          <!-- last child -->
        <!-- include footer -->
        <?php
        include("../includes/footer.php")
        ?>
    




<!-- Bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>