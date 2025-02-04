<?php
$servername = "localhost";
$username = "pushti"; // Replace with your actual username
$password = "123"; // Replace with your actual password
$dbname = "insightmed";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection and display an error message if connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>