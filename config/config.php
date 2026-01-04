<?php
// General Configuration

// Include database and constants
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/constants.php';

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Session configuration
ini_set('session.gc_maxlifetime', SESSION_TIMEOUT);
session_set_cookie_params([
    'lifetime' => SESSION_TIMEOUT,
    'path' => '/',
    'httponly' => true,
    'secure' => false, // Set to true in production with HTTPS
    'samesite' => 'Lax'
]);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Global database connection
global $conn;

?>
