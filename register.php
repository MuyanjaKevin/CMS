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

// Check if the registration form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the form data (You can customize the validation logic)
    if (validateRegistration($username, $password)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Registration successful
            echo '<p class="success" style="color: #00FF00; font-weight: bold; font-size: 20px;">Registration Successful!</p>';
        } else {
            // Registration failed
            echo '<p class="error" style="color: #ff0000; font-weight: bold; font-size: 20px;">Registration Failed.</p>';
        }
    } else {
        // Invalid registration data
        echo '<p class="error" style="color: #ff0000; font-weight: bold; font-size: 20px;">Invalid Registration Data.</p>';
    }
}

// Close the database connection
mysqli_close($conn);

// Function to validate the registration data
function validateRegistration($username, $password) {
    // You can customize the validation logic here
    if (empty($username) || empty($password)) {
        return false;
    }

    // Additional validation checks...

    return true;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Registration</title>
        <style>
            body {
                background-color: whitesmoke;
                font-family: Arial, sans-serif;
            }

            .registration-form {
                background-color: #fff;
                padding: 50px;
                border-radius: 5px;
                width: 300px;
                margin: 20px auto;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .registration-form input[type="text"],
            .registration-form input[type="password"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 3px;
            }

            .registration-form input[type="submit"] {
                background-color: #4CAF50;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 3px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="registration-form">
            <h2>User Registration</h2>
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="register" value="Register">
            </form>
            <div class="login-link">
                <a href="login.php">Back to Login</a>
            </div>
        </div>
    </body>
</html>
