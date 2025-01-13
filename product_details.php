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
    <title>Ecommerce Website</title>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <!-- font awesome link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" href="style.css">
     <style>
        body{
        overflow-x:hidden;
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
              <li class="nav-item"></li>
                <a class="nav-link" href="./users_area/user_registration.php">Register</a>
              </li>
              <li class="nav-item"></li>
                <a class="nav-link" href="#">Contact</a>
              </li>
              <li class="nav-item"></li>
                <a class="nav-link" href="#"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item();?></sup></a>
              </li>
              <li class="nav-item"></li>
                <a class="nav-link" href="#">Total Price: <?php total_cart_price();?>/- </a>
              </li>
              
            </ul>
            <form class="d-flex" action="search_product.php" method="get">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
               <input type="submit" value="search" class="btn btn-outline-light" name="search_data_product">
            </form>
          </div>
        </div>
      </nav>
      <!-- Second Child -->
       <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <ul class="navbar-nav me-auto">
           
          <?php
          if(!isset($_SESSION['username'])){
            echo "<li class='nav-item'></li>
                      <a class='nav-link' href='#'>Welcome Guest</a>
                    </li>";
          }else{
            echo "<li class='nav-item'></li>
                      <a class='nav-link' href='#'>Welcome ".$_SESSION['username']."</a>
                    </li>";
          }


          if(!isset($_SESSION['username'])){
            echo "<li class='nav-item'></li>
          <a class='nav-link' href='./users_area/user_login.php'>Login</a>
        </li>";
          }else{
            echo "<li class='nav-item'></li>
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
       <div class="row px-1">
        <div class="col-md-10">
            <!--products  -->
            <div class="row">
                
                    
<!-- fetching product -->
            <?php
            // calling function
            view_details();
            get_unique_categories();
            get_unique_brand();


            ?>
                
                <!-- row end -->

                </div>
                <!-- col end -->
            </div>

        <div class="col-md-2 bg-secondary p-0">
         <ul class="navbar-nav text-light me-auto text-center">
          <li class="nav-item bg-info ">
            <a href="" class="nav-link"><h4>Delivary Brands</h4></a>
          
          <?php
         getbrands();
        ?>
        </ul>
        <!-- categories to be display -->
        <ul class="navbar-nav text-light me-auto text-center">
          <li class="nav-item bg-info ">
            <a href="" class="nav-link"><h4>Categories</h4></a>
          </li>
          
          <?php
          getcategories();
        ?>
        </ul>
        
       
        </div>
       </div>














      <!-- last child -->
       <!-- include footer -->
        <?php
        include("./includes/footer.php")
        ?>
 </div>
 
    



    <!-- Bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>