<?php
include_once("classes.php");
session_start();

$response = "";
$user = new User($_POST['login'], $_POST['password'], $_POST['password']);
$login_result = $user->loginUser();
if($login_result === true){

    $_SESSION['lastUserId'] = $user->getLastUserId();
    $_SESSION['login'] = $user->getLogin();
    $response = true;


//    $_SESSION['userLogin'] =
}
else {
    $response = "Wrong login or password!";
}

echo $response;

?>