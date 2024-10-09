<?php include("navbar.php"); ?>

<?php
    
    error_reporting(E_ALL);

    ob_start();
    require("dbconfig.php");
    
    // if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']))
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        echo $hash_password = base64_encode($password);
        echo $hash_confirm_password = base64_encode($confirm_password);

        $hash_previous_password = [];
        $hash_previous_password[] = $hash_password;

        $serialized_hash_previous_password = serialize($hash_previous_password);

        $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
        
        if($pageWasRefreshed ) {
          session_unset();
        } 
        
        if (!isset($_SESSION['password'])) {
            $_SESSION['password'] = $password;
        }
        if ($password !== $_SESSION['password']) {
            if($pageWasRefreshed ) {
          exit();
        } else {
          exit("Password Mismatch");
        }
        }

        if(empty($username)){
            echo "38";
            // echo '<script>alert("Username Required")</script>';
            echo '<script>
            var labelText = document.getElementById("usernameLabel");
            var input = document.getElementById("username");
                labelText.innerHTML = "Username Required";
                labelText.style.color = "red";
                labelText.style.fontSize = "small";
                input.style.border = "2px solid red";
</script>';
            exit();
        } else if(empty($email)){
            // echo '<script>alert("Email Required")</script>';
            echo '<script>
            var labelText = document.getElementById("emailLabel");
            var input = document.getElementById("email");
                labelText.innerHTML = "Email Required";
                labelText.style.color = "red";
                labelText.style.fontSize = "small";
                input.style.border = "2px solid red";
</script>';
            exit();
        } else if(empty($password)){
            // echo '<script>alert("Password Required")</script>';
            echo '<script>
            var labelText = document.getElementById("passwordLabel");
            var input = document.getElementById("password");
                labelText.innerHTML = "Password Required";
                labelText.style.color = "red";
                labelText.style.fontSize = "small";
                input.style.border = "2px solid red";
</script>';
            exit();
        } else if(empty($confirm_password)){
            // echo '<script>alert("Re-enter Password")</script>';
            echo '<script>
            var labelText = document.getElementById("confirm_passwordLabel");
            var input = document.getElementById("confirm_password");
                labelText.innerHTML = "Re-enter Password";
                labelText.style.color = "red";
                labelText.style.fontSize = "small";
                input.style.border = "2px solid red";
</script>';
            exit();
        } else if(strlen($password) < 8){
            // echo '<script>alert("Password should be atleast 8 characters long")</script>';
            echo '<script>
            var labelText = document.getElementById("passwordLabel");
            var input = document.getElementById("password");
                labelText.innerHTML = "Password should be atleast 8 characters long";
                labelText.style.color = "red";
                labelText.style.fontSize = "small";
                input.style.border = "2px solid red";
</script>';
            exit();
        } else if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $password)){
            echo '<script>
            var labelText = document.getElementById("passwordLabel");
            var input = document.getElementById("password");
                labelText.innerHTML = "Password should contain alphanumeric characters";
                labelText.style.color = "red";
                labelText.style.fontSize = "small";
                input.style.border = "2px solid red";
</script>';
            exit();
        } else if($password !== $confirm_password){
            // echo '<script>alert("Password Mismatch")</script>';
            echo '<script>
            var labelText = document.getElementById("confirm_passwordLabel");
                labelText.innerHTML = "Password Mismatch";
                labelText.style.color = "red";
                labelText.style.fontSize = "small";
</script>';
            exit();
        }
        else{

            $sql = "SELECT * FROM users WHERE email='$email'";
		    $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            }else{
            $sql2 = "INSERT INTO users(username, email, password, previous_password) VALUES('$username', '$email', '$hash_password', '$serialized_hash_previous_password')";
            echo $sql2;
            $result2 = mysqli_query($conn, $sql2);
            if ($result2) {
                $_SESSION["login"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;

                header("Location: home.php");
                ob_end_flush();
                exit();
                
            }
        }
    }
}

?>
<?php ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSMOS | User Registration</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Main Section -->
    <div class="main">
        <div class="left-main">
            <img src="./images/register.jpg" alt="login-user">
        </div>
        <div class="right-main">
            <form action="register.php" method="post">
                <!-- <input type="text" placeholder="Enter Username" name="username" value="" required> -->
               <input type="text" placeholder="Enter Username" name="username" id="username">
                </br>
               <label id="usernameLabel"></label>               
                </br>
                </br>
                <input type="email" placeholder="Enter Email ID" name="email" id="email" >
                </br>
                <label id="emailLabel"></label>  
                </br>
                </br>
                <input type="password" placeholder="Enter Password" name="password" id="password">
                </br>
                <label id="passwordLabel"></label>  
                </br>
                </br>
                <input type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password">
                </br>
                <label id="confirm_passwordLabel"></label>  
                </br>
                </br>
                <button type="submit">Register</button>
            </form>
        </div>
</body>

</html>


