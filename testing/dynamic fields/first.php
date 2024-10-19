<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Input Fields with PHP and Database</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h2>Dynamic Input Fields for Box Items and Quantities</h2>
    <form action="second.php" method="POST">
        <label for="id">Select ID:</label>
        <input type="text" name="id" required placeholder="Enter ID">

        <div id="dynamic-field-container">
            <div class="input-group">
                <input type="text" name="box_item[]" placeholder="Enter Box Item" required>
                <input type="number" name="quantity[]" placeholder="Enter Quantity" required>
                <button type="button" class="remove-field">Remove</button>
            </div>
        </div>

        <button type="button" id="add-field">Add More Fields</button>
        <input type="submit" value="Submit">
    </form>

    <script>
        $(document).ready(function() {
            // Function to add a new group of fields
            $('#add-field').click(function() {
                const fieldGroup = `
                <div class="input-group">
                    <input type="text" name="box_item[]" placeholder="Enter Box Item" required>
                    <input type="number" name="quantity[]" placeholder="Enter Quantity" required>
                    <button type="button" class="remove-field">Remove</button>
                </div>`;
                $('#dynamic-field-container').append(fieldGroup);
            });

            // Function to remove a group of fields
            $(document).on('click', '.remove-field', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>

</body>
</html>
