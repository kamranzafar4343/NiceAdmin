<?php
// Include the database configuration file.
include "db.php";
// Retrieve the value of the "search" variable from "script.js".
if (isset($_POST['search'])) {
    // Assign the search box value to the $Name variable.
    $Name = $_POST['search'];
    // Define the search query.
    $Query = "SELECT Name FROM search WHERE Name LIKE '%$Name%' LIMIT 5";
    // Execute the query.
    $ExecQuery = MySQLi_query($conn, $Query);
    // Create an unordered list to display the results.
    echo '
<ul>
   ';
    // Fetch the results from the database.
    while ($Result = MySQLi_fetch_array($ExecQuery)) {
?>
        <!-- Create list items.
        Call the JavaScript function named "fill" found in "script.js".
        Pass the fetched result as a parameter. -->
        <li onclick='fill("<?php echo $Result['Name']; ?>")'>
            <a>
                <!-- Display the searched result in the search box of "search.php". -->
                <?php echo $Result['Name']; ?>
        </li></a>
        <!-- The following PHP code is only for closing parentheses. Do not be confused. -->
<?php
    }
}
?>
</ul>