<?php
include "db.php";

// Retrieve company ID from URL
$company_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate company ID
$companyQuery = "SELECT comp_id, comp_name FROM compani WHERE comp_id = $company_id";
$companyResult = $conn->query($companyQuery);

if ($companyResult->num_rows === 0) {
    die("Error: Company ID does not exist.");
}

if (isset($_POST['submit'])) {
    $contactPersonName = mysqli_real_escape_string($conn, $_POST['ContactPersonName']);
    $contactPersonPhone = mysqli_real_escape_string($conn, $_POST['ContactPersonPhone']);
    $contactPersonResignation = mysqli_real_escape_string($conn, $_POST['ContactPersonResignation']);
    $city = mysqli_real_escape_string($conn, $_POST['City']);
    $state = mysqli_real_escape_string($conn, $_POST['State']);
    $country = mysqli_real_escape_string($conn, $_POST['Country']);

    $sql = "INSERT INTO branch (compID_FK, ContactPersonName, ContactPersonPhone, ContactPersonResignation, City, State, Country) 
            VALUES ('$company_id', '$contactPersonName', '$contactPersonPhone', '$contactPersonResignation', '$city', '$state', '$country')";

    if ($conn->query($sql) === TRUE) {
        header("Location: table-data2.php?id=" . $company_id);
        exit; // Ensure script ends after redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Add Branch</title>
</head>
<body>
    <section class="container my-2 w-50 p-2">
        <form class="row g-3 p-3" action="#" method="POST">
            <h3>Add Branch</h3>

            <!-- Company ID input (readonly) -->
            <div class="col-md-6">
                <label class="form-label">Company ID</label>
                <input type="text" class="form-control" name="compID_FK" value="<?php echo htmlspecialchars($company_id); ?>" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label">Contact Person Name</label>
                <input type="text" class="form-control" name="ContactPersonName" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Person Phone</label>
                <input type="text" class="form-control" name="ContactPersonPhone" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Person Resignation</label>
                <input type="text" class="form-control" name="ContactPersonResignation" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="City" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">State</label>
                <input type="text" class="form-control" name="State" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" name="Country" required>
            </div>

            <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
            </div>
        </form>
    </section>
</body>
</html>
