<?php
include_once("newdb.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $totalCost = $_POST['totalCost'];
    $userLogin = $_SESSION['login'];
    $status = 'Preparing';

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "Cart Is Empty";
        exit();
    }

    $pdo = connect();

    if ($pdo) 
    {
        try {
            // Получение user_id для указанного логина
            $stmtUser = $pdo->prepare("SELECT user_id FROM users WHERE login_ = :userLogin");
            $stmtUser->bindParam(':userLogin', $userLogin, PDO::PARAM_STR);
            $stmtUser->execute();

            if ($stmtUser->rowCount() > 0) {
                $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);
                $userId = $userData['user_id'];
                $_SESSION['userId'] = $userId;


                    // Вставка данных заказа, если заказа еще нет
                    $stmtOrder = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (:userId, :totalCost, :status)");
                    $stmtOrder->bindParam(':userId', $userId, PDO::PARAM_INT);
                    $stmtOrder->bindParam(':totalCost', $totalCost, PDO::PARAM_INT);
                    $stmtOrder->bindParam(':status', $status, PDO::PARAM_STR);
                    $stmtOrder->execute();

                    echo 'success';
               
            } else {
                echo 'User not found';
            }
        } catch (PDOException $e) 
        {
            echo 'An error occurred during order addition: ' . $e->getMessage();
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
