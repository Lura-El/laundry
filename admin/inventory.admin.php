<?php

    require __DIR__ . '/../inc/connect.db.php';

    if($_SERVER['REQUEST_METHOD'] = "POST"){

        $laundry_basket = htmlspecialchars($_POST['laundry_basket']);
        $hanger = htmlspecialchars($_POST['hanger']);
        $scatch_tape = htmlspecialchars($_POST['scatch_tape']);
        $plastic = htmlspecialchars($_POST['plastic']);
        $soap_powder = htmlspecialchars($_POST['soap_powder']);
        $fabcon = htmlspecialchars($_POST['fabcon']);
        $zonrox = htmlspecialchars($_POST['zonrox']);
        $name = htmlspecialchars($_POST['name']);
        $note = htmlspecialchars($_POST['note']);
        $date = htmlspecialchars($_POST['date']);

        $insert_data = 'INSERT INTO inventory
        (laundry_basket, hanger, scatch_tape, plastic, soap_powder, fabcon, zonrox, check_by, note, date)
         VALUES(:laundry_basket, :hanger, :scatch_tape, :plastic, :soap_powder, :fabcon, 
         :zonrox, :name, :note, :date)';

        $stmt = $pdo->prepare($insert_data);
        $stmt->bindParam(':laundry_basket', $laundry_basket);
        $stmt->bindParam(':hanger', $hanger);
        $stmt->bindParam(':scatch_tape', $scatch_tape);
        $stmt->bindParam(':plastic', $plastic);
        $stmt->bindParam(':soap_powder', $soap_powder);
        $stmt->bindParam(':fabcon', $fabcon);
        $stmt->bindParam(':zonrox', $zonrox);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':date', $date);
        
        if ($stmt->execute()){

           echo 'Successfully submitted.';
        }else{

            echo "Failed to insert the inventory.";
        }

    }