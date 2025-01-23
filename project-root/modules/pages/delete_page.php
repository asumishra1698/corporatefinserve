<?php
include('../../config/db.php');
include('../session_check.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $page_id = intval($_GET['id']); // Sanitize the page ID

    // Fetch the page to confirm existence
    $stmt = $conn->prepare("SELECT featured_image FROM pages WHERE id = ?");
    $stmt->bind_param("i", $page_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Page not found.";
        exit;
    }

    $page = $result->fetch_assoc();

    // Delete the page from the database
    $delete_stmt = $conn->prepare("DELETE FROM pages WHERE id = ?");
    $delete_stmt->bind_param("i", $page_id);

    if ($delete_stmt->execute()) {
        // Optionally delete the featured image file if it exists
        if (!empty($page['featured_image']) && file_exists($page['featured_image'])) {
            unlink($page['featured_image']);
        }
        echo "Page deleted successfully.";
    } else {
        echo "Failed to delete the page.";
    }
} else {
    echo "Invalid request.";
}