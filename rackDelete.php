<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

// Include the database connection
include 'config/db.php';

// Get session email 
$email = $_SESSION['email'];

// Get user name, email, and role from the register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
    $userRole = $row2['role']; // Assuming you have a 'role' column in the 'register' table
}

// Check if the user is an admin
if ($userRole != 'admin') {
    // If the user is not an admin, show an error message and stop the deletion process
    echo "<script>alert('Only admins can delete items!');</script>";
    echo "<script>window.location.href = 'racks.php';</script>"; // Redirect to another page (e.g., home)
    exit();
}

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
