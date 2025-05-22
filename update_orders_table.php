<?php
include('./includes/connect.php');

// First, check if columns already exist
$check_query = "SHOW COLUMNS FROM `user_orders` LIKE 'payment_mode'";
$result = mysqli_query($con, $check_query);

if(mysqli_num_rows($result) == 0) {
    // Column doesn't exist, add it
    $alter_query = "ALTER TABLE `user_orders` 
                   ADD `payment_mode` VARCHAR(50) NULL DEFAULT 'pending' AFTER `order_status`,
                   ADD `payment_reference` VARCHAR(100) NULL DEFAULT NULL AFTER `payment_mode`";
    
    if(mysqli_query($con, $alter_query)) {
        echo "Successfully added payment_mode and payment_reference columns to user_orders table.";
    } else {
        echo "Error adding columns: " . mysqli_error($con);
    }
} else {
    echo "Columns already exist in the user_orders table.";
}

// Display current table structure
echo "<br><br>Current user_orders table structure:<br>";
$desc_query = "DESCRIBE `user_orders`";
$result = mysqli_query($con, $desc_query);

if($result) {
    while($row = mysqli_fetch_assoc($result)) {
        echo $row['Field'] . " - " . $row['Type'] . "<br>";
    }
} else {
    echo "Error getting table structure: " . mysqli_error($con);
}
?> 