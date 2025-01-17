<?php
// Include database connection and PHPMailer integration
include('../config/db.php');
include('send_mail.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    // Validate email
    if (empty($email)) {
        $error_message = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Check if email exists in the database
        $sql = "SELECT id FROM admins WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $otp = rand(1000, 9999); // Generate 4-digit OTP

            // Save OTP to the database
            $sql = "UPDATE admins SET otp = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('is', $otp, $email);

            if ($stmt->execute()) {
                // Send OTP via email
                $subject = "Password Reset OTP";
                $body = "Your OTP for resetting your password is: $otp. This OTP is valid for 10 minutes.";
                
                if (sendMail($email, $subject, $body)) {
                    // Redirect to verify OTP page with email in the query string
                    header('Location: verify_otp.php?email=' . urlencode($email));
                    exit;
                } else {
                    $error_message = "Failed to send OTP. Please try again.";
                }
            } else {
                $error_message = "Error: Could not save OTP. Please try again.";
            }
        } else {
            $error_message = "Email not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Forgot Password</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php elseif (!empty($success_message)): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send OTP</button>
        </form>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
