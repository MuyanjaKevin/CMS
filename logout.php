<?php

// Database connection parameters
$host = '127.0.0.1';
$username = 'lucky';
$password = '6%b48fCbUNZPfnQ';
$database = 'computers';

// Create a connection to the database
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start(); // Start the session
// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // User is logged in, perform logout actions
    session_destroy(); // Destroy the session data
    header('Location: login.php'); // Redirect to the login page
    exit;
} else {
    // User is not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}
?>


