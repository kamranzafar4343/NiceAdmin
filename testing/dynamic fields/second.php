<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "catmarketing_old"; // Replace with your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Get the ID from the form
    $box_items = $_POST['box_item'];
    $quantities = $_POST['quantity'];

    // Iterate over the dynamic fields and insert data into the database
    for ($i = 0; $i < count($box_items); $i++) {
        $box_item = $box_items[$i];
        $quantity = $quantities[$i];

        // Simple SQL query to insert data
        $sql = "INSERT INTO testing_dyn_fields (id, box_item, quantity) 
                VALUES ('$id', '$box_item', '$quantity')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo "Data inserted successfully for box item: $box_item with quantity: $quantity<br>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Close connection
mysqli_close($conn);
?>
