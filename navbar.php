<!-- Navigation Bar -->
<style>
<?php include("styles/style.css");?>
</style>

<?php session_start();?>

<nav>
    <div class="logo">
        <img src="./images/osmos.png" alt="OSMOS">
    </div>
    <ul>
        <li id="home">Home</li>
        <li>About Us</li>
        <li>Contact Us</li>
    </ul>
    <div class="buttons">
        <div class="btn" id="login">Sign In</div>
        <div class="btn" id="register">Sign Up</div>
    </div>

    <script>
        var btn = document.getElementById('home');
        btn.addEventListener('click', function() {
            document.location.href = 'index.php';
        });
        var btn = document.getElementById('login');
        btn.addEventListener('click', function() {
            document.location.href = 'login.php';
        });
        var btn = document.getElementById('register');
        btn.addEventListener('click', function() {
            document.location.href = 'register.php';
        });
    </script>
</nav>