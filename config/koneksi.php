<?php
$servername = "localhost";
$username = "root";
$password = "password123";
$dbname = "project_crud";

// Create connection
$koneksi = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$koneksi) {
  die("Connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully";
?>
