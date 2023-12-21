<?php
session_start();

//include_once('addToCart.php');
header('Content-Type: application/json');

// Check if the cart is not empty
if (!empty($_SESSION['cart'])) {
    $cartItems = $_SESSION['cart'];
    echo json_encode($cartItems);
} else {
    echo json_encode([]);
}

exit();
?>

