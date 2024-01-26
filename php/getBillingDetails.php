<?php
session_start();
include_once("newdb.php");

$pdo = connect();

if (isset($_SESSION['login'])) {
   $userLogin = $_SESSION['login'];

   if ($pdo) {
    try {        
        $stmt = $pdo->prepare("SELECT * FROM customers
                             JOIN users ON users.user_id = customers.user_id
                             WHERE users.login_ = :userLogin"); 
        $stmt->bindParam(':userLogin', $userLogin, PDO::PARAM_STR);
        $stmt->execute();
        $userData = $stmt->fetch();

        if ($userData) {
            echo json_encode($userData);
        } else {
            echo json_encode($userData);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Database connection error.']);
}

}