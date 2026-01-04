<?php
// Menu Management Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/MenuItem.php';

class MenuManagementController extends BaseController {
    
    /**
     * Show menu management page
     */
    public function showMenuManagement() {
        $this->requireAdmin();
        
        $menuItem = new MenuItem();
        $items = $menuItem->getAll();
        
        $this->render('admin/menu-management', [
            'items' => $items
        ]);
    }
    
    /**
     * Show add menu item form
     */
    public function showAddForm() {
        $this->requireAdmin();
        $this->render('admin/menu-add');
    }
    
    /**
     * Handle add menu item
     */
    public function handleAdd() {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        }
        
        $name = $this->getPost('name');
        $description = $this->getPost('description');
        $category = $this->getPost('category');
        $price = $this->getPost('price');
        
        // Validate inputs
        if (!ValidationHelper::validateRequired($name) || !ValidationHelper::validateRequired($category) || 
            !ValidationHelper::validateNumeric($price)) {
            $this->setFlash('error', 'Please fill in all required fields');
            $this->redirect(SITE_URL . '/public/index.php?page=menu-add');
        }
        
        $image_path = null;
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $upload = ImageHelper::uploadImage($_FILES['image']);
            if ($upload['success']) {
                $image_path = $upload['filename'];
            } else {
                $this->setFlash('error', $upload['error']);
                $this->redirect(SITE_URL . '/public/index.php?page=menu-add');
            }
        }
        
        // Create menu item
        $menuItem = new MenuItem();
        $result = $menuItem->create([
            'name' => $name,
            'description' => $description,
            'category' => $category,
            'price' => $price,
            'image_path' => $image_path
        ]);
        
        if ($result['success']) {
            $this->setFlash('success', $result['message']);
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        } else {
            $this->setFlash('error', $result['error']);
            $this->redirect(SITE_URL . '/public/index.php?page=menu-add');
        }
    }
    
    /**
     * Show edit menu item form
     */
    public function showEditForm() {
        $this->requireAdmin();
        
        $id = $this->getGet('id');
        if (!ValidationHelper::validateNumeric($id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        }
        
        $menuItem = new MenuItem();
        $item = $menuItem->getById($id);
        
        if (!$item) {
            $this->setFlash('error', 'Menu item not found');
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        }
        
        $this->render('admin/menu-edit', [
            'item' => $item
        ]);
    }
    
    /**
     * Handle edit menu item
     */
    public function handleEdit() {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        }
        
        $id = $this->getPost('id');
        $name = $this->getPost('name');
        $description = $this->getPost('description');
        $category = $this->getPost('category');
        $price = $this->getPost('price');
        
        // Validate inputs
        if (!ValidationHelper::validateNumeric($id) || !ValidationHelper::validateRequired($name) || 
            !ValidationHelper::validateRequired($category) || !ValidationHelper::validateNumeric($price)) {
            $this->setFlash('error', 'Please fill in all required fields');
            $this->redirect(SITE_URL . '/public/index.php?page=menu-edit&id=' . $id);
        }
        
        $menuItem = new MenuItem();
        $item = $menuItem->getById($id);
        
        if (!$item) {
            $this->setFlash('error', 'Menu item not found');
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        }
        
        $updateData = [
            'name' => $name,
            'description' => $description,
            'category' => $category,
            'price' => $price
        ];
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $upload = ImageHelper::uploadImage($_FILES['image']);
            if ($upload['success']) {
                // Delete old image
                if ($item['image_path']) {
                    ImageHelper::deleteImage(UPLOAD_DIR . $item['image_path']);
                }
                $updateData['image_path'] = $upload['filename'];
            } else {
                $this->setFlash('error', $upload['error']);
                $this->redirect(SITE_URL . '/public/index.php?page=menu-edit&id=' . $id);
            }
        }
        
        // Update menu item
        $result = $menuItem->update($id, $updateData);
        
        if ($result['success']) {
            $this->setFlash('success', $result['message']);
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        } else {
            $this->setFlash('error', $result['error']);
            $this->redirect(SITE_URL . '/public/index.php?page=menu-edit&id=' . $id);
        }
    }
    
    /**
     * Handle delete menu item
     */
    public function handleDelete() {
        $this->requireAdmin();
        
        $id = $this->getGet('id');
        if (!ValidationHelper::validateNumeric($id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        }
        
        $menuItem = new MenuItem();
        $item = $menuItem->getById($id);
        
        if (!$item) {
            $this->setFlash('error', 'Menu item not found');
            $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
        }
        
        // Delete image
        if ($item['image_path']) {
            ImageHelper::deleteImage(UPLOAD_DIR . $item['image_path']);
        }
        
        // Delete menu item
        $result = $menuItem->delete($id);
        
        if ($result['success']) {
            $this->setFlash('success', $result['message']);
        } else {
            $this->setFlash('error', $result['error']);
        }
        
        $this->redirect(SITE_URL . '/public/index.php?page=menu-management');
    }
}

?>
