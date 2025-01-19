<?php
// Include the PHPMailer class
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure to use the correct path if you're using Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();  // Use SMTP
        $mail->Host = 'smtp.gmail.com';  // Set the SMTP server (e.g., Gmail, SendGrid, etc.)
        $mail->SMTPAuth = true;
        $mail->Username = 'info.mountaingriffon@gmail.com';  // SMTP username
        $mail->Password = 'passward-Dehradun@123';  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port = 587;  // TCP port to connect to (use 465 for SSL)

        // Sender's and recipient's details
        $mail->setFrom($email, $name);  // Sender email and name
        $mail->addAddress('recipient@example.com', 'Recipient Name');  // Add a recipient

        // Subject and body content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "You have received a new message from: <strong>$name</strong><br><br>
                          <strong>Email:</strong> $email<br>
                          <strong>Phone:</strong> $phone<br>
                          <strong>Message:</strong><br><br>$message";

        // Send the email
        if ($mail->send()) {
            echo 'Message has been sent';
        } else {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
