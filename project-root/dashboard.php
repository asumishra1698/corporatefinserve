<?php
// Start session and include database connection
session_start();
$base_url = "http://localhost/corporatefinserve/project-root/";
include('./config/db.php');
// Redirect to login if the user is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: modules/login.php');
    exit;
}
// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: modules/login.php');
    exit;
}
$base_url = "http://localhost/corporatefinserve/project-root/";
include(__DIR__ . '/includes/header.php'); 
?>

        <main class="content">
            <header>
                <h1>Welcome to the Admin Dashboard</h1>
                <a href="<?php echo $base_url; ?>modules/logout.php" class="logout">Logout</a>
            </header>
            <section>
            <div class="stats-container">
                <div class="stat-box">
                    <h3>Total Pages</h3>
                    <p id="totalPages">0</p>
                </div>
                <div class="stat-box">
                    <h3>Total Users</h3>
                    <p id="totalUsers">0</p>
                </div>
                <div class="stat-box">
                    <h3>Total Posts</h3>
                    <p id="totalPosts">0</p>
                </div>
            </div>       
            </section>
        </main>    
        
        <?php include(__DIR__ . '/includes/footer.php'); ?>