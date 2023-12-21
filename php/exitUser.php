<?php
session_start();

session_destroy();

echo '<li><a class="nav-link" href="customer_login.html"><img src="images/user.svg"></a></li>';
echo '<li><a class="nav-link" href="cart.html"><img src="images/cart.svg"></a></li>';

?>
