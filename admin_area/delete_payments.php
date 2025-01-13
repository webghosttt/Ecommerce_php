<?php
if (isset($_GET['delete_payments'])) {
    $delete_id = $_GET['delete_payments'];
    // Delete query
    $delete_payments = "DELETE FROM `user_payments` WHERE order_id=$delete_id";
    $result_payments = mysqli_query($con, $delete_payments);

    if ($result_payments) {
        echo "<script>alert('Payment deleted successfully')</script>";
        echo "<script>window.open('./index.php', '_self')</script>";
    } else {
        echo "<script>alert('Failed to delete the payment')</script>";
    }
}
?>