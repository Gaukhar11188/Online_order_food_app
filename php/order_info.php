<?php
include_once('newdb.php');
session_start(); 

if(isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    //$_SESSION['current_order_id'] = $order_id;

    $pdo = connect();

    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM orders 
            JOIN coupons on
            orders.coupon_id = coupons.coupon_id
            WHERE order_id = :order_id");
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
            $orderData = $stmt->fetch();

            if ($orderData) {
                echo '<div style="text-align: right;">';
                echo '<h2>Total: $'.$orderData['total_amount'].'</h2>';
                echo '<h5>Coupon: '.$orderData['code'].'</h5>';
                echo '<h5>Date: '.$orderData['order_date'].'</h5>';
                
            } 
            
            else {
                echo '<br>';
                echo '<br>';
                echo '<p>No data</p>';
            }
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    } else {
        echo 'Database connection error.';
    }
}

?>
