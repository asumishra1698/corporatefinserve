<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.corporatefinserve.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'info@corporatefinserve.com';                     //SMTP username
    $mail->Password   = 'Sairam@1698#';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_POST['email'],$_POST['name']);
    $mail->addAddress('info@corporatefinserve.com', 'Corporate Finserve');     //Add a recipient
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'New Enquiry from Website';
    $mail->Body='<h4>Name :'.$_POST['name'].'<br>Email: '.$_POST['email']. '<br> Mobile Number :'.$_POST['mobile'].'<br> City:'.$_POST['city'].'<br>  Service Type:'.$_POST['type'].'<br> Message: '.$_POST['message'].'</h4>';
    $mail->addReplyTo($_POST['email']);

    $mail->send();
    echo '<script language="javascript">';
    echo 'alert("Your Request has been successfully received. Our Team of Experts Will Connect you within Next 2 Hours.");';
    echo 'window.location.href="https://api.whatsapp.com/send/?phone=919999241024&text=+Im+interested+in+consultation+and+company+registration+I+have+a+few+question.+Can+you+help";';
    echo '</script>';
    exit();
} catch (Exception $e) {
    echo '<script language="javascript">';
    echo 'alert("Request could not be sent. Mailer Error: Please fill the required fields.");';
    echo 'window.location.href="https://api.whatsapp.com/send/?phone=919999241024&text=+Im+interested+in+consulatation+and+company+registration+I+have+a+few+question.+Can+you+help";';
    echo '</script>';
    echo "";
}
