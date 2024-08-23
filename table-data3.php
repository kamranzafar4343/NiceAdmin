<?php
include 'db.php';

$company_data2 = null;
$result = [];

// Get company ID from query string
$company_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch branches of the company
$sql = "SELECT * FROM branch WHERE compID_FK = $company_id";
$result = $conn->query($sql);
$result->fetch_assoc();

// Display branches
if ($result->num_rows > 0) {
    echo "<h2>Branches for Company ID: " . htmlspecialchars($company_id) . "</h2>";
    echo "<table>
            <tr>
                <th>Branch ID</th>
                <th>Representative</th>
                <th>Phone</th>
                <th>City</th>
                <th>State</th>
                <th>Country</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["branch_id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ContactPersonName"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ContactPersonPhone"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ContactPersonResignation"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["City"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Country"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No branches found for this company.</p>";
}
?>
