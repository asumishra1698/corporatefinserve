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
            <span id="totalPages">Loading...</span>
        </div>
        <div class="stat-box">
            <h3>Total Users</h3>
            <span id="totalUsers">Loading...</span>
        </div>
        <div class="stat-box">
            <h3>Total Posts</h3>
            <span id="totalPosts">Loading...</span>
        </div>
        <div class="stat-box">
            <h3>Total Contacts</h3>
            <span id="totalContacts">Loading...</span>
        </div>
    </div>

    <script>
        // Fetch and display stats from stats.php
        document.addEventListener('DOMContentLoaded', function () {
            fetch('modules/stats.php') // Adjust the path if needed
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Update DOM elements with the fetched data
                    document.getElementById('totalPages').textContent = data.totalPages;
                    document.getElementById('totalUsers').textContent = data.totalUsers;
                    document.getElementById('totalPosts').textContent = data.totalPosts;
                    document.getElementById('totalContacts').textContent = data.totalContacts;
                })
                .catch(error => {
                    console.error('Error fetching stats:', error);
                    alert('Failed to load statistics. Please try again later.');
                });
        });
    </script>
            </section>
        </main> 
           
        
        <?php include(__DIR__ . '/includes/footer.php'); ?>