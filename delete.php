<?php
if (isset($_GET['id'])) {
    $id = $_GET['id']; 

    // Validate that the ID is a positive integer
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        header("Location: index.php?error=InvalidID");
        exit();
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "myclients";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Close resources
    $stmt->close();
    $conn->close();
}

header("Location: index.php");
exit();
