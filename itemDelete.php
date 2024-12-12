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
    echo "<script>window.location.href = 'showItems.php';</script>"; // Redirect to another page (e.g., home)
    exit();
}

if (isset($_GET['id'])) {
    $item_id = intval($_GET['id']); // Ensure the item ID is an integer

    // Fetch the box ID associated with the item from the box_FK_item column
    $sql = "SELECT * FROM `item` WHERE `item_id` = $item_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // $box_id = $row['box_barcode'];

        // Now, perform the delete operation (since the user is an admin)
        $delete_sql = "DELETE FROM `item` WHERE `item_id` = $item_id";
        if ($conn->query($delete_sql) === TRUE) {
            // Redirect to the page showing the items for the box after successful deletion
            header("Location: showItems.php");
            exit;
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error: No item found with the provided ID.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No item ID provided.";
}
