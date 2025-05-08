<?php
    session_start();
    require  __DIR__ . '/../inc/connect.db.php';

    if(isset($_SESSION["user_email"])) {

        $user_email = $_SESSION["user_email"];
        
    try{
        $id_query = "SELECT id FROM users WHERE user_email = :email";
        $stmt = $pdo->prepare($id_query);
        $stmt->bindParam(':email', $user_email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result){

            $customer_id = $result['id'];

            $query = "SELECT * FROM default_contact_info WHERE id = :customer_id";
                 $stmt2 = $pdo->prepare($query);
                 $stmt2->bindParam(':customer_id', $customer_id);
                 $stmt2->execute();
                 $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);  
                 
            if($result2){
                $name = $result2["name"];
                $number = $result2["number"];
                $location = $result2["location"];
            }

        }else{
            die("Cant find this email". $customer_id);
        }
    }catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
    }
    // else{
    //     echo "There's an error. Please log in.";
    // }