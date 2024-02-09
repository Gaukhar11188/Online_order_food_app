<?php

include_once("newdb.php");
session_start();

function loadOrderDetailsToDB(&$pdo)
{

    $cart = $_SESSION['cart'];
    $userId = $_SESSION['user_id'];

    try {
        $stmtLastOrderId = $pdo->prepare("SELECT order_id FROM orders WHERE user_id = :user_id ORDER BY order_id DESC LIMIT 1");
        $stmtLastOrderId->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmtLastOrderId->execute();

        $lastOrderId = $stmtLastOrderId->fetch(PDO::FETCH_ASSOC);
        $lastOrderId = $lastOrderId['order_id'];

        foreach ($cart as $item) {
            $subtotal = $item['quantity'] * $item['price'];
            $stmtOrder_details = $pdo->prepare("INSERT INTO order_details (item_id, order_id, quantity, subtotal) VALUES (:item_id, :order_id, :quantity, :subtotal)");
            $stmtOrder_details->bindParam(':item_id', $item['item_id'], PDO::PARAM_INT);
            $stmtOrder_details->bindParam(':order_id', $lastOrderId, PDO::PARAM_INT);
            $stmtOrder_details->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
            $stmtOrder_details->bindParam(':subtotal', $subtotal, PDO::PARAM_INT);
            $stmtOrder_details->execute();
        }

        return true;
    } catch (PDOException $e) {
        echo 'An error occurred during order_details addition: ' . $e->getMessage();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totalCost = $_SESSION['totalCost'];
    $userLogin = $_SESSION['login'];

    $pdo = connect();

    if (empty($totalCost)) {
        echo 'Invalid parameters.';
        exit;
    }


    if ($pdo) {
        try {
            // Получение user_id для указанного логина
            $stmtUser = $pdo->prepare("SELECT user_id FROM users WHERE login_ = :userLogin");
            $stmtUser->bindParam(':userLogin', $userLogin, PDO::PARAM_STR);
            $stmtUser->execute();

            if ($stmtUser->rowCount() > 0) {
                $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);
                $userId = $userData['user_id'];
                $paymentMethod = $_POST['paymentMethod'];

                // Получение последнего order_id по логину
                $stmtOrder = $pdo->prepare(
                    "SELECT 
                        o.order_id,
                        u.login_ AS user_login,
                        o.order_date
                    FROM 
                        orders o
                    JOIN 
                        users u ON o.user_id = u.user_id
                    WHERE 
                        u.login_ = :userLogin
                    ORDER BY 
                        o.order_date DESC
                    LIMIT 1");
                $stmtOrder->bindParam(':userLogin', $userLogin, PDO::PARAM_STR);
                $stmtOrder->execute();

                if ($stmtOrder->rowCount() > 0) {
                    $orderData = $stmtOrder->fetch(PDO::FETCH_ASSOC);
                    $orderId = $orderData['order_id'];

                    // Проверка наличия существующего заказа
                    $stmtExistingPayment = $pdo->prepare("SELECT COUNT(*) AS paymentCount FROM payments WHERE order_id = :orderId");
                    $stmtExistingPayment->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                    $stmtExistingPayment->execute();

                    $existingPaymentData = $stmtExistingPayment->fetch(PDO::FETCH_ASSOC);
                    $paymentCount = $existingPaymentData['paymentCount'];

                    if ($paymentCount == 0 && $paymentMethod == 1) {

                        $stmtPayment = $pdo->prepare("INSERT INTO payments (order_id, amount, payment_method) VALUES (:orderId, :totalCost, :paymentMethod)");
                        $stmtPayment->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                        $stmtPayment->bindParam(':totalCost', $totalCost, PDO::PARAM_INT);
                        $stmtPayment->bindParam(':paymentMethod', $paymentMethod, PDO::PARAM_STR);
                        $stmtPayment->execute();

                        loadOrderDetailsToDB($pdo);

                        echo 'success';
                    } 
                    
                    else if ($paymentCount == 0 && $paymentMethod == 2) {
                        $stmtBalance = $pdo->prepare("SELECT balance FROM creditcards 
                            JOIN customers ON customers.customer_id = creditcards.customer_id
                            WHERE customers.user_id = :userId");
                        $stmtBalance->bindParam(':userId', $userId, PDO::PARAM_INT);
                        $stmtBalance->execute();
                        $balanceData = $stmtBalance->fetch(PDO::FETCH_ASSOC);
                        $balance = $balanceData['balance'];
                        $newBalance = $balance - $totalCost;

                        if ($newBalance < 0) {
                            
                            echo "Insufficient funds on the credit card.";
    
                            exit;
                        }
                    
                        $stmtCustomer = $pdo->prepare("SELECT customers.customer_id
                            FROM customers JOIN users ON customers.user_id = users.user_id
                            WHERE users.user_id = :userId");
                        $stmtCustomer->bindParam(':userId', $userId, PDO::PARAM_INT);
                        $stmtCustomer->execute();
                        $customerData = $stmtCustomer->fetch(PDO::FETCH_ASSOC);
                        $customerId = $customerData['customer_id'];
                    
                        $stmtUpdateBalance = $pdo->prepare("UPDATE creditcards SET balance = :newBalance WHERE customer_id = :customerId");
                        $stmtUpdateBalance->bindParam(':newBalance', $newBalance, PDO::PARAM_INT);
                        $stmtUpdateBalance->bindParam(':customerId', $customerId, PDO::PARAM_INT);
                        $stmtUpdateBalance->execute();
                    
                        $stmtPayment = $pdo->prepare("INSERT INTO payments (order_id, amount, payment_method) VALUES (:orderId, :totalCost, :paymentMethod)");
                        $stmtPayment->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                        $stmtPayment->bindParam(':totalCost', $totalCost, PDO::PARAM_INT);
                        $stmtPayment->bindParam(':paymentMethod', $paymentMethod, PDO::PARAM_STR);
                        $stmtPayment->execute();
                    
                        loadOrderDetailsToDB($pdo);
                        
                        date_default_timezone_set('Your/Timezone');
                        $purchaseTime = date('Y-m-d H:i:s');
                    
                        echo "\nPurchase: Rocket Chefs Restaurant\nCost: $totalCost\nTime: $purchaseTime\nBalance: $newBalance";

                        //echo 'success';
                         
                    }
                    
                    
                    else {
                        echo 'Order already exists for this user';
                    }
                } else {
                    echo 'User not found';
                }
            }
        } catch (PDOException $e) {
            echo 'An error occurred during order addition: ' . $e->getMessage();
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid request method.';
}

?>
