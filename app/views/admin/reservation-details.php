<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row mb-4">
        <div class="col-12">
            <a href="<?php echo SITE_URL; ?>/public/index.php?page=reservation-management" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Back to Reservations
            </a>
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-calendar-check me-3"></i>Reservation Details
            </h1>
            <p class="text-muted">Reservation #<?php echo $reservation['id']; ?></p>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Reservation Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Reservation ID</small>
                        <p class="mb-0"><strong>#<?php echo $reservation['id']; ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Customer Name</small>
                        <p class="mb-0"><strong><?php echo SecurityHelper::escapeOutput($reservation['full_name']); ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Email</small>
                        <p class="mb-0"><a href="mailto:<?php echo SecurityHelper::escapeOutput($reservation['email']); ?>"><?php echo SecurityHelper::escapeOutput($reservation['email']); ?></a></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Phone</small>
                        <p class="mb-0"><a href="tel:<?php echo SecurityHelper::escapeOutput($reservation['phone']); ?>"><?php echo SecurityHelper::escapeOutput($reservation['phone']); ?></a></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Reservation Details</h5>
                </div>
                <div class="card-body">
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
                    <div class="mb-0">
                        <small class="text-muted">Status</small>
                        <p class="mb-0">
                            <span class="badge bg-<?php echo $reservation['status'] === 'Accepted' ? 'success' : ($reservation['status'] === 'Pending' ? 'warning' : 'danger'); ?>">
                                <?php echo SecurityHelper::escapeOutput($reservation['status']); ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted mb-3"><small>Created: <?php echo date('M d, Y H:i', strtotime($reservation['created_at'])); ?></small></p>
                    
                    <div class="d-flex gap-2 flex-wrap">
                        <?php if ($reservation['status'] === 'Pending'): ?>
                            <a href="<?php echo SITE_URL; ?>/public/index.php?action=accept-reservation&id=<?php echo $reservation['id']; ?>" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Accept Reservation
                            </a>
                            <a href="<?php echo SITE_URL; ?>/public/index.php?action=decline-reservation&id=<?php echo $reservation['id']; ?>" class="btn btn-danger">
                                <i class="fas fa-times me-2"></i>Decline Reservation
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
