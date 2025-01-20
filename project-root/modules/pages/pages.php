<?php
include('../../config/db.php');
include('../../includes/header.php');
$base_url = "http://localhost/corporatefinserve/project-root/";

// Fetch all pages
$pagesQuery = "SELECT * FROM pages ORDER BY created_at DESC";
$pagesResult = $conn->query($pagesQuery);

$query = "SELECT id, title, featured_image FROM pages";
$result = $conn->query($query);


if (!$pagesResult) {
    die('Error fetching pages: ' . $conn->error);
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: modules/login.php');
    exit;
}
?>

<main class="content">
    <header>
        <h1>All Pages</h1>
        <a href="add_page.php" class="add-page-btn">Add New Page</a>
        <a href="<?php echo $base_url; ?>modules/logout.php" class="logout">Logout</a>
    </header>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <!-- <th>Page Url</th> -->
                <th>Feture images</th>
                <!-- <th>Created At</th> -->
                <th>Actions</th>

            </tr>
        </thead>
        <tbody>
            <?php while ($page = $pagesResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $page['id']; ?></td>
                <td><?php echo htmlspecialchars($page['title']); ?></td>
                <!-- <td><?php // echo htmlspecialchars(substr($page['page_url'], 0, 50)); ?>...</td> -->
                <td>
                    <?php if (!empty($page['featured_image'])): ?>
                    <img src="<?php echo htmlspecialchars($page['featured_image']); ?>" alt="Featured Image"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <?php else: ?>
                    <span>No Image</span>
                    <?php endif; ?>
                </td>
                <!-- <td><?php //echo $page['created_at']; ?></td> -->
                <td>
                    <a href="view_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">View</a>
                    <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="delete_page.php?id=<?php echo $page['id']; ?>" class="action-btn delete"
                        onclick="return confirm('Are you sure you want to delete this page?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</main>

<?php include('../../includes/footer.php'); ?>