<?php

    session_start();

    if(isset($_SESSION['slogin'])){
        echo true;
    }
    else{
        echo false;
    }

?>
