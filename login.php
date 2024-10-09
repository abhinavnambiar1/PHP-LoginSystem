<?php include("navbar.php");?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSMOS | User Login</title>
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
            <img src="./images/login.jpg" alt="login-user">
        </div>
        <div class="right-main">
        <form action="login.php" method="post">
                <input type="text" placeholder="Enter Email ID" name="email">
                </br>
                </br>
                <input type="password" placeholder="Enter Password" name="password">
                </br>
                </br>
                <button type="submit">Login</button>
                </form>
            </div>
        </div>
</body>

</html>

<?php 

error_reporting(E_ALL ^ E_WARNING);

require("dbconfig.php");

    if(isset($_POST['email']) && isset($_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        // echo $password;
        $password = base64_encode($password);
        // echo $password;

        $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
        
        if($pageWasRefreshed ) {
          session_unset();
        } 

        $hash_pass = "SELECT * from users WHERE email='$email'";
        // echo $hash_pass;
        $hash_pass_result = mysqli_query($conn, $hash_pass);
        $final_pass = mysqli_num_rows($hash_pass_result);
        //print_r($final_pass);
        if(empty($email)){
            echo '<script>
            var labelText = document.getElementById("emailLabel");
            var input = document.getElementById("email");
                labelText.innerHTML = "Email Required";
                labelText.style.color = "red";
                labelText.style.fontSize = "small";
                input.style.border = "2px solid red";
</script>';
            exit();
        } 
        else if(empty($password)){
            echo '<script>
            var labelText = document.getElementById("passwordLabel");
            var input = document.getElementById("password");
                labelText.innerHTML = "Password Required";
                labelText.style.color = "red";
                labelText.style.fontSize = "small";
                input.style.border = "2px solid red";
</script>';
            exit();
        } 
        if($final_pass == 1){
            echo "<br/>";
            while($row=mysqli_fetch_assoc($hash_pass_result)){
                print_r($row);
                // echo $row['password'] . " - Row Pass";
                // echo "<br/>";
                // echo $password . " - Password";
                $username = $row['username'];
                echo $username;
                if($password == $row['password']){
                    echo $row['password'];
                    echo $row['username'];
                        $_SESSION["login"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["email"] = $email;
                        header("Location: home.php");
                        var_dump($_SESSION);
                        echo($_SESSION['username']);
                        exit();
                    }else{
                        echo '<script>alert("Incorrect Username or Password")</script>';
                        exit();
                    }
                }
                }
    }
?>