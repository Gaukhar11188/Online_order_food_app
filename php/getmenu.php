<?php
include_once('newdb.php');
$pdo = connect();
$imagePath = 'images/';

$list = $pdo->query('SELECT * FROM menu_items');

while ($row = $list->fetch()) {
    echo '<div class="col-12 col-md-4 col-lg-3 mb-5">';
    echo '<a class="product-item" href="#">';
    echo '<img src="' . $imagePath . $row['img_pc'] . '" class="img-fluid product-thumbnail" width="250" height="150">';
    echo '<h3 class="product-title">' . $row['name'] . '</h3><br>';
    echo '<strong class="product-price">$' . $row['price'] . '</strong>';
    echo '<span class="icon-cross">';
    echo '<div class="productId" onclick="addToCartButton(' . $row['item_id'] . ')">';
    echo '<img src="images/cross.svg" class="img-fluid">';
    echo '</div>';
    echo '</span>';
    echo '</a>';
    echo '</div>';
}
?>

