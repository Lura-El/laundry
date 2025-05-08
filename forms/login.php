 <?php
 
    session_start();

    require __DIR__ . '/../inc/connect.db.php';

        if($_SERVER["REQUEST_METHOD"] == "POST"){

           // var_dump($_POST);

            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
        
            $query = "SELECT * FROM `users` WHERE `user_email` = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && password_verify($password, $result['password'])) {
                $_SESSION["user_email"] = $email;
                $_SESSION["success"] = "You are now logged in";
                header('Location: /laundry/customer.php');
                exit();
            } else {
                die("Incorrect credentials");
            }
        }
      
