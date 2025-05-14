<?php

    header('Content-Type: application/json');  
    
    require __DIR__ . '/../inc/connect.db.php';
    
    try{

        $walkin_amount = "SELECT amount FROM walkins";
        $results_amount = $pdo->query($walkin_amount)->fetchAll(PDO::FETCH_ASSOC);

        // $online_amount = "SELECT amount FROM customers_order";
        // $results_online = $pdo->query($online_amount)->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results_amount);
       

    }catch(PDOException $e){
        echo "Error" .  $e->getMessage();
    }

