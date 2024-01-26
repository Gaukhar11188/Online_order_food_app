<?php
include_once("newdb.php");

if (isset($_POST['name']) && isset($_POST['category'])
&& isset($_POST['price']) && isset($_POST['image'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $pdo = connect();

    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE name = :name");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $existingProduct = $stmt->fetch();

            if (!$existingProduct) {
                $stmt = $pdo->prepare("INSERT INTO  menu_items (name, category, price, img_pc) VALUES (:name, :category, :price, :image)");
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':category', $category, PDO::PARAM_STR);
                $stmt->bindParam(':price', $price, PDO::PARAM_STR);
                $stmt->bindParam(':image', $image, PDO::PARAM_STR);
                $stmt->execute();
                echo 'success';
            } else {
                echo 'Product already exists.';
            }
        } catch (PDOException $e) {
            echo 'An error occurred during product addition.';
        }
    } else {
        echo 'Database connection error.';
    }
} else {
    echo 'Invalid parameters.';
}
?>
