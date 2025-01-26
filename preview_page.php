<?php
include('project-root/config/db.php');
include('header.php');
// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $page_id = intval($_GET['id']); // Sanitize input
    $stmt = $conn->prepare("SELECT title, description, content, featured_image, created_at FROM pages WHERE id = ?");
    $stmt->bind_param("i", $page_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the page exists
    if ($result->num_rows > 0) {
        $page = $result->fetch_assoc();
    } else {
        echo "<p>Page not found.</p>";
        exit;
    }
} else {
    echo "<p>No page ID provided.</p>";
    exit;
}
?>

<main class="content">
    <article>
        <header>
            <h1><?php echo htmlspecialchars($page['title']); ?></h1>
            <p><em>Created on: <?php echo htmlspecialchars($page['created_at']); ?></em></p>
        </header>

        <!-- Featured Image -->
        <?php if (!empty($page['featured_image'])): ?>
            <img src="<?php echo htmlspecialchars($page['featured_image']); ?>" alt="Featured Image"
                style="max-width: 100%; height: auto;">
        <?php endif; ?>

        <!-- Page Content -->
        <section>
            <p><?php echo nl2br(htmlspecialchars($page['description'])); ?></p>
            <div>
                <?php echo nl2br(htmlspecialchars($page['content'])); ?>
            </div>
        </section>
    </article>
</main>

<?php include('footer.php'); ?>
