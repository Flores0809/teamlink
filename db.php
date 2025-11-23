<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Default username for XAMPP/WAMP
$password = "";     // Default password for XAMPP/WAMP (leave empty)
$dbname = "team_link_db"; // You must create this database in phpMyAdmin

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optionally, echo a success message for testing, then remove it
// echo "Connected successfully to the database: " . $dbname;
?>