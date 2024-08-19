<?php
include "db.php";

// Fetch all company IDs from the `compani` table
$companyQuery = "SELECT comp_id, comp_name FROM compani";
$companyResult = $conn->query($companyQuery);

if (isset($_POST['submit'])) {
    $comId = $_POST['compID_FK'];
    $contactPersonName = mysqli_real_escape_string($conn, $_POST['ContactPersonName']);
    $contactPersonPhone = mysqli_real_escape_string($conn, $_POST['ContactPersonPhone']);
    $contactPersonResignation = mysqli_real_escape_string($conn, $_POST['ContactPersonResignation']); // corrected name
    $city = mysqli_real_escape_string($conn, $_POST['City']);
    $state = mysqli_real_escape_string($conn, $_POST['State']);
    $country = mysqli_real_escape_string($conn, $_POST['Country']);
    $compID_FK = mysqli_real_escape_string($conn, $_POST['compID_FK']); // assuming this is passed from the form


    $sql = "INSERT INTO branch (compID_FK, ContactPersonName, ContactPersonPhone, ContactPersonResignation, City, State, Country) 
       VALUES ('$comId', '$contactPersonName', '$contactPersonPhone', '$contactPersonResignation', '$city', '$state', '$country')";

    //   echo $sql= "SELECT * FROM branch WHERE compID_FK = '$comId'";


    if ($conn->query($sql) === TRUE) {
        echo "New branch added successfully.";
        header("Location: table-data2.php");
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
    <title>Add branch</title>
</head>

<body>
    <!-- <div class="container-fluid bg-dark text-light py-1">
       <header class="text-center">
           <h1 class="display-6">Create Company</h1>
       </header> -->

    <!-- </div> -->
    <section class="container my-2 w-50 p-2">
        <form class="row g-3 p-3" action="#" method="POST">
            <h3>Add Branch</h3>

            <div class="col-md-6">
                <label class="form-label">Select Company</label>
                <select class="form-select" name="compID_FK" required>
                    <option value="" disabled selected>Select Company ID</option>
                    <?php
                    // Populate dropdown with company IDs and names
                    if ($companyResult->num_rows > 0) {
                        while($row = $companyResult->fetch_assoc()) {
                            echo "<option value='".$row['comp_id']."'>".$row['comp_id']." - ".$row['comp_name']."</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No Companies Found</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Contact Person Name</label>
                <input type="text" class="form-control" name="ContactPersonName" required>
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Contact Person Phone</label>
                <input type="text" class="form-control" name="ContactPersonPhone" required>
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Contact Person resignation</label>
                <input type="text" class="form-control" name="ContactPersonResignation" required>
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">city</label>
                <input type="text" class="form-control" name="City" required>
            </div>

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">State</label>
                <input type="text" class="form-control" id="inputEmail4" name="State" required>
            </div>

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Country</label>
                <input type="text" class="form-control" id="inputEmail4" name="Country" required>
            </div>

            <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
            </div>
        </form>
    </section>
</body>

</html>