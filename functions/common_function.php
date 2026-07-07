<?php
// including connect file
// include('./includes/connect.php');

// getting functions
function getproducts(){
    global $con;
    // condition to check isset or not
    if(!isset($_GET['category'])){
      if(!isset($_GET['brand'])){
    
    $select_query="Select * from `products` order by rand() limit 0,9";
            $result_query=mysqli_query($con,$select_query);
            // $row=mysqli_fetch_assoc($result_query);
            // echo $row['product_title'];
            while($row=mysqli_fetch_assoc($result_query)){
              $product_id=$row['product_id'];
              $product_title=$row['product_title'];
              $product_description=$row['product_description'];
              $product_image1=$row['product_image1'];
              $product_price=$row['product_price'];
              $category_id=$row['category_id'];
              $brand_id=$row['brand_id'];
              echo "<div class='col-md-4 mb-4'>
                <div class='card h-100 product-card'>
                  <div class='position-relative'>
                    <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                    <a href='product_details.php?product_id=$product_id' class='btn btn-sm btn-light quick-view-btn'>
                      <i class='fas fa-eye'></i> Quick View
                    </a>
                  </div>
                  <div class='card-body d-flex flex-column'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text flex-grow-1'>$product_description</p>
                    <div class='d-flex justify-content-between align-items-center mt-2'>
                      <span class='price-display'>Rs. $product_price/-</span>
                      <div class='btn-group'>
                        <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>
                          <i class='fas fa-cart-plus me-1'></i>Add To Cart
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>";
            }
          }
        }
}



// getting all products
function get_all_products(){
  global $con;
    // condition to check isset or not
    if(!isset($_GET['category'])){
      if(!isset($_GET['brand'])){
    
    $select_query="Select * from `products` order by rand()";
            $result_query=mysqli_query($con,$select_query);
            // $row=mysqli_fetch_assoc($result_query);
            // echo $row['product_title'];
            while($row=mysqli_fetch_assoc($result_query)){
              $product_id=$row['product_id'];
              $product_title=$row['product_title'];
              $product_description=$row['product_description'];
              $product_image1=$row['product_image1'];
              $product_price=$row['product_price'];
              $category_id=$row['category_id'];
              $brand_id=$row['brand_id'];
              echo "<div class='col-md-4 mb-4'>
                <div class='card h-100 product-card'>
                  <div class='position-relative'>
                    <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                    <a href='product_details.php?product_id=$product_id' class='btn btn-sm btn-light quick-view-btn'>
                      <i class='fas fa-eye'></i> Quick View
                    </a>
                  </div>
                  <div class='card-body d-flex flex-column'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text flex-grow-1'>$product_description</p>
                    <div class='d-flex justify-content-between align-items-center mt-2'>
                      <span class='price-display'>Rs. $product_price/-</span>
                      <div class='btn-group'>
                        <a href='display_all.php?add_to_cart=$product_id' class='btn btn-primary'>
                          <i class='fas fa-cart-plus me-1'></i>Add To Cart
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>";
            }
          }
        }
}

// getting unique categories
function get_unique_categories(){
  global $con;
  // condition to check isset or not
  if(isset($_GET['category'])){
    $category_id=$_GET['category'];
    
  
  $select_query="Select * from `products` where category_id=$category_id ";
          $result_query=mysqli_query($con,$select_query);
          $num_of_rows=mysqli_num_rows($result_query);
          if($num_of_rows==0){
            echo "<h2 class='text-center text-danger'>No Stock for this category</h2>";
          }
          
          while($row=mysqli_fetch_assoc($result_query)){
            $product_id=$row['product_id'];
            $product_title=$row['product_title'];
            $product_description=$row['product_description'];
            $product_image1=$row['product_image1'];
            $product_price=$row['product_price'];
            $category_id=$row['category_id'];
            $brand_id=$row['brand_id'];
            echo "<div class='col-md-4 mb-4'>
                <div class='card h-100 product-card'>
                  <div class='position-relative'>
                    <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                    <a href='product_details.php?product_id=$product_id' class='btn btn-sm btn-light quick-view-btn'>
                      <i class='fas fa-eye'></i> Quick View
                    </a>
                  </div>
                  <div class='card-body d-flex flex-column'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text flex-grow-1'>$product_description</p>
                    <div class='d-flex justify-content-between align-items-center mt-2'>
                      <span class='price-display'>Rs. $product_price/-</span>
                      <div class='btn-group'>
                        <a href='display_all.php?add_to_cart=$product_id' class='btn btn-primary'>
                          <i class='fas fa-cart-plus me-1'></i>Add To Cart
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>";
          }
        }
      }

      
      
      // getting unique brands
function get_unique_brand(){
  global $con;
  // condition to check isset or not
  if(isset($_GET['brand'])){
    $brand_id=$_GET['brand'];
    
  
  $select_query="Select * from `products` where brand_id=$brand_id ";
          $result_query=mysqli_query($con,$select_query);
          $num_of_rows=mysqli_num_rows($result_query);
          if($num_of_rows==0){
            echo "<h2 class='text-center text-danger'>No Stock for this brand</h2>";
          }
          
          while($row=mysqli_fetch_assoc($result_query)){
            $product_id=$row['product_id'];
            $product_title=$row['product_title'];
            $product_description=$row['product_description'];
            $product_image1=$row['product_image1'];
            $product_price=$row['product_price'];
            $category_id=$row['category_id'];
            $brand_id=$row['brand_id'];
            echo "<div class='col-md-4 mb-4'>
                <div class='card h-100 product-card'>
                  <div class='position-relative'>
                    <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                    <a href='product_details.php?product_id=$product_id' class='btn btn-sm btn-light quick-view-btn'>
                      <i class='fas fa-eye'></i> Quick View
                    </a>
                  </div>
                  <div class='card-body d-flex flex-column'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text flex-grow-1'>$product_description</p>
                    <div class='d-flex justify-content-between align-items-center mt-2'>
                      <span class='price-display'>Rs. $product_price/-</span>
                      <div class='btn-group'>
                        <a href='display_all.php?add_to_cart=$product_id' class='btn btn-primary'>
                          <i class='fas fa-cart-plus me-1'></i>Add To Cart
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>";
          }
        }
      }









// displaying brands in sidenav
function getbrands(){
    global $con;
    $select_brands="select * from `brands`";
    $result_brands=mysqli_query($con,$select_brands);
    while($row_data=mysqli_fetch_assoc($result_brands)){
      $brand_title=$row_data['brand_title'];
      $brand_id=$row_data['brand_id'];
      echo" <li class='nav-item'>
      <a href='index.php?brand=$brand_id' class='nav-link text-light'>$brand_title</a>
      </li>";
    }
}

// displaying categories in sidenav
function getcategories(){
    global $con;
    $select_categories="select * from `categories`";
          $result_categories=mysqli_query($con,$select_categories);
          while($row_data=mysqli_fetch_assoc($result_categories)){
            $category_title=$row_data['category_title'];
            $category_id=$row_data['category_id'];
            echo" <li class='nav-item'>
            <a href='index.php?category=$category_id' class='nav-link text-light'>$category_title</a>
            </li>";
          }
}


// searching product
function search_product(){
  global $con;
  if(isset($_GET['search_data_product'])){
    $search_data_value=$_GET['search_data'];
  $search_query="Select * from `products` where product_keywords like '%$search_data_value%'";

            $result_query=mysqli_query($con,$search_query);
            $num_of_rows=mysqli_num_rows($result_query);
          if($num_of_rows==0){
            // Get popular categories for suggestions
            $category_query = "SELECT * FROM categories LIMIT 6";
            $category_result = mysqli_query($con, $category_query);
            
            // Get popular keywords for suggestions
            $keywords = array('laptop', 'phone', 'headphones', 'camera', 'speaker', 'watch');
            
            echo "
            <div class='no-results-container'>
                <div class='no-results-icon'>
                    <i class='fas fa-search'></i>
                </div>
                <h2 class='no-results-title'>Oops! No results found</h2>
                <p class='no-results-text'>
                    Sorry, we couldn't find any products matching '<strong>$search_data_value</strong>'. 
                    Please try another search term or browse our categories.
                </p>
                
                <div class='search-suggestion'>
                    <h4>Popular Searches</h4>
                    <div class='search-suggestion-list'>";
                    
                    foreach($keywords as $keyword) {
                        echo "<a href='search_product.php?search_data=$keyword&search_data_product=Search' class='search-keyword'>$keyword</a>";
                    }
                    
                    echo "</div>
                </div>
                
                <div class='category-suggestions'>
                    <a href='index.php' class='back-btn'><i class='fas fa-home'></i> Back to Homepage</a>
                </div>
                
                <div class='category-suggestions'>";
                
                // Display category cards
                while($category = mysqli_fetch_assoc($category_result)) {
                    $category_id = $category['category_id'];
                    $category_title = $category['category_title'];
                    $icon_class = '';
                    
                    // Assign icons based on category name
                    if(stripos($category_title, 'laptop') !== false) {
                        $icon_class = 'fas fa-laptop';
                    } elseif(stripos($category_title, 'mobile') !== false) {
                        $icon_class = 'fas fa-mobile-alt';
                    } elseif(stripos($category_title, 'camera') !== false) {
                        $icon_class = 'fas fa-camera';
                    } elseif(stripos($category_title, 'watch') !== false) {
                        $icon_class = 'fas fa-clock';
                    } elseif(stripos($category_title, 'speaker') !== false) {
                        $icon_class = 'fas fa-volume-up';
                    } else {
                        $icon_class = 'fas fa-box';
                    }
                    
                    echo "
                    <a href='index.php?category=$category_id' class='category-card'>
                        <div class='category-icon'><i class='$icon_class'></i></div>
                        <p class='category-name'>$category_title</p>
                    </a>";
                }
                
                echo "
                </div>
            </div>
            ";
          }
            while($row=mysqli_fetch_assoc($result_query)){
              $product_id=$row['product_id'];
              $product_title=$row['product_title'];
              $product_description=$row['product_description'];
              $product_image1=$row['product_image1'];
              $product_price=$row['product_price'];
              $category_id=$row['category_id'];
              $brand_id=$row['brand_id'];
              echo "<div class='col-md-4 mb-4'>
                <div class='card h-100 product-card'>
                  <div class='position-relative'>
                    <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                    <a href='product_details.php?product_id=$product_id' class='btn btn-sm btn-light quick-view-btn'>
                      <i class='fas fa-eye'></i> Quick View
                    </a>
                  </div>
                  <div class='card-body d-flex flex-column'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text flex-grow-1'>$product_description</p>
                    <div class='d-flex justify-content-between align-items-center mt-2'>
                      <span class='price-display'>Rs. $product_price/-</span>
                      <div class='btn-group'>
                        <a href='display_all.php?add_to_cart=$product_id' class='btn btn-primary'>
                          <i class='fas fa-cart-plus me-1'></i>Add To Cart
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>";
            }
          }
        }
        
//view details function
function view_details(){
  global $con;
    // condition to check isset or not
    if(isset($_GET['product_id'])){
    if(!isset($_GET['category'])){
      if(!isset($_GET['brand'])){
        $product_id=$_GET['product_id'];
    
    $select_query="Select * from `products` where product_id=$product_id";
            $result_query=mysqli_query($con,$select_query);
            // $row=mysqli_fetch_assoc($result_query);
            // echo $row['product_title'];
            while($row=mysqli_fetch_assoc($result_query)){
              $product_id=$row['product_id'];
              $product_title=$row['product_title'];
              $product_description=$row['product_description'];
              $product_image1=$row['product_image1'];
              $product_image2=$row['product_image2'];
              $product_image3=$row['product_image3'];
              $product_price=$row['product_price'];
              $category_id=$row['category_id'];
              $brand_id=$row['brand_id'];
              echo "<div class='col-md-4 mb-2'>
              <div class='card'>
                    <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                    <div class='card-body'>
                      <h5 class='card-title'>$product_title</h5>
                      <p class='card-text'>$product_description</p>
                      <p class='card-text'>price: $product_price/-</p>
                      <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add To Cart</a>
                      <a href='index.php' class='btn btn-secondary'>Go Home</a>
                    </div>
                  </div></div>
                  <div class='col-md-8'>
                    <!-- related images -->
                     <div class='row'>
                        <div class='class-md-12'>
                            <h4 class='text-center text-info mb-5'>Related products</h4>
                        </div>
                        <div class='col-md-6'>
                        <img src='./admin_area/product_images/$product_image2' class='card-img-top' alt='$product_title'>
                        </div>
                        <div class='col-md-6'>
                        <img src='./admin_area/product_images/$product_image3' class='card-img-top' alt='$product_title'>
                        </div>
                        
                     </div>
                </div>
                  ";
        


            }
          }
        }
}
}
// getting ip address
function getIPAddress() {  
  //whether ip is from the share internet  
   if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
              $ip = $_SERVER['HTTP_CLIENT_IP'];  
      }  
  //whether ip is from the proxy  
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
              $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
   }  
//whether ip is from the remote address  
  else{  
           $ip = $_SERVER['REMOTE_ADDR'];  
   }  
   return $ip;  
}  
// $ip = getIPAddress();  
// echo 'User Real IP Address - '.$ip;


// cart function
function cart(){
if(isset($_GET['add_to_cart'])){
  global $con;
  $get_ip_add = getIPAddress();
  $get_product_id=$_GET['add_to_cart'];
  $select_query="select * from `cart_details` where ip_address='$get_ip_add' and product_id=$get_product_id";
  $result_query=mysqli_query($con,$select_query);
  $num_of_rows=mysqli_num_rows($result_query);
          if($num_of_rows>0){
            echo "<script>alert('This item is already present in cart')</script>";
            echo "<script>window.open('index.php','_self')</script>";

          }else{
            $insert_query="insert into `cart_details` (product_id,ip_address,quantity) values ($get_product_id,'$get_ip_add',0)";
            $result_query=mysqli_query($con,$insert_query);
            echo "<script>alert('This item is added to cart')</script>";
            echo "<script>window.open('index.php','_self')</script>";


          }
}
}


// function to get cart item number
function cart_item(){
  if(isset($_GET['add_to_cart'])){
    global $con;
    $get_ip_add = getIPAddress();
    $select_query="select * from `cart_details` where ip_address='$get_ip_add'";
    $result_query=mysqli_query($con,$select_query);
    $count_cart_items=mysqli_num_rows($result_query);
    }else{
      global $con;
      $get_ip_add = getIPAddress();
      $select_query="select * from `cart_details` where ip_address='$get_ip_add'";
      $result_query=mysqli_query($con,$select_query);
      $count_cart_items=mysqli_num_rows($result_query);
  
  
            }
            echo $count_cart_items;
  }

  // total price function
  function total_cart_price(){
    global $con;
    $get_ip_add = getIPAddress();
    $total_price=0;
    $cart_query="Select * from `cart_details` where ip_address='$get_ip_add'";
    $result=mysqli_query($con,$cart_query);
    while($row=mysqli_fetch_array($result)){
      $product_id=$row['product_id'];
      $select_products="Select * from `products` where product_id='$product_id'";
      $result_product=mysqli_query($con,$select_products);
      while($row_product_price=mysqli_fetch_array($result_product)){
        $product_price=array($row_product_price['product_price']);
        $product_values=array_sum($product_price);
        $total_price+=$product_values;

    }
  }
  echo $total_price;
}

// Get user order details
function get_user_order_details() {
  global $con;
  $username = $_SESSION['username'];
  $get_details = "Select * from `user_table` where username='$username'";
  $result_query = mysqli_query($con, $get_details);

  while ($row_query = mysqli_fetch_array($result_query)) {
      $user_id = $row_query['user_id'];

      if (!isset($_GET['edit_account'])) {
          if (!isset($_GET['my_orders'])) {
              if (!isset($_GET['delete_account'])) {
                  $get_orders = "Select * from `user_orders` where user_id=$user_id and order_status='pending'";
                  $result_orders_query = mysqli_query($con, $get_orders);
                  $row_count = mysqli_num_rows($result_orders_query);

                  if ($row_count > 0) {
                      echo "<h3 class='text-center text-success my-5' >You have <span class='text-danger'>$row_count</span> Pending Orders</h3>
                      <p class='text-center'><a href='profile.php?my_orders' class='text-dark' >Order Details</a></p>";
                  }
              else{
                echo "<h3 class='text-center text-success my-5' >You have Zero Pending Orders</h3>
                      <p class='text-center'><a href='../index.php' class='text-dark' >Explore Products </a></p>";
              }
          }
      }
  }
  }
}

// ============================================================
// PRODUCT RECOMMENDATION ALGORITHM (Content-Based Filtering)
// ============================================================
// This algorithm recommends products similar to the one the user
// is currently viewing. It uses a weighted scoring system:
//
// Scoring Criteria:
//   +3 points — Same category (strongest signal)
//   +2 points — Same brand  
//   +1 point  — Each matching keyword
//   +1 point  — Price within 20% range (similar budget)
//
// Algorithm Steps:
//   1. Fetch the current product's attributes
//   2. Fetch all other products from the database
//   3. For each product, calculate a similarity score
//   4. Sort products by score in descending order
//   5. Return the top N most similar products
// ============================================================

function get_recommended_products($current_product_id, $limit = 4) {
    global $con;
    
    // ── Step 1: Get current product details ──
    $current_product_id = (int)$current_product_id; // sanitize input
    $query = "SELECT * FROM `products` WHERE product_id = $current_product_id";
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) == 0) {
        return []; // product not found
    }
    
    $current_product = mysqli_fetch_assoc($result);
    $current_category = $current_product['category_id'];
    $current_brand = $current_product['brand_id'];
    $current_price = (float)$current_product['product_price'];
    $current_keywords = strtolower($current_product['product_keywords']);
    $current_keyword_array = array_map('trim', explode(',', $current_keywords));
    // Remove empty keywords
    $current_keyword_array = array_filter($current_keyword_array, function($k) {
        return !empty($k);
    });
    
    // ── Step 2: Fetch all other products ──
    $all_query = "SELECT * FROM `products` WHERE product_id != $current_product_id";
    $all_result = mysqli_query($con, $all_query);
    
    $scored_products = [];
    
    // ── Step 3: Calculate similarity score for each product ──
    while ($product = mysqli_fetch_assoc($all_result)) {
        $score = 0;
        $match_reasons = []; // track why this product was recommended
        
        // Criterion 1: Same category (+3 points)
        if ($product['category_id'] == $current_category) {
            $score += 3;
            $match_reasons[] = 'same-category';
        }
        
        // Criterion 2: Same brand (+2 points)
        if ($product['brand_id'] == $current_brand) {
            $score += 2;
            $match_reasons[] = 'same-brand';
        }
        
        // Criterion 3: Keyword overlap (+1 per matching keyword)
        $product_keywords = strtolower($product['product_keywords']);
        $product_keyword_array = array_map('trim', explode(',', $product_keywords));
        $product_keyword_array = array_filter($product_keyword_array, function($k) {
            return !empty($k);
        });
        
        $keyword_matches = array_intersect($current_keyword_array, $product_keyword_array);
        $keyword_score = count($keyword_matches);
        if ($keyword_score > 0) {
            $score += $keyword_score;
            $match_reasons[] = 'keyword-match(' . $keyword_score . ')';
        }
        
        // Criterion 4: Price proximity — within 20% range (+1 point)
        $product_price = (float)$product['product_price'];
        if ($current_price > 0) {
            $price_diff_percent = abs($product_price - $current_price) / $current_price * 100;
            if ($price_diff_percent <= 20) {
                $score += 1;
                $match_reasons[] = 'similar-price';
            }
        }
        
        // Only include products with a score > 0 (at least some similarity)
        if ($score > 0) {
            $product['similarity_score'] = $score;
            $product['match_reasons'] = $match_reasons;
            $scored_products[] = $product;
        }
    }
    
    // ── Step 4: Sort by similarity score (highest first) ──
    usort($scored_products, function($a, $b) {
        return $b['similarity_score'] - $a['similarity_score'];
    });
    
    // ── Step 5: Return top N recommendations ──
    return array_slice($scored_products, 0, $limit);
}

// Display recommended products section with visual match indicators
function display_recommendations($product_id) {
    $recommendations = get_recommended_products($product_id, 4);
    
    if (empty($recommendations)) {
        return; // no recommendations to show
    }
    
    echo '<div class="recommendations-section">';
    echo '<div class="recommendations-header">';
    echo '<h3><i class="fas fa-magic me-2"></i>You May Also Like</h3>';
    echo '<p class="text-muted">Products recommended</p>';
    echo '</div>';
    echo '<div class="row g-4">';
    
    foreach ($recommendations as $product) {
        $pid = $product['product_id'];
        $title = htmlspecialchars($product['product_title']);
        $desc = htmlspecialchars(substr($product['product_description'], 0, 80)) . '...';
        $image = $product['product_image1'];
        $price = $product['product_price'];
        $score = $product['similarity_score'];
        $reasons = $product['match_reasons'];
        
        // Generate match reason badges
        $badges = '';
        foreach ($reasons as $reason) {
            if ($reason == 'same-category') {
                // $badges .= '<span class="rec-badge rec-badge-category"><i class="fas fa-layer-group me-1"></i>Same Category</span>';
            } elseif ($reason == 'same-brand') {
                // $badges .= '<span class="rec-badge rec-badge-brand"><i class="fas fa-tag me-1"></i>Same Brand</span>';
            } elseif (strpos($reason, 'keyword-match') !== false) {
                // $badges .= '<span class="rec-badge rec-badge-keyword"><i class="fas fa-key me-1"></i>Keyword Match</span>';
            } elseif ($reason == 'similar-price') {
                // $badges .= '<span class="rec-badge rec-badge-price"><i class="fas fa-dollar-sign me-1"></i>Similar Price</span>';
            }
        }
        
        // Calculate match percentage (max possible score ~8, normalize to 100%)
        $match_percent = min(100, round(($score / 8) * 100));
        
        echo '<div class="col-md-6 col-lg-3">';
        echo '<div class="card h-100 rec-card">';
        // echo '<div class="rec-score-badge"><span>' . $match_percent . '% Match</span></div>';
        echo '<img src="./admin_area/product_images/' . $image . '" class="card-img-top" alt="' . $title . '">';
        echo '<div class="card-body d-flex flex-column">';
        echo '<h6 class="card-title fw-bold">' . $title . '</h6>';
        echo '<p class="card-text text-muted small flex-grow-1">' . $desc . '</p>';
        echo '<div class="rec-badges mb-2">' . $badges . '</div>';
        echo '<div class="d-flex justify-content-between align-items-center mt-auto">';
        echo '<span class="fw-bold" style="color: var(--primary-color);">Rs. ' . $price . '/-</span>';
        echo '<a href="product_details.php?product_id=' . $pid . '" class="btn btn-sm btn-outline-primary rounded-pill">';
        echo '<i class="fas fa-eye me-1"></i>View</a>';
        echo '</div></div></div></div>';
    }
    
    echo '</div></div>';
}

?>