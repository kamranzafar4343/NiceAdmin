
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
    $dept_id = intval($_GET['id']); // Ensure branch ID is an integer

    // Fetch the company ID associated with the branch from the compID_FK column
    $sql = "SELECT `branch_id_fk` FROM `departments` WHERE `dept_id` = $dept_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $branch_id = $row['branch_id_fk'];

        //only delete departments which has no employees and no boxes or items associated with it
        //user can only del a company if it has no branches
    $queryCount = "SELECT COUNT(*) AS comp_count FROM branches WHERE comp_id_fk = '$comp_id'";
    $resultCount = mysqli_query($conn, $queryCount);
    $rowCount = mysqli_fetch_assoc($resultCount);
    $Count = $rowCount['comp_count'];

    //if record exists in branches table, then it cannot be deleted
    if ($Count > 0) {
        die('cannot delete department, which has records of employees or boxes or items');
    } 
        // Now, perform the delete operation
        $delete_sql = "DELETE FROM `departments` WHERE `dept_id` = $dept_id";
        if ($conn->query($delete_sql) === TRUE) {
            // Redirect to the company's branches page after successful deletion
            header("Location: departments.php?id=" . $branch_id);
            exit;
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error: No department found for this branch.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No branch ID provided.";
}
?>
