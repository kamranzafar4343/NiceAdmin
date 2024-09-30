<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

// Include database connection
include "config/db.php";

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Retrieve and sanitize the 'id' to prevent SQL injection
    $store_id = $conn->real_escape_string($_GET['id']);

    // SQL query to delete the record from the 'store' table
    $query = "DELETE FROM store WHERE id = '$store_id'";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        // Record deleted successfully
        echo "Record deleted successfully.";
        // Optionally redirect to the store page after deletion
        header('Location: store.php');
        exit();
    } else {
        // Error occurred
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // If 'id' parameter is not set, redirect to store page
    header('Location: store.php');
    exit();
}

// Close the database connection
$conn->close();
?>
