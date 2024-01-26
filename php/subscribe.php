<?php
function message($msg) {
    echo "<script>alert('$msg'); window.location.replace('../index.html');</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";

    $filePath = 'C:\Users\admin\Downloads\OSPanel\domains\localhost\Test\PHPProjectLast\files\subscribers.txt';

    $file = fopen($filePath, 'a');

    if ($file) {
        fwrite($file, "Name: $name, Email: $email\n");
        fclose($file);

        message("Subscription successful! Thank you for subscribing.");
    } else {
        message("Error opening the file for writing.");
    }
} else {
    message("Invalid request method.");
}
?>
