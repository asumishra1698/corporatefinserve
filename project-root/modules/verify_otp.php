<?php
// Include database connection
include('../config/db.php');
session_start();

$email = isset($_GET['email']) ? trim($_GET['email']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $otp = trim($_POST['otp']);

    // Validate inputs
    if (empty($email) || empty($otp)) {
        $error_message = "Both email and OTP are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif (!is_numeric($otp) || strlen($otp) != 4) {
        $error_message = "Invalid OTP. Please enter the 4-digit OTP.";
    } else {
        // Verify OTP in the database
        $sql = "SELECT id FROM admins WHERE email = ? AND otp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $email, $otp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // OTP verified, set session variable
            $_SESSION['reset_email'] = $email;

            // Redirect to reset password page
            header('Location: reset_password.php');
            exit;
        } else {
            $error_message = "Invalid email or OTP.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Verify OTP</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" readonly required>
            <input type="number" name="otp" placeholder="Enter 4-digit OTP" required>
            <button type="submit">Verify OTP</button>
        </form>
        <p><a href="forgot_password.php">Back to Forgot Password</a></p>
    </div>
</body>
</html>
