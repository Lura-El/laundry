<?php

require __DIR__ . '/register.php';


if (isset($_GET['token'])) {
    $token = htmlspecialchars($_GET['token']);
    $current_time = date("Y-m-d H:i:s"); // Set the current time

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM users WHERE verification_token = :token AND token_expiry > :current_time";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':current_time', $current_time);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $query = "UPDATE users SET is_available = 1 WHERE verification_token = :token";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        header('Location: /laundry/customer.php');
        exit();
    } else {
        echo 'Invalid or expired token.';
    }
} else {
    echo 'No token provided.';
}

