<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: ' . $base_url . 'modules/login.php');
    exit;
}
?>
