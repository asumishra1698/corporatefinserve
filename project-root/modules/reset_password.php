<?php
// Include database connection
include('../config/db.php');
session_start();

// Check if the reset_email session variable is set
if (!isset($_SESSION['reset_email'])) {
    // If not authorized, redirect to OTP verification page
    header('Location: verify_otp.php');
    exit;
}

$email = $_SESSION['reset_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate inputs
    if (empty($password) || empty($confirm_password)) {
        $error_message = "Both password fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters.";
    } else {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Update the password in the database
        $sql = "UPDATE admins SET password = ?, otp = NULL WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $hashed_password, $email);

        if ($stmt->execute()) {
            // Clear the session and redirect to login
            unset($_SESSION['reset_email']);
            $_SESSION['success_message'] = "Your password has been reset successfully. Please log in.";
            header('Location: login.php');
            exit;
        } else {
            $error_message = "Error: Could not reset your password. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Reset Password</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="password" name="password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <button type="submit">Reset Password</button>
        </form>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
