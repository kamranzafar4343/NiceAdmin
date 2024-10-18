<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form Fields</title>
    <style>
        .field-container {
            margin-bottom: 10px;
        }
        .remove-button {
            margin-left: 10px;
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form id="dynamicForm">
        <div id="fieldContainer"></div>
        <button type="button" id="addButton">Add Fields</button>
        <button type="submit">Submit</button>
    </form>

    <script src="dynamicFields.js"></script>
</body>
</html>