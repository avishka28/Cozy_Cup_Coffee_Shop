<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <a href="<?php echo SITE_URL; ?>/public/index.php?page=account" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Back to Account
            </a>
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-calendar-check me-3"></i>Reservation Details
            </h1>
            <p class="text-muted">Reservation #<?php echo $reservation['id']; ?></p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Reservation Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Reservation ID</small>
                        <p class="mb-0"><strong>#<?php echo $reservation['id']; ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Reservation Date</small>
                        <p class="mb-0"><strong><?php echo date('M d, Y', strtotime($reservation['reservation_date'])); ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Reservation Time</small>
                        <p class="mb-0"><strong><?php echo date('H:i', strtotime($reservation['reservation_time'])); ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Table</small>
                        <p class="mb-0"><span class="badge bg-secondary">Table <?php echo $reservation['table_number']; ?></span></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Number of Guests</small>
                        <p class="mb-0"><strong><i class="fas fa-users me-1"></i><?php echo $reservation['number_of_guests']; ?> guests</strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <p class="mb-0">
                            <span class="badge bg-<?php echo $reservation['status'] === 'Accepted' ? 'success' : ($reservation['status'] === 'Pending' ? 'warning' : 'danger'); ?>">
                                <?php echo SecurityHelper::escapeOutput($reservation['status']); ?>
                            </span>
                        </p>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted">Created</small>
                        <p class="mb-0"><strong><?php echo date('M d, Y H:i', strtotime($reservation['created_at'])); ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
