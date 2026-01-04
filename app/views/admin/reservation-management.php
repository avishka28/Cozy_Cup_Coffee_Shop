<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-calendar-check me-3"></i>Reservation Management
            </h1>
            <p class="text-muted">Manage table reservations</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Reservations</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Reservation ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Table</th>
                                    <th>Guests</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($reservations)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                            <p class="text-muted">No reservations found</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($reservations as $reservation): ?>
                                        <tr>
                                            <td><strong>#<?php echo $reservation['id']; ?></strong></td>
                                            <td><?php echo SecurityHelper::escapeOutput($reservation['full_name']); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($reservation['reservation_date'])); ?></td>
                                            <td><?php echo date('H:i', strtotime($reservation['reservation_time'])); ?></td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    Table <?php echo $reservation['table_number']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <i class="fas fa-users me-1"></i><?php echo $reservation['number_of_guests']; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $reservation['status'] === 'Accepted' ? 'success' : ($reservation['status'] === 'Pending' ? 'warning' : 'danger'); ?>">
                                                    <?php echo SecurityHelper::escapeOutput($reservation['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo SITE_URL; ?>/public/index.php?page=admin-reservation-details&id=<?php echo $reservation['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($reservation['status'] === 'Pending'): ?>
                                                    <a href="<?php echo SITE_URL; ?>/public/index.php?action=accept-reservation&id=<?php echo $reservation['id']; ?>" class="btn btn-sm btn-outline-success" title="Accept">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a href="<?php echo SITE_URL; ?>/public/index.php?action=decline-reservation&id=<?php echo $reservation['id']; ?>" class="btn btn-sm btn-outline-danger" title="Decline">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
