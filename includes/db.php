<?php
$host = "localhost";
$user = "root";
$password = "";   // keep empty in XAMPP
$database = "stayease";  // must be string

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>