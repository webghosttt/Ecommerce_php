<!-- connect file -->
<?php
 include('includes/connect.php');
 include('functions/common_function.php');
 session_start();
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - NepalBazar Store</title>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <!-- font awesome link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" href="style.css">
     <style>
        body {
            overflow-x: hidden;
            background-color: #f9fafb;
        }
        .product-details-container {
            padding: 2rem 0;
        }
        .product-image-container {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow);
            position: sticky;
            top: 2rem;
        }
        .product-info {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow);
        }
        .product-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }
        .product-price {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .product-description {
            margin-bottom: 1.5rem;
            color: var(--gray-color);
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .meta-item i {
            color: var(--primary-color);
        }
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .action-buttons .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 50px;
        }
        .related-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 2rem 0 1rem;
            color: var(--dark-color);
        }
        .sidebar-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .sidebar-title {
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            margin: 0;
            font-weight: 600;
        }
        .sidebar-list {
            padding: 0.5rem 0;
        }
        .sidebar-list .nav-link {
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            color: var(--dark-color);
        }
        .sidebar-list .nav-link:hover {
            background-color: rgba(0,0,0,0.05);
            color: var(--primary-color);
            transform: translateX(5px);
        }



    </style>
</head>
<body>
<!-- navbar -->
 <div class="container-fluid p-0">
    <!-- first child -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container-fluid">
          <img src="./image/logo.png" alt="" class="logo">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="display_all.php">Product</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./users_area/user_registration.php" >Register</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item();?></sup></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Total Price: <?php total_cart_price();?>/- </a>
              </li>
            </ul>
            <form class="d-flex" action="search_product.php" method="get">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
              <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
            </form>
          </div>
        </div>
      </nav>
      
      <!-- Second Child -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <ul class="navbar-nav me-auto">
          <?php
          if(!isset($_SESSION['username'])){
            echo "<li class='nav-item'>
                    <a class='nav-link' href='#'>Welcome Guest</a>
                  </li>";
          }else{
            echo "<li class='nav-item'>
                    <a class='nav-link' href='#'>Welcome ".$_SESSION['username']."</a>
                  </li>";
          }

          if(!isset($_SESSION['username'])){
            echo "<li class='nav-item'>
                    <a class='nav-link' href='./users_area/user_login.php'>Login</a>
                  </li>";
          }else{
            echo "<li class='nav-item'>
                    <a class='nav-link' href='./users_area/logout.php'>Logout</a>
                  </li>";
          }
          ?>
        </ul>
      </nav>

      <!-- Third Child -->
      <div class="bg-light">
        <h3 class="text-center">NepalBazar Store</h3>
        <p class="text-center">Collaborating for a Better Shopping Experience</p>
      </div>

      <!-- fourth child -->
      <div class="container product-details-container">
        <div class="row g-4">
            <div class="col-lg-9 order-lg-2">
                <!-- Products -->
                <div class="row">
                    <?php
                    // calling function
                    view_details();
                    get_unique_categories();
                    get_unique_brand();
                    ?>
                </div>
            </div>

            <div class="col-lg-3 order-lg-1">
                <!-- Brands Sidebar -->
         

      <!-- Last child -->
      <!-- Include footer -->
     
 </div>
 
 <!-- Bootstrap js link -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>