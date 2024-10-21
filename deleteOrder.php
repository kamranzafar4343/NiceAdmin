
<?php

// session_start(); // Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}
include 'config/db.php';

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']); // Ensure order ID is an integer

        // Now, perform the delete operation
        $delete_sql = "DELETE FROM `orders` WHERE `order_no` = $order_id";
        if ($conn->query($delete_sql) === TRUE) {
            // Redirect to the orders page after successful deletion
            header("Location: order.php");
            exit;
        } else {
            echo "Error deleting order: " . $conn->error;
        }
    } else {
        echo "Error: No company found for this branch.";
    }

    // Close the database connection
    $conn->close();
?>
