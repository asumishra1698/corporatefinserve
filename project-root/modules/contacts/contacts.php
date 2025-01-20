<?php
include('../../config/db.php');
include('../../includes/header.php');
$base_url = "http://localhost/corporatefinserve/project-root/";

// Fetch all enquiries
$result = $conn->query("SELECT * FROM enquiries ORDER BY created_at DESC");

if (!$result) {
    die('Error fetching enquiries: ' . $conn->error);
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
                <h1>All Contact Details</h1>
                <a href="<?php echo $base_url; ?>modules/logout.php" class="logout">Logout</a>
            </header>
            <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>City</th>
                <th>Service Type</th>
                <th>Message</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                    <td><?php echo htmlspecialchars($row['city']); ?></td>
                    <td><?php echo htmlspecialchars($row['type']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
        </main>

<?php include('../../includes/footer.php'); ?>