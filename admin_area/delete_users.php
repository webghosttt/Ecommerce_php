<?php
if (isset($_GET['delete_users'])) {
    $delete_id = $_GET['delete_users'];
    // Delete query
    $delete_users = "DELETE FROM `user_table` WHERE user_id=$delete_id";
    $result_users = mysqli_query($con, $delete_users);

    if ($result_users) {
        echo "<script>alert('User deleted successfully')</script>";
        echo "<script>window.open('./index.php', '_self')</script>";
    } else {
        echo "<script>alert('Failed to delete the User')</script>";
    }
}
?>