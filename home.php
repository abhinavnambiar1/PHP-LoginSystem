<?php include('navbar.php');?>

<?php 

error_reporting(E_ALL ^ E_WARNING);

$username = $_SESSION['username'];
$email = $_SESSION['email'];

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


<script>
    function changePass(){
        document.location.href="change-password.php";
    }
    function logout(){
        document.location.href="logout.php";
    }
</script>