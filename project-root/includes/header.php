<?php 
$base_url = "http://localhost/corporatefinserve/project-root/";
include(__DIR__ . '/../config/db.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="dashboard-container">
        <aside class="sidebar" id="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="<?php echo $base_url; ?>"><i class="fas fa-address-book"></i> Dashboard</a></li>
                <li><a href="<?php echo $base_url; ?>modules/users/users.php"><i class="fas fa-users"></i> Admin Users</a>
                </li>
                <li><a href="<?php echo $base_url; ?>modules/pages/pages.php"><i class="fas fa-file-alt"></i> All
                        Pages</a>
                <li><a href="<?php echo $base_url; ?>modules/posts/manage-posts.php">Page Category</a></li>
                <li> <a href="<?php echo $base_url; ?>modules/posts/posts.php"> <i class="fas fa-edit"></i> All Posts
                    </a></li>
                <li><a href="<?php echo $base_url; ?>modules/posts/manage-posts.php">Post Category</a></li>
                <li><a href="<?php echo $base_url; ?>modules/contacts/contacts.php"><i class="fas fa-address-book"></i>
                        Contact</a></li>
                <li><a href="<?php echo $base_url; ?>modules/contacts/contacts.php"><i class="fas fa-address-book"></i>
                        Services</a></li>
                <li><a href="<?php echo $base_url; ?>modules/contacts/contacts.php"><i class="fas fa-address-book"></i>
                Service Category</a></li>
                </a></li>
            </ul>
        </aside>
        <div class="toggle-btn" id="toggle-btn">☰</div>