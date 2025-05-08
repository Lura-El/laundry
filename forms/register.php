<?php

require __DIR__ . '/../inc/connect.db.php';

require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$phpmailer = new PHPMailer();

if($_SERVER["REQUEST_METHOD"]== "POST"){
    
    $user_email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

    $verification_token = bin2hex(random_bytes(16));
    $token_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $query = "INSERT INTO users (user_email, verification_token, token_expiry, password) VALUES ('$user_email', '$verification_token', '$token_expiry', '$hashed_pw')";
    $pdo->query($query);

    try {
            // Server settings
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'secret';
        $phpmailer->Password = 'secret';
    
        // Sender and recipient settings
        $phpmailer->setFrom('enerbubbleslaundry@service.com', 'Enurbubbles Laundry Shop');
        $phpmailer->addAddress($user_email, 'Our Valued Customer');
    
        // Email content settings
        $phpmailer->isHTML(true);
        $phpmailer->Subject = 'Email Verification';
        $phpmailer->Body = "Please click the link below to verify your email address:<br><br>
                            <a href='http://localhost/laundry/forms/verify.php?token=$verification_token'>http://localhost/laundry/forms/verify.php?token=$verification_token</a>";
    
        // Send the email
        if ($phpmailer->send()) {
            echo 'A verification email has been sent to your email address.';
            header('Location: checkmail.php');
        } else {
            echo 'Failed to send verification email. Mailer Error: ' . $phpmailer->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
    }
}


