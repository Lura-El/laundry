<?php

    // session_start();

    require __DIR__ . '/../inc/connect.db.php';

    if(isset($_SESSION['user_email'])){

        $user_email = $_SESSION["user_email"];

        // Fetch customer ID
        $id_query = "SELECT id FROM users WHERE user_email = :email";
        $stmt = $pdo->prepare($id_query);
        $stmt->bindParam(':email', $user_email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            $customer_id = $result['id'];

            $order_query = "SELECT * FROM customers_order WHERE id = :id";
            $stmt = $pdo->prepare($order_query);
            $stmt->bindParam(':id', $customer_id);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }
    }else{
        echo "Can't find  any thing. Please log in.";
        session_unset();
    }


    
   

