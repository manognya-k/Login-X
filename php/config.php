<?php
$con = mysqli_connect("localhost:3307", "root", "", "pr");

// Check connection
if (!$con) {
    die("Couldn't connect: " . mysqli_connect_error());
}
?>