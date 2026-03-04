<?php
$conn = mysqli_connect("localhost","root", "", "task_manager"); 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
