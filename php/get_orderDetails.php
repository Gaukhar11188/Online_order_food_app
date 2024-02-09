<?php
session_start();
include_once("newdb.php");

if(isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    //$_SESSION['current_order_id'] = $order_id;

    $pdo = connect();

    if ($pdo) {
        try {        
            $stmt = $pdo->prepare("SELECT * FROM order_details
                JOIN menu_items ON order_details.item_id = menu_items.item_id
                WHERE order_id = :order_id"); 
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $orderData = $stmt->fetchAll(PDO::FETCH_ASSOC); 

                if ($orderData) {
                    echo json_encode($orderData);
                } else {
                    echo json_encode([]); 
                }
            } else {
                echo json_encode(['error' => 'Failed to execute query.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Database connection error.']);
    }
} else {
    echo json_encode(['error' => 'Missing or empty order_id parameter.']);
}
?>
