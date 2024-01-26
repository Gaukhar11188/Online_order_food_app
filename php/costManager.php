<?php
session_start();
include_once('newdb.php');

function getDiscountByCoupone($code){
    $pdo = connect();

    $stmt = $pdo->prepare('SELECT percent, code FROM coupons WHERE code = :code');
    $stmt->bindParam(':code', $code, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $discount = intval($data['percent']);
    $code_name = $data['code'];

    $response = array(
        'discount' => $discount,
        'code_name' => $code_name,
    );

    return $response;
}

function getSubtotalCost() {
    $cart = $_SESSION['cart'];
    $subtotalCost = 0;

    foreach ($cart as $key => $item) {
        $subtotalCost += $item['quantity'] * $item['price'];
    }

    $_SESSION['subtotalCost'] = $subtotalCost;
    return $subtotalCost;
}

function getTotalCost(){
    $subtotalCost = getSubtotalCost();
    $totalCost = $subtotalCost;
    if(isset($_SESSION['discount'])){
        $totalCost = $subtotalCost * (100 - $_SESSION['discount']) / 100;
    }
    
    $_SESSION['totalCost'] = $totalCost;
    return $totalCost;
}

$response = array();
$code = $_POST['code'];
$functionName = $_POST['functionName'];
$discount = 0;
$code_name = "";
if($functionName == 'getDiscountByCoupone'){
    $response = getDiscountByCoupone($code);
    $_SESSION['discount'] = $response['discount'];
    $_SESSION['code_name'] = $response['code_name'];
}
else if($functionName == 'getLastDiscount' && isset($_SESSION['discount'])){
    $discount = $_SESSION['discount'];
    $code_name = $_SESSION['code_name'];
    $response = array(
        'discount' => $discount,
        'code_name' => $code_name,
    );
}
else if($functionName == 'getSubtotalCost'){
    $response = getSubtotalCost();
}
else if($functionName == 'getTotalCost'){
    $response = getTotalCost();
}

header('Content-Type: application/json');
echo json_encode($response);

exit();

?>
