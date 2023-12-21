<?php
include_once("newdb.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $pdo = connect();

    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM staff WHERE staff_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $existingStaff = $stmt->fetch();

            if ($existingStaff) {
                $stmt = $pdo->prepare("DELETE FROM staff WHERE staff_id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                echo 'success';
            } else {
                echo 'User not found.';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during staff deletion.';
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
