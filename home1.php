<?php include('navbar.php');?>

<?php 

error_reporting(E_ALL ^ E_WARNING);

$username = $_SESSION['username'];
$email = $_SESSION['email'];

?>


<br>
<h1><?= "Welcome " . $username;?></h1>
</br>
</br>
<p><?= "<h3>You have successfully changed your password!!</h3>" ?></p>

<!-- <button class="change_password" onclick="changePass()">Change Password</button> -->
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