<?php

require __DIR__ . '/../inc/connect.db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
  
    $service_id = htmlspecialchars($_POST['service_id']);
    $kilos = htmlspecialchars($_POST['kilos']);
    $paid = htmlspecialchars($_POST['paid']);
    $status = htmlspecialchars($_POST['status']);

    try {

        $get_query = "SELECT kilos, paid, status, amount FROM customers_order WHERE service_id = :service_id";
        $stmt3 = $pdo->prepare($get_query);
        $stmt3->bindParam('service_id', $service_id);
        $stmt3->execute();
        $result = $stmt3->fetch(PDO::FETCH_ASSOC);
    
        $existingKilo = $result['kilos'];
        $existingPaid = $result['paid'];
        $existingStatus = $result['status'];
        $existingAmount = $result['amount'];  

        $servicePerPiece = [
            'weddinggown' => '500',
            'weddinggownsets' => '800',
            'suit' => '200',
            'simplegown' => '200',
            'specialgown' => '300',
            'barongpina' => '150',
            'smallgown' => '180',
            'leather' => '300',
            'barongjusi' => '120',
        ];

        $servicePerKilo = [
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
    
        if(!empty($kilos)){

            $query_service = "SELECT service from customers_order where service_id = :service_id";
            $stmt2 = $pdo->prepare($query_service);
            $stmt2->bindParam(':service_id', $service_id);
            $stmt2->execute();
            $result1 = $stmt2->fetch(PDO::FETCH_ASSOC);
            
            $service = $result1['service'];

            if(array_key_exists($service, $servicePerKilo)){
                if($kilos >= 10){
                    $total_amount = $servicePerKilo[$service] * $kilos;
                }else{
                    $total_amount = $servicePerKilo[$service] * 10;
                }
            }else{
              
               $total_amount = $servicePerPiece[$service] * $kilos;
            }
        }else{
            $kilos = $existingKilo;
            $total_amount = $existingAmount;
        }

        $checkPaid = empty($paid) ? $existingPaid : $paid;
        $checkStatus = empty($status) ? $existingStatus :$status;

        if($status === "Completed"){
            $completed_at = date('Y-m-d H:i:s');
        }
         

        $query = "UPDATE customers_order
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

