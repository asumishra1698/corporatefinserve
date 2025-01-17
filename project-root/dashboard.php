<?php
// Start session and include database connection
session_start();
include('./config/db.php');

// Redirect to login if the user is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: modules/login.php');
    exit;
}

// Fetch all registered users
$sql = "SELECT id, email, created_at FROM admins ORDER BY created_at DESC";
$result = $conn->query($sql);

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: modules/login.php');
    exit;
}

include 'includes/header.php'
?>

        <main class="content">
            <header>
                <h1>Welcome to the Admin Dashboard</h1>
                <a href="modules/logout.php" class="logout">Logout</a>
            </header>
            <section>
                <h2>Registered Users</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['created_at']}</td>
                                    </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No users found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
<?php    include 'includes/footer.php' ?>