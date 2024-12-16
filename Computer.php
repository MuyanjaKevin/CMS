<?php
class Computer
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createComputer($name, $model, $serial_number, $specifications)
    {

        // Define the query
        $query = "INSERT INTO computer_services(name, model, serial_number, specifications) VALUES (?, ?, ?, ?)";
        // Prepare and execute the query
        $stmt = $this->conn->prepare($query);
        
        //printf(n);
        $stmt->bind_param("ssss", $name, $model, $serial_number, $specifications);

        if ($stmt->execute()) {
            return "Computer created successfully" . $this->conn->error;
        } else {
            return "Error creating computer: " . $this->conn->error;
        }
    }
}
?>
