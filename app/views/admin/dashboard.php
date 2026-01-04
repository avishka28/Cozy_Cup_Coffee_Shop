<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-12">
                <h1><i class="fas fa-chart-line me-3"></i>Admin Dashboard</h1>
                <p>Welcome back! Manage your coffee shop operations</p>
            </div>
        </div>
    </div>
    
    <div class="row g-4 mt-2">
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card">
                <i class="fas fa-utensils text-primary"></i>
                <h5>Menu Management</h5>
                <p>Add, edit, or delete menu items</p>
                <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu-management" class="btn btn-primary btn-sm w-100">
                    <i class="fas fa-arrow-right me-2"></i>Manage Menu
                </a>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card">
                <i class="fas fa-box text-success"></i>
                <h5>Order Management</h5>
                <p>View and manage customer orders</p>
                <a href="<?php echo SITE_URL; ?>/public/index.php?page=order-management" class="btn btn-success btn-sm w-100">
                    <i class="fas fa-arrow-right me-2"></i>Manage Orders
                </a>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card">
                <i class="fas fa-calendar-check text-info"></i>
                <h5>Reservation Management</h5>
                <p>Accept or decline table reservations</p>
                <a href="<?php echo SITE_URL; ?>/public/index.php?page=reservation-management" class="btn btn-info btn-sm w-100">
                    <i class="fas fa-arrow-right me-2"></i>Manage Reservations
                </a>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card">
                <i class="fas fa-users text-warning"></i>
                <h5>Customer Management</h5>
                <p>View customer information and history</p>
                <a href="<?php echo SITE_URL; ?>/public/index.php?page=customer-management" class="btn btn-warning btn-sm w-100">
                    <i class="fas fa-arrow-right me-2"></i>Manage Customers
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
