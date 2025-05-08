<?php

require __DIR__ . '/../inc/connect.db.php';

require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if($_SERVER["REQUEST_METHOD"]== "POST"){
    
    $user_email = htmlspecialchars($_POST['email']);

    $verification_token = bin2hex(random_bytes(16));
    $token_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $query = "INSERT INTO users (verification_token, token_expiry) VALUES ('$verification_token', '$token_expiry')";
    $pdo->query($query);

    $query = "SELECT user_email FROM users WHERE user_email = :user_email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_email', $user_email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    try{
        if ($result) {
             
            $phpmailer = new PHPMailer();
            // Server settings
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '4c8e675f472a9e';
            $phpmailer->Password = '9c23267c5ff2a6';
        
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
            
        }else{
            echo "Can't find Email.";
        }
    }catch(Exception $e){
        echo "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
    }

}


    
    