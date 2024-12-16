<?php
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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $computerId = $_POST['id'];
    $name = $_POST['name'];
    $model = $_POST['model'];
    $serialNumber = $_POST['serial_number'];
    $specifications = $_POST['specifications'];
    $Status_name = $_POST['Status_name'];
    $repair_types_name = $_POST['repair_types_name'];

    // Update the computer record in the database
    $sql = "UPDATE computer_services SET name = '$name', model = '$model', serial_number = '$serialNumber', specifications = '$specifications', Status_name = '$Status_name', repair_types_name = '$repair_types_name' WHERE id = '$computerId'";
    $result = mysqli_query($conn, $sql);

    // Check if the update was successful
    if ($result) {
        // echo "Computer updated successfully";
    } else {
        echo "Error updating computer: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
<?php
// Database connection parameters and other PHP logic...
// Output the HTML content
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Update Computer</title>
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
                border: 1px solid #ddd;
                border-radius: 4px;
                margin-bottom: 20px;
            }

            .message.success {
                color: #155724;
                background-color: #d4edda;
                border-color: #c3e6cb;
            }

            .message.error {
                color: #721c24;
                background-color: #f8d7da;
                border-color: #f5c6cb;
            }
        </style>
    </head>
    <body>

        <?php
        // Check if the form is submitted and perform the update logic...
        // Display the success or error message
        if ($result) {
            echo "<div class='message success'>Computer updated successfully</div>";
        } else {
            echo "<div class='message error'>Error updating computer: " . mysqli_error($conn) . "</div>";
        }
        ?>
        <h2>Update Computer</h2>
        <!-- Additional content if needed -->
    </body>
</html>
<?php
// Your existing code
// After displaying a message or at the end of the file
echo '<p></p>';
redirectButton();
?>

