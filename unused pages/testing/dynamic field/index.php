<?php
// Include your database connection file
include_once("dbconnect.php");

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Iterate over each set of Material fields and insert them into the database
    foreach ($_POST['material'] as $key => $value) {
        $quantity = $_POST['material'][$key];
        $description = $_POST['description'][$key];
        $item_no = $_POST['item_no'][$key];

        // Insert data into the 'tb3' table (or your specified table)
        $query = "INSERT INTO tb3 (f1, f2, f3) VALUES ('$quantity', '$description', '$item_no')";
        mysqli_query($conn, $query);
    }
    echo "<div class='alert alert-success'>Form submitted successfully!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Material Entry Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Material Entry Form</h2>

    <!-- Material Form Section -->
    <form action="" method="post">
        <div id="dynamic_field2">
            <div class="form-row mb-2">
                <div class="col">
                    <input type="text" class="form-control" name="material[]" placeholder="Quantity" required>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="description[]" placeholder="Description" required>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="item_no[]" placeholder="Item Number" required>
                </div>
                <div class="col">
                    <button type="button" name="add" id="add2" class="btn btn-success">+</button>
                </div>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        var i = 1;

        // Add new row in Material section
        $('#add2').click(function () {
            i++;
            $('#dynamic_field2').append('<div class="form-row mb-2" id="row2' + i + '"> \
                <div class="col"><input type="text" class="form-control" name="material[]" placeholder="Quantity" required></div> \
                <div class="col"><input type="text" class="form-control" name="description[]" placeholder="Description" required></div> \
                <div class="col"><input type="text" class="form-control" name="item_no[]" placeholder="Item Number" required></div> \
                <div class="col"><button type="button" class="btn btn-danger btn_remove2" id="' + i + '">-</button></div> \
            </div>');
        });

        // Remove row in Material section
        $(document).on('click', '.btn_remove2', function () {
            var button_id = $(this).attr("id");
            $('#row2' + button_id).remove();
        });
    });
</script>

</body>
</html>
