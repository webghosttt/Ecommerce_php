<?php
include('./includes/connect.php');
include('./functions/common_function.php');

echo "<h2>Cart and Price Debugging</h2>";

// Get user IP
$user_ip = getIPAddress();
echo "User IP: " . $user_ip . "<br><br>";

// Fetch cart items
echo "<h3>Cart Items</h3>";
$cart_query = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
$result_cart = mysqli_query($con, $cart_query);
$count_cart = mysqli_num_rows($result_cart);

if($count_cart == 0) {
    echo "Cart is empty";
} else {
    echo "Number of items in cart: " . $count_cart . "<br><br>";
    
    echo "<table border='1' cellpadding='5'>
    <tr>
        <th>Product ID</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Subtotal</th>
    </tr>";
    
    $total_price = 0;
    
    while($row = mysqli_fetch_array($result_cart)) {
        $product_id = $row['product_id'];
        $quantity = isset($row['quantity']) ? $row['quantity'] : "Not set (using default 1)";
        $quantity_for_calc = isset($row['quantity']) ? (int)$row['quantity'] : 1;
        
        $select_products = "SELECT * FROM `products` WHERE product_id='$product_id'";
        $result_products = mysqli_query($con, $select_products);
        $row_product = mysqli_fetch_array($result_products);
        
        if($row_product) {
            $product_price = $row_product['product_price'];
            $product_title = $row_product['product_title'];
            $subtotal = $product_price * $quantity_for_calc;
            $total_price += $subtotal;
            
            echo "<tr>
                <td>$product_id ($product_title)</td>
                <td>$quantity</td>
                <td>$product_price</td>
                <td>$subtotal</td>
            </tr>";
        } else {
            echo "<tr>
                <td>$product_id (Product not found)</td>
                <td>$quantity</td>
                <td>N/A</td>
                <td>N/A</td>
            </tr>";
        }
    }
    
    echo "<tr>
        <td colspan='3' align='right'><strong>Total:</strong></td>
        <td><strong>$total_price</strong></td>
    </tr>";
    echo "</table>";
}

// Show cart_details table structure
echo "<h3>Cart Details Table Structure</h3>";
$result = mysqli_query($con, 'DESCRIBE cart_details');
if($result) {
    echo "<table border='1' cellpadding='5'>
    <tr>
        <th>Field</th>
        <th>Type</th>
        <th>Null</th>
        <th>Key</th>
        <th>Default</th>
        <th>Extra</th>
    </tr>";
    
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['Field']}</td>
            <td>{$row['Type']}</td>
            <td>{$row['Null']}</td>
            <td>{$row['Key']}</td>
            <td>{$row['Default']}</td>
            <td>{$row['Extra']}</td>
        </tr>";
    }
    
    echo "</table>";
} else {
    echo "Error getting table structure: " . mysqli_error($con);
}

// Check for the quantity column specifically
$check_quantity_column = "SHOW COLUMNS FROM `cart_details` LIKE 'quantity'";
$result_quantity = mysqli_query($con, $check_quantity_column);
if(mysqli_num_rows($result_quantity) > 0) {
    echo "<p>✅ 'quantity' column exists in cart_details table</p>";
} else {
    echo "<p>❌ 'quantity' column does NOT exist in cart_details table</p>";
    
    // Suggest solution
    echo "<h3>Solution</h3>";
    echo "<p>The 'quantity' column is missing from the cart_details table. You need to add it using this SQL:</p>";
    echo "<pre>ALTER TABLE `cart_details` ADD `quantity` INT NOT NULL DEFAULT '1';</pre>";
    
    // Provide a button to automatically fix the issue
    echo "<form method='post'>
        <input type='submit' name='fix_table' value='Add quantity column to cart_details table'>
    </form>";
    
    // Handle the fix if the button is clicked
    if(isset($_POST['fix_table'])) {
        $alter_query = "ALTER TABLE `cart_details` ADD `quantity` INT NOT NULL DEFAULT '1'";
        if(mysqli_query($con, $alter_query)) {
            echo "<p>✅ Successfully added 'quantity' column to cart_details table. Please refresh the page.</p>";
        } else {
            echo "<p>❌ Error adding column: " . mysqli_error($con) . "</p>";
        }
    }
}
?> 