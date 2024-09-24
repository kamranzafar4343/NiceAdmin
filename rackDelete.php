<?php
// Include the database connection file
include 'db.php';

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    // Get the ID of the rack to delete
    $rack_id = $_GET['id'];

    // SQL query to delete the rack from the database
    $sql = "DELETE FROM racks WHERE id = ?";
    
    // Prepare and bind the SQL statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $rack_id);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to the racks list page with a success message
            header("Location: racks.php?message=Rack+deleted+successfully");
            exit();
        } else {
            // Handle error in execution
            echo "Error deleting rack: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle error in preparing the SQL statement
        echo "Error preparing the SQL statement: " . $conn->error;
    }
} else {
    // If no ID is provided, redirect to the racks page
    header("Location: racks.php?message=No+rack+ID+provided");
    exit();
}

// Close the database connection
$conn->close();
?>
