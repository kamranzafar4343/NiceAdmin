<?php
// Database connection
include_once 'config/db.php';

if (isset($_GET['id'])) {
    $fileId = intval($_GET['id']);

    //get detail from the database
    $query = "SELECT * FROM assign_task WHERE order_no_fk = $fileId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $filePath = $row['proof'];

        if ($filePath && file_exists($filePath)) {
            // force the donload of the file
            header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
            header("Expires: 0");
            header("Cache-Control: must-revalidate");
            header("Pragma: public");
            header("Content-Length: " . filesize($filePath));
            readfile($filePath);
            exit;
        } else {
            echo "File does not exist.";
        }
    } else {
        echo "No record found for the given order number.";
    }
} else {
    echo "No order number provided.";
}

mysqli_close($conn);
?>
