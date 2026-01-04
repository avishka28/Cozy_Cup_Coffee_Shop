<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-calendar-plus me-3"></i>Reserve a Table
            </h1>
            <p class="lead text-muted">Book your table at our cozy café</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Reservation Details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo SITE_URL; ?>/public/index.php?action=check-availability">
                        <?php echo SecurityHelper::getCSRFTokenField(); ?>
                        
                        <div class="mb-3">
                            <label for="reservation_date" class="form-label fw-bold">Reservation Date *</label>
                            <input type="date" class="form-control form-control-lg" id="reservation_date" name="reservation_date" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="reservation_time" class="form-label fw-bold">Reservation Time *</label>
                            <input type="time" class="form-control form-control-lg" id="reservation_time" name="reservation_time" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="number_of_guests" class="form-label fw-bold">Number of Guests *</label>
                            <input type="number" class="form-control form-control-lg" id="number_of_guests" name="number_of_guests" min="1" max="20" placeholder="How many guests?" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-search me-2"></i>Check Availability
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
