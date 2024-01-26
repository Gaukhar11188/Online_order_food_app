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

            if ($userData) {
                echo '<br>';
                echo '<br>';
                echo '<h3>Clients personal information:</h3><br>';
                echo '<p><strong>First name: </strong>' . $userData['first_name'] . '</p>';
                echo '<p><strong>Last name: </strong>' . $userData['last_name'] . '</p>';
                echo '<p><strong>Phone number: </strong>' . $userData['phone_number'] . '</p>';
                echo '<p><strong>Email: </strong>' . $userData['email'] . '</p>';
                echo '<p><strong>Address: </strong>' . $userData['address'] . '</p>';
                echo '<br>';
                echo '<br>';
            } else {
                echo '<br>';
                echo '<br>';
                echo '<p>No data</p>';
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Database connection error.']);
    }
}
?>
