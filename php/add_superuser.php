<?php
include_once("newdb.php");

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];


    $pdo = connect();

    if ($pdo) {
        try {
            $pattern = '/^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z]).{6,}$/';
            $loginPattern = '/^.{3,}$/';      

            if (!preg_match($pattern, $password)) {
                echo "Debug: Password pattern not matched";
                return "Password should include at least 1 number, 1 symbol, 1 uppercase letter, and more than 6 symbols!";
            }

            if(!preg_match($loginPattern, $login)){
                echo "Debug: Login pattern not matched";
                return "Login should be more than 3 numbers!";
            }
        
            $stmt = $pdo->prepare("SELECT * FROM superusers WHERE login_ = :login");
            $stmt->bindParam(':login', $login, PDO::PARAM_STR);
            $stmt->execute();
            $existingUser = $stmt->fetch();

            if (!$existingUser && preg_match($pattern, $password) && preg_match($loginPattern, $login)) {
                $stmt = $pdo->prepare("INSERT INTO superusers (login_, password_) VALUES (:login, :password)");
                $stmt->bindParam(':login', $login, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();

                echo 'success';
            } else {
                echo 'User already exists.';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during user addition.';
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
