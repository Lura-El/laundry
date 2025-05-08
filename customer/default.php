<?php
   session_start();
   require __DIR__ . '/../inc/connect.db.php';
   
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
       $name = htmlspecialchars($_POST["name"]);
       $number = htmlspecialchars($_POST["number"]);
       $location = htmlspecialchars($_POST["location"]);
   
       if (isset($_SESSION["user_email"])) {
           $user_email = $_SESSION["user_email"];
   
           try {
              
               $id_query = "SELECT id FROM users WHERE user_email = :email";
               $stmt = $pdo->prepare($id_query);
               $stmt->bindParam(':email', $user_email);
               $stmt->execute();
               $result = $stmt->fetch(PDO::FETCH_ASSOC);
   
               if ($result) {
                   $customer_id = $result['id'];
   
                   $query = "INSERT INTO default_contact_info (id, name, number, location) 
                             VALUES (:id, :name, :number, :location)
                             ON DUPLICATE KEY UPDATE 
                             name = :name, 
                             number = :number, 
                             location = :location";
   
                   $stmt2 = $pdo->prepare($query);
                   $stmt2->bindParam(':id', $customer_id);
                   $stmt2->bindParam(':name', $name);
                   $stmt2->bindParam(':number', $number);
                   $stmt2->bindParam(':location', $location);
   
                   if ($stmt2->execute()) {
                       header('Location: /laundry/customer.php');
                       exit();
                   } else {
                       echo "Failed to insert details.";
                   }
   
               } else {
                   die("Can't find this email: " . $user_email);
               }
           } catch (PDOException $e) {
               echo "Database error: " . $e->getMessage();
           }
       } else {
           echo "There's an error. Please log in first.";
       }
   }
   