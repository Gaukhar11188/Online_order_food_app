<?php
function message($msg) {
    echo "<script>alert('$msg'); window.location.replace('../index.html');</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = isset($_POST["fname"]) ? $_POST["fname"] : "";
    $lname = isset($_POST["lname"]) ? $_POST["lname"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $txt = isset($_POST["txt"]) ? $_POST["txt"] : "";

    $filePath = 'C:\Users\admin\Downloads\OSPanel\domains\localhost\Test\PHPProjectLast\files\qa.txt';

    $file = fopen($filePath, 'a');

    if ($file) {
      
        $currentDate = date("Y-m-d H:i:s");

        fwrite($file, "Date: $currentDate, First name: $fname, Last name: $lname, Email: $email, Message: $txt\n");

        fclose($file);

        message("Thank you for contacting us, we will answer you as soon as possible!");
    } else {
        message("Error opening the file for writing.");
    }
} else {
    message("Invalid request method.");
}
?>
