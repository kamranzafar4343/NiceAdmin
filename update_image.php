<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_id = $_POST['company_id'];

    // Check if a file has been uploaded
    if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] == 0) {
        $file_name = $_FILES['newImage']['name'];
        $file_tmp = $_FILES['newImage']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Define the allowed extensions
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Check if the file extension is allowed
        if (in_array($file_ext, $allowed_extensions)) {
            // Define the upload directory
            $upload_dir = 'path/to/images/';
            $new_file_name = 'company_' . $company_id . '.' . $file_ext;
            $upload_path = $upload_dir . $new_file_name;

            // Move the uploaded file to the desired location
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Update the database with the new image path
                $sql = "UPDATE compani SET company_image = '$new_file_name' WHERE comp_id = $company_id";
                
                if ($conn->query($sql) === TRUE) {
                    echo "Image updated successfully!";
                } else {
                    echo "Error updating image: " . $conn->error;
                }
            } else {
                echo "Failed to upload the image.";
            }
        } else {
            echo "Invalid file extension. Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        echo "No image file selected or an error occurred during the upload.";
    }
}
?>
