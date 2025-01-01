<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

include 'config/db.php';

$email = $_SESSION['email'];

// Get user name and email from the register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
}

$error = false;

if (isset($_POST['submit'])) {
    // Sanitize user inputs
    $creator = mysqli_real_escape_string($conn, $_POST['creater']);
    $comp = mysqli_real_escape_string($conn, $_POST['company']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $dept = mysqli_real_escape_string($conn, $_POST['dept']);
    $priority = mysqli_real_escape_string($conn, $_POST['purirty']);  // Fixed typo
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $foc = mysqli_real_escape_string($conn, $_POST['foc']);
    $foc_phone = mysqli_real_escape_string($conn, $_POST['foc_phone']);
    $pickup_address = mysqli_real_escape_string($conn, $_POST['pickup_address']);
    $requestor_name = mysqli_real_escape_string($conn, $_POST['requestor_name']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $request_date = mysqli_real_escape_string($conn, $_POST['req_date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Handle multiple selected values for "items"
    $boxBarcodes = $_POST['barcode'];

    // also handles empty values
    if (empty($boxBarcodes)) {
        $boxBarcodesString = ''; // Set to empty string if the array is empty
    } else {
        $boxBarcodesString = implode(", ", array_map(function ($value) use ($conn) {
            return mysqli_real_escape_string($conn, $value); // Sanitize each value
        }, $boxBarcodes)); // Convert to a comma-separated string
    }

    // Check if any barcode already exists in the database
    $existingBarcodes = [];
    foreach ($boxBarcodes as $barcode) {
        $query = "SELECT COUNT(*) FROM orders WHERE barcode = '$barcode'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        
        if ($row[0] > 0) {
            // If barcode exists, add to existingBarcodes array
            $existingBarcodes[] = $barcode;
        }
    }

    if (count($existingBarcodes) > 0) {
        // If there are any existing barcodes, show an error message
        $errorMessage = "Cannot create workorder of box which is already Out: " . implode(", ", $existingBarcodes);
        echo $errorMessage;
        exit();
    } else {
        // If no barcodes exist, proceed with the insert
        $sql = "INSERT INTO orders(creator, flag, comp_id_fk, branch_id_fk, dept_id_fk, status, priority, date, foc, foc_phone, pickup_address, barcode, requestor, role, req_date, description) 
                VALUES ('$creator', 'Delivery', '$comp', '$branch', '$dept', 'Pending', '$priority', '$date', '$foc', '$foc_phone', '$pickup_address', '$boxBarcodesString', '$requestor_name', '$role', '$request_date', '$description')";
        
        if ($conn->query($sql) === TRUE) {
            
            //if query is successful, out the boxes(set status = out of the selected boxes against this workorder)
            $sql2 = "UPDATE box SET status = 'Out' WHERE barcode IN ('$boxBarcodesString')";
           
            if ($conn->query($sql2) === TRUE) {
                // Redirect to the order page
                header("Location: order.php");
                exit();
            } else {
                echo "Error: " . $sql2 . "<br>" . $conn->error;
                exit();
            }
           } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit();
        }
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link href="assets/img/dtl.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!--bootstrap search and select-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
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

    <script src="https://code.jquery.com/jquery/3.7.1/jquery.min.js"></script>

    <!-- dselect -->
    <link rel="stylesheet" href="assets/css/dselect.css">
    <script src="assets/js/dselect.js"></script>

    <style>
        /* form text sizing */
        .form-select {
            font-size: 0.8rem;
        }

        .form-control {
            font-size: 0.8rem;
        }


        /* Custom CSS to decrease font size of the table */
        .custom {
            font-size: 0.9rem;
            /* Adjust as needed */
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

        .headerimg {
            margin-top: 100px;
            margin-left: 260px;
        }

        .custom-header {
            background-color: white;
            /* Light gray background */
            color: #343a40;
            /* Dark text color */
            font-weight: bold;
            /* Bold text */
            text-align: center;
            /* Center align text */
            padding: 14px;
            /* Bottom border */
            margin-left: 19px;
        }


        /*styles for form*/
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

        /* Define the pulse animation */
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

        /* Define the click animation */
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
            /* Change color on hover */
            animation: pulse 10s ease-in-out;
            /* Apply the pulse animation on hover */
        }

        .company-name:active {
            animation: clickEffect 0.s ease;
            /* Apply the click effect animation on click */
            color: #0056b3;
            /* Darken color on click */
        }

        * {
            margin: 0;

            padding: 0;

            box-sizing: border-box;
        }

        .custom-card {
            width: 100%;
            margin-top: 64px;
            margin-left: 290px;
            box-shadow: none;

            border: none;
        }

        .error {
            color: #FF0000;
        }
    </style>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <title>Create workOrder</title>


</head>

<body> <!-- ======= Header ======= -->
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


    <!-- sidebar start -->
    <?php
    include "sidebarcode.php";
    ?>
    <!-- sidebar end -->

    <!--form--------------------------------------form--------------------------------------->
    <!-- Start Header form -->
    <div class="headerimg text-center">
        <img src="image/create.png" alt="network-logo" width="50" height="50">
        <h2>Create a Workorder</h2>
    </div>
    <!-- End Header form -->

    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3">
            <div class="card-body mt-3">
                <form class="row g-3 needs-validation" id="orderForm" action="" method="POST">

                    <hr style="color: white;">

                    <!-- Select Company -->
                    <div class="col-md-4">
                        <label for="company">Company:</label>
                        <select id="company" class="form-select" name="company" required>
                            <option value="">Select Company</option>
                            <?php
                            // Fetch the account levels from the database
                            $result = $conn->query("SELECT comp_id, comp_name FROM compani");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['comp_id']}'>{$row['comp_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <div class="col-md-4">
                        <label for="branch">Branch:</label>
                        <select id="branch" class="form-select" name="branch" required>
                            <option value="">Select branch</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="dept">Department:</label>
                        <select id="dept" class="form-select" name="dept">
                            <option value="">Select Department</option>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label for="purirty" class="form-label">Service Priority</label>
                        <select class="form-select" id="purirty" name="purirty" required>
                            <option value="">Select Service Priority</option>
                            <option value="Urgent">Urgent - Rush Same Day</option>
                            <option value="Regular">Regular - Next Working Day</option>
                        </select>
                    </div>

                    <!-- Required BY -->
                    <div class="col-md-3">
                        <label class="form-label">Required By</label>
                        <input type="datetime-local" class="form-control" name="date" id="dateField" required>
                    </div>

                    <!-- hidden field -->
                    <div class="col-md-2">
                        <input type="text" style="visibility: hidden;" class="form-control" id="creater" name="creater" value="<?php echo ($_SESSION['role'] == 'admin') ? 'admin' : 'user'; ?>" readonly>
                    </div>

                    <hr style="color: white;">

                    <div class="col-md-4">
                        <label for="">Contact Person:</label>
                        <select id="emp" class="form-select" name="foc">
                            <option value="">Select contact person</option>
                        </select>
                    </div>

                    <!-- For the FOC phone -->
                    <div class="col-md-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="foc_phone" name="foc_phone" value="">
                    </div>

                    <!-- for the Pickup and delivery Addrss -->
                    <div class="col-md-5">
                        <label for="pickup_address" class="form-label">Pickup/Delivery Address </label>
                        <input type="text" class="form-control" id="pickup_address" name="pickup_address" required>
                    </div>

                    <h2 style="color: #0056b3; margin-top: 45px;">Add Container/Filefolder</h2>

                    <!-- Select barcode -->
                    <div class="col-md-4">
                        <label for="barcodes">Select Container/Filefolder:</label>
                        <select id="barcode" class="form-select" name="barcode[]" multiple>
                            <option value="">Select 1 or more boxes</option>
                            <!-- dynamically populate with ajax -->
                        </select>
                    </div>

                    <!-- Select Requestor -->
                    <div class="col-md-4">
                        <label for="">Requestor:</label>
                        <select id="requestor" class="form-select" name="requestor_name">
                            <option value="">Select Requestor</option>
                        </select>
                    </div>

                    <!--  Comments -->
                    <div class="col-md-4">
                        <label for="designation" class="form-label">Contact Person Role</label>
                        <input type="text" class="form-control" id="designation" name="role" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Request date</label>
                        <input type="datetime-local" id="req_date" class="form-control" name="req_date" required>
                    </div>
                    <!--  Comments -->
                    <div class="col-md-5">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>

                    <div class="text-center mt-4 mb-2 ml-2">
                        <div class="text-center mt-4 mb-2">
                            <button type="submit" class="btn btn-outline-primary mr-1" name="submit" value="submit">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>

                    </div>
            </div>
            </form>
        </div>
    </div>


    <!-- Include Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js">
    </script>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7/z1gk35k1RA6QQg+SjaK6MjpS3TdeL1h1jDdED5+ZIIbsSdyX/twQvKZq5uY15B" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9BfDxO4v5a9J9TZz1ck8vTAvO8ue+zjqBd5l3eUe8n5EM14ZlXyI4nN" crossorigin="anonymous"></script>
    <!-- Template Main JS File -->
    <!-- Updated JavaScript with proper lev2Select selection -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        window.onload = function() {
            //user can't select the date before current date in required by field
            const dateField = document.getElementById('dateField');
            const req_date = document.getElementById('req_date');

            const now = new Date();
            var year = now.getFullYear();
            var month = ('0' + (now.getMonth() + 1)).slice(-2); // Months are zero indexed
            var day = ('0' + now.getDate()).slice(-2);
            var hour = ('0' + now.getHours()).slice(-2);
            var minute = ('0' + now.getMinutes()).slice(-2);

            // Format the date and time in the format yyyy-MM-ddTHH:mm
            const formattedDateTime = now.toISOString().slice(0, 16);
            const formattedDateTime2 = now.toISOString().slice(0, 16);


            dateField.min = formattedDateTime;

            req_date.min = formattedDateTime2;

            // Set the default value of required by field to current date and time
            var dateTime = year + '-' + month + '-' + day + 'T' + hour + ':' + minute;
            document.getElementById('req_date').value = dateTime;
        };
    </script>

    <script>
        $(document).ready(function() {

            const config = {
                search: true, // Enable search feature
                creatable: false, // Disable creatable selection
                clearable: false, // Disable clearable selection
                maxHeight: '360px', // Max height for showings scrollbar
                size: 'md', // Size of the select, can be 'sm' or 'lg'
            };

            // Initialize dselect for the initial dropdowns
            dselect(document.querySelector('#company'), config);
            dselect(document.querySelector('#branch'), config);
            dselect(document.querySelector('#dept'), config);
            dselect(document.querySelector('#emp'), config);
            dselect(document.querySelector('#requestor'), config);
            dselect(document.querySelector('#barcode'), config);

            // When company is changed, fetch the branches
            $('#company').change(function() {
                var company_id = $(this).val();

                // AJAX request to get branches for the selected company
                $.ajax({
                    url: 'get_branches.php',
                    type: 'POST',
                    data: {
                        company_id: company_id
                    },
                    success: function(response) {
                        try {
                            var branches = JSON.parse(response); //return the json response as an array
                            // Clear existing branches
                            $('#branch').empty();
                            $('#branch').append('<option value="">Select branches</option>');
                            // Add the new options from the response
                            $.each(branches, function(index, branch) {
                                $('#branch').append('<option value="' + branch.branch_id + '">' + branch.branch_name + '</option>');
                            });
                            // Refresh or reinitialize dselect
                            dselect(document.querySelector('#branch'), config);
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            });

            // When branch is changed, fetch the departments
            $('#branch').change(function() {
                var branch_id = $(this).val();

                // AJAX request to get dept's for the selected branch
                $.ajax({
                    url: 'get_departments.php',
                    type: 'POST',
                    data: {
                        branch_id: branch_id
                    },
                    success: function(response) {
                        try {
                            var departments = JSON.parse(response); //return the json response as an array
                            // Clear existing dept's
                            $('#dept').empty();
                            $('#dept').append('<option value="">Select department</option>');

                            // Add the new options from the response
                            $.each(departments, function(index, department) {
                                $('#dept').append('<option value="' + department.dept_id + '">' + department.dept_name + '</option>');
                            });
                            // Refresh or reinitialize dselect
                            dselect(document.querySelector('#dept'), config);
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            });

            // When branch is changed, fetch the employees
            $('#branch').change(function() {
                var branch_id = $(this).val();

                console.log(branch_id);

                // AJAX request to get emp's for the selected branch
                $.ajax({
                    url: 'get_employees.php',
                    type: 'POST',
                    data: {
                        branch_id: branch_id
                    },
                    success: function(response) {
                        try {
                            var employees = JSON.parse(response); //return the json response as an array
                            // Clear existing employees
                            $('#emp').empty();
                            $('#emp').append('<option value="">Select contact person</option>');

                            // Add the new options from the response
                            $.each(employees, function(index, employe) {
                                $('#emp').append('<option value="' + employe.emp_id + '">' + employe.name + '</option>');
                            });
                            // Refresh or reinitialize dselect
                            dselect(document.querySelector('#emp'), config);
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            });

            // When branch is changed, fetch the employees
            $('#branch').change(function() {
                var branch_id = $(this).val();

                console.log(branch_id);

                // AJAX request to get requestor's for the selected branch
                $.ajax({
                    url: 'get_employees.php',
                    type: 'POST',
                    data: {
                        branch_id: branch_id
                    },
                    success: function(response) {
                        try {
                            var employees = JSON.parse(response); //return the json response as an array
                            // Clear existing employees
                            $('#requestor').empty();
                            $('#requestor').append('<option value="">Select requestor</option>');

                            // Add the new options from the response
                            $.each(employees, function(index, employe) {
                                $('#requestor').append('<option value="' + employe.emp_id + '">' + employe.name + '</option>');
                            });
                            // Refresh or reinitialize dselect
                            dselect(document.querySelector('#requestor'), config);
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            });

            // When branch is changed, fetch the barcodes
            $('#branch').change(function() {
                var branch_id = $(this).val();
                // console.log(branch_id);

                // AJAX request to get barcodes for the selected branch
                $.ajax({
                    url: 'getBarcodes.php',
                    type: 'POST',
                    data: {
                        branch_id: branch_id
                    },
                    success: function(response) {
                        try {
                            var boxes = JSON.parse(response); //return the json response as an array
                            // Clear existing dept's
                            $('#barcode').empty();
                            $('#barcode').append('<option value="">Select box</option>');

                            // Add the new options from the response
                            $.each(boxes, function(index, box) {
                                $('#barcode').append('<option value="' + box.barcode + '">' + box.barcode + '</option>');
                            });
                            // Refresh or reinitialize dselect
                            dselect(document.querySelector('#barcode'), config);
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            });

            //show the phone no of employee on selection
            $('#emp').change(function() {
                var emp_id = $(this).val();
                if (emp_id) {
                    $.ajax({
                        url: 'getEmpDetail.php', // API endpoint where you get employee details
                        type: 'GET',
                        data: {
                            emp_id: emp_id
                        },
                        success: function(response) {
                            var response = JSON.parse(response); //return the json response as an array

                            // Assuming response is a JSON object containing phone
                            document.getElementById('foc_phone').value = response.phone;
                            console.log(response.phone);
                        },
                        error: function() {
                            alert('Error fetching employee details');
                        }
                    });
                } else {
                    document.getElementById('foc_phone').value = '';
                }
            });

            //show the address of employee on selection
            $('#emp').change(function() {
                var emp_id = $(this).val();
                if (emp_id) {
                    $.ajax({
                        url: 'getEmpAdd.php', // API endpoint where you get employee details
                        type: 'GET',
                        data: {
                            emp_id: emp_id
                        },
                        success: function(response) {
                            var response = JSON.parse(response); //return the json response as an array

                            // Assuming response is a JSON object containing phone
                            document.getElementById('pickup_address').value = response.address;
                            console.log(response.address);
                        },
                        error: function() {
                            alert('Error fetching employee details');
                        }
                    });
                } else {
                    document.getElementById('pickup_address').value = '';
                }
            });

            //show the role of employee on selection
            $('#emp').change(function() {
                var emp_id = $(this).val();
                if (emp_id) {
                    $.ajax({
                        url: 'getEmpDetail.php', // API endpoint where you get employee details
                        type: 'GET',
                        data: {
                            emp_id: emp_id
                        },
                        success: function(response) {
                            var response = JSON.parse(response); 

                            document.getElementById('designation').value = response.role;
                            console.log(response.role);
                        },
                        error: function() {
                            alert('Error fetching employee details');
                        }
                    });
                } else {
                    document.getElementById('designation').value = '';
                }
            });


        });
    </script>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!--datatable export buttons-->
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
</body>

</html>