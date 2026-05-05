<?php
$conn = new mysqli("localhost","root","","banking");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>