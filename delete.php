<?php
include 'functions.php';

// Database connection parameters
$host = '127.0.0.1';
$username = 'lucky';
$password = '6%b48fCbUNZPfnQ';
$database = 'computers';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the computer ID is provided
if (isset($_GET['id'])) {
    $computerId = intval($_GET['id']); // Sanitize input
    $stmt = $conn->prepare("DELETE FROM computer_services WHERE id = ?");
    $stmt->bind_param("i", $computerId);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $message = "Computer deleted successfully.";
        $success = true;
    } else {
        $message = "Error deleting computer: ID not found or query failed.";
        $success = false;
    }

    $stmt->close();
} else {
    $message = "Invalid computer ID.";
    $success = false;
}

// Return plain response for functional tests
if (php_sapi_name() === 'cli' || isset($_GET['test_mode'])) {
    header('Content-Type: text/plain');
    echo $message;
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Delete Computer</title>
        <style>
            body {
                background-color: #f1f1f1;
                font-family: Arial, sans-serif;
            }
            h2 {
                color: #333;
            }
            .message {
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 4px;
                margin-bottom: 20px;
            }
            .success {
                color: #155724;
                background-color: #d4edda;
            }
            .error {
                color: #721c24;
                background-color: #f8d7da;
            }
        </style>
    </head>
    <body>
        <h2>Delete Computer</h2>
        <div class="message <?php echo (strpos($message, 'successfully') !== false) ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    </body>
</html>
