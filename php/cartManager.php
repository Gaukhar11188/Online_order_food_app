<?php

session_start();
header('Content-Type: application/json');

function decrease($productId, $products){
    foreach ($products as $key => &$item) {
        if ($item['item_id'] == $productId) {
            $item['quantity']--;
            if ($item['quantity'] == 0) {
                unset($products[$key]);
            }
            break;
        }
    }

    return $products;
}

function increase($productId, $products){

    foreach ($products as $key => &$item) {
        if ($item['item_id'] == $productId) {
            $item['quantity']++;
            break;
        }
    }

    return $products;
}

function inputByText($productId, $products, $quantity){

    foreach ($products as $key => &$item) {
        if ($item['item_id'] == $productId) {
            $item['quantity'] = $quantity;
            break;
        }
    }

    return $products;
}

function deletePosition($productId, $products){
    foreach ($products as $key => $item) {
        if ($item['item_id'] == $productId) {
            unset($products[$key]);
            break;
        }
    }
    return $products;
}

$productId = $_POST['productId'];

$products = $_SESSION['cart'];

if($_POST['functionName'] == 'increase'){
    $products = increase($productId, $products);
}
else if($_POST['functionName'] == 'decrease'){
    $products = decrease($productId, $products);
}
else if($_POST['functionName'] == 'inputByText'){
    $products = inputByText($productId, $products, intval($_POST['quantity']));
}
else if($_POST['functionName'] == 'deletePosition'){
    $products = deletePosition($productId, $products);
}
else if($_POST['functionName'] == 'clearCart'){
    $_SESSION['cart'] = [];
    $response = "success";
    echo json_encode($response);
    exit();
}


$_SESSION['cart'] = $products;
$response = array(
    'totalItems' => count($_SESSION['cart']),
    'cartContents' => $_SESSION['cart']
);
echo json_encode($response);

exit();

?>