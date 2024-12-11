<?php
include 'db.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM teachers WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Teacher deleted successfully";
    } else {
        echo "Error deleting teacher: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the teachers list
    header("Location: teachers.php");
    exit();
} else {
    echo "No teacher ID specified";
}
?>
