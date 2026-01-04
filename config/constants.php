<?php
// Application Constants

// Site Configuration
define('SITE_NAME', 'Cozy Cup Coffee Shop');
define('SITE_URL', 'http://localhost/coffee-shop');
define('UPLOAD_DIR', __DIR__ . '/../public/uploads/');
define('IMAGES_DIR', __DIR__ . '/../public/images/');
define('CSS_URL', '/coffee-shop/public/css');
define('JS_URL', '/coffee-shop/public/js');
define('IMG_URL', '/coffee-shop/public/images');

// Order Types
define('ORDER_TYPE_TAKEAWAY', 'Takeaway');
define('ORDER_TYPE_DELIVERY', 'Delivery');
define('ORDER_TYPE_DINE_IN', 'Dine-in');

// Order Status
define('ORDER_STATUS_PENDING', 'Pending');
define('ORDER_STATUS_PROCESSING', 'Processing');
define('ORDER_STATUS_COMPLETED', 'Completed');
define('ORDER_STATUS_REJECTED', 'Rejected');

// Reservation Status
define('RESERVATION_STATUS_PENDING', 'Pending');
define('RESERVATION_STATUS_ACCEPTED', 'Accepted');
define('RESERVATION_STATUS_DECLINED', 'Declined');

// Menu Categories
define('CATEGORY_COFFEE', 'Coffee');
define('CATEGORY_FOOD', 'Food');
define('CATEGORY_DESSERT', 'Dessert');

// User Roles
define('ROLE_CUSTOMER', 'customer');
define('ROLE_ADMIN', 'admin');

// Session timeout (in seconds)
define('SESSION_TIMEOUT', 3600);

// Password requirements
define('MIN_PASSWORD_LENGTH', 6);

?>
