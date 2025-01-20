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

// Helper function to fetch totals
function fetchTotal($conn, $query, $label) {
    try {
        $result = $conn->query($query);
        if (!$result) {
            throw new Exception("Error fetching $label: " . $conn->error);
        }
        $data = $result->fetch_assoc();
        return $data['total'] ?? 0;
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}

// Fetch totals using helper function
$totalPages = fetchTotal($conn, "SELECT COUNT(*) AS total FROM pages", "total pages");
$totalUsers = fetchTotal($conn, "SELECT COUNT(*) AS total FROM admins", "total users");
$totalPosts = fetchTotal($conn, "SELECT COUNT(*) AS total FROM posts", "total posts");
$totalContacts = fetchTotal($conn, "SELECT COUNT(*) AS total FROM enquiries", "total contacts");

// Return stats as a JSON response
echo json_encode([
    'totalPages' => $totalPages,
    'totalUsers' => $totalUsers,
    'totalPosts' => $totalPosts,
    'totalContacts' => $totalContacts,
]);
exit;
?>