<?php

require __DIR__ . '/../inc/connect.db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $service = htmlspecialchars($_POST['services']);
    $name= htmlspecialchars($_POST['name']);
    $number = htmlspecialchars($_POST['number']);
    $housedelivery = htmlspecialchars($_POST['housedelivery']);
    $location = htmlspecialchars($_POST['location']);
    $kilos = htmlspecialchars($_POST['kilos']);
    $amount = htmlspecialchars($_POST['amount']);
    $paid = htmlspecialchars($_POST['paid']);
    $status = htmlspecialchars($_POST['status']);
    
    try {

        $housedelivery = empty($housedelivery) ? "NO" : "YES";
   
        $query = "INSERT INTO walkins
            (service, name, number, house_delivery, location, kilos, amount, paid, status) 
            VALUES (:service, :name, :number,:housedelivery, :location, :kilos, :amount, :paid, :status)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':service', $service);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':housedelivery', $housedelivery);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':kilos',$kilos); 
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':paid', $paid);
        $stmt->bindParam(':status', $status);
            
        if ($stmt->execute()) {
            header("Location: /laundry/admin.html");
            // echo "Successfully submitted.";
        }else{
            echo "Failed to insert the order.";
        }
        
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
    
}