<?php

session_start(); // Start the session
// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // User is logged in, no need to perform logout actions
} else {
    // User is not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}

include 'functions.php';
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

// Function to fetch all computers from the database
function getComputers($conn) {
    $computers = array();

    // Prepare the SELECT statement
    $sql = "SELECT * FROM computer_services";

    // Execute the SELECT statement
    $result = mysqli_query($conn, $sql);

    // Check if any records are found
    if (mysqli_num_rows($result) > 0) {
        // Loop through each row and add the computer details to the array
        while ($row = mysqli_fetch_assoc($result)) {
            $computers[] = $row;
        }
    }

    return $computers;
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $model = $_POST['model'];
    $serialNumber = $_POST['serial_number'];
    $specifications = $_POST['specifications'];
    // $Status_name = $_POST['Status_name'];
    //$repair_types_name = $_POST['repair_types_name'];
    // Check the action requested
    if ($_POST['submit'] === 'Save') {
        // Check if it's a new computer or an existing computer being updated
        if (empty($id)) {
            // Create a new computer
            $sql = "INSERT INTO computer_services (name, model, serial_number, specifications)
                    VALUES ('$name', '$model', '$serialNumber', '$specifications')";
            if (mysqli_query($conn, $sql)) {
                echo '<p style="color: green; font-size: 20px; font-weight: bold;">Computer Created Successfully.</p>';
            } else {
                echo "Error creating computer: " . mysqli_error($conn);
            }

// Your existing code
// After displaying a message or at the end of the file
            echo '<p></p>';
            redirectButton();
        } else {
            // Update an existing computer
            $sql = "UPDATE computer_services SET
                    name = '$name',
                    model = '$model',
                    serial_number = '$serialNumber',
                    specifications = '$specifications',
                    Status_name = '$Status_name',
                    repair_types_name = '$repair_types_name'
                    WHERE id = $id";
            if (mysqli_query($conn, $sql)) {
                echo "Computer updated successfully.";
            } else {
                echo "Error updating computer: " . mysqli_error($conn);
            }
        }
    } elseif ($_POST['submit'] === 'Delete') {
        // Delete a computer
        $sql = "DELETE FROM computer_services WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "Computer deleted successfully.";
        } else {
            echo "Error deleting computer: " . mysqli_error($conn);
        }
    }
}

// Function to validate login
function login($username, $password, $conn) {
    // Escape user inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to check if the admin key and password match in the database
    $query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        // Authentication successful
        return true;
    } else {
        // Authentication failed
        return false;
    }
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the login credentials
    if (login($username, $password, $conn)) {
        // Authentication successful
        echo 'Login successful!';

        // Store the user's login status in the session
        $_SESSION['loggedin'] = true;

        // Redirect to the home page or any other page
        // header('Location: i.php');
        // exit;
    } else {
        // Authentication failed
        echo 'Invalid username or password.';
    }
}

// Close the database connection
mysqli_close($conn);
?>
