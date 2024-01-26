<?php

session_start();

if(!isset($_SESSION['login'])){

    echo '<div class="col-md-12">';
	echo '</br>';
	echo '</br>';
	echo '<div class="border p-4 rounded" role="alert">';
	echo 'Returning customer? <a href="customer_login.html">Click here</a> to login';
	echo '</div>';
	echo '</div>';
}

else{
}
?>
