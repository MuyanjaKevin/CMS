<?php
// Include the database configuration file to establish a connection
require_once('database.php'); // Adjust the path if needed

// Include the Computer class file
require_once('Computer.php');

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['model'], $_POST['serial_number'], $_POST['specifications'])) {
    // Instantiate the Computer class, passing the DB connection
    $computer = new Computer($conn);
    
    // Get data from the POST request
    $name = $_POST['name'];
    $model = $_POST['model'];
    $serialNumber = $_POST['serial_number'];
    $specifications = $_POST['specifications'];

    // Call the createComputer function and handle response
    if ($computer->createComputer($name, $model, $serialNumber, $specifications)) {
        echo "Computer created successfully";
    } else {
        echo "Failed to create computer";
    }
} else {
    http_response_code(405); // Method not allowed
    echo "Invalid request method or missing parameters.";
}
?>
