<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="mb-4">
                <i class="fas fa-check-circle fa-5x text-success"></i>
            </div>
            <h1 class="display-4 fw-bold mb-3">Reservation Confirmed!</h1>
            <p class="lead text-muted">Your table has been reserved. We look forward to seeing you!</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Reservation Details</h5>
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
                    <div class="mb-0">
                        <small class="text-muted">Status</small>
                        <p class="mb-0"><span class="badge bg-success">Confirmed</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12 text-center">
            <a href="<?php echo SITE_URL; ?>/public/index.php?page=account" class="btn btn-primary btn-lg me-2">
                <i class="fas fa-eye me-2"></i>View My Reservations
            </a>
            <a href="<?php echo SITE_URL; ?>/public/index.php?page=home" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-home me-2"></i>Back to Home
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
