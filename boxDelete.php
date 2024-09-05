<?php
include "db.php";

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