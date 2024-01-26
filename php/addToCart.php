<?php
session_start();
include_once('newdb.php');
include_once('get_menu_items.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['productId'];

    
    $pdo = connect();

    $stmt = $pdo->prepare('SELECT * FROM menu_items WHERE item_id = :item_id');
    $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
    $stmt->execute();
    $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    $cart_arr = $_SESSION['cart'];
    $alreadyWas = false;

    foreach ($cart_arr as &$item){
        if($item['item_id'] == $productDetails['item_id']){
            $item['quantity']++;
            $alreadyWas = true;
            break;
        }
    } 

    if($alreadyWas){
        $_SESSION['cart'] = $cart_arr;
    }
    else{
        $_SESSION['cart'][] = array(
            'item_id' => $productDetails['item_id'],
            'name' => $productDetails['name'],
            'price' => $productDetails['price'],
            'quantity' => 1, 
            'image' => $productDetails['img_pc']
        );
    }
    
    

    

    $response = array(
        'totalItems' => count($_SESSION['cart']),
        'cartContents' => $_SESSION['cart'] 
    );

    header('Content-Type: application/json');

    echo json_encode($response);

    exit();
}
?>
