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
if (isset($_GET['id'])) {
    $box_id = intval($_GET['id']); // Ensure box ID is an integer

    // Fetch the branch ID associated with the box from the branchID_FK column
    $sql = "SELECT `level2` FROM `box` WHERE `box_id` = $box_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $branch_id = $row['level2'];

        // Check if the user is an admin
        if ($userRole == 'admin') {
            // Now, delete the box from the `box` table
            $delete_box_sql = "DELETE FROM `box` WHERE `box_id` = $box_id";
            if ($conn->query($delete_box_sql) === TRUE) {
                // Redirect to the branch box page after successful deletion
                header("Location: box.php?id=" . $branch_id);
                exit;
            }
        } else {
            // If the user is not an admin, show a pop-up
            echo "<script>alert('Only admins can delete a box.'); window.location.href='box.php?id=" . $branch_id . "';</script>";
        }
    } else {
        echo "Error: No branch found for this box.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No box ID provided.";
}
