<?php
include('../../config/db.php');
include('../../includes/header.php');

// Initialize variables
$title = $page_url = $description = $featured_image = "";
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = $_POST['title'] ?? "";
    $page_url = $_POST['page_url'] ?? "";
    $description = $_POST['description'] ?? "";

    // Validate required fields
    if (empty($title) || empty($page_url)) {
        $message = "Title and Page URL are required.";
    } else {
        // Set upload directory
        $uploadDir = dirname(__DIR__, 2) . '/uploads/'; // Adjust for relative path to project root
        $fileUrl = "";

        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            // Ensure the upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = uniqid() . '_' . basename($_FILES['featured_image']['name']); // Unique file name
            $uploadFile = $uploadDir . $fileName;
            $fileType = pathinfo($uploadFile, PATHINFO_EXTENSION);

            // Validate file type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($fileType), $allowedTypes)) {
                $message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            } else {
                // Move the file to the upload directory
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadFile)) {
                    $featured_image = '../../uploads/' . $fileName; // Relative path to the uploaded file
                } else {
                    $message = "Failed to upload the featured image.";
                }
            }
        }
        // Insert into the database
        if (empty($message)) {
            $stmt = $conn->prepare("INSERT INTO pages (title, page_url, featured_image, description) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $title, $page_url, $featured_image, $description);

            if ($stmt->execute()) {
                $message = "Page added successfully!";
                // Clear form fields
                $title = $page_url = $description = $featured_image = "";
            } else {
                $message = "Error adding page: " . $conn->error;
            }
        }
    }
}
?>


<main class="content">
    <header>
        <h1>Add A New Page</h1>
        <a href="<?php echo $base_url; ?>modules/logout.php" class="logout">Logout</a>
    </header>

    <?php if ($message): ?>
    <div class="message">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="add_page.php" enctype="multipart/form-data" >
        <label for="title">Page Title</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

        <label for="page_url">Page URL</label>
        <input type="text" id="page_url" name="page_url" value="<?php echo htmlspecialchars($page_url); ?>" required>

        <label for="featured_image">Featured Image</label>
        <input type="file" id="featured_image" name="featured_image" accept="image/*">

        <label for="description">Description</label>
        <input id="description" name="description" rows="5"><?php echo htmlspecialchars($description); ?></input>

        <button type="submit">Add Page</button>
    </form>
</main>
    <?php include('../../includes/footer.php'); ?>