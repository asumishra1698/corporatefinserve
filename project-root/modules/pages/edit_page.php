<?php
include('../../config/db.php');
include('../../includes/header.php');
include('../session_check.php');

// Check if the page ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p>Invalid Page ID.</p>";
    exit;
}

$page_id = intval($_GET['id']); // Sanitize input

// Fetch the page details
$stmt = $conn->prepare("SELECT id, title, description, content, featured_image FROM pages WHERE id = ?");
$stmt->bind_param("i", $page_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Page not found.</p>";
    exit;
}

$page = $result->fetch_assoc();

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $content = htmlspecialchars($_POST['content']);
    $featured_image = $page['featured_image']; // Default to existing image

    // Handle file upload if a new image is provided
    if (!empty($_FILES['featured_image']['name'])) {
        $upload_dir = '../../uploads/';
        $uploaded_file = $upload_dir . basename($_FILES['featured_image']['name']);

        if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploaded_file)) {
            $featured_image = $uploaded_file; // Update the image path
        } else {
            echo "<p>Failed to upload the image.</p>";
        }
    }

    // Update the page details in the database
    $update_stmt = $conn->prepare("UPDATE pages SET title = ?, description = ?, content = ?, featured_image = ? WHERE id = ?");
    $update_stmt->bind_param("ssssi", $title, $description, $content, $featured_image, $page_id);

    if ($update_stmt->execute()) {
        echo "<p>Page updated successfully.</p>";
    } else {
        echo "<p>Failed to update the page: " . $conn->error . "</p>";
    }
}
?>

<main class="content">
    <h1>Edit Page</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($page['title']); ?>" required>

        <label for="description">Short Description:</label>
        <textarea id="description" name="description" rows="3" required><?php echo htmlspecialchars($page['description']); ?></textarea>

        <label for="content">Long Description:</label>
        <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($page['content']); ?></textarea>

        <label for="featured_image">Featured Image:</label>
        <?php if (!empty($page['featured_image'])): ?>
            <img src="<?php echo htmlspecialchars($page['featured_image']); ?>" alt="Featured Image" style="max-width: 150px; margin-bottom: 10px;">
        <?php endif; ?>
        <input type="file" id="featured_image" name="featured_image">

        <button type="submit">Save Changes</button>
    </form>
</main>

<?php include('../../includes/footer.php'); ?>
