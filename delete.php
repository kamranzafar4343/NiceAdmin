
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
    $comp_id = intval($_GET['id']); // Ensure ID is an int

    // Get the number of company for the specific box
    $queryCount = "SELECT COUNT(*) AS comp_count FROM branches WHERE comp_id_fk = '$comp_id'";
    $resultCount = mysqli_query($conn, $queryCount);
    $rowCount = mysqli_fetch_assoc($resultCount);
    $Count = $rowCount['comp_count'];

    //if record exists in branches table, then it cannot be deleted
    if ($Count > 0) {
        echo 'Error: Cannot delete a Company having branches';
    } else {
        // Prepare and execute the delete query
        $sql = "DELETE FROM `compani` WHERE `comp_id`='$comp_id'";

        if ($conn->query($sql) === TRUE) {
            header('Location: Companies.php');
            exit(); // Make sure no further code is executed after redirect
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
}
?>
