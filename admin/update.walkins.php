<?php

require __DIR__ . '/../inc/connect.db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
  
    $service_id = htmlspecialchars($_POST['service_id']);
    $kilos = htmlspecialchars($_POST['kilos']);
    $paid = htmlspecialchars($_POST['paid']);
    $status = htmlspecialchars($_POST['status']);

    try {
 
        // fix the update walkins, fix this file 
        $get_query = "SELECT kilos, paid, status, amount FROM walkins WHERE service_id = :service_id";
        $stmt3 = $pdo->prepare($get_query);
        $stmt3->bindParam('service_id', $service_id);
        $stmt3->execute();
        $result = $stmt3->fetch(PDO::FETCH_ASSOC);
    
        $existingKilo = $result['kilos'];
        $existingPaid = $result['paid'];
        $existingStatus = $result['status'];
        $existingAmount = $result['amount'];  

        $services = [
            'weddinggown' => '500',
            'weddinggownsets' => '800',
            'suit' => '200',
            'simplegown' => '200',
            'specialgown' => '300',
            'barongpina' => '150',
            'smallgown' => '180',
            'leather' => '300',
            'barongjusi' => '120',
            'regularwash' => '25',
            'specialwash' => '60',
            'comforters' => '60',
            'seatcovers' => '60',
            'whitebaby' => '50',
            'curtains' => '50',
            'blankets' => '45',
            'largeitems' => '45',
            'trouserslacks' => '130',
            'jackets' => '130',   
            
        ]; 

        $total_amount = 0;

        if(!empty($kilos)){

            $query_service = "SELECT service from walkins where service_id = :service_id";
            $stmt2 = $pdo->prepare($query_service);
            $stmt2->bindParam(':service_id', $service_id);
            $stmt2->execute();
            $result1 = $stmt2->fetch(PDO::FETCH_ASSOC);
            
            $service = $result1['service'];

            $total_amount = $services[$service] * $kilos;
             
        }else{
            $kilos = $existingKilo;
            $total_amount = $existingAmount;
        }

        $checkPaid = empty($paid) ? $existingPaid : $paid;
        $checkStatus = empty($status) ? $existingStatus :$status;

        if($status === "Completed"){
            date_default_timezone_set('Asia/Taipei');
            $completed_at = date('Y-m-d H:i:s');
        }
         

        $query = "UPDATE walkins
          SET kilos = :kilos, 
              paid = :paid,
              status = :status,
              amount = :amount,
              completed_at = :completed_at
          WHERE service_id = :service_id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':service_id', $service_id); 
        $stmt->bindParam(':kilos', $kilos); 
        $stmt->bindParam(':paid', $checkPaid);
        $stmt->bindParam(':status', $checkStatus);
        $stmt->bindParam(':amount', $total_amount);
        $stmt->bindParam(':completed_at', $completed_at);

        if ($stmt->execute()){

           header("Location: /laundry/admin.html");
        }else{

            echo "Failed to insert the order.";
        }
        
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
    
    }

