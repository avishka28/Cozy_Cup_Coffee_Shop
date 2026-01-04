<?php include __DIR__ . '/../layouts/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-lg-8 text-center text-white position-relative z-1">
                <h1 class="display-3 fw-bold mb-3 animate-fade-in">
                    <i class="fas fa-coffee me-3"></i><?php echo SITE_NAME; ?>
                </h1>
                <p class="lead mb-4 fs-5 animate-fade-in-delay">Experience the finest coffee and delicious treats</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <?php if (SessionHelper::isCustomer()): ?>
                        <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-cart me-2"></i>Order Now
                        </a>
                        <a href="<?php echo SITE_URL; ?>/public/index.php?page=reservations" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-calendar me-2"></i>Reserve a Table
                        </a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/public/index.php?page=login" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Order
                        </a>
                        <a href="<?php echo SITE_URL; ?>/public/index.php?page=register" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3">Why Choose Us?</h2>
                <div class="w-25 mx-auto" style="height: 4px; background: linear-gradient(135deg, #8B4513, #D2691E); border-radius: 2px;"></div>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>Premium Quality</h4>
                    <p>We source the finest coffee beans and fresh ingredients</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4>Fast Service</h4>
                    <p>Quick and efficient service for all order types</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h4>Cozy Atmosphere</h4>
                    <p>Relax and enjoy in our comfortable café environment</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="fas fa-mouse"></i>
                    </div>
                    <h4>Easy Ordering</h4>
                    <p>Simple online ordering and table reservation system</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Items Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3">Featured Items</h2>
                <div class="w-25 mx-auto" style="height: 4px; background: linear-gradient(135deg, #8B4513, #D2691E); border-radius: 2px;"></div>
            </div>
        </div>
        
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="menu-card">
                    <div class="menu-card-icon">
                        <i class="fas fa-mug-hot"></i>
                    </div>
                    <h5>Espresso</h5>
                    <p>Strong and bold espresso shot</p>
                    <div class="price-tag">$2.50</div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="menu-card">
                    <div class="menu-card-icon">
                        <i class="fas fa-mug-hot"></i>
                    </div>
                    <h5>Cappuccino</h5>
                    <p>Espresso with steamed milk and foam</p>
                    <div class="price-tag">$3.50</div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="menu-card">
                    <div class="menu-card-icon">
                        <i class="fas fa-cookie"></i>
                    </div>
                    <h5>Croissant</h5>
                    <p>Buttery French pastry</p>
                    <div class="price-tag">$3.00</div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="menu-card">
                    <div class="menu-card-icon">
                        <i class="fas fa-birthday-cake"></i>
                    </div>
                    <h5>Cheesecake</h5>
                    <p>Creamy cheesecake slice</p>
                    <div class="price-tag">$4.50</div>
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu" class="btn btn-primary btn-lg">
                <i class="fas fa-list me-2"></i>View Full Menu
            </a>
        </div>
    </div>
</section>

<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #2C1810 0%, #8B4513 50%, #A0522D 100%);
        background-attachment: fixed;
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        color: white;
    }
    
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        z-index: 0;
    }
    
    .hero-section .z-1 {
        z-index: 1;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }
    
    .animate-fade-in-delay {
        animation: fadeIn 0.8s ease-out 0.2s both;
    }
    
    /* Feature Cards */
    .feature-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-top: 4px solid #8B4513;
    }
    
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .feature-icon {
        font-size: 3rem;
        color: #8B4513;
        margin-bottom: 1rem;
        display: inline-block;
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #F5DEB3 0%, #FFE4B5 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .feature-card h4 {
        color: #8B4513;
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-size: 1.2rem;
    }
    
    .feature-card p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    /* Menu Cards */
    .menu-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .menu-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .menu-card-icon {
        font-size: 3rem;
        color: #8B4513;
        margin-bottom: 1rem;
    }
    
    .menu-card h5 {
        color: #8B4513;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
    }
    
    .menu-card p {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        flex-grow: 1;
    }
    
    .price-tag {
        background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 700;
        font-size: 1.1rem;
        display: inline-block;
    }
    
    @media (max-width: 768px) {
        .hero-section {
            min-height: 50vh;
        }
        
        .hero-section h1 {
            font-size: 2rem;
        }
        
        .hero-section .lead {
            font-size: 1rem;
        }
    }
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
