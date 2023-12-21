<?php
include_once("newdb.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userid'];
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone'];
    $address = $_POST['address'];
    $position = $_POST['position'];
    $roleId = 3;

    $pdo = connect();

    if ($pdo) {
        try {        
            $stmt = $pdo->prepare("SELECT * FROM staff WHERE last_name = :lname");
            $stmt->bindParam(':lname', $lastName, PDO::PARAM_STR);  
            $stmt->execute();
            $isStaffExists = $stmt->fetch();

            if (!$isStaffExists) {
                $stmt = $pdo->prepare("INSERT INTO staff (first_name, last_name, email, phone_number, address, position, user_id, role_id)
                VALUES (:fname, :lname, :email, :phone, :address, :position, :userid, :roleid)");
                $stmt->bindParam(':fname', $firstName, PDO::PARAM_STR);
                $stmt->bindParam(':lname', $lastName, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phoneNumber, PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':position', $position, PDO::PARAM_STR);
                $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':roleid', $roleId, PDO::PARAM_INT);
                
                $stmt->execute();

                echo 'success';
            } else {
                echo 'Staff member is already exists!';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during staff member addition: ' . $e->getMessage();
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}

?>
