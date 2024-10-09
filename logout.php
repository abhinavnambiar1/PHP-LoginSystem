<?php 

include("navbar.php");

if(isset($_SESSION)){
    session_destroy();

    header("Location:login.php");
}
else{
    header("Location:login.php");
}

?>