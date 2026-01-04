<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 fw-bold mb-2">
                <i class="fas fa-user-circle me-3"></i>My Account
            </h1>
            <p class="text-muted">Manage your profile and view your orders</p>
        </div>
    </div>
    
    <!-- Profile Section -->
    <div class="row mb-5">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Full Name</small>
                        <p class="mb-0"><strong><?php echo SecurityHelper::escapeOutput($profile['full_name']); ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Email Address</small>
                        <p class="mb-0"><strong><?php echo SecurityHelper::escapeOutput($profile['email']); ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Phone Number</small>
                        <p class="mb-0"><strong><?php echo SecurityHelper::escapeOutput($profile['phone']); ?></strong></p>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted">Member Since</small>
                        <p class="mb-0"><strong><?php echo date('M d, Y', strtotime($profile['created_at'])); ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-box me-2"></i>My Orders</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($orders)): ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h6 class="mt-3">No Orders Yet</h6>
                            <p class="text-muted small">You haven't placed any orders yet.</p>
                            <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu" class="btn btn-sm btn-primary">
                                <i class="fas fa-shopping-cart me-1"></i>Start Ordering
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><strong>#<?php echo $order['id']; ?></strong></td>
                                            <td><?php echo SecurityHelper::escapeOutput($order['order_type']); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                            <td><strong>Rs.<?php echo number_format($order['total_price'], 2); ?></strong></td>
                                            <td>
                                                <span class="badge bg-<?php echo $order['status'] === 'Completed' ? 'success' : ($order['status'] === 'Pending' ? 'warning' : 'danger'); ?>">
                                                    <?php echo SecurityHelper::escapeOutput($order['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo SITE_URL; ?>/public/index.php?page=order-details&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reservations Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>My Reservations</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($reservations)): ?>
                        <div class="empty-state">
                            <i class="fas fa-calendar"></i>
                            <h6 class="mt-3">No Reservations Yet</h6>
                            <p class="text-muted small">You haven't made any reservations yet.</p>
                            <a href="<?php echo SITE_URL; ?>/public/index.php?page=reservations" class="btn btn-sm btn-primary">
                                <i class="fas fa-calendar-plus me-1"></i>Make a Reservation
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Reservation ID</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Table</th>
                                        <th>Guests</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reservations as $reservation): ?>
                                        <tr>
                                            <td><strong>#<?php echo $reservation['id']; ?></strong></td>
                                            <td><?php echo date('M d, Y', strtotime($reservation['reservation_date'])); ?></td>
                                            <td><?php echo date('H:i', strtotime($reservation['reservation_time'])); ?></td>
                                            <td>Table <?php echo $reservation['table_number']; ?></td>
                                            <td><i class="fas fa-users me-1"></i><?php echo $reservation['number_of_guests']; ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $reservation['status'] === 'Accepted' ? 'success' : ($reservation['status'] === 'Pending' ? 'warning' : 'danger'); ?>">
                                                    <?php echo SecurityHelper::escapeOutput($reservation['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo SITE_URL; ?>/public/index.php?page=reservation-details&id=<?php echo $reservation['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
