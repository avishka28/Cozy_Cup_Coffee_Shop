<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row mb-4">
        <div class="col-12">
            <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu-management" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Back to Menu
            </a>
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-plus-circle me-3"></i>Add Menu Item
            </h1>
            <p class="text-muted">Create a new menu item</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-utensils me-2"></i>Item Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo SITE_URL; ?>/public/index.php?action=menu-add" enctype="multipart/form-data">
                        <?php echo SecurityHelper::getCSRFTokenField(); ?>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Item Name *</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="e.g., Cappuccino" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe your item..."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label fw-bold">Category *</label>
                                <select class="form-select form-select-lg" id="category" name="category" required>
                                    <option value="">-- Select Category --</option>
                                    <option value="Coffee">Coffee</option>
                                    <option value="Food">Food</option>
                                    <option value="Dessert">Dessert</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">Price *</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">Image</label>
                            <input type="file" class="form-control form-control-lg" id="image" name="image" accept="image/*">
                            <small class="text-muted">Recommended size: 400x400px</small>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Add Item
                            </button>
                            <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu-management" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
