<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable detailed error reporting

// Database connection details
$host = '127.0.0.1';
$username = 'lucky';
$password = '6%b48fCbUNZPfnQ';
$database = 'computers';

// Connect to the database
try {
    $conn = new mysqli($host, $username, $password, $database);
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

$errorMessage = ""; // Initialize error message

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (verifyCredentials($username, $password)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = isAdmin($username) ? 'admin' : 'user';

        // Redirect to dashboard
        header('Location: index.php');
        exit;
    } else {
        $errorMessage = "Invalid Username or Password.";
    }
}

// Close the database connection
$conn->close();

// Function to verify credentials
function verifyCredentials($username, $password) {
    global $conn;
    $query = "SELECT password FROM admins WHERE username = ? 
              UNION 
              SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return password_verify($password, $row['password']);
    }
    return false;
}

// Function to check if a user is an admin
function isAdmin($username) {
    global $conn;
    $query = "SELECT 1 FROM admins WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            background-color: whitesmoke;
            font-family: Arial, sans-serif;
        }

        .login-form {
            background-color: #fff;
            padding: 50px;
            border-radius: 5px;
            width: 300px;
            margin: 20px auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .login-form input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .login-form .register-link {
            text-align: center;
            margin-top: 10px;
        }

        .login-form .register-link a {
            color: #333;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
            <?php if (!empty($errorMessage)): ?>
                <div style="color: red; text-align: center; margin-top: 10px;">
                    <?= htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>
            <div class="register-link">
                <a href="register.php">Register a new user</a>
            </div>
        </form>
    </div>
</body>
</html>
