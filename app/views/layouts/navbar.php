<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/coffee-shop/public/index.php?page=home">
            <i class="fas fa-coffee me-2"></i><?php echo SITE_NAME; ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/coffee-shop/public/index.php?page=home">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/coffee-shop/public/index.php?page=menu">
                        <i class="fas fa-list me-1"></i>Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/coffee-shop/public/index.php?page=about">
                        <i class="fas fa-info-circle me-1"></i>About
                    </a>
                </li>
                
                <?php if (SessionHelper::isCustomer()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/coffee-shop/public/index.php?page=cart">
                            <i class="fas fa-shopping-cart me-1"></i>Order
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/coffee-shop/public/index.php?page=reservations">
                            <i class="fas fa-calendar me-1"></i>Reservation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/coffee-shop/public/index.php?page=account">
                            <i class="fas fa-user me-1"></i>Account
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i><?php echo SecurityHelper::escapeOutput(SessionHelper::getUserName()); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="/coffee-shop/public/index.php?page=account"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="/coffee-shop/public/index.php?action=logout" style="display: inline;">
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php elseif (SessionHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/coffee-shop/public/index.php?page=admin-dashboard">
                            <i class="fas fa-chart-line me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cogs me-1"></i>Management
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="/coffee-shop/public/index.php?page=menu-management"><i class="fas fa-utensils me-2"></i>Menu</a></li>
                            <li><a class="dropdown-item" href="/coffee-shop/public/index.php?page=order-management"><i class="fas fa-box me-2"></i>Orders</a></li>
                            <li><a class="dropdown-item" href="/coffee-shop/public/index.php?page=reservation-management"><i class="fas fa-calendar-check me-2"></i>Reservations</a></li>
                            <li><a class="dropdown-item" href="/coffee-shop/public/index.php?page=customer-management"><i class="fas fa-users me-2"></i>Customers</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-shield me-1"></i><?php echo SecurityHelper::escapeOutput(SessionHelper::getUserName()); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminUserDropdown">
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="/coffee-shop/public/index.php?action=admin-logout" style="display: inline;">
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/coffee-shop/public/index.php?page=contact">
                            <i class="fas fa-envelope me-1"></i>Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/coffee-shop/public/index.php?page=login">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light ms-2" href="/coffee-shop/public/index.php?page=register">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?php 
$flash = SessionHelper::getFlash();
if ($flash): 
?>
    <div class="container mt-3">
        <div class="alert alert-<?php echo ($flash['type'] === 'error' ? 'danger' : SecurityHelper::escapeOutput($flash['type'])); ?> alert-dismissible fade show" role="alert">
            <i class="fas fa-<?php echo ($flash['type'] === 'error' ? 'exclamation-circle' : 'check-circle'); ?> me-2"></i>
            <?php echo SecurityHelper::escapeOutput($flash['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>
