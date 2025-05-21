<?php

require __DIR__ . '/../inc/connect.db.php';

try {
    $currentMonth = date('F');  
    $currentYear = date('Y');   
    $monthYearValue = "$currentMonth-$currentYear";

    $online_query = "SELECT * FROM customers_order";
    $results_online = $pdo->query($online_query)->fetchAll(PDO::FETCH_ASSOC);
    
    $online_total = 0;

    foreach ($results_online as $result) {
        $date = DateTime::createFromFormat('F-d-y H:i:s', $result['completed_at']);
        if ($date && $date->format('F-Y') === $monthYearValue) {
            $online_total += (float)$result['amount'];
        }
    }

    $walkins_query = "SELECT * FROM walkins";
    $results_walkins = $pdo->query($walkins_query)->fetchAll(PDO::FETCH_ASSOC);

    $walkins_total = 0;

    foreach ($results_walkins as $result) {
        $date = DateTime::createFromFormat('F-d-y H:i:s', $result['completed_at']);
        if ($date && $date->format('F-Y') === $monthYearValue) {
            $walkins_total += (float)$result['amount'];
        }
    }

    $gross_income = $walkins_total + $online_total;

    $expenses_query = $pdo->prepare("SELECT total_expenses FROM expenses WHERE month_year = :month_year");
    $expenses_query->bindParam(":month_year", $monthYearValue);
    $expenses_query->execute();
    $results_expenses = $expenses_query->fetch(PDO::FETCH_ASSOC);

    $total_expenses = $results_expenses ? (float)$results_expenses['total_expenses'] : 0;

    $net_income = $gross_income - $total_expenses;

    var_dump($walkins_total);
    var_dump($online_total);

    $insert_update_query = "INSERT INTO sales (month_year, online_sales, walkins_sales, gross_income, expenses, net_income)
                            VALUES (:month_year, :online_sales, :walkins_sales, :gross_income, :expenses, :net_income)
                            ON DUPLICATE KEY UPDATE 
                            online_sales = VALUES(online_sales),
                            walkins_sales = VALUES(walkins_sales),
                            gross_income = VALUES(gross_income),
                            expenses = VALUES(expenses),
                            net_income = VALUES(net_income)";

    $stmt = $pdo->prepare($insert_update_query);
    $stmt->bindParam(":month_year", $monthYearValue);
    $stmt->bindParam(":online_sales", $online_total);
    $stmt->bindParam(":walkins_sales", $walkins_total);
    $stmt->bindParam(":gross_income", $gross_income);
    $stmt->bindParam(":expenses", $total_expenses);
    $stmt->bindParam(":net_income", $net_income);
    $stmt->execute();

    echo "Sales data successfully recorded for $monthYearValue.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
