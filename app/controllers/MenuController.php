<?php
// Menu Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/MenuItem.php';

class MenuController extends BaseController {
    
    /**
     * Show menu page
     */
    public function showMenu() {
        $menuItem = new MenuItem();
        $category = $this->getGet('category', null);
        
        if ($category) {
            $items = $menuItem->getByCategory($category);
        } else {
            $items = $menuItem->getAll();
        }
        
        $categories = $menuItem->getCategories();
        
        $this->render('customer/menu', [
            'items' => $items,
            'categories' => $categories,
            'selected_category' => $category
        ]);
    }
}

?>
