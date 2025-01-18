<?php
include('../../config/db.php');
include('../../includes/header.php');
$base_url = "http://localhost/corporatefinserve/project-root/";


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
            <section>                          
                All Contact Details
        </main>

<?php include('../../includes/footer.php'); ?>