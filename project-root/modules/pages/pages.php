<?php
include('../../config/db.php');
include('../../includes/header.php');
$base_url = "http://localhost/corporatefinserve/project-root/";

// Fetch all pages
$pagesQuery = "SELECT * FROM pages ORDER BY created_at DESC";
$pagesResult = $conn->query($pagesQuery);

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
            <section>                          
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($page = $pagesResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $page['id']; ?></td>
                            <td><?php echo htmlspecialchars($page['title']); ?></td>
                            <td><?php echo htmlspecialchars(substr($page['content'], 0, 50)); ?>...</td>
                            <td><?php echo $page['created_at']; ?></td>
                            <td>
                                <a href="view_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">View</a>
                                <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                                <a href="delete_page.php?id=<?php echo $page['id']; ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this page?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>

<?php include('../../includes/footer.php'); ?>