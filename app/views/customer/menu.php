<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-list me-3"></i>Our Menu
            </h1>
            <p class="lead text-muted">Discover our delicious selection of coffee and treats</p>
        </div>
    </div>
    
    <!-- Category Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="category-filter d-flex flex-wrap gap-2 justify-content-center">
                <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu" 
                   class="btn <?php echo $selected_category === null ? 'btn-primary' : 'btn-outline-primary'; ?>">
                    <i class="fas fa-th me-2"></i>All Items
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu&category=<?php echo urlencode($cat['category']); ?>" 
                       class="btn <?php echo $selected_category === $cat['category'] ? 'btn-primary' : 'btn-outline-primary'; ?>">
                        <i class="fas fa-tag me-2"></i><?php echo SecurityHelper::escapeOutput($cat['category']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Menu Items Grid -->
    <div class="row g-4">
        <?php if (empty($items)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>No items available in this category.</strong>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($items as $item): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="menu-item-card h-100">
                        <div class="menu-item-image">
                            <?php if ($item['image_path']): ?>
                                <img src="<?php echo SITE_URL; ?>/public/uploads/<?php echo SecurityHelper::escapeOutput($item['image_path']); ?>" 
                                     alt="<?php echo SecurityHelper::escapeOutput($item['name']); ?>" 
                                     class="img-fluid">
                            <?php else: ?>
                                <div class="image-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            <?php endif; ?>
                            <div class="item-badge"><?php echo SecurityHelper::escapeOutput($item['category']); ?></div>
                        </div>
                        
                        <div class="menu-item-body">
                            <h5 class="menu-item-title"><?php echo SecurityHelper::escapeOutput($item['name']); ?></h5>
                            <p class="menu-item-description"><?php echo SecurityHelper::escapeOutput($item['description']); ?></p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="menu-item-price">Rs.<?php echo number_format($item['price'], 2); ?></span>
                                <?php if ($item['is_available']): ?>
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Available</span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Unavailable</span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (SessionHelper::isCustomer() && $item['is_available']): ?>
                                <form method="POST" action="<?php echo SITE_URL; ?>/public/index.php?action=add-to-cart">
                                    <?php echo SecurityHelper::getCSRFTokenField(); ?>
                                    <input type="hidden" name="menu_item_id" value="<?php echo $item['id']; ?>">
                                    
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Quantity</label>
                                        <input type="number" class="form-control form-control-sm" name="quantity" value="1" min="1" max="10" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Special Requests</label>
                                        <textarea class="form-control form-control-sm" name="special_requests" placeholder="e.g., Extra hot, no sugar..." rows="2"></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                    </button>
                                </form>
                            <?php elseif (!SessionHelper::isCustomer()): ?>
                                <a href="<?php echo SITE_URL; ?>/public/index.php?page=login" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Order
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary w-100" disabled>
                                    <i class="fas fa-ban me-2"></i>Unavailable
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Category Filter */
    .category-filter {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    /* Menu Item Card */
    .menu-item-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .menu-item-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .menu-item-image {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: #f0f0f0;
    }
    
    .menu-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .menu-item-card:hover .menu-item-image img {
        transform: scale(1.1);
    }
    
    .image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
        font-size: 3rem;
        color: #ccc;
    }
    
    .item-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .menu-item-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .menu-item-title {
        color: #8B4513;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
    }
    
    .menu-item-description {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        flex-grow: 1;
    }
    
    .menu-item-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #8B4513;
    }
    
    @media (max-width: 768px) {
        .menu-item-image {
            height: 150px;
        }
        
        .menu-item-body {
            padding: 1rem;
        }
    }
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
