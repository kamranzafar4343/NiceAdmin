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

// Get session variables
$session_userId = $_SESSION['id']; // User ID
$session_user_role = $_SESSION['role']; // User role
$session_email = $_SESSION['email']; // User email

// Get user name, email, and role from the register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
    $userRole = $row2['role']; // Assuming you have a 'role' column in the 'register' table
}

// Audit log function
function logAudit($action_by, $action, $description) {
    global $conn;

    // Escape and sanitize inputs
    $action_by = mysqli_real_escape_string($conn, $action_by);
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);

    $query = "
        INSERT INTO audit_log (user_info, action, description)
        VALUES ('$action_by', '$action', '$description')
    ";

    // Execute the query
    if (!mysqli_query($conn, $query)) {
        error_log("Failed to log audit: " . mysqli_error($conn));
    }
}

// show box previous data
if (isset($_GET['id'])) {

    $box_id = $_GET['id'];
    $sql_box_data = "SELECT * FROM `box` WHERE `box_id`= '$box_id'";

    $result_box = $conn->query($sql_box_data);

    $row_box = mysqli_fetch_array($result_box);
    $fetch_object_code = $row_box['object'];
    $fetch_barcode = $row_box['barcode'];
    $fetch_description = $row_box['box_desc'];
    $fetch_altcode = $row_box['alt_code'];
    $fetch_status = $row_box['status'];
}
         

// Check if a box ID is provided
if (isset($_GET['id'])) {
    $box_id = intval($_GET['id']); // Ensure box ID is an integer

    // Fetch the branch ID associated with the box
    $sql = "SELECT `branch_id_fk` FROM `box` WHERE `box_id` = $box_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $branch_id = $row['branch_id_fk'];

        // Check if the user is an admin
        if ($userRole == 'admin') {
            // Delete the box from the `box` table
            $delete_box_sql = "DELETE FROM `box` WHERE `box_id` = $box_id";
            if ($conn->query($delete_box_sql) === TRUE) {
                // Prepare details for logging the audit
                $action_by = "Deleted by the user-id: $session_userId, user-role: $session_user_role, user-email: $session_email";
                $action = 'Delete';
                $description = "Deleted record: Box ID - $box_id, Object Code - $fetch_object_code, Barcode - $fetch_barcode, Alt Code - $fetch_altcode, Status - $fetch_status, Description - $fetch_description";
               
                // Log the audit
                logAudit($action_by, $action, $description);

                // Redirect to the branch box page after successful deletion
                header("Location: box.php?id=" . $branch_id);
                exit;
            } else {
                echo "Error deleting box: " . $conn->error;
            }
        } else {
            // If the user is not an admin, show an alert
            echo "<script>alert('Only admins can delete a box.'); window.location.href='box.php?id=" . $branch_id . "';</script>";
        }
    } else {
        echo "Error: No branch found for this box.";
    }
} else {
    echo "No box ID provided.";
}
?>
