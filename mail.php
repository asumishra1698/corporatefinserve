<?php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
require 'project-root/config/db.php'; // Include database connection file

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0;                      // Disable verbose debug output
    $mail->isSMTP();                           // Send using SMTP
    $mail->Host       = 'mail.corporatefinserve.com'; // Set the SMTP server
    $mail->SMTPAuth   = true;                  // Enable SMTP authentication
    $mail->Username   = 'info@corporatefinserve.com'; // SMTP username
    $mail->Password   = 'Sairam@1698#';        // SMTP password
    $mail->SMTPSecure = 'ssl';                 // Enable SSL encryption
    $mail->Port       = 465;                   // TCP port

    // Form data
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $mobile = $_POST['mobile'] ?? null;
    $city = !empty($_POST['city']) ? $_POST['city'] : null;
    $type = !empty($_POST['type']) ? $_POST['type'] : null;
    $message = !empty($_POST['message']) ? $_POST['message'] : null;

    // Validate form fields
    if (!$name || !$email || !$mobile || !$city || !$type || !$message) {
        throw new Exception('All fields are required.');
    }

    // Store in database
    $stmt = $conn->prepare("INSERT INTO enquiries (name, email, mobile, city, type, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssss', $name, $email, $mobile, $city, $type, $message);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Email setup
        $mail->setFrom($email, $name);
        $mail->addAddress('info@corporatefinserve.com', 'Corporate Finserve'); // Recipient
        $mail->addReplyTo($email);
        $mail->isHTML(true); // Email format
        $mail->Subject = 'New Enquiry from Website';
        $mail->Body = "
            <h4>
                Name: $name<br>
                Email: $email<br>
                Mobile Number: $mobile<br>
                City: $city<br>
                Service Type: $type<br>
                Message: $message
            </h4>
        ";

        // Send the email
        $mail->send();

        echo '<script language="javascript">';
        echo 'alert("Your request has been successfully received. Our team of experts will connect with you within the next 2 hours.");';
        echo 'window.location.href="https://api.whatsapp.com/send/?phone=919999241024&text=+I+am+interested+in+consultation+and+company+registration.+I+have+a+few+questions.+Can+you+help?";';
        echo '</script>';
    } else {
        throw new Exception('Failed to save enquiry to database.');
    }
} catch (Exception $e) {
    echo '<script language="javascript">';
    echo 'alert("Request could not be sent. Error: ' . $e->getMessage() . '");';
    echo 'window.location.href="index.php";';
    echo '</script>';
}
