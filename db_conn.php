<?php
// Database connection parameters
$servername = "localhost"; // host
$username = "root";       // xamp username
$password = "";           // MYSQL password
$dbname = "user_db";      // db name

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    // If connection fails, terminate the script and display the error
    die("Connection failed: " . $conn->connect_error);
}
?>