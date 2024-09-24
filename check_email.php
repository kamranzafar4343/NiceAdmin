<?php
include 'config/db.php';

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if the email already exists in the database
    $emailCheckQuery = "SELECT * FROM `compani` WHERE `email` = '$email'";
    $result = $conn->query($emailCheckQuery);

    if ($result->num_rows > 0) { 
        echo 'exists';
    } else {
        echo 'not_exists';
    }
}
?>
