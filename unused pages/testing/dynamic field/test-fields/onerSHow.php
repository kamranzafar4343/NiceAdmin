<?php

    // Database connection
    error_reporting(E_ALL);
ini_set('display_errors', 1);

//using env. var's
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'catmarketing2';


$conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if (!$conn) {
    echo "error during database connection";
}

// Fetch data from the orders table
$sql = "SELECT * FROM orders2";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Orders</title>
</head>
<body>

<h2>Orders Table</h2>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Creator</th>
        <th>Company</th>
        <th>Object Code</th>
        <th>Barcode</th>
        <th>Alt Code</th>
        <th>Requestor</th>
        <th>Designation</th>
        <th>Request Date</th>
        <th>Description</th>
        <th>Created At</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert comma-separated strings to arrays
            $object_codes = explode(',', $row['object_code']);
            $barcodes = explode(',', $row['barcode']);
            $alt_codes = explode(',', $row['alt_code']);
            $requestors = explode(',', $row['requestor']);
            $designations = explode(',', $row['designation']);
            $req_dates = explode(',', $row['req_date']);
            $descriptions = explode(',', $row['description']);

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['creator']) . "</td>";
            echo "<td>" . htmlspecialchars($row['company']) . "</td>";

            // Display each array as a list
            echo "<td><ul>";
            foreach ($object_codes as $code) {
                echo "<li>" . htmlspecialchars(trim($code)) . "</li>";
            }
            echo "</ul></td>";

            echo "<td><ul>";
            foreach ($barcodes as $barcode) {
                echo "<li>" . htmlspecialchars(trim($barcode)) . "</li>";
            }
            echo "</ul></td>";

            echo "<td><ul>";
            foreach ($alt_codes as $alt) {
                echo "<li>" . htmlspecialchars(trim($alt)) . "</li>";
            }
            echo "</ul></td>";

            echo "<td><ul>";
            foreach ($requestors as $requestor) {
                echo "<li>" . htmlspecialchars(trim($requestor)) . "</li>";
            }
            echo "</ul></td>";

            echo "<td><ul>";
            foreach ($designations as $designation) {
                echo "<li>" . htmlspecialchars(trim($designation)) . "</li>";
            }
            echo "</ul></td>";

            echo "<td><ul>";
            foreach ($req_dates as $date) {
                echo "<li>" . htmlspecialchars(trim($date)) . "</li>";
            }
            echo "</ul></td>";

            echo "<td><ul>";
            foreach ($descriptions as $description) {
                echo "<li>" . htmlspecialchars(trim($description)) . "</li>";
            }
            echo "</ul></td>";

            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No data found</td></tr>";
    }

    // Close the connection
    $conn->close();
    ?>
</table>

</body>
</html>
