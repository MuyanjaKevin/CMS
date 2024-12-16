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

// Check if the search form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    // Get the search query from the form
    $searchQuery = $_POST['searchQuery'];

    // Perform the search query in the database
    $sql = "SELECT * FROM computer_services WHERE name LIKE '%$searchQuery%'";
    $result = mysqli_query($conn, $sql);

    // Check if any results are found
    if (mysqli_num_rows($result) > 0) {
        ?>
        <html>
            <head>
                <style>
                    body {
                        background-color: whitesmoke;
                        font-family: Arial, sans-serif;
                    }

                    .search-results {
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 5px;
                        width: 900px;
                        margin: 20px auto;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }

                    h2 {
                        color: #333;
                    }



                    table {
                        border-collapse: collapse;
                        width: 100%;
                        margin-top: 20px;
                    }

                    th, td {
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
                <div class="search-results">
                    <h2>Search Results</h2>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Model</th>
                            <th>Serial Number</th>
                            <th>Specifications</th>
                            <th>Status Name</th>
                            <th>Repair Type Name</th>
                        </tr>

                        <?php
                        // Display the search results
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['model'] . '</td>';
                            echo '<td>' . $row['serial_number'] . '</td>';
                            echo '<td>' . $row['specifications'] . '</td>';
                            echo "<td>" . $row['Status_name'] . "</td>";
                            echo "<td>" . $row['repair_types_name'] . "</td>";
                            echo '</tr>';
                        }
                        ?>

                    </table>
                </div>
            </body>
        </html>
        <?php
    } else {
        echo '<p class="no-results" style="color: #ff0000; font-weight: bolder; font-size: 30px; ">No results found.</p>';
    }
}

// Close the database connection
mysqli_close($conn);
?>
<?php
// Your existing code
// After displaying a message or at the end of the file
echo '<p></p>';
redirectButton();
?>
