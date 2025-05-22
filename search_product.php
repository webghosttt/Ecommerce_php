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
        echo "<script>window.open('search_product.php?search_data=" . $_GET['search_data'] . "&search_data_product=Search','_self')</script>";
    } else {
        $insert_query = "INSERT INTO `cart_details` (product_id, ip_address, quantity) VALUES ($product_id, '$ip', 1)";
        $result_query = mysqli_query($con, $insert_query);
        echo "<script>alert('Item is added to cart')</script>";
        echo "<script>window.open('search_product.php?search_data=" . $_GET['search_data'] . "&search_data_product=Search','_self')</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - NepalBazar Store</title>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <!-- font awesome link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" href="style.css">
     <style>
        body{
            overflow-x: hidden;
            background-color: #f9fafb;
        }
        .search-hero {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            padding: 3rem 0;
            color: white;
            margin-bottom: 2rem;
            border-radius: 0 0 10px 10px;
            box-shadow: var(--shadow);
        }
        .search-hero .current-search {
            font-weight: 700;
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            display: inline-block;
            margin-top: 0.5rem;
        }
        .search-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .search-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        .search-count {
            background-color: rgba(255,255,255,0.2);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
            margin-top: 1rem;
        }
        .filter-section {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        .filter-section h4 {
            margin-bottom: 1rem;
            color: var(--dark-color);
            font-weight: 600;
        }
        .filter-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .filter-badge {
            background-color: var(--light-color);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }
        .filter-badge:hover {
            background-color: var(--primary-color);
            color: white;
        }
        .products-grid {
            margin-top: 1rem;
        }
        @media (max-width: 768px) {
            .search-hero {
                text-align: center;
            }
            .search-title {
                font-size: 1.8rem;
            }
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
                <a class="nav-link" href="display_all.php">Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./users_area/user_registration.php">Register</a>
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

      <?php
      // Search Hero Section - Only display when search is performed
      if(isset($_GET['search_data_product']) && isset($_GET['search_data'])) {
          $search_term = $_GET['search_data'];
          
          // Get count of results
          $count_query = "SELECT COUNT(*) as count FROM `products` WHERE product_keywords LIKE '%$search_term%'";
          $count_result = mysqli_query($con, $count_query);
          $count_row = mysqli_fetch_assoc($count_result);
          $result_count = $count_row['count'];
          
          echo "
          <div class='search-hero'>
              <div class='container'>
                  <div class='row align-items-center'>
                      <div class='col-md-8'>
                          <div class='search-title'>Search Results</div>
                          <div class='search-subtitle'>You searched for: <span class='current-search'>".$search_term."</span></div>
                          <div class='search-count'>".$result_count." products found</div>
                      </div>
                      <div class='col-md-4 text-end d-none d-md-block'>
                          <i class='fas fa-search fa-4x' style='opacity: 0.5;'></i>
                      </div>
                  </div>
              </div>
          </div>";
      }
      ?>

      <!-- Filter Section -->
      <div class="container mb-4">
          <div class="filter-section">
              <h4>Quick Filters</h4>
              <div class="filter-badges">
                  <?php
                  // Get some categories for quick filters
                  $category_query = "SELECT * FROM categories LIMIT 5";
                  $category_result = mysqli_query($con, $category_query);
                  while($category = mysqli_fetch_assoc($category_result)){
                      echo "<a href='index.php?category=".$category['category_id']."' class='filter-badge'>".$category['category_title']."</a>";
                  }
                  
                  // Get some brands for quick filters
                  $brand_query = "SELECT * FROM brands LIMIT 3";
                  $brand_result = mysqli_query($con, $brand_query);
                  while($brand = mysqli_fetch_assoc($brand_result)){
                      echo "<a href='index.php?brand=".$brand['brand_id']."' class='filter-badge'>".$brand['brand_title']."</a>";
                  }
                  ?>
                  <a href="display_all.php" class="filter-badge">All Products</a>
              </div>
          </div>
      </div>

      <!-- fourth child -->
      <div class="container">
          <div class="row">
              <div class="col-md-9 order-md-2">
                  <!-- Products -->
                  <div class="row products-grid">
                      <?php
                      // calling function
                      search_product();
                      get_unique_categories();
                      get_unique_brand();
                      ?>
                  </div>
              </div>

              <div class="col-md-3 order-md-1">
                  <div class="sidebar mb-4">
                      <ul class="navbar-nav text-light me-auto text-center">
                          <li class="nav-item bg-info">
                              <a href="#" class="nav-link"><h4>Brands</h4></a>
                          </li>
                          <?php getbrands(); ?>
                      </ul>
                  </div>

                  <!-- Categories to be displayed -->
                  <div class="sidebar">
                      <ul class="navbar-nav text-light me-auto text-center">
                          <li class="nav-item bg-info">
                              <a href="#" class="nav-link"><h4>Categories</h4></a>
                          </li>
                          <?php getcategories(); ?>
                      </ul>
                  </div>
              </div>
          </div>
      </div>

      <!-- Include footer -->
      <?php include("./includes/footer.php"); ?>
 </div>
 
 <!-- Bootstrap js link -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>