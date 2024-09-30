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

// Check if the user is an admin, otherwise redirect
if (isset($_SESSION['role']) &&$_SESSION['role'] != 'admin') {
  // If the user is not an Admin, redirect to index page
  header("Location: index.php");
  exit();
}

if (isset($_GET['id'])) {
    $branch_id = intval($_GET['id']); // Ensure branch ID is an integer

    // Fetch the company ID associated with the branch from the compID_FK column
    $sql = "SELECT `compID_FK` FROM `branch` WHERE `branch_id` = $branch_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $company_id = $row['compID_FK'];

        // Now, perform the delete operation
        $delete_sql = "DELETE FROM `branch` WHERE `branch_id` = $branch_id";
        if ($conn->query($delete_sql) === TRUE) {
            // Redirect to the company's branches page after successful deletion
            header("Location: Branches.php?id=" . $company_id);
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