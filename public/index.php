<?php
// Coffee Shop E-Commerce - Main Entry Point

// Load configuration
require_once __DIR__ . '/../config/config.php';

// Load helpers
require_once __DIR__ . '/../helpers/ValidationHelper.php';
require_once __DIR__ . '/../helpers/SecurityHelper.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once __DIR__ . '/../helpers/ImageHelper.php';

// Get page and action parameters
$page = isset($_GET['page']) ? SecurityHelper::sanitizeInput($_GET['page']) : 'home';
$action = isset($_GET['action']) ? SecurityHelper::sanitizeInput($_GET['action']) : null;

// Route to appropriate controller
try {
    if ($action) {
        // Handle actions
        switch ($action) {
            // Auth Actions
            case 'register':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->handleRegister();
                break;
            
            case 'login':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->handleLogin();
                break;
            
            case 'logout':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->handleLogout();
                break;
            
            case 'admin-login':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->handleAdminLogin();
                break;
            
            case 'admin-logout':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->handleAdminLogout();
                break;
            
            // Cart Actions
            case 'add-to-cart':
                require_once __DIR__ . '/../app/controllers/CartController.php';
                $controller = new CartController();
                $controller->handleAddToCart();
                break;
            
            case 'remove-from-cart':
                require_once __DIR__ . '/../app/controllers/CartController.php';
                $controller = new CartController();
                $controller->handleRemoveFromCart();
                break;
            
            case 'update-quantity':
                require_once __DIR__ . '/../app/controllers/CartController.php';
                $controller = new CartController();
                $controller->handleUpdateQuantity();
                break;
            
            // Order Actions
            case 'checkout':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->handleCheckout();
                break;
            
            // QR Order Actions
            case 'qr-add-to-cart':
                require_once __DIR__ . '/../app/controllers/QROrderController.php';
                $controller = new QROrderController();
                $controller->handleQRAddToCart();
                break;
            
            case 'qr-checkout':
                require_once __DIR__ . '/../app/controllers/QROrderController.php';
                $controller = new QROrderController();
                $controller->handleQRCheckout();
                break;
            
            // Reservation Actions
            case 'check-availability':
                require_once __DIR__ . '/../app/controllers/ReservationController.php';
                $controller = new ReservationController();
                $controller->handleAvailabilityCheck();
                break;
            
            case 'create-reservation':
                require_once __DIR__ . '/../app/controllers/ReservationController.php';
                $controller = new ReservationController();
                $controller->handleReservation();
                break;
            
            // Menu Management Actions
            case 'menu-add':
                require_once __DIR__ . '/../app/controllers/MenuManagementController.php';
                $controller = new MenuManagementController();
                $controller->handleAdd();
                break;
            
            case 'menu-edit':
                require_once __DIR__ . '/../app/controllers/MenuManagementController.php';
                $controller = new MenuManagementController();
                $controller->handleEdit();
                break;
            
            case 'menu-delete':
                require_once __DIR__ . '/../app/controllers/MenuManagementController.php';
                $controller = new MenuManagementController();
                $controller->handleDelete();
                break;
            
            // Admin Order Actions
            case 'approve-order':
                require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
                $controller = new AdminOrderController();
                $controller->handleApproveOrder();
                break;
            
            case 'reject-order':
                require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
                $controller = new AdminOrderController();
                $controller->handleRejectOrder();
                break;
            
            case 'complete-order':
                require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
                $controller = new AdminOrderController();
                $controller->handleCompleteOrder();
                break;
            
            // Admin Reservation Actions
            case 'accept-reservation':
                require_once __DIR__ . '/../app/controllers/AdminReservationController.php';
                $controller = new AdminReservationController();
                $controller->handleAcceptReservation();
                break;
            
            case 'decline-reservation':
                require_once __DIR__ . '/../app/controllers/AdminReservationController.php';
                $controller = new AdminReservationController();
                $controller->handleDeclineReservation();
                break;
            
            default:
                header("Location: " . SITE_URL . "/public/index.php?page=home");
                exit;
        }
    } else {
        // Handle page requests
        switch ($page) {
            // Customer Pages
            case 'home':
                require_once __DIR__ . '/../app/views/customer/home.php';
                break;
            
            case 'menu':
                require_once __DIR__ . '/../app/controllers/MenuController.php';
                $controller = new MenuController();
                $controller->showMenu();
                break;
            
            case 'about':
                require_once __DIR__ . '/../app/views/customer/about.php';
                break;
            
            case 'contact':
                require_once __DIR__ . '/../app/views/customer/contact.php';
                break;
            
            case 'cart':
                require_once __DIR__ . '/../app/controllers/CartController.php';
                $controller = new CartController();
                $controller->showCart();
                break;
            
            case 'checkout':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->showCheckout();
                break;
            
            case 'order-confirmation':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->showConfirmation();
                break;
            
            case 'qr-menu':
                require_once __DIR__ . '/../app/controllers/QROrderController.php';
                $controller = new QROrderController();
                $controller->showQRMenu();
                break;
            
            case 'qr-cart':
                require_once __DIR__ . '/../app/controllers/QROrderController.php';
                $controller = new QROrderController();
                $controller->showQRCart();
                break;
            
            case 'qr-confirmation':
                require_once __DIR__ . '/../app/controllers/QROrderController.php';
                $controller = new QROrderController();
                $controller->showQRConfirmation();
                break;
            
            case 'reservations':
                require_once __DIR__ . '/../app/controllers/ReservationController.php';
                $controller = new ReservationController();
                $controller->showReservationForm();
                break;
            
            case 'reservation-tables':
                require_once __DIR__ . '/../app/controllers/ReservationController.php';
                $controller = new ReservationController();
                $controller->handleAvailabilityCheck();
                break;
            
            case 'reservation-confirmation':
                require_once __DIR__ . '/../app/controllers/ReservationController.php';
                $controller = new ReservationController();
                $controller->showConfirmation();
                break;
            
            case 'account':
                require_once __DIR__ . '/../app/controllers/AccountController.php';
                $controller = new AccountController();
                $controller->showAccount();
                break;
            
            case 'order-details':
                require_once __DIR__ . '/../app/controllers/AccountController.php';
                $controller = new AccountController();
                $controller->showOrderDetails();
                break;
            
            case 'reservation-details':
                require_once __DIR__ . '/../app/controllers/AccountController.php';
                $controller = new AccountController();
                $controller->showReservationDetails();
                break;
            
            // Auth Pages
            case 'login':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->showLogin();
                break;
            
            case 'register':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->showRegister();
                break;
            
            // Admin Pages
            case 'admin-login':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->showAdminLogin();
                break;
            
            case 'admin-dashboard':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->showDashboard();
                break;
            
            case 'menu-management':
                require_once __DIR__ . '/../app/controllers/MenuManagementController.php';
                $controller = new MenuManagementController();
                $controller->showMenuManagement();
                break;
            
            case 'menu-add':
                require_once __DIR__ . '/../app/controllers/MenuManagementController.php';
                $controller = new MenuManagementController();
                $controller->showAddForm();
                break;
            
            case 'menu-edit':
                require_once __DIR__ . '/../app/controllers/MenuManagementController.php';
                $controller = new MenuManagementController();
                $controller->showEditForm();
                break;
            
            case 'order-management':
                require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
                $controller = new AdminOrderController();
                $controller->showOrderManagement();
                break;
            
            case 'admin-order-details':
                require_once __DIR__ . '/../app/controllers/AdminOrderController.php';
                $controller = new AdminOrderController();
                $controller->showOrderDetails();
                break;
            
            case 'reservation-management':
                require_once __DIR__ . '/../app/controllers/AdminReservationController.php';
                $controller = new AdminReservationController();
                $controller->showReservationManagement();
                break;
            
            case 'admin-reservation-details':
                require_once __DIR__ . '/../app/controllers/AdminReservationController.php';
                $controller = new AdminReservationController();
                $controller->showReservationDetails();
                break;
            
            case 'customer-management':
                require_once __DIR__ . '/../app/controllers/AdminCustomerController.php';
                $controller = new AdminCustomerController();
                $controller->showCustomerManagement();
                break;
            
            case 'admin-customer-details':
                require_once __DIR__ . '/../app/controllers/AdminCustomerController.php';
                $controller = new AdminCustomerController();
                $controller->showCustomerDetails();
                break;
            
            default:
                header("Location: " . SITE_URL . "/public/index.php?page=home");
                exit;
        }
    }
} catch (Exception $e) {
    // Log error
    error_log($e->getMessage());
    
    // Display error message
    SessionHelper::setFlash('error', 'An error occurred. Please try again.');
    header("Location: " . SITE_URL . "/public/index.php?page=home");
    exit;
}

?>
