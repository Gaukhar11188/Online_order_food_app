<?php
include_once('newdb.php');
$pdo=connect();
$imagePath = 'images/';

$list2 = $pdo->query('SELECT 
    mi.name AS item_name,
    mi.price AS item_price,
    mi.img_pc AS img,
    SUM(od.quantity) AS total_quantity_sold
    FROM 
    order_details od
    JOIN 
    menu_items mi ON od.item_id = mi.item_id
    GROUP BY 
    od.item_id
    ORDER BY 
    total_quantity_sold DESC
    LIMIT 3');

while ($rowTop3 = $list2->fetch()) {
    echo '<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">';
    echo '<a class="product-item" href="shop.html">';
    echo '<img src="'.$imagePath.$rowTop3['img'].'" class="img-fluid product-thumbnail">';
    echo '<h3 class="product-title">'.$rowTop3['item_name'] . '</h3>';
    echo '<strong class="product-price">$'.$rowTop3['item_price'] . '</strong>';
    echo '</a>';
    echo '</div>';
}

?>