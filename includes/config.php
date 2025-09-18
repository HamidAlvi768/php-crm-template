<?php
// Bootstrap session and app defaults
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// App constants
define('APP_NAME', 'AdminCRM');
define('APP_TITLE_SUFFIX', ' - CRM Admin');

// Ensure a default user name for header demo
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = 'Admin User';
}

// Helper: get current page filename
function current_page_name(): string {
    return basename($_SERVER['PHP_SELF']);
}

// Module-specific configs should live in their own modules to keep this file small

?>

