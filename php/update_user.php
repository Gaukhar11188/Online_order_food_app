<?php
include_once("newdb.php");

if (isset($_POST['login1']) && isset($_POST['password1'])) {
    $login1 = $_POST['login1'];
    $password1 = $_POST['password1'];

    $pdo = connect();

    if ($pdo) {
        try {
            $pattern = '/^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z]).{6,}$/';

            if (!preg_match($pattern, $password1)) {
                echo "Debug: Password pattern not matched";
                return "Password should include at least 1 number, 1 symbol, 1 uppercase letter, and more than 6 symbols!";
            }

            $stmt = $pdo->prepare("SELECT * FROM superusers WHERE login_ = :login1");
            $stmt->bindParam(':login1', $login1, PDO::PARAM_STR);
            $stmt->execute();
            $existingUser = $stmt->fetch();

            if ($existingUser && preg_match($pattern, $password1)) {
                $stmt = $pdo->prepare("UPDATE superusers SET password_ = :password1 WHERE login_ = :login1");
                $stmt->bindParam(':login1', $login1, PDO::PARAM_STR);
                $stmt->bindParam(':password1', $password1, PDO::PARAM_STR);
                $stmt->execute();

                echo 'success';
            } else {
                echo 'User not found.';
            }           
        } catch (PDOException $e) {
            echo 'An error occurred during user password update.';
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
