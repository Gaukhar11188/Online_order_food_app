<?php
include_once("newdb.php");

if (isset($_POST['id1']) && isset($_POST['statusSelect'])) {
    $id1 = $_POST['id1'];
    $statusSelect = $_POST['statusSelect'];

    $pdo = connect();

    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = :id1");
            $stmt->bindParam(':id1', $id1, PDO::PARAM_INT);
            $stmt->execute();
            $existingOrder = $stmt->fetch();

            if ($existingOrder) {
                $stmt = $pdo->prepare("UPDATE orders SET status = :statusSelect WHERE order_id = :id1");
                $stmt->bindParam(':id1', $id1, PDO::PARAM_INT);
                $stmt->bindParam(':statusSelect', $statusSelect, PDO::PARAM_STR);
                $stmt->execute();

                echo 'success';
            } else {
                echo 'Order not found.';
            }           
        } catch (PDOException $e) {
            echo 'An error occurred during order update.';
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
