<?php

include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comp_id = $_POST['comp_id'];
    $target_dir = "image/";
    $uploadOk = 1;
    $new_image_path = "";

    if ($_FILES['image']['size'] > 0) {
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a real image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Upload file if everything is okay
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $new_image_path = $target_file;

                // Update the database with the new image path
                $sql = "UPDATE compani SET image='$new_image_path' WHERE comp_id=$comp_id";
                if ($conn->query($sql) === TRUE) {
                    echo $new_image_path; // Return the new image path for AJAX to update the preview
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

$conn->close();
?>
