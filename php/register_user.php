<?php
include_once("classes.php");

session_start();

$response = "";
$user = new User($_POST['login'], $_POST['password'], $_POST['repeat_password']);
$registration_result = $user->registerUser();
if($registration_result === true){
    $_SESSION['lastUserId'] = $user->getLastUserId();
    $_SESSION['login'] = $user->getLogin();
    $response = true;
}
else {
    $response = $registration_result;
}

echo $response;

?>