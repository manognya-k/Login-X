<?php
session_start();
include("php/config.php");

require ('PHPMailer/Exception.php'); 
require ('PHPMailer/PHPMailer.php');
require ('PHPMailer/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email,$reset_token)
{

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;          
    $mail->SMTPSecure = "ssl";                         //Enable SMTP authentication
    $mail->Username   = 'protechie007@gmail.com';                     //SMTP username
    $mail->Password   = 'koxt gibe hbgd uuki';                               //SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    //$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587; 
    //Recipients
    $mail->setFrom('protechie007@gmail.com', 'Mailer');
    $mail->addAddress($email);     //Add a recipient


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password Reset Link';
    $mail->Body    = "We got a request from you to reset your password! <br>
    Click the Link below: <br>
    <a href='https://localhost/pr-1/reset-password.php?email=$email&reset-token=$reset_token'>Reset Link</a>";

    $mail->send();
    return true;
} 
catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    return false;
}
}
if(isset($_POST['submit']))
{
    $query = "SELECT * FROM users WHERE Email = '".$_POST['email']."'";
    $result = mysqli_query($con,$query);
    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/kolkata');
            $date = date("Y-m-d");
            $query = "UPDATE `users` SET `reset_token`='$reset_token',`reset_token_expire`='$date' WHERE Email='".$_POST['email']."'";
            if(mysqli_query($con,$query) && sendMail($_POST['email'],$reset_token))
            {
                echo"<div class='message'>
            <p>Password reset link sent to your mail  !!</p>
            </div><br>";
            }
            else
            {
                echo"<div class='message'>
            <p>Something went wrong.Please try again later.</p>
            </div><br>";
            }
        }
        else
        {
            echo"<div class='message'>
            <p>This email does not exists</p>
            </div><br>";
        }
    }
    else
    { 
         echo"<div class='message'>
             <p>Cannot run query</p>
             </div><br>";
        echo "<a href='index.php'><button class='btn'>Go Back</button>"; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Forgot Password</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Forgot Password</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" value="Send Reset Link" class="btn" name="submit" required>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
