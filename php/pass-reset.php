<?php
$db_host = 'localhost';  // Database host
$db_name = 'ishield';  // Database name
$db_user = 'root';  // Database username
$db_pass = '';  // Database password

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



?>