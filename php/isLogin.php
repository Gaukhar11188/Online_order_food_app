<?php

    session_start();

    if(isset($_SESSION['lastUserId'])){
        echo true;
    }
    else{
        echo false;
    }

?>