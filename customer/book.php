<?php
session_start();

require __DIR__ . '/../inc/connect.db.php';

//var_dump($_SESSION["user_email"]);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $service = htmlspecialchars($_POST['services']);
    $datetime = htmlspecialchars($_POST['datetime']);
    $specialrequest = htmlspecialchars($_POST['specialrequest']);

    if (isset($_SESSION["user_email"])) {
        $user_email = $_SESSION["user_email"];
    
        try {
            // SELECT the user ID based on the email
            $id_query = "SELECT id FROM users WHERE user_email = :email";
            $stmt = $pdo->prepare($id_query);
            $stmt->bindParam(':email', $user_email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $customer_id = $result['id'];
    
                       
                    require __DIR__ . '/getcontact.php';
                
                $query = "INSERT INTO customers_order 
                    (id, service, name, number, location, pick_up_time, special_request) 
                    VALUES (:customer_id, :service, :name, :number, :location, :pick_up_time, :special_request)";
                $stmt2 = $pdo->prepare($query);
                $stmt2->bindParam(':customer_id', $customer_id);
                $stmt2->bindParam(':service', $service);
                $stmt2->bindParam(':name', $name);
                $stmt2->bindParam(':number', $number);
                $stmt2->bindParam(':location', $location);
                $stmt2->bindParam(':pick_up_time',$datetime); 
                $stmt2->bindParam(':special_request', $specialrequest);
                
                if($name == "" && $number == "" && $location == ""){
                    header("Location: /laundry/customer/setcontact.php");
                }
                 
    
                if ($stmt2->execute()) {
                    header('Location: /laundry/customer.php');
                } else {
                    echo "Failed to insert the order.";
                }
            } else {
                die("User not found for email: $user_email");
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "No user is logged in. Please log in first.";
    }     
    
}