<?php
// Check session
if(!isset($_SESSION['admin_username'])){
    $admin_username = 'Admin';
    $admin_email = 'admin@nepalbazar.com';
} else {
    $admin_username = $_SESSION['admin_username'];
    $admin_email = $_SESSION['admin_email'] ?? 'admin@nepalbazar.com';
}

// Mock data for the admin profile
$admin_role = "Administrator";
$admin_joined = "January 10, 2023";
$admin_last_login = date('F j, Y, g:i a', strtotime('-2 days'));

// Get order statistics
$get_pending_orders = "SELECT COUNT(*) as pending_count FROM user_orders WHERE order_status='Pending'";
$result_pending = mysqli_query($con, $get_pending_orders);
$pending_orders = 0;
if ($result_pending) {
    $row_pending = mysqli_fetch_assoc($result_pending);
    $pending_orders = $row_pending['pending_count'];
}

$get_completed_orders = "SELECT COUNT(*) as completed_count FROM user_orders WHERE order_status='Complete'";
$result_completed = mysqli_query($con, $get_completed_orders);
$completed_orders = 0;
if ($result_completed) {
    $row_completed = mysqli_fetch_assoc($result_completed);
    $completed_orders = $row_completed['completed_count'];
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4">Admin Profile</h1>
        </div>
    </div>
    
    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary text-white mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                        <i class="fas fa-user-tie" style="font-size: 60px;"></i>
                    </div>
                    <h3 class="card-title"><?php echo $admin_username; ?></h3>
                    <p class="text-muted"><?php echo $admin_role; ?></p>
                    <p class="mb-2"><i class="fas fa-envelope me-2"></i> <?php echo $admin_email; ?></p>
                    <p class="mb-4"><i class="fas fa-calendar me-2"></i> Joined: <?php echo $admin_joined; ?></p>
                    <button class="btn btn-primary w-100"><i class="fas fa-user-edit me-2"></i> Edit Profile</button>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success p-3 text-white me-3">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Admin Activities</h6>
                                    <h4 class="fw-bold mb-0">158</h4>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-warning p-3 text-white me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Completed Tasks</h6>
                                    <h4 class="fw-bold mb-0">42</h4>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-danger p-3 text-white me-3">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Last Login</h6>
                                    <h4 class="fw-bold mb-0"><?php echo $admin_last_login; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-info p-3 text-white me-3">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Security Status</h6>
                                    <h4 class="fw-bold mb-0">Good</h4>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Status Cards -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-warning p-3 text-white me-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Pending Orders</h6>
                                    <h4 class="fw-bold mb-0"><?php echo $pending_orders; ?></h4>
                                    <small class="text-muted"><?php echo $pending_orders; ?> order(s) awaiting processing</small>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <a href="index.php?list_orders" class="btn btn-sm btn-warning">Process Orders</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success p-3 text-white me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Completed Orders</h6>
                                    <h4 class="fw-bold mb-0"><?php echo $completed_orders; ?></h4>
                                    <small class="text-muted"><?php echo $completed_orders; ?> order(s) successfully delivered</small>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <a href="index.php?list_orders" class="btn btn-sm btn-success">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Activities</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center py-3">
                            <div class="rounded-circle bg-primary p-2 text-white me-3">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div>
                                <p class="mb-0">Updated product inventory for "Smart Watch Pro"</p>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center py-3">
                            <div class="rounded-circle bg-success p-2 text-white me-3">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div>
                                <p class="mb-0">Changed order status to "Shipped" for Order #ORD-0123</p>
                                <small class="text-muted">Yesterday at 4:30 PM</small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center py-3">
                            <div class="rounded-circle bg-warning p-2 text-white me-3">
                                <i class="fas fa-box"></i>
                            </div>
                            <div>
                                <p class="mb-0">Added new product "Wireless Earbuds Pro"</p>
                                <small class="text-muted">2 days ago</small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center py-3">
                            <div class="rounded-circle bg-info p-2 text-white me-3">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <p class="mb-0">Added new category "Smart Home"</p>
                                <small class="text-muted">3 days ago</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Security Settings -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Security Settings</h5>
                </div>
                <div class="card-body">
                    <form class="row g-3">
                        <div class="col-md-6">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password">
                        </div>
                        <div class="col-md-6">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password">
                        </div>
                        <div class="col-md-6">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold">Two-Factor Authentication</h6>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="enable_2fa">
                                <label class="form-check-label" for="enable_2fa">Enable Two-Factor Authentication</label>
                            </div>
                            <small class="text-muted d-block mt-1">Add an extra layer of security to your account by requiring more than just a password to sign in.</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 