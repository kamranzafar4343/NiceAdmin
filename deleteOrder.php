<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}
include 'config/db.php';

$email = $_SESSION['email'];

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']); // Ensure order ID is an integer

    // Now, perform the delete operation
    $delete_sql = "DELETE FROM `orders` WHERE `order_no` = $order_id";

    //insert delete time into order audit table
    if ($conn->query($delete_sql) === TRUE) {
        $updateDelTime = "UPDATE `orders_audit` SET `deleted_at` = NOW(), `deleted_by` = '$email' WHERE `order_no` = $order_id";
    }
    if ($conn->query($updateDelTime) === TRUE) {
        // Redirect to the referring page
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            header("Location: order.php"); // A fallback page
        }
        exit();
    }
} else {
    echo "Error: No company found for this branch.";
}

// Close the database connection
$conn->close();
?>
