<?php
session_start();

// Database connection parameters
$host = '127.0.0.1';
$username = 'lucky';
$password = '6%b48fCbUNZPfnQ';
$database = 'computers';

try {
    // Create a connection to the database
    $conn = mysqli_connect($host, $username, $password, $database);

    // Check the connection
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Check if the registration form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        // Get the username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the admin into the admins table
        $query = "INSERT INTO admins (username, password) VALUES ('$username', '$hashedPassword')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo '<p class="success" style="color: #00FF00; font-weight: bold; font-size: 20px; ">Admin registered successfully!</p>';
        } else {
            echo '<p class="Invalid" style="color: #ff0000; font-weight: bolder; font-size: 15px; ">Failed to register admin.</p>';
        }
    }
    // Check if the login form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        // Get the username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Fetch the admin details from the admins table based on the provided username
        $query = "SELECT * FROM admins WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);
            $hashedPassword = $admin['password'];

            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, set session variables and redirect to admin panel
                $_SESSION['username'] = $admin['username'];
                header('Location: index.php');
                exit();
            } else {
                echo '<p class="Invalid" style="color: #ff0000; font-weight: bolder; font-size: 15px; ">Invalid username or password.</p>';
            }
        } else {
            echo '<p class="Invalid" style="color: #ff0000; font-weight: bolder; font-size: 15px; ">Invalid username or password.</p>';
        }
    }

    // Close the database connection
    mysqli_close($conn);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Registration</title>
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
            <h2>Admin Registration</h2>
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
