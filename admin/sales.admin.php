<?php

require __DIR__ . '/../inc/connect.db.php';

try {
    $currentMonth = date('F');  
    $currentYear = date('Y');   
    $monthYearValue = "$currentMonth-$currentYear";

    // Fetch Online Sales
    $online_total = 0;
    $online_query = "SELECT * FROM customers_order";
    $results_online = $pdo->query($online_query)->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results_online as $result) {
        $date = DateTime::createFromFormat('F-d-y H:i:s', $result['completed_at']);
        if ($date && $date->format('F-Y') === $monthYearValue) {
            $online_total += (float)$result['amount'];
        }
    }

    // Fetch Walk-in Sales
    $walkins_total = 0;
    $walkins_query = "SELECT * FROM walkins";
    $results_walkins = $pdo->query($walkins_query)->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results_walkins as $result) {
        $date = DateTime::createFromFormat('F-d-y H:i:s', $result['completed_at']);
        if ($date && $date->format('F-Y') === $monthYearValue) {
            $walkins_total += $result['amount'];
        }
    }

    var_dump($walkins_total);
    // Calculate Gross Income
    $gross_income = $walkins_total + $online_total;

    // Fetch Expenses
    $expenses_query = $pdo->prepare("SELECT total_expenses FROM expenses WHERE month_year = :month_year");
    $expenses_query->bindParam(":month_year", $monthYearValue);
    $expenses_query->execute();
    $results_expenses = $expenses_query->fetch(PDO::FETCH_ASSOC);
    $total_expenses = $results_expenses ? (float)$results_expenses['total_expenses'] : 0;

    // Calculate Net Income
    $net_income = $gross_income - $total_expenses;

    // Check if Sales Record Exists for the Month
    $check_sales = $pdo->prepare("SELECT * FROM sales WHERE month_year = :month_year");
    $check_sales->bindParam(":month_year", $monthYearValue);
    $check_sales->execute();
    $sales_exists = $check_sales->fetch(PDO::FETCH_ASSOC);

    if ($sales_exists) {
        // Update existing sales record
        $update_query = $pdo->prepare("
            UPDATE sales 
            SET online_sales = :online_sales, walkins_sales = :walkins_sales, 
                gross_income = :gross_income, expenses = :expenses, net_income = :net_income
            WHERE month_year = :month_year
        ");
    } else {
        // Insert new sales record
        $update_query = $pdo->prepare("
            INSERT INTO sales (month_year, online_sales, walkins_sales, gross_income, expenses, net_income)
            VALUES (:month_year, :online_sales, :walkins_sales, :gross_income, :expenses, :net_income)
        ");
    }
    // Bind Parameters and Execute
    $update_query->bindParam(":month_year", $monthYearValue);
    $update_query->bindParam(":online_sales", $online_total);
    $update_query->bindParam(":walkins_sales", $walkins_total);
    $update_query->bindParam(":gross_income", $gross_income);
    $update_query->bindParam(":expenses", $total_expenses);
    $update_query->bindParam(":net_income", $net_income);

    if ($update_query->execute()) {
        echo "Sales data successfully recorded/updated for $monthYearValue.";
    } else {
        echo "Error updating sales table: " . implode(", ", $update_query->errorInfo());
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
