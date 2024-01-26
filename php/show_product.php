<?php
include_once("newdb.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $itemid = $_GET['itemid'];

    $pdo = connect();

    if ($pdo) {
        try {        
            $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE item_id = :itemid");
            $stmt->bindParam(':itemid', $itemid, PDO::PARAM_INT);  
            $stmt->execute();
            $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($productData) {
                echo json_encode($productData);
            }
            else{
                echo json_encode(['error' => 'Product not found.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'An error occurred during staff member retrieval: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Database connection error.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
