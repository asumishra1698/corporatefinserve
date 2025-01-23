<?php
include('../../config/db.php');
include('../../includes/header.php');
include('../session_check.php');
$base_url = "http://localhost/corporatefinserve/project-root/";


// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json'); // Ensure JSON response
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data['action']) && $data['action'] === 'delete') {
        $user_id = $data['user_id'];

        // Validate user ID
        if (empty($user_id) || !is_numeric($user_id)) {
            echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
            exit;
        }

        // Prepare DELETE statement
        $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement.']);
            exit;
        }

        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        // Check if a row was deleted
        if ($stmt->affected_rows > 0) {
            // Reorder table IDs
            $reorder_sql = "
                SET @count = 0;
                UPDATE admins SET id = (@count := @count + 1);
                ALTER TABLE admins AUTO_INCREMENT = 1;
            ";
            $conn->multi_query($reorder_sql);

            echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found or already deleted.']);
        }

        $stmt->close();
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}

// Fetch all users
$sql = "SELECT id, email, created_at FROM admins";
$result = $conn->query($sql);
if (!$result) {
    die('Error fetching users: ' . $conn->error);
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
        <h1>Registered Users</h1>
        <a href="<?php echo $base_url; ?>modules/logout.php" class="logout">Logout</a>
    </header>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td>
                    <button class="action-btn delete" onclick="confirmDeleteUser(<?php echo $row['id']; ?>)">Delete</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        function confirmDeleteUser(userId) {
            const confirmation = document.createElement("div");
            confirmation.classList.add("confirmation-popup");
            confirmation.innerHTML = `
                <div>
                    <p>Are you sure you want to delete this user?</p>
                    <button class="confirm-btn" onclick="deleteUser(${userId})">Confirm</button>
                    <button class="cancel-btn" onclick="this.parentElement.remove()">Cancel</button>
                </div>
            `;
            document.body.appendChild(confirmation);
        }

        async function deleteUser(userId) {
            try {
                const response = await fetch("./users.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        action: "delete",
                        user_id: userId,
                    }),
                });

                const result = await response.json();
               
            } catch (error) {
                console.error("Error deleting user:", error);                
            } finally {
                const popup = document.querySelector(".confirmation-popup");
                if (popup) popup.remove();
                window.location.href = "users.php";
            }
        }
    </script>
</main>

<?php include('../../includes/footer.php'); ?>
