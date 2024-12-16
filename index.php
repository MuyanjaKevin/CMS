<?php
session_start(); // Start the session
// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page or display an error message
    header('Location: login.php');
    exit;
}

class Computer {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createComputer($name, $model, $serialNumber, $specifications) {
        $stmt = $this->conn->prepare("INSERT INTO computer_services (name, model, serial_number, specifications) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $model, $serialNumber, $specifications);
        if ($stmt->execute()) {
            echo "Computer created successfully.";
        } else {
            echo "Error creating computer: " . $stmt->error;
        }

        $stmt->close();
    }

    public function getComputers() {
        $sql = "SELECT * FROM computers";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "Name: " . htmlspecialchars($row['name']) . "<br>";
                echo "Model: " . htmlspecialchars($row['model']) . "<br>";
                echo "Serial Number: " . htmlspecialchars($row['serial_number']) . "<br>";
                echo "Specifications: " . htmlspecialchars($row['specifications']) . "<br><br>";
            }
        } else {
            echo "No computers found.";
        }
    }

    public function updateComputer($id, $name, $model, $serialNumber, $specifications) {
        $stmt = $this->conn->prepare("UPDATE computers SET name = ?, model = ?, serial_number = ?, specifications = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $model, $serialNumber, $specifications, $id);

        if ($stmt->execute()) {
            echo "Computer updated successfully.";
        } else {
            echo "Error updating computer: " . $stmt->error;
        }

        $stmt->close();
    }

    public function deleteComputer($id) {
        $stmt = $this->conn->prepare("DELETE FROM computers WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Computer deleted successfully.";
        } else {
            echo "Error deleting computer: " . $stmt->error;
        }

        $stmt->close();
    }

}
?>

<html>
    <head>
        <title>Computer Management System</title>
        <style>
            body {
                background-color: #f1f1f1;
                font-family: Arial, sans-serif;
            }

            h1 {
                color: #333;
            }

            form {
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                width: 400px;
                margin: 0 auto;
                margin-left: 50px; /* Add this line to adjust the form to the left */
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            label {
                display: block;
                margin-bottom: 10px;
            }

            input[type="text"],
            textarea {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            input[type="submit"] {
                background-color: #4CAF50;
                color: #fff;
                border: none;
                padding: 10px 16px;
                cursor: pointer;
                border-radius: 4px;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
            }

            th,
            td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            a {
                text-decoration: none;
                color: #333;
            }

            a:hover {
                color: #4CAF50;
            }
        </style>
    </head>
    <body>
        <h1>Computer Management System</h1>

        <!-- Form for creating or updating a computer -->
        <form action="process.php" method="POST">
            <input type="hidden" name="id" value="">
            <label>Name:</label>
            <input type="text" name="name" value=""><br><br>
            <label>Model:</label>
            <input type="text" name="model" value=""><br><br>
            <label>Serial Number:</label>
            <input type="text" name="serial_number" value=""><br><br>
            <label>Specifications:</label>
            <textarea name="specifications"></textarea><br><br>

            <!-- Submit button for creating or updating a computer -->
            <input type="submit" name="submit" value="Save">
        </form>
        <hr>

        <!-- Display existing computers -->
        <h2> Registered Computers</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>Specifications</th>
                <th>Status Name</th>
                <th>Repair Type Name</th>
                <th>Action</th>
            </tr>
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

            // Fetch all computers from the database
            $sql = "SELECT * FROM computer_services";
            $result = mysqli_query($conn, $sql);

// Check if any records are found
            if (mysqli_num_rows($result) > 0) {
                // Loop through each row and display the computer details in table rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['model'] . "</td>";
                    echo "<td>" . $row['serial_number'] . "</td>";
                    echo "<td>" . $row['specifications'] . "</td>";
                    echo "<td>" . $row['Status_name'] . "</td>";
                    echo "<td>" . $row['repair_types_name'] . "</td>";
                    echo "<td>";
                    echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a> | ";
                    echo "<a href='delete.php?id=" . $row['id'] . "'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No computers found</td></tr>";
            }



            // Close the database connection
            mysqli_close($conn);
            ?>
        </table>
    <html>
        <style>
            .search-form {
                position: fixed;
                top: 30px;
                right: 10px;
                display: flex;
                align-items: center;
                height: 30px;
            }

            .search-input {
                width: 150px;
                padding: 4px;
                border: none;
                border-radius: 4px;
            }

            .search-button {
                padding: 4px 10px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .search-button:hover {
                background-color: #45a049;
            }
        </style>

        <div class="search-form">
            <form method="POST" action="search.php">
                <input type="text" name="searchQuery" class="search-input" placeholder="Enter search query">
                <button type="submit" name="search" class="search-button">Search</button>
            </form>
        </div>

    </style>
</head>
</html>


<a href="logout.php" style="color: #ffffff; background-color: #ff0000; padding: 2px 50%; text-decoration: none; border-radius: 5px;">Logout</a>