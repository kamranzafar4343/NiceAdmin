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
    $item_id = intval($_GET['id']); 

    // Fetch the company ID associated with the item from the comp_FK_item column
    $sql = "SELECT * FROM `item` WHERE `item_id` = $item_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $box_id = $row['box_FK_item'];

        // Now, perform the delete operation
        $delete_sql = "DELETE FROM `item` WHERE `item_id` = $item_id";
        if ($conn->query($delete_sql) === TRUE) {
            // Redirect to the company's branches page after successful deletion
            header("Location: showItems.php?id=". $box_id);
            exit;
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error: No company found for this branch.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No branch ID provided.";
}
?>