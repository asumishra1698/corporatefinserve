<?php
include('../../config/db.php');
include('../../includes/header.php');
include('../session_check.php');
$base_url = "http://localhost/corporatefinserve/project-root/";


// Handle POST request for delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data['action']) && $data['action'] === 'delete') {
        $page_id = $data['page_id'];

        // Validate page ID
        if (empty($page_id) || !is_numeric($page_id)) {
            echo json_encode(['success' => false, 'message' => 'Invalid page ID.']);
            exit;
        }

        // Prepare DELETE statement
        $stmt = $conn->prepare("DELETE FROM pages WHERE id = ?");
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement.']);
            exit;
        }

        $stmt->bind_param('i', $page_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Reorder table IDs
            $reorder_sql = "
                SET @count = 0;
                UPDATE pages SET id = (@count := @count + 1);
                ALTER TABLE pages AUTO_INCREMENT = 1;
            ";
            $conn->multi_query($reorder_sql);
            
            echo json_encode(['success' => true, 'message' => 'Page deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Page not found or already deleted.']);
        }

        $stmt->close();
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}

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
        <a href="<?php echo $base_url; ?>modules/logout.php" class="logout">Logout</a>
    </header>
    <div style="margin-bottom:20px">
        <a href="add_page.php" class="add-page-btn">Add New Page</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Page URL</th>
                <th>Short Description</th>
                <th>Long Description</th>
                <th>Featured Images</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($page = $pagesResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($page['id']); ?></td>
                <td><?php echo htmlspecialchars($page['title']); ?></td>
                <td><?php echo htmlspecialchars(substr($page['page_url'] ?? 'N/A', 0, 50)); ?>...</td>
                <td><?php echo htmlspecialchars(substr($page['content'] ?? 'N/A', 0, 50)); ?>...</td>
                <td><?php echo htmlspecialchars(substr($page['description'] ?? 'N/A', 0, 50)); ?>...</td>
                <td>
                    <?php if (!empty($page['featured_image'])): ?>
                    <img src="<?php echo htmlspecialchars($page['featured_image']); ?>" alt="Featured Image"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <?php else: ?>
                    <span>No Image</span>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($page['created_at']); ?></td>
                <td>
                    <a href="preview_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">Preview</a>
                    <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="#" class="action-btn delete"
                        onclick="confirmDeletePage(<?php echo $page['id']; ?>)">Delete</a>
                </td>
                <td>
                    <a href="preview_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">Preview</a>
                    <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="#" class="action-btn delete"
                        onclick="confirmDeletePage(<?php echo $page['id']; ?>)">Delete</a>
                </td>
                <td>
                    <a href="preview_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">Preview</a>
                    <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="#" class="action-btn delete"
                        onclick="confirmDeletePage(<?php echo $page['id']; ?>)">Delete</a>
                </td>
                <td>
                    <a href="preview_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">Preview</a>
                    <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="#" class="action-btn delete"
                        onclick="confirmDeletePage(<?php echo $page['id']; ?>)">Delete</a>
                </td>
                <td>
                    <a href="preview_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">Preview</a>
                    <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="#" class="action-btn delete"
                        onclick="confirmDeletePage(<?php echo $page['id']; ?>)">Delete</a>
                </td>
                <td>
                    <a href="preview_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">Preview</a>
                    <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="#" class="action-btn delete"
                        onclick="confirmDeletePage(<?php echo $page['id']; ?>)">Delete</a>
                </td>
                <td>
                    <a href="preview_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">Preview</a>
                    <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="#" class="action-btn delete"
                        onclick="confirmDeletePage(<?php echo $page['id']; ?>)">Delete</a>
                </td>
                <td>
                    <a href="preview_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">Preview</a>
                    <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="#" class="action-btn delete"
                        onclick="confirmDeletePage(<?php echo $page['id']; ?>)">Delete</a>
                </td><td>
                    <a href="preview_page.php?id=<?php echo $page['id']; ?>" class="action-btn view">Preview</a>
                    <a href="edit_page.php?id=<?php echo $page['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="#" class="action-btn delete"
                        onclick="confirmDeletePage(<?php echo $page['id']; ?>)">Delete</a>
                </td>

            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
    function confirmDeletePage(pageId) {
        const confirmation = document.createElement("div");
        confirmation.classList.add("confirmation-popup");
        confirmation.innerHTML = `
                <div>
                    <p>Are you sure you want to delete this page?</p>
                    <button class="confirm-btn" onclick="deletePage(${pageId})">Confirm</button>
                    <button class="cancel-btn" onclick="this.parentElement.remove()">Cancel</button>
                </div>
            `;
        document.body.appendChild(confirmation);
    }

    async function deletePage(pageId) {
        try {
            const response = await fetch("./pages.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    action: "delete",
                    page_id: pageId,
                }),
            });

            const result = await response.json();


        } catch (error) {


        } finally {
            const popup = document.querySelector(".confirmation-popup");
            if (popup) popup.remove();
            window.location.href = "pages.php";
        }
    }
    </script>
</main>

<?php include('../../includes/footer.php'); ?>