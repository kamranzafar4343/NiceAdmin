<?php

// session_start(); // Start the session
session_start();


// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}
include 'config/db.php';

$email = $_SESSION['email'];

// Get session variables
$session_userId = $_SESSION['id']; // User ID
$session_user_role = $_SESSION['role']; // User role
$session_email = $_SESSION['email']; // User email

//get user name and email from register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
}

// show box previous data
if (isset($_GET['id'])) {

    $box_id = $_GET['id'];
    $sql = "SELECT * FROM `box` WHERE `box_id`= '$box_id'";

    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $barcode = $row['barcode'];
    $description = $row['box_desc'];
    $fetch_altcode = $row['alt_code'];
    $fetch_status = $row['status'];
    $fetch_object_code = $row['object'];
    $fetch_location = $row['location'];
}

// Audit log function
function logAudit($action_by, $action, $description)
{
    global $conn;

    // Escape and sanitize inputs
    $action_by = mysqli_real_escape_string($conn, $action_by);
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);

    $query = "
        INSERT INTO audit_log (user_info, action, description)
        VALUES ('$action_by', '$action', '$description')
    ";

    // Execute the query
    if (!mysqli_query($conn, $query)) {
        error_log("Failed to log audit: " . mysqli_error($conn));
    }
}

//update the record
if (isset($_POST['update'])) {
    $barcode =  mysqli_real_escape_string($conn, $_POST['barcode_select']);
    $box_desc =  mysqli_real_escape_string($conn, $_POST['description']);
    $status =  mysqli_real_escape_string($conn, $_POST['status']);
    $alt_code =  mysqli_real_escape_string($conn, $_POST['alt_code']);
    $obj_code =  mysqli_real_escape_string($conn, $_POST['object']);
    $storedLocation =  mysqli_real_escape_string($conn, $_POST['location']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    //only checks when location is changed otherwise it will not check
    if ($location !== $fetch_location) {

    // Check if the selected rack already contains 9 boxes (max limit for each rack)
    $rack_limit_check_sql = "SELECT COUNT(*) as total_boxes FROM box WHERE location = '$location'";
    $rack_limit_check_result = $conn->query($rack_limit_check_sql);
    $rack_data = $rack_limit_check_result->fetch_assoc();

    if ($rack_data['total_boxes'] >= 9) {
        // Rack already contains 9 boxes, show error
        echo "<script>alert('The selected rack reached its maximum capacity(9 boxes)'); window.location.href = 'boxUpdate.php?id=$box_id';</script>";
        exit();
    }
    }

    $sql = "UPDATE `box` SET `object`='$obj_code', `barcode`='$barcode', `status`='$status', `alt_code`='$alt_code', `box_desc`='$box_desc', `location`='$storedLocation' WHERE `box_id`='$box_id'";

    if (mysqli_query($conn, $sql)) {

        // Prepare details for logging the audit
        $action_by = "Update by the user-id: $session_userId, user-role: $session_user_role, user-email: $session_email";
        $action = 'Update';
        $description = "Updated record: From(Box ID - $box_id, Object Code - $fetch_object_code, location - $storedLocation, Barcode - $barcode, Alt Code - $fetch_altcode, Status - $fetch_status, Description - $description) to (Box ID - $box_id, Object Code - $obj_code, Barcode - $barcode, Alt Code - $alt_code, Status - $status, Description - $box_desc)";

        // Log the audit
        logAudit($action_by, $action, $description);

        header("Location: box.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update box</title>

    <!-- Favicons -->
    <link href="assets/img/dtl.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <!-- Additional Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

 <!-- dselect -->
 <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        /* Custom CSS to decrease font size of the table */
        .img {
            border-radius: 30%;
        }

        .custom {
            font-size: 0.9rem;
            font-family: monospace;
        }

        .company-name {
            font-size: 1rem;
        }

        .company-title {
            font-size: 1.1rem;
        }

        .burger {
            left: -10px;
            top: -20px;
        }

        .custom-card2 {
            width: 100%;
            margin-left: 290px;
            box-shadow: none;
            border: none;
        }

        .card-body {
            padding: 0 20px 20px 20px;
            font-size: 0.8rem;
        }

        .form-control[type=file]:not(:disabled):not([readonly]) {
            cursor: pointer;
            font-size: 0.8rem;
        }

        input[type=date].form-control {
            appearance: none;
            font-size: 0.8rem;
        }

        @media (min-width: 1200px) {

            .h2,
            h2 {
                font-size: 1.5rem;
            }
        }

        .headerimg h2 {
            font-family: "Nunito", sans-serif;
            font-size: 1.5rem;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes clickEffect {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(0.9);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .company-name {
            color: #000;
            text-decoration: none;
            display: inline-block;
            transition: color 0.3s ease;
        }

        .company-name:hover {
            color: #007bff;
            animation: pulse 10s ease-in-out;
        }

        .company-name:active {
            animation: clickEffect 0.s ease;
            color: #0056b3;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .headerimg {
            margin-left: 290px;
        }

        .custom-card {
            width: 60%;
            margin-top: 50px;
            box-shadow: none;
            border: none;
        }
    </style>
</head>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <img class="navbar-image" src="assets/img/dtl.png" alt="">
        <a href="index.php" class="logo d-flex align-items-center">

            <span class="d-none d-lg-block"></span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!--
<div class="search-bar">
  <form class="search-form d-flex align-items-center" method="POST" action="#">
    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
  </form>
</div>
End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item profileimage dropdown pe-3 mr-4">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="image/admin-png.png" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $adminName ?></span>
                </a><!-- End Profile Image Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $adminName ?></h6>
                        <span><?php echo $adminEmail ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="logout.php">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>
            </li>

        </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<?php
include "config/db.php";
$role = $_SESSION['role'];
?>

<?php
include "sidebarcode.php";
?>

<div class="mt-3">

    <!-- empty space -->
    <br>
</div>
<!-- Start Header form -->
<div class="headerimg text-center mt-5">
    <img src="image/update.png.png" alt="network-logo" width="50" height="50" />
    <h2>Update Container/filefolder</h2>
</div>
<!-- End Header form -->

<section class="container d-flex justify-content-center my-4">
    <div class="card custom-card2  shadow-lg" style="border: none; box-shadow:none; border:none;">
        <div class="card-body">
            <!-- <h5 class="card-title">Update Company Information</h5> -->
            <form class="row g-3 mt-2" action="" method="POST" enctype="multipart/form-data">

                <!-- Object Code -->
                <div class="col-md-3">
                    <label for="object_code" class="form-label">Object</label>
                    <select class="form-select" id="object_code" name="object" required>
                        <option value="">Select object code</option>
                        <option value="Container" <?php echo $fetch_object_code == 'Container' ? 'selected' : ''; ?>>Conainer</option>
                        <option value="Filefolder" <?php echo $fetch_object_code == 'Filefolder' ? 'selected' : ''; ?>>Filefolder</option>
                    </select>
                </div>

                <!-- Select Barcode -->
                <div class="col-md-4">
                    <label for="barcode_select" class="form-label">Barcode</label>
                    <input type="text" class="form-control" id="barcode_select" maxlength="8" pattern="\d{7,8}" title="Enter a 7 or 8-digit number" value="<?php echo $barcode; ?>" name="barcode_select" required>
                </div>

                <!-- FOR the alternative code -->
                <div class="col-md-4">
                    <label for="alt_code" class="form-label">Alt Code</label>
                    <input type="text" class="form-control" id="alt_code" name="alt_code" maxlength="8" pattern="\d{7,8}" title="Enter a 7 or 8-digit number" value="<?php echo $fetch_altcode; ?>" placeholder="Enter Alt code">
                </div>
                <!-- change status -->

                <div class="col-md-3">
                    <label for="change_status" class="form-label">Status</label>
                    <select class="form-select" name="status" id="status" required>
                        <option value="">Select Status</option>
                        <option value="In" <?php echo $fetch_status == 'In' ? 'selected' : ''; ?>>In</option>
                        <option value="Out" <?php echo $fetch_status == 'Out' ? 'selected' : ''; ?>>Out</option>
                        <option value="Out" <?php echo $fetch_status == 'Perm Out' ? 'selected' : ''; ?>>Perm Out</option>
                        <option value="Destroyed" <?php echo $fetch_status == 'Destroyed' ? 'selected' : ''; ?>>Destroyed</option>
                    </select>
                </div>

                <!-- Location Code -->
                <div class="col-md-3">
                    <label for="location" class="form-label">Location</label>
                    <select class="form-select" name="location" id="location" required>

                        <option value="">Select Location</option>
                        <?php
                        // Loop through each record and generate dropdown options
                        $rackQuery = "SELECT rack_location FROM racks";
                        $rackResult = mysqli_query($conn, $rackQuery);
                        if ($rackResult->num_rows > 0) {
                            while ($rackRow = $rackResult->fetch_assoc()) {
                                $rack_code = $rackRow['rack_location'];
                                // Check if this option matches the stored value
                                $selected = ($rack_code === $fetch_location) ? 'selected' : '';
                                echo "<option value='$rack_code' $selected>$rack_code</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <hr style="color: white;">
                <!--  Description -->
                <div class="col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="summernotelib" name="description" rows="3"><?php echo htmlspecialchars($description); ?></textarea>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-outline-primary mt-3" name="update" value="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>


<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!--corrected jquery version-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<script>
    tinymce.init({
        selector: '#summernotelib', // Replace with your textarea ID
        menubar: false,
        width: 500,
        height: 200
    });
</script>

<script>
    const dataTable = new simpleDatatables.DataTable("#myTable2", {
        searchable: false,
        fixedHeight: true,
    })
</script>

<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js">
</script>
<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7/z1gk35k1RA6QQg+SjaK6MjpS3TdeL1h1jDdED5+ZIIbsSdyX/twQvKZq5uY15B" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9BfDxO4v5a9J9TZz1ck8vTAvO8ue+zjqBd5l3eUe8n5EM14ZlXyI4nN" crossorigin="anonymous"></script>


<script>
    $(document).ready(function() {
        //d-search dropdown
        const config = {
            search: true, // Enable search feature
            creatable: false, // Disable creatable selection
            clearable: false, // Disable clearable selection
            maxHeight: '400px', // Max height for showing scrollbar
            size: 'md', // Size of the select, can be 'sm' or 'lg'
        };

        // Initialize dselect for the initial dropdowns

        dselect(document.querySelector('#location'), config);
    });
</script>


</body>

</html>