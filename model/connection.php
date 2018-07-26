<?php
$servername = "localhost";
$username = "jhunnie";
$password = "mysql";
$database = "abc";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// echo "Connected successfully to database";

?>
