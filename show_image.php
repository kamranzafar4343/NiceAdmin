<?php
include "config/db.php";

$id = intval($_GET['id']); // Image ID from URL parameter
$sql = "SELECT type, data FROM images WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header("Content-Type: " . $row['type']);
    echo $row['data'];
} else {
    echo "Image not found.";
}

$conn->close();
?>
