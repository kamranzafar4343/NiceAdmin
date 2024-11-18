To display the array values stored in the database as comma-separated strings (e.g., "value, value, value"), you need to fetch the data from the database, split the strings into arrays, and then display them in a table format.

Here is how you can do it:

### Step-by-Step Guide

1. **Fetch Data from the Database**: Use a `SELECT` query to retrieve the row from the `orders` table.
2. **Split the Comma-Separated Values**: Use `explode()` to convert the string into an array.
3. **Display the Values**: Loop through the arrays to display the values neatly.

### Explanation in Simple Words

1. **Connect to the Database**: The script connects to the database using `mysqli`.
2. **Retrieve Data**: It runs a `SELECT` query to get all the rows from the `orders` table.
3. **Loop Through Each Row**: For each row in the result, it:
   - **Splits Values**: Uses `explode(',', $row['column_name'])` to split the comma-separated string into an array.
   - **Displays Data**: Uses `implode(', ', $array)` to join array values into a string for displaying.
4. **Output as a Table**: It shows the data in an HTML table, making it easy to read.

### Example Output

If you have a row with:
- **object_code**: "code1, code2, code3"
- **barcode**: "123, 456, 789"

The output will be:
```
| Creator | Company | Object Code      | Barcode       | Alt Code | Requestor | Designation | Request Date | Description |
|---------|---------|-------------------|---------------|----------|-----------|-------------|--------------|-------------|
| John    | ABC Inc | code1, code2, code3 | 123, 456, 789 | ...      | ...       | ...         | ...          | ...         |
```

- **`explode()`**: Converts "code1, code2, code3" into an array: `["code1", "code2", "code3"]`.
- **`implode()`**: Converts the array back into a string for display.

This way, you can easily show each set of values in your table.


---------------------------------------------------------------------------------------------------------------

### 2- Summary of the Code (onerSHow.php)

The purpose of this code is to **fetch and display order details** stored in a database, where some fields contain **comma-separated values**. These values are split into individual items and displayed in a more readable list format within an HTML table.

### Explanation
1. **Fetch Data**: Retrieves all rows from the `orders` table using a database query.
2. **Split Values**: Uses `explode()` to turn comma-separated strings (e.g., "value1,value2") into arrays.
3. **Display Data**: Loops through these arrays and displays each item in a list (`<ul>`), making the data easy to read.

This way, the code makes complex, comma-separated database values visually clear and organized.