<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-container">
    <div class="col-lg-5 col-md-6 col-sm-8 col-12">
        <div class="auth-card">
            <div class="auth-header">
                <i class="fas fa-lock"></i>
                <h2>Admin Login</h2>
                <p>Secure access to admin panel</p>
            </div>
            
            <div class="auth-body">
                <form method="POST" action="<?php echo SITE_URL; ?>/public/index.php?action=admin-login">
                    <?php echo SecurityHelper::getCSRFTokenField(); ?>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" placeholder="admin@coffeeshop.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Admin Login
                    </button>
                </form>
                
                <hr class="my-3">
                
                <div class="auth-link">
                    <p>Not an admin? <a href="<?php echo SITE_URL; ?>/public/index.php?page=login">Customer Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
