<?php
// api/db_config.php

/**
 * Read database credentials from environment variables.
 * These variables are passed into the container by the docker-compose.robotarm.yml file.
 * This is a secure and flexible way to manage configuration.
 */
$servername = getenv('DB_HOST');       // This will be 'db', the service name of your MySQL container
$username   = getenv('DB_USER');       // This will be 'thedilution_user' from your .env file
$password   = getenv('DB_PASSWORD');   // This will be 'admin123' from your .env file
$dbname     = getenv('DB_NAME');       // This will be 'thedilution_db' from your .env file

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // It's better practice to return a proper server error than to die()
    header('HTTP/1.1 500 Internal Server Error');
    error_log("Database Connection Failed: " . $conn->connect_error); // Log error instead of exposing it
    exit("Database connection failed. Please check server logs.");
}

// Set the charset to ensure proper encoding
$conn->set_charset("utf8mb4");

?>