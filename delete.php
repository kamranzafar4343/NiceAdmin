
<?php
// session_start(); // Start the session
session_start();

session_regenerate_id(true); // This will regenerate the session ID and delete the old one
ini_set('session.cookie_secure', '1'); // Only send cookies over HTTPS
ini_set('session.cookie_httponly', '1'); // Prevent access to cookies via JavaScript (mitigates XSS)
ini_set('session.cookie_samesite', 'Strict'); // Prevent CSRF attacks by restricting cross-site cookie sharing


// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

include "db.php";


if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Ensure ID is an int

    // Prepare and execute the delete query
   echo $sql = "DELETE FROM `compani` WHERE `comp_id`='$user_id'";
    
    if ($conn->query($sql) === TRUE) {
        
        header('Location: Companies.php');
        exit(); // Make sure no further code is executed after redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
