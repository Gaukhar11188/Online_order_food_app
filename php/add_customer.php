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
            $isCustomerExists = $stmt->fetch();

            if (!$isCustomerExists) {
                
                $stmt = $pdo->prepare("INSERT INTO customers (first_name, last_name, email, phone_number, address, user_id, role_id)
                VALUES (:c_fname, :c_lname, :c_email_address, :c_phone, :c_address, :lastUserId, :roleid)");
                $stmt->bindParam(':c_fname', $fname, PDO::PARAM_STR);
                $stmt->bindParam(':c_lname', $lname, PDO::PARAM_STR);
                $stmt->bindParam(':c_email_address', $email, PDO::PARAM_STR);
                $stmt->bindParam(':c_phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':c_address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':lastUserId', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':roleid', $roleId, PDO::PARAM_INT);

                $stmt->execute();

                echo 'success';
            } else {
                echo 'Customer already exists. Please check the details.';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during customer addition: ' . $e->getMessage();
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
