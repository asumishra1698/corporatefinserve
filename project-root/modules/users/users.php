<?php
include('../../config/db.php');
include('../../includes/header.php');
$base_url = "http://localhost/corporatefinserve/project-root/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data['action'] === 'delete') {
        $user_id = $data['user_id'];
        $sql = "DELETE FROM admins WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $reorder_sql = "SET @count = 0; UPDATE admins SET id = (@count:= @count + 1); ALTER TABLE admins AUTO_INCREMENT = 1;";
        $conn->multi_query($reorder_sql);
        echo json_encode(['success' => $stmt->affected_rows > 0]);
        exit;
    }      
}

$sql = "SELECT id, email, created_at FROM admins";
$result = $conn->query($sql);

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
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['created_at']; ?></td>

                <td><button class="action-btn delete" onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</main>

<?php include('../../includes/footer.php'); ?>