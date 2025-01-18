<?php
// Enable error reporting for debugging during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type as JSON
header('Content-Type: application/json');

// Include the database connection
include_once '../config/db.php';

// Check if the database connection is successful
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}

// Fetch total pages
$totalPagesQuery = "SELECT COUNT(*) AS total FROM pages";
$totalPagesResult = $conn->query($totalPagesQuery);
if (!$totalPagesResult) {
    echo json_encode(['error' => 'Error fetching total pages: ' . $conn->error]);
    exit;
}
$totalPages = $totalPagesResult->fetch_assoc()['total'];

// Fetch total users
$totalUsersQuery = "SELECT COUNT(*) AS total FROM admins";
$totalUsersResult = $conn->query($totalUsersQuery);
if (!$totalUsersResult) {
    echo json_encode(['error' => 'Error fetching total users: ' . $conn->error]);
    exit;
}
$totalUsers = $totalUsersResult->fetch_assoc()['total'];

// Fetch total posts
$totalPostsQuery = "SELECT COUNT(*) AS total FROM posts";
$totalPostsResult = $conn->query($totalPostsQuery);
if (!$totalPostsResult) {
    echo json_encode(['error' => 'Error fetching total posts: ' . $conn->error]);
    exit;
}
$totalPosts = $totalPostsResult->fetch_assoc()['total'];

// Return stats as a JSON response
echo json_encode([
    'totalPages' => $totalPages,
    'totalUsers' => $totalUsers,
    'totalPosts' => $totalPosts,
]);
exit;
?>