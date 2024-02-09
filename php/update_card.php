<?php
include_once("newdb.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $chname = $_POST['chname'];
    $cname = $_POST['cname']; // Original credit card number
    $cdate = $_POST['cdate'];
    $cvv = $_POST['cvv'];

    $userId = $_SESSION['lastUserId'];
    //$userId = 1;
    $cbalance = mt_rand(0, 999999) / 100; // Random number between 0 and 9999.99

    $pdo = connect();

    if ($pdo) {
        try {
            // Get customer ID
            $stmt = $pdo->prepare("SELECT customer_id FROM customers WHERE user_id = :userId");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $customerId = $stmt->fetchColumn();

            if ($customerId) {
                // Check if the card exists
                $stmt = $pdo->prepare("SELECT * FROM creditcards WHERE customer_id = :customerId");
                $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
                $stmt->execute();
                $existingCard = $stmt->fetch();

                if ($existingCard) {
                    // Update the card details
                    $hashedCname = substr($cname, 0, 4) . str_repeat('*', strlen($cname) - 8) . substr($cname, -4); // Hashed format
                    $hashedCvv = password_hash($cvv, PASSWORD_DEFAULT); 

                    $stmt = $pdo->prepare("UPDATE creditcards SET cardholder_name = :chname, cardholder_number = :cname, expiry_date = :cdate, cvv = :cvv, balance = :cbalance WHERE customer_id = :customerId");
                    $stmt->bindParam(':chname', $chname, PDO::PARAM_STR);
                    $stmt->bindParam(':cname', $hashedCname, PDO::PARAM_STR); 
                    $stmt->bindParam(':cdate', $cdate, PDO::PARAM_STR);
                    $stmt->bindParam(':cvv', $hashedCvv, PDO::PARAM_STR);
                    $stmt->bindParam(':cbalance', $cbalance, PDO::PARAM_STR);
                    $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
                    $stmt->execute();

                    echo 'success';
                } else {
                    echo 'Card does not exist. Please check the details.';
                }
            } else {
                echo 'Customer not found.';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during card update: ' . $e->getMessage();
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
