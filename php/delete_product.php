<?php
include_once("newdb.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $pdo = connect();

    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE item_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $existingProduct = $stmt->fetch();

            if ($existingProduct) {
                $stmt = $pdo->prepare("DELETE FROM menu_items WHERE item_id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                echo 'success';
            } else {
                echo 'Product not found.';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during product deletion.';
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>