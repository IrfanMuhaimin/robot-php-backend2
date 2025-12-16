<?php
// api/db_config.php
$servername = "localhost";
$username = "pi_user";       // <<< UPDATE YOUR USERNAME
$password = "your_strong_password"; // <<< UPDATE YOUR PASSWORD
$dbname = "pi_tasks";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

