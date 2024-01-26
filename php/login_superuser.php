<?php
session_start();
include_once("newdb.php");

if (isset($_POST['slogin']) && isset($_POST['spassword'])) {
    $slogin = $_POST['slogin'];
    $spassword = $_POST['spassword'];

    $pdo = connect();

    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM superusers WHERE login_ = :slogin AND password_ = :spassword");
            $stmt->bindParam(':slogin', $slogin, PDO::PARAM_STR);
            $stmt->bindParam(':spassword', $spassword, PDO::PARAM_STR);
            $stmt->execute();
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                $stmt = $pdo->prepare("SELECT role_id FROM superusers JOIN staff ON staff.user_id = superusers.superuser_id WHERE login_ = :slogin");
                $stmt->bindParam(':slogin', $slogin, PDO::PARAM_STR);
                $stmt->execute();
                $role_id = $stmt->fetchColumn();
                $_SESSION['slogin'] = $slogin;
                echo $role_id; 

            } else {
                echo 'User does not exist or wrong password.';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during user addition.';
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo '';
}
?>