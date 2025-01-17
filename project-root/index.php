<?php
// Start session
session_start();

// Check if the user is logged in
if (isset($_SESSION['admin_id'])) {
    // Redirect to the dashboard if logged in
    header('Location: dashboard.php');
    exit;
} else {
    // Redirect to the login page if not logged in
    header('Location: modules/login.php');
    exit;
}
?>
