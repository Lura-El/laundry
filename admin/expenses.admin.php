<?php

require __DIR__ . '/../inc/connect.db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electricity = htmlspecialchars($_POST['electricity']);
    $water = htmlspecialchars($_POST['water']);
    $labor = htmlspecialchars($_POST['labor']);
    $stocks = htmlspecialchars($_POST['stocks']);
    $others = htmlspecialchars($_POST['others']);

    try {
        $currentMonth = date('F');  
        $currentYear = date('Y');   
        $monthYearValue = "$currentMonth-$currentYear"; 

        $monthYearQuery = "INSERT INTO expenses (month_year) 
                           SELECT :month_year 
                           WHERE NOT EXISTS (SELECT 1 FROM expenses WHERE month_year = :month_year)";
        $stmt1 = $pdo->prepare($monthYearQuery);
        $stmt1->bindParam(':month_year', $monthYearValue);
        $stmt1->execute();

        $queryCheck = "SELECT * FROM expenses WHERE month_year = :month_year LIMIT 1";
        $stmtCheck = $pdo->prepare($queryCheck);
        $stmtCheck->bindParam(':month_year', $monthYearValue);
        $stmtCheck->execute();
        $existingData = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($existingData) {
            $electricity = empty($electricity) ? $existingData['electricity'] : $electricity;
            $water = empty($water) ? $existingData['water'] : $water;
            $labor = empty($labor) ? $existingData['labor'] : $labor;
            $stocks = empty($stocks) ? $existingData['stocks'] : $stocks;
            $others = empty($others) ? $existingData['others'] : $others;
            $total_expenses = $electricity + $water + $labor + $stocks + $others;
        }

        $queryUpdate = "UPDATE expenses
                        SET electricity = :electricity,
                            water = :water,
                            labor = :labor,
                            stocks = :stocks, 
                            others = :others, 
                            total_expenses = :total_expenses
                        WHERE month_year = :month_year";

        $stmt2 = $pdo->prepare($queryUpdate);
        $stmt2->bindParam(':month_year', $monthYearValue);
        $stmt2->bindParam(':electricity', $electricity);
        $stmt2->bindParam(':water', $water);
        $stmt2->bindParam(':labor', $labor);
        $stmt2->bindParam(':stocks', $stocks);
        $stmt2->bindParam(':others', $others);
        $stmt2->bindParam(':total_expenses', $total_expenses);

        $stmt2->execute();


        echo "Expenses updated successfully!";

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
