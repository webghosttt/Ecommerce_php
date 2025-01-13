<?php
if (isset($_GET['delete_orders'])) {
    $delete_id = $_GET['delete_orders'];
    // Delete query
    $delete_orders = "DELETE FROM `user_orders` WHERE order_id=$delete_id";
    $result_orders = mysqli_query($con, $delete_orders);

    if ($result_orders) {
        echo "<script>alert('Order deleted successfully')</script>";
        echo "<script>window.open('./index.php', '_self')</script>";
    } else {
        echo "<script>alert('Failed to delete the order')</script>";
    }
}
?>