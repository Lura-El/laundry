<?php

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'enerbubbles_laundry';

    $dsn = "mysql:host=$dbhost;dbname=$dbname;charset=UTF8";

    try{
        $pdo = new PDO($dsn, $dbuser, $dbpass);
        // if($pdo){
        //     echo "Connected to the $dbname database is successful";
        // }
    } catch(PDOException $e){
        die($e->getMessage());
    }