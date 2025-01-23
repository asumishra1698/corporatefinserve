<?php
include('../../config/db.php');
include('../../includes/header.php');
include('../session_check.php');

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $page_url = $_POST['page_url'];
    $content = $_POST['content'];
    $description = $_POST['description'];
    $featured_image = '';
    $message = '';

    // Handle file upload (if any)
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/';
        $uploaded_file = $upload_dir . basename($_FILES['featured_image']['name']);

        if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploaded_file)) {
            $featured_image = $uploaded_file; // Save the path to the database
        } else {
            echo "Failed to upload image.";
        }
    }

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO pages (title, page_url, content, description, featured_image, created_at) 
                            VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $title, $page_url, $content, $description, $featured_image);

    if ($stmt->execute()) {
        echo "Page added successfully!";
        header("Location: pages.php"); // Redirect to the list of pages
        exit;
    } else {
        echo "Error adding page: " . $conn->error;
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

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="page_url">Page URL:</label>
        <input type="text" name="page_url" id="page_url" required>

        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="5" required></textarea>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="3" required></textarea>

        <label for="featured_image">Featured Image:</label>
        <input type="file" name="featured_image" id="featured_image">

        <button type="submit">Add Page</button>
    </form>
</main>
<?php include('../../includes/footer.php'); ?>