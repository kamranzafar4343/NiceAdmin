<?php
if (isset($_POST['submit'])) {
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


    // Static fields
    $creator = mysqli_real_escape_string($conn, $_POST['creator']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);

    // Dynamic fields: Process each array and convert to comma-separated string
    $object_code = isset($_POST['object_code']) ? implode(',', array_map(function($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['object_code'])) : '';

    $barcode_select = isset($_POST['barcode_select']) ? implode(',', array_map(function($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['barcode_select'])) : '';

    $alt_code = isset($_POST['alt_code']) ? implode(',', array_map(function($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['alt_code'])) : '';

    $requestor = isset($_POST['requestor']) ? implode(',', array_map(function($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['requestor'])) : '';

    $designation = isset($_POST['designation']) ? implode(',', array_map(function($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['designation'])) : '';

    $req_date = isset($_POST['req_date']) ? implode(',', array_map(function($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['req_date'])) : '';

    $description = isset($_POST['description']) ? implode(',', array_map(function($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['description'])) : '';

    // SQL Insert statement
    $sql = "INSERT INTO orders2 (creator, company, object_code, barcode, alt_code, requestor, designation, req_date, description) 
            VALUES ('$creator', '$company', '$object_code', '$barcode_select', '$alt_code', '$requestor', '$designation', '$req_date', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "Data successfully inserted.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form Example</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<h2>Add Order Details</h2>
<form action="" method="post">
    <!-- Static fields -->
    <label for="creator">Creator:</label>
    <input type="text" id="creator" name="creator" required><br>

    <label for="company">Company:</label>
    <input type="text" id="company" name="company" required><br>

    <!-- Dynamic fields container -->
    <div id="dynamic_field2">
        <!-- Default Row for dynamic fields -->
        <div class="form-row mb-2" id="row2_">
            <input type="text" class="form-control" name="object_code[]" placeholder="Object Code" required>
            <input type="text" class="form-control" name="barcode_select[]" placeholder="Barcode" required>
            <input type="text" class="form-control" name="alt_code[]" placeholder="Alt Code" required>
            <input type="text" class="form-control" name="requestor[]" placeholder="Requestor" required>
            <input type="text" class="form-control" name="designation[]" placeholder="Role" required>
            <input type="datetime-local" class="form-control" name="req_date[]" placeholder="Request Date" required>
            <input type="text" class="form-control" name="description[]" placeholder="Description" required>
            <button type="button" class="btn btn-danger btn_remove2" id="1">-</button>
        </div>
    </div>
    
    <!-- Button to add more rows -->
    <button type="button" name="add" id="add2" class="btn btn-success">+</button>

    <!-- Submit button -->
    <button type="submit" name="submit">Submit</button>
</form>

<script>
$(document).ready(function() {
    var i = 1;

    // Add new row in dynamic fields
    $('#add2').click(function() {
        i++;
        $('#dynamic_field2').append('<div class="form-row mb-2" id="row2_' + i + '"> \
            <input type="text" class="form-control" name="object_code[]" placeholder="Object Code" required> \
            <input type="text" class="form-control" name="barcode_select[]" placeholder="Barcode" required> \
            <input type="text" class="form-control" name="alt_code[]" placeholder="Alt Code" required> \
            <input type="text" class="form-control" name="requestor[]" placeholder="Requestor" required> \
            <input type="text" class="form-control" name="designation[]" placeholder="Role" required> \
            <input type="datetime-local" class="form-control" name="req_date[]" placeholder="Request Date" required> \
            <input type="text" class="form-control" name="description[]" placeholder="Description" required> \
            <button type="button" class="btn btn-danger btn_remove2" id="' + i + '">-</button> \
        </div>');
    });

    // Remove row in dynamic fields
    $(document).on('click', '.btn_remove2', function() {
        var button_id = $(this).attr("id");
        $('#row2_' + button_id).remove();
    });
});
</script>

</body>
</html>
