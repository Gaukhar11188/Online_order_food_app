<?php
include_once("newdb.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $fname1 = $_GET['fname1'];
    $lname1 = $_GET['lname1'];
    $pdo = connect();

    if ($pdo) {
        try {        
            $stmt = $pdo->prepare("SELECT * FROM staff WHERE first_name = :fname1 AND last_name = :lname1");
            $stmt->bindParam(':fname1', $fname1, PDO::PARAM_STR);  
            $stmt->bindParam(':lname1', $lname1, PDO::PARAM_STR);
            $stmt->execute();
            $staffData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($staffData) {
                echo json_encode($staffData);
            }
            else{
                echo json_encode(['error' => 'Staff not found.']);
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
