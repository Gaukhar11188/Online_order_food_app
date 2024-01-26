<?php
include_once("newdb.php");
session_start();

try {
    $pdo = connect();

    $stmtLastOrderId = $pdo->prepare("SELECT COUNT(*) as count FROM orders");
    $stmtLastOrderId->execute();

    if ($stmtLastOrderId->rowCount() > 0) {
        $lastOrderIdData = $stmtLastOrderId->fetch(PDO::FETCH_ASSOC);
        $lastOrderId = $lastOrderIdData['count'];
        $_SESSION['last_order_id'] = $lastOrderId;
        echo $lastOrderId;
        exit;
    }
}
catch (PDOException $e) {
    echo 'An error occurred during last order Id addition: ' . $e->getMessage();
}
?>