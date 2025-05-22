<?php
include('./includes/connect.php');

// Check if the quantity column exists
$check_query = "SHOW COLUMNS FROM `cart_details` LIKE 'quantity'";
$result = mysqli_query($con, $check_query);

if(mysqli_num_rows($result) == 0) {
    // Column doesn't exist, add it
    $alter_query = "ALTER TABLE `cart_details` ADD `quantity` INT NOT NULL DEFAULT '1'";
    
    if(mysqli_query($con, $alter_query)) {
        echo "<div style='padding: 20px; background-color: #d4edda; color: #155724; border-radius: 5px; margin: 20px;'>
            <h2>Success!</h2>
            <p>Successfully added the 'quantity' column to the cart_details table.</p>
            <p>This column is required for proper calculation of cart totals.</p>
            <p><a href='index.php' style='color: #155724; text-decoration: underline;'>Return to home page</a></p>
        </div>";
    } else {
        echo "<div style='padding: 20px; background-color: #f8d7da; color: #721c24; border-radius: 5px; margin: 20px;'>
            <h2>Error</h2>
            <p>Failed to add the 'quantity' column: " . mysqli_error($con) . "</p>
            <p>Please try again or contact the administrator.</p>
            <p><a href='index.php' style='color: #721c24; text-decoration: underline;'>Return to home page</a></p>
        </div>";
    }
} else {
    echo "<div style='padding: 20px; background-color: #d1ecf1; color: #0c5460; border-radius: 5px; margin: 20px;'>
        <h2>Information</h2>
        <p>The 'quantity' column already exists in the cart_details table.</p>
        <p>No changes were made to the database.</p>
        <p><a href='index.php' style='color: #0c5460; text-decoration: underline;'>Return to home page</a></p>
    </div>";
}
?> 