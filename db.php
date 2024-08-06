<?php
$servername = "localhost";
$username_db = "root"; 
$password_db = "010123.Qw"; 
$dbname = "pharmacy";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
?>