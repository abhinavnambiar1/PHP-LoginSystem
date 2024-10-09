<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSMOS User Login System</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include("navbar.php");?>

    <?php 

    error_reporting(E_ALL ^ E_WARNING);

    $username = $_SESSION['username'];
   echo $email = $_SESSION['email'];
    

    ?>


    <main>
    <h1><?= "Welcome " . $username;?></h1>
    <p><?= "You have registered using this ID <b>" . $email . "</b>";?></p>
    <br>
    <br>
    <small>Change your password here!</small>
    <br>

    <button class="change_password" onclick="changePass()">Change Password</button>
    <br><br>
    <button class="logout" onclick="logout()">Logout</button>
    </main>

    <?php
    ?>
    <script>
    function changePass(){
        document.location.href="change-password.php";
    }
    function logout(){
        document.location.href="logout.php";
    }
    </script>
<?php
    
    ?>


</body>
</html>