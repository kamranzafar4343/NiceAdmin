<?php
// Include the database connection file
include 'config/db.php';

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    // Get the ID of the rack to delete and sanitize it
    $rack_id = $conn->real_escape_string($_GET['id']);

    // SQL query to delete related records from the store table
    $delete_store_sql = "DELETE FROM store WHERE rack_id = '$rack_id'";
    
    // Execute the delete statement for the store table
    if ($conn->query($delete_store_sql) === TRUE) {
        // SQL query to delete the rack from the racks table
        $delete_rack_sql = "DELETE FROM racks WHERE id = '$rack_id'";
        
        // Execute the delete statement for the racks table
        if ($conn->query($delete_rack_sql) === TRUE) {
            // Redirect to the racks list page with a success message
            header("Location: racks.php?message=Rack+deleted+successfully");
            exit();
        } else {
            // Handle error in execution
            echo "Error deleting rack: " . $conn->error;
        }
    } else {
        // Handle error in execution for store deletion
        echo "Error deleting related records from store: " . $conn->error;
    }
} else {
    // If no ID is provided, redirect to the racks page
    header("Location: racks.php?message=No+rack+ID+provided");
    exit();
}

// Close the database connection
$conn->close();
?>
