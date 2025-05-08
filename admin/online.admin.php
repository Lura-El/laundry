<?php

    header('Content-Type: application/json');  

    // dont forget the header
    
    require __DIR__ . '/../inc/connect.db.php';
    
    try{

        $query = "SELECT * FROM customers_order";
        $result = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);

        
    // fix the data format, foreach the result ,  review the foreach  dont forget. 
        // echo json_encode($result);

    }catch(PDOException $e){
        echo "Error" .  $e->getMessage();
    }
