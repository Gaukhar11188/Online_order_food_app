<?php
include_once("newdb.php");

if (isset($_POST['userid'])) {
    $userid = $_POST['userid'];

    $pdo = connect();

    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM superusers WHERE superuser_id = :userid");
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->execute();
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                $stmt = $pdo->prepare("DELETE FROM superusers WHERE superuser_id = :userid");
                $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
                $stmt->execute();
                echo 'success';
            } else {
                echo 'User not found.';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during user deletion.';
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
