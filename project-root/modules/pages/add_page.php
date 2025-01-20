<?php
include('../../config/db.php');
include('../../includes/header.php');



// Initialize variables
$title = $page_url = $description = "";
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? "";
    $page_url = $_POST['page_url'] ?? "";
    $description = $_POST['description'] ?? "";
    $featured_image = "";

    if (empty($title) || empty($page_url)) {
        $message = "Title and Page URL are required.";
    } else {
        // Set upload directory and base URL for file access
        $uploadDir = dirname(__DIR__, 1) . '/uploads/';
        $fileUrl = "";

        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create directory if it doesn't exist
            }

            $uploadFile = $uploadDir . basename($_FILES['featured_image']['name']);
            $fileType = pathinfo($uploadFile, PATHINFO_EXTENSION);

            // Validate file type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($fileType), $allowedTypes)) {
                $message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            } else {
                // Move the file to the upload directory
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadFile)) {
                    $fileUrl = $base_url . 'uploads/' . basename($_FILES['featured_image']['name']);
                    $featured_image = $fileUrl; // Save file URL for database
                } else {
                    $message = "Failed to upload the featured image.";
                }
            }
        }

        // Insert into database
        if (empty($message)) {
            $stmt = $conn->prepare("INSERT INTO pages (title, page_url, featured_image, description) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $title, $page_url, $featured_image, $description);

            if ($stmt->execute()) {
                $message = "Page added successfully!";
                $title = $page_url = $description = ""; // Clear form fields
            } else {
                $message = "Error adding page: " . $conn->error;
            }
        }
    }
}
?>

<main class="content">

    <h1>Add New Page</h1>

    <?php if ($message): ?>
    <div class="message">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="add_page.php" enctype="multipart/form-data">
        <label for="title">Page Title</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

        <label for="page_url">Page URL</label>
        <input type="text" id="page_url" name="page_url" value="<?php echo htmlspecialchars($page_url); ?>" required>

        <label for="featured_image">Featured Image</label>
        <input type="file" id="featured_image" name="featured_image" accept="image/*">

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($description); ?></textarea>

        <button type="submit">Add Page</button>
    </form>

    <?php include('../../includes/footer.php'); ?>