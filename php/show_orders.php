<?php
include_once("newdb.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $formattedDate = $_GET['formattedDate'];

    $pdo = connect();

    if ($pdo) {
        try {        
            $stmt = $pdo->prepare("SELECT
            o.order_id,
            ANY_VALUE(o.order_date) AS order_date,
            ANY_VALUE(o.total_amount) AS total_amount,
            ANY_VALUE(o.status) AS status,
            GROUP_CONCAT(mi.name) AS menu_items_names,
            GROUP_CONCAT(od.quantity) AS quantities
        FROM
            orders o
        JOIN
            customers c ON o.user_id = c.user_id
        JOIN
            order_details od ON o.order_id = od.order_id
        JOIN
            menu_items mi ON od.item_id = mi.item_id
        WHERE
            DATE(o.order_date) = :formattedDate
        GROUP BY
            o.order_id;
        ");

            $stmt->bindParam(':formattedDate', $formattedDate, PDO::PARAM_STR);  
          
            $stmt->execute();
            $orderData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($orderData) {
                echo json_encode($orderData);
            }
            else{
                echo json_encode(['error' => 'Orders not found.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'An error occurred during order retrieval: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Database connection error.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
