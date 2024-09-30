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
    echo "<script>window.location.href = 'store.php';</script>"; // Redirect to another page (e.g., home)
    exit();
}

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
