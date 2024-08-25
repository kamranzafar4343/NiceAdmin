<?php
include "db.php";

if (isset($_POST['submit'])) {
    $comp_name = mysqli_real_escape_string($conn, $_POST['comp_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists in the database
    $emailCheckQuery = "SELECT * FROM `compani` WHERE `email` = '$email'";
    $emailCheckResult = $conn->query($emailCheckQuery);


    //---------------------------set image variable------------------------ and its validation
    if ($emailCheckResult->num_rows > 0) {
        die("Error: The email '$email' already exists.");
    }

    // Validate if the image is uploaded without errors
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die("File upload error: " . $_FILES['image']['error']);
    }

    // Check for maximum file size (5MB)
    $maxFileSize = 5 * 1024 * 1024; // 5 MB
    if ($_FILES['image']['size'] > $maxFileSize) {
        die("File size exceeds the 5 MB limit.");
    }

    // Check allowed MIME types
    $allowedTypes = ['image/jpeg', 'image/png'];
    $fileType = $_FILES['image']['type'];
    if (!in_array($fileType, $allowedTypes)) {
        die("Invalid file type. Only JPEG and PNG files are allowed.");
    }

    // Check allowed file extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        die("Invalid file extension. Only .jpg, .jpeg, and .png files are allowed.");
    }

    // Sanitize and set the file name and destination
    $img_name = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES['image']['name']));
    $img_des = "image" . $img_name;

    // Move the uploaded file to the destination directory
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $img_des)) {
        die("Failed to upload image.");
    }

    //------------------end---------------------------------- of image variable and its validation



    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $registration = mysqli_real_escape_string($conn, $_POST['registration']);
    $expiry = mysqli_real_escape_string($conn, $_POST['expiry']);

    // Insert the record into the database
    $sql = "INSERT INTO `compani` (`comp_name`, `phone`, `email`, `password`, `image`, `city`, `state`, `country`, `registration`, `expiry`) 
            VALUES ('$comp_name', '$phone', '$email', '$hashedPassword', '$img_des', '$city', '$state', '$country', '$registration', '$expiry')";

//redirect and show message
    if (mysqli_query($conn, $sql)) {

        header("location:Companies.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
</head>

<body>

</body>

</html>