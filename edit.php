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

// Check if the computer ID is provided in the query parameters
if (isset($_GET['id'])) {
    $computerId = $_GET['id'];

    // Fetch the computer details from the database based on the provided ID
    $sql = "SELECT * FROM computer_services WHERE id = '$computerId'";
    $result = mysqli_query($conn, $sql);

    // Check if a matching computer record is found
    if (mysqli_num_rows($result) > 0) {
        $computer = mysqli_fetch_assoc($result);
    } else {
        echo "Computer not found";
        exit;
    }
} else {
    echo "Invalid computer ID";
    exit;
}

// Close the database connection
mysqli_close($conn);

// Function to generate dropdown options
function generateDropdownOptions($selectedValue, $options) {
    foreach ($options as $option) {
        $isSelected = ($selectedValue == $option) ? 'selected' : '';
        echo "<option value='$option' $isSelected>$option</option>";
    }
}
?>

<html>
    <head>
        <title>Edit Computer</title>
        <style>
            body {
                background-color: #f1f1f1;
                font-family: Arial, sans-serif;
            }

            h2 {
                color: #333;
            }

            form {
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            form input[type="text"],
            form textarea,
            form select {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            form input[type="submit"] {
                background-color: #4CAF50;
                color: #fff;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                border-radius: 4px;
            }

            form input[type="submit"]:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>
        <h2>Edit Computer</h2>
        <form method="POST" action="update.php">
            <input type="hidden" name="id" value="<?php echo $computer['id']; ?>">
            Name: <input type="text" name="name" value="<?php echo $computer['name']; ?>"><br>
            Model: <input type="text" name="model" value="<?php echo $computer['model']; ?>"><br>
            Serial Number: <input type="text" name="serial_number" value="<?php echo $computer['serial_number']; ?>"><br>
            Specifications: <textarea name="specifications"><?php echo $computer['specifications']; ?></textarea><br>
            Status Name:
            <select name="Status_name">
                <?php generateDropdownOptions($computer['Status_name'], ['Pending', 'In Process', 'Ready', 'Returned']); ?>
            </select>
            Repair Types Name:
            <select name="repair_types_name">
                <?php generateDropdownOptions($computer['repair_types_name'], ['Hardware Repair', 'Software Installation', 'Virus Removal', 'Data Recovery', 'Network Configuration']); ?>
            </select>
            <input type="submit" value="Update">
        </form>

        <?php
        // Your existing code
        // After displaying a message or at the end of the file
        echo '<p></p>';
        redirectButton();
        ?>
    </body>
</html>
