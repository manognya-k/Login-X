<?php
session_start();
include("php/config.php");

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_GET['email'];
    if ($password == $confirm_password) {
        $update_query = "UPDATE users SET Password='$password', reset_token=NULL, reset_token_expire=NULL WHERE Email='$email'";
        //echo "Update query: $update_query<br>"; // Debug statement
        $result = mysqli_query($con, $update_query);
        //echo "Affected rows: " . mysqli_affected_rows($con) . "<br>";
        if (mysqli_affected_rows($con) > 0) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
            $update_query = "UPDATE users SET Password=? WHERE Email=?";
            $stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email); // Bind the hashed password
            mysqli_stmt_execute($stmt);
            $_SESSION['message']="<div class='message'><p>Password has been reset successfully.</p></div>";
            header("Location: index.php"); // Redirect to login page
            exit;
        } else {
            echo "<div class='message'>
            <p>Failed to update password.</p>
            </div>";
        }
    } else {
        echo "<div class='message'>
        <p>Passwords do not match.</p>
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Reset Password</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" value="Reset Password" class="btn" name="submit" required>
                </div>
            </form>
        </div>
    </div>
</body>
</html>