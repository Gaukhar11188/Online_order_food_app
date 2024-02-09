<?php
include_once("newdb.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $userId = $_SESSION['lastUserId'];
    $roleId = 2;

    $pdo = connect();

    if ($pdo) {
        try {
           
            $stmt = $pdo->prepare("SELECT * FROM customers WHERE first_name = :fname AND last_name = :lname");
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->execute();
            $existingCustomer = $stmt->fetch();

            if ($existingCustomer) {
                $stmt = $pdo->prepare("UPDATE customers SET email = :c_email_address, phone_number = :c_phone, address = :c_address WHERE first_name = :fname AND last_name = :lname");
                $stmt->bindParam(':c_email_address', $email, PDO::PARAM_STR);
                $stmt->bindParam(':c_phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':c_address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
                $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);

                $stmt->execute();

                echo 'success';
            } else {
                echo 'Customer does not exist. Please check the details.';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during customer operation: ' . $e->getMessage();
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
