<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSMOS | Password Reset</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    
<?php include("navbar.php");?>

<?php require("dbconfig.php");?>

<?php 

error_reporting(E_ALL ^ E_WARNING);

if(!isset($_SESSION)){
    header("Location:login.php");
}
// print_r($_SESSION);
$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

    <!-- Main Section -->
    <div class="main">
        <div class="left-main">
            <img src="./images/login.jpg" alt="login-user">
        </div>
        <div class="right-main">
            <p>
                <?="<p style='font-size: 25px;'>Hello " . "<b>$username</b></p>";?>
            </p>
            <br>
            <form action="change-password.php" method="post">
                <input type="password" placeholder="Enter Old Password" name="old_password" id="prev_pass">
                </br>
                <label id="oldPassword"></label>  
                </br>
                </br>
                <input type="password" placeholder="Enter New Password" name="new_password" id="new_pass">
                </br>
                <label id="newPassword"></label>  
                </br>
                </br>
                <input type="password" placeholder="Re-enter New Password" name="confirm_password" id="confirm_pass">
                </br>
                <label id="confirmPassword"></label>  
                </br>
                </br>
                <button type="submit">Re-Login</button>
                </form>
            </div>
        </div>
</body>

</html>

<?php 

error_reporting(E_ALL ^ E_WARNING);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
 
    if($pageWasRefreshed ) {
      session_unset();
    } else {
      exit();
    }

    $hash_old_password = base64_encode($old_password);
    // echo $hash_old_password;
    // echo "<br/>";
    $hash_new_password = base64_encode($new_password);
    // echo $hash_new_password;
    // echo "<br/>";
    $hash_confirm_password = base64_encode($confirm_password);
    // echo $hash_confirm_password;

    // Fetch the old password from the database
    $previous_password = "SELECT * FROM users WHERE email='$email'";
    // echo "Old: " . $previous_password;
    $prev_pass_result = mysqli_query($conn, $previous_password);
    $row = mysqli_fetch_assoc($prev_pass_result);
    $hash_previous_password = unserialize($row['previous_password']);

    if (in_array(base64_encode($new_password), $hash_previous_password)){
        echo '<script>
        alert("New password cannot be same from the last 3 passwords.");
        </script>';
        exit();
    }

    $hash_previous_password[] = base64_encode($row['password']);

    if (count($hash_previous_password) > 3) {
        array_shift($hash_previous_password); // Remove the oldest password
    }

    $serialized_hash_previous_password = serialize($hash_previous_password);

    // echo "Row Pass: ". $row['password'];

    if(empty($old_password)){
        // echo '<script>alert("Username Required")</script>';
        echo '<script>
        var labelText = document.getElementById("oldPassword");
        var input = document.getElementById("prev_pass");
            labelText.innerHTML = "Old Password Required";
            labelText.style.color = "red";
            labelText.style.fontSize = "small";
            input.style.border = "2px solid red";
</script>';
        exit();
    } else if(empty($new_password)){
        // echo '<script>alert("Email Required")</script>';
        echo '<script>
        var labelText = document.getElementById("newPassword");
        var input = document.getElementById("new_pass");
            labelText.innerHTML = "New Password Required";
            labelText.style.color = "red";
            labelText.style.fontSize = "small";
            input.style.border = "2px solid red";
</script>';
        exit();
    } else if(empty($confirm_password)){
        // echo '<script>alert("Password Required")</script>';
        echo '<script>
        var labelText = document.getElementById("confirmPassword");
        var input = document.getElementById("confirm_pass");
            labelText.innerHTML = "Re-enter Password";
            labelText.style.color = "red";
            labelText.style.fontSize = "small";
            input.style.border = "2px solid red";
</script>';
        exit();
    } else if(strlen($new_password) < 8){
        // echo '<script>alert("Password should be atleast 8 characters long")</script>';
        echo '<script>
        var labelText = document.getElementById("newPassword");
        var input = document.getElementById("new_pass");
            labelText.innerHTML = "Password should be atleast 8 characters long";
            labelText.style.color = "red";
            labelText.style.fontSize = "small";
            input.style.border = "2px solid red";
</script>';
        exit();
    } else if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $new_password)){
        echo '<script>
        var labelText = document.getElementById("newPassword");
        var input = document.getElementById("new_pass");
            labelText.innerHTML = "Password should contain alphanumeric characters";
            labelText.style.color = "red";
            labelText.style.fontSize = "small";
            input.style.border = "2px solid red";
</script>';
        exit();
    }
    // echo $row['password'];
    if(($hash_old_password == $row['password']) && ($new_password == $confirm_password)) {
        // echo "Hello";
            $sql3 = "UPDATE users SET password = '$hash_new_password', previous_password = '$serialized_hash_previous_password' WHERE email = '$email'";
            
            $result3 = mysqli_query($conn, $sql3);
            if ($result3) {
                // echo "180 -----------------";
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                
                header("Location: home1.php");
                // session_destroy();
                // header("login.php");
                
                exit();
            }
        }
    }
?>