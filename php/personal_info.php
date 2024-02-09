<?php
include_once('newdb.php');
session_start(); 

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

            $stmt2 = $pdo->prepare("SELECT user_id FROM users        
            WHERE login_ = :userLogin");
            $stmt2->bindParam(':userLogin', $userLogin, PDO::PARAM_STR);
            $stmt2->execute();
            $userId = $stmt2->fetch();       
           
            $stmt3 = $pdo->prepare("SELECT * FROM creditcards 
            JOIN customers ON customers.customer_id = creditcards.customer_id
            WHERE customers.user_id = :userId");
            $stmt3->bindParam(':userId', $userId['user_id'], PDO::PARAM_INT);
            $stmt3->execute();
            $cardData = $stmt3->fetch();        

            if ($userData) {
                echo '<br>';
                echo '<br>';
                echo '<h3>Clients personal information:</h3><br>';
                echo '<p><strong>First name: </strong>' . $userData['first_name'] . '</p>';
                echo '<p><strong>Last name: </strong>' . $userData['last_name'] . '</p>';
                echo '<p><strong>Phone number: </strong>' . $userData['phone_number'] . '</p>';
                echo '<p><strong>Email: </strong>' . $userData['email'] . '</p>';
                echo '<p><strong>Address: </strong>' . $userData['address'] . '</p>';
            } 
            
            if ($cardData){
                echo '<p><strong>Card Number: </strong>' .$cardData['cardholder_number']. '</p>';
                echo '<p><strong>Balance: </strong>' . $cardData['balance'] . ' USD </p>';
                echo '<br>';
                echo '<br>';
            }
                   
            else {
                echo '<br>';
                echo '<br>';
                echo '<p>No data</p>';
            }
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    } else {
        echo 'Database connection error.';
    }
}
?>
