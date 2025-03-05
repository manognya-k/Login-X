<?php
    session_start();
    include("php/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Register</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="Username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="Email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already a member? <a href="index.php">Sign In</a><br><br>
                </div>
            </form>
            <?php
                if(isset($_POST['submit'])){
                    $username = mysqli_real_escape_string($con,$_POST['username']);
                    $email = mysqli_real_escape_string($con,$_POST['email']);
                    $password = $_POST['password'];
                    $confirm_password = $_POST['confirm_password'];

                    if($password == $confirm_password){
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $query = "INSERT INTO users (Username, Email, Password) VALUES ('$username', '$email', '$hashed_password')";
                        mysqli_query($con, $query);

                        echo "<div class='message'>
                        <p>Registration successful. Please login to continue.</p>
                        </div>";
                        echo "<center><a href='index.php'><button class='btn'>Sign In</button></center>";
                    }
                    else{
                        echo "<div class='message'>
                        <p>Passwords do not match.</p>
                        </div>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>