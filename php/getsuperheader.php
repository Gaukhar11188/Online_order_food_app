<?php
session_start();
include_once("login_superuser.php");

if(isset($_SESSION['slogin'])){
    echo '<li><a class="nav-link" href="#">'.$_SESSION["slogin"].'</a></li>';
   
    echo '<div><a class="nav-link exit-button" onclick="ExitButtonClick()"><img src="images/exit.png"></a></div>';
}
else{
    echo '<li><a class="nav-link" href="staff_login.html"><img src="images/user.svg"></a></li>';
   
}
?>
