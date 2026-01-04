<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-chair me-3"></i>Select a Table
            </h1>
            <p class="text-muted">Choose your preferred table</p>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <small class="text-muted">Date</small>
                            <p class="mb-0"><strong><?php echo date('M d, Y', strtotime($reservation_date)); ?></strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Time</small>
                            <p class="mb-0"><strong><?php echo date('H:i', strtotime($reservation_time)); ?></strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Guests</small>
                            <p class="mb-0"><strong><i class="fas fa-users me-1"></i><?php echo $number_of_guests; ?> guests</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if (empty($available_tables)): ?>
        <div class="row">
            <div class="col-12">
                <div class="empty-state card border-0 shadow-sm">
                    <div class="card-body py-5">
                        <i class="fas fa-ban"></i>
                        <h4 class="mt-3">No Tables Available</h4>
                        <p class="text-muted mb-4">No tables are available for the selected date and time.</p>
                        <a href="<?php echo SITE_URL; ?>/public/index.php?page=reservations" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Try Another Time
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <form method="POST" action="<?php echo SITE_URL; ?>/public/index.php?action=create-reservation">
            <?php echo SecurityHelper::getCSRFTokenField(); ?>
            <input type="hidden" name="reservation_date" value="<?php echo $reservation_date; ?>">
            <input type="hidden" name="reservation_time" value="<?php echo $reservation_time; ?>">
            <input type="hidden" name="number_of_guests" value="<?php echo $number_of_guests; ?>">
            
            <div class="row g-4 mb-5">
                <?php foreach ($available_tables as $table): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="table-option-card">
                            <input type="radio" id="table_<?php echo $table['id']; ?>" name="table_id" value="<?php echo $table['id']; ?>" required>
                            <label for="table_<?php echo $table['id']; ?>" class="w-100">
                                <div class="card border-2 h-100 cursor-pointer">
                                    <div class="card-body text-center">
                                        <i class="fas fa-chair fa-3x text-primary mb-3"></i>
                                        <h5 class="card-title">Table <?php echo $table['table_number']; ?></h5>
                                        <p class="card-text text-muted">
                                            <i class="fas fa-users me-1"></i>Capacity: <?php echo $table['capacity']; ?> guests
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="row">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg me-2">
                        <i class="fas fa-check me-2"></i>Confirm Reservation
                    </button>
                    <a href="<?php echo SITE_URL; ?>/public/index.php?page=reservations" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<style>
    .table-option-card input[type="radio"] {
        display: none;
    }
    
    .table-option-card input[type="radio"]:checked + label .card {
        border-color: #8B4513 !important;
        background: linear-gradient(135deg, rgba(139, 69, 19, 0.05) 0%, rgba(210, 105, 30, 0.05) 100%);
    }
    
    .table-option-card label {
        cursor: pointer;
    }
    
    .table-option-card .card {
        transition: all 0.3s ease;
    }
    
    .table-option-card .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
