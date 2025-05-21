<?php

    header('Content-Type: application/json');  
    
    require __DIR__ . '/../inc/connect.db.php';
    
    try{

        $query = "SELECT * FROM sales";
        $result = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);

    }catch(PDOException $e){
        echo "Error" .  $e->getMessage();
    }
