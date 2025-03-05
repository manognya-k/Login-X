<?php
    session_start();
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php
                include("php/config.php");
                if(isset($_POST['submit'])){
                    $email = mysqli_real_escape_string($con,$_POST['email']);
                    $password = $_POST['password'];

                    $result = mysqli_query($con,"SELECT * FROM users WHERE Email='$email'");
                    $row = mysqli_fetch_assoc($result);
                    if(is_array($row)&& !empty($row)){
                        $hashed_password = $row['Password'];
                        if(password_verify($password, $hashed_password)){
                            $_SESSION['valid'] = $row['Email'];
                            $_SESSION['username'] = $row['Username'];
                            $_SESSION['id'] = $row['Id'];
                        }
                        else{
                            echo "<div class='message'>
                            <p>Wrong Username or Password</p>
                            </div><br>";
                            echo "<a href='index.php'><button class='btn'>Go Back</button>";
                        }
                    }
                    else{
                        echo "<div class='message'>
                        <p>This email doesn't exists.Sign Up.</p>
                        </div><br>";
                        echo "<a href='register.php'><button class='btn'>Sign Up</button>";
                    }
                    if(isset($_SESSION['valid'])){
                        header("Location: home.php");
                    }
                }
                else{
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="Email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links"><p>
                    Don't have an account? <a href="register.php">Register Now</a><br>
                    <a href="forgot_password.php">Forgot Password?</a>
                </p></div>
            </form>
        </div>
               <?php } ?> 
    </div>
</body>
</html>