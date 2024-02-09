<?php
include_once("newdb.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totalCost = $_POST['totalCost'];

    if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
        $userLogin = $_SESSION['login'];
        $status = 'Preparing';

        // Подключение к базе данных
        $pdo = connect();

        // Получение coupon_id
        $couponId = NULL;
        if (isset($_SESSION['code_name']) && !empty($_SESSION['code_name'])) {
            $code_name = $_SESSION['code_name'];
            $stmtCoupon = $pdo->prepare("SELECT coupon_id FROM coupons WHERE code = :code_name");
            $stmtCoupon->bindParam(':code_name', $code_name, PDO::PARAM_STR);
            $stmtCoupon->execute();
            $couponId =  $stmtCoupon->fetchColumn(); 
        }

        try {
            $stmtUser = $pdo->prepare("SELECT user_id FROM users WHERE login_ = :userLogin");
            $stmtUser->bindParam(':userLogin', $userLogin, PDO::PARAM_STR);
            $stmtUser->execute();

            if ($stmtUser->rowCount() > 0) {
                $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);
                $userId = $userData['user_id'];

                $stmtOrder = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status, coupon_id) VALUES (:userId, :totalCost, :status, :couponId)");
                $stmtOrder->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmtOrder->bindParam(':totalCost', $totalCost, PDO::PARAM_INT);
                $stmtOrder->bindParam(':status', $status, PDO::PARAM_STR);
                $stmtOrder->bindParam(':couponId', $couponId, PDO::PARAM_INT);
                $stmtOrder->execute();

                echo 'success';
            } else {
                echo 'User not found';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during order addition: ' . $e->getMessage();
        }
    } else {
        echo 'User is not logged in.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
