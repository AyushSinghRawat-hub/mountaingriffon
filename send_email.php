<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $fullname = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = nl2br(htmlspecialchars(trim($_POST['message'])));

    // Validate form inputs
    if (empty($fullname) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
        die("All fields are required!");
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Please enter a valid email address.");
    }

    // Create email content
    $to = "info.mountaingriffon@gmail.com"; 
    $emailSubject = "New Message from Contact Form";
    $body = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                background-color: #f9f9f9;
                padding: 10px;
            }
            .container {
                background: #ffffff;
                border: 1px solid #ddd;
                padding: 20px;
                margin: 10px auto;
                max-width: 600px;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #444;
                border-bottom: 2px solid #f53b23;
                padding-bottom: 10px;
            }
            p {
                margin: 8px 0;
            }
            strong {
                color: #000;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Contact Form Submission</h2>
            <p><strong>Full Name:</strong> $fullname</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong><br>$message</p>
        </div>
    </body>
    </html>
    ";

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP host
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info.mountaingriffon@gmail.com'; // Sender's email
        $mail->Password   = 'weqf jabj ichj hpmw'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL encryption
        $mail->Port       = 465; // SSL port
        
        // Recipients
        $mail->setFrom('info.mountaingriffon@gmail.com', 'Mountingriffon');
        $mail->addAddress($to, 'Recipient Name'); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = $emailSubject;
        $mail->Body    = $body;

        // Send email
        $mail->send();
        echo "Thank you for your message. We will contact you shortly.";
        header("refresh:2; url=index.html");  // Redirect after 2 seconds
    } catch (Exception $e) {
        echo "Sorry, there was an error processing your request. Please try again later.";
        error_log("Mailer Error: " 
        . $e->getMessage()); // Logs the error for debugging
    }
}
?>
