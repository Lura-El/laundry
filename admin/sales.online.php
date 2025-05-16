<?php

    header('Content-Type: application/json');  
    
    require __DIR__ . '/../inc/connect.db.php';
    
    try{

        $online_amount = "SELECT * FROM customers_order";
        $results_online = $pdo->query($online_amount)->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results_online);
       

    }catch(PDOException $e){
        echo "Error" .  $e->getMessage();
    }

