<?php
session_start();
include("php/config.php");
if(!isset($_SESSION['valid'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Home</p>
        </div>
        <div class="right-links">
            <?php
            $id = $_SESSION['id'];
            $query = mysqli_query($con,"SELECT * FROM users WHERE Id=$id");
            while($result = mysqli_fetch_assoc($query)){
                $un = $result['Username'];
                $em = $result['Email'];
                $id = $result['Id'];
            }
            ?>
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <p>Hello <b><?php echo $un?></b></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>