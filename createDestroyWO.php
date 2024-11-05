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

    $creator = mysqli_real_escape_string($conn, $_POST['creater']);
    $comp = mysqli_real_escape_string($conn, $_POST['company']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $dept = mysqli_real_escape_string($conn, $_POST['dept']);
    $priority = mysqli_real_escape_string($conn, $_POST['purirty']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $foc = mysqli_real_escape_string($conn, $_POST['foc']);
    $foc_phone = mysqli_real_escape_string($conn, $_POST['foc_phone']);
    $pickup_address = mysqli_real_escape_string($conn, $_POST['pickup_address']);


    // Array fields: Process each by joining values with commas
    //explanation: processes the object_code field, which is submitted as an array from the HTML form, and prepares it for insertion into a database
    $object_codes = isset($_POST['object_code']) ? implode(',', array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['object_code'])) : '';

    $barcodes = isset($_POST['barcode_select']) ? implode(',', array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['barcode_select'])) : '';

    $alt_codes = isset($_POST['alt_code']) ? implode(',', array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['alt_code'])) : '';

    $requestor_names = isset($_POST['requestor']) ? implode(',', array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['requestor'])) : '';

    $designation = isset($_POST['designation']) ? implode(',', array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['designation'])) : '';

    $request_dates = isset($_POST['req_date']) ? implode(',', array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['req_date'])) : '';

    $descriptions = isset($_POST['description']) ? implode(',', array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $_POST['description'])) : '';

    //check duplicate barcode entry in delivery table
    $check_duplicate_barcode = "SELECT barcode FROM orders WHERE barcode = '$barcodes' AND flag = 'Destroy'";
    $result_duplicate_barcode = mysqli_query($conn, $check_duplicate_barcode);

    //show error if finds duplicate barcode
    if ($result_duplicate_barcode && $result_duplicate_barcode->num_rows > 0) {
        die("workorder already created against that barcode");
    } else {
        $sql = "INSERT INTO orders ( creator, flag, comp_id_fk, branch_id_fk, dept_id_fk, priority,  date, foc, foc_phone, pickup_address, object_code, barcode, alt, requestor, role, req_date, description) 
     VALUES ( '$creator', 'Destroy', '$comp', '$branch', '$dept', '$priority', '$date', '$foc', '$foc_phone', '$pickup_address', '$object_codes', '$barcodes', '$alt_codes', '$requestor_names', '$designation', '$request_dates', '$descriptions')";
    }

    if ($conn->query($sql) === TRUE) {

        // Get the last inserted order_no from the orders table
        $last_id = $conn->insert_id;

        echo $sqlAudit = "INSERT INTO orders_audit (order_no, creator, flag, comp_id_fk, branch_id_fk, dept_id_fk, priority,  date, foc, foc_phone, pickup_address, object_code, barcode, alt, requestor, role, req_date, description) 
     VALUES ( '$last_id','$creator', 'Destroy', '$comp', '$branch', '$dept', '$priority', '$date', '$foc', '$foc_phone', '$pickup_address', '$object_codes', '$barcodes', '$alt_codes', '$requestor_names', '$designation', '$request_dates', '$descriptions')";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit();
    }

    if ($conn->query($sqlAudit) === TRUE) {
        header("Location: destroy.php");
        exit();
    } else {
        echo "Error: " . $sqlAudit . "<br>" . $conn->error;
        exit();
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
    <link href="assets/img/favicon.png" rel="icon">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <!--choosen-js css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <!--choosen js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

    <!-- dselect -->
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>

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
            <img class="navbar-image" src="assets/img/logo3.png" alt="">
            <a href="index.php" class="logo d-flex align-items-center">

                <span class="d-none d-lg-block">FingerLog</span>
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


    <!-- ======= Sidebar ======= -->
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <!-- Dashboard Link (Visible to all users) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="ri-home-8-line"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <?php if ($_SESSION['role'] == 'admin') { ?>
                <!-- Admin-only Links -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="Companies.php">
                        <i class="ri-building-4-line"></i><span>Accounts</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Companies Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="box.php">
                        <i class="ri-archive-stack-fill"></i><span>Containers</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Boxes Nav -->

                <li class="nav-item">
                    <a class="nav-link active" data-bs-target="#forms-nav" data-bs-toggle="" href="#">
                        <i class="ri-list-ordered"></i><span>Work Order</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="forms-nav" class="nav-content" data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="nav-link collapsed" href="order.php">
                                <i class="bi bi-circle"></i><span>delivery</span>
                            </a>
                            <a class="nav-link collapsed" href="pickup.php">
                                <i class="bi bi-circle"></i><span>pickup </span>
                            </a>
                            <a class="nav-link collapsed" href="permout.php">
                                <i class="bi bi-circle"></i><span>perm_out </span>
                            </a>
                            <a class="nav-link active" href="destroy.php">
                                <i class="bi bi-circle"></i><span>destroy </span>
                            </a>
                            <a class="nav-link collapsed" href="access.php">
                                <i class="bi bi-circle"></i><span>access </span>
                            </a>
                            <a class="nav-link collapsed" href="supplies.php">
                                <i class="bi bi-circle"></i><span>supplies </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="racks.php">
                        <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Racks Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="store.php">
                        <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Store Nav -->

            <?php } else { ?>
                <!-- User-only Links -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="box.php">
                        <i class="ri-archive-stack-fill"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Boxes Nav -->

                <li class="nav-item">
                    <a class="nav-link active" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                        <i class="ri-list-ordered"></i><span>Work Order</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="racks.php">
                        <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Racks Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="store.php">
                        <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Store Nav -->
            <?php } ?>


            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-login.php">
                    <i class="bi bi-box-arrow-right"></i><span>Login</span>
                </a>
            </li><!-- End Login Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="logout.php">
                    <i class="bi bi-box-arrow-left"></i><span>Logout</span>
                </a>
            </li><!-- End Logout Nav -->

        </ul>
    </aside>
    <!--------------- End sidebar ------------------>
    <!-- ---------------------------------------------------End Sidebar--------------------------------------------------->


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
                <form class="row g-3 needs-validation" action="" method="POST">

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

                    <!-- Select lev 2 of selected account -->
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
                        <input type="datetime-local" class="form-control" name="date" required>
                    </div>

                    <!-- hidden field -->
                    <div class="col-md-2">
                        <input type="text" style="visibility: hidden;" class="form-control" id="creater" name="creater" value="<?php echo ($_SESSION['role'] == 'admin') ? 'admin' : 'user'; ?>" readonly>
                    </div>

                    <hr style="color: white;">

                    <!-- For the FOC -->
                    <div class="col-md-3">
                        <label for="" class="form-label">Contact Person Name</label>
                        <input type="text" class="form-control" id="" name="foc" required pattern="[A-Za-z\s\.]+" required minlength="3" maxlength="38" title="only letters allowed; at least 3" required>
                    </div>
                    <!-- For the FOC phone -->
                    <div class="col-md-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="" name="foc_phone" required>
                    </div>
                    <!-- for the Pickup and delivery Addrss -->
                    <div class="col-md-5">
                        <label for="pickup_address" class="form-label">Pickup/Delivery Address </label>
                        <input type="text" class="form-control" id="" name="pickup_address" required>
                    </div>


                    <h2 style="color: #0056b3; margin-top: 45px;">Add Container/Filefolder</h2>
                    <div id="dynamic_field2">
                        <div class="form-row mb-2" id="row2">

                            <!-- Object Code -->
                            <div class="col-md-3">
                                <label for="object_code" class="form-label">Object Code</label>
                                <select class="form-select" id="object_code" name="object_code[]" onchange="updateBarcodeInput()" required>
                                    <option value="">Select object</option>
                                    <option value="Container">Container</option>
                                    <option value="FileFolder">FileFolder</option>
                                </select>
                            </div>
                            <!-- Select Barcode -->
                            <div class="col-md-4">
                                <label for="barcode_select">Enter Barcode:</label>
                                <input type="text" class="form-control" id="barcode_select" name="barcode_select[]" required>
                            </div>
                            <!-- FOR the alternative code -->
                            <div class="col-md-4">
                                <label for="alt_code" class="form-label">Alt Code</label>
                                <input type="text" class="form-control" id="alt_code" name="alt_code[]" required>
                            </div>

                            <!-- Select Requestor -->
                            <div class="col-md-4">
                                <label for="requestor" class="form-label">Requestor Name</label>
                                <input type="text" class="form-control" id="requestor" name="requestor[]" required>
                            </div>
                            <!--  Comments -->
                            <div class="col-md-4">
                                <label for="designation" class="form-label">Contact Person Role</label>
                                <input type="text" class="form-control" id="designation" name="designation[]" required>
                            </div>


                            <div class="col-md-3">
                                <label class="form-label">request date</label>
                                <input type="datetime-local" class="form-control" name="req_date[]" required>
                            </div>
                            <!--  Comments -->
                            <div class="col-md-5">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description[]" required>
                            </div>

                            <div class="text-center mt-4 mb-2 ml-2">
                                <button type="button" name="add" id="add2" class="btn btn-success">Add more</button>
                            </div>

                            <div>

                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4 mb-2">
                        <button type="submit" class="btn btn-outline-primary mr-1" name="submit" value="submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Function to update the barcode input field on selection of the object type-->
    <script>
        function updateBarcodeInput() {
            const object_type = document.getElementById('object_code');
            const barcode_input = document.getElementById('barcode_select');
            const alt_input = document.getElementById('alt_code');

            if (object_type.value === 'Container') {
                barcode_input.maxLength = 7;
                alt_input.maxLength = 7;
                barcode_input.placeholder = "Enter 7 digit Container Barcode";
                alt_input.placeholder = "Enter 7 digit Container alt code";
            } else {
                barcode_input.maxLength = 8;
                alt_input.maxLength = 8;
                barcode_input.placeholder = "Enter 8 digit Filefolder Barcode";
                alt_input.placeholder = "Enter 8 digit Filefolder alt code";
            }
            //clear input on type change
            barcode_input.value = "";
            alt_input.value = "";
        }
    </script>

    <script>
        $(document).ready(function() {
            var i = 1;

            // Add new row in container/filefolder
            $('#add2').click(function() {
                i++;
                $('#dynamic_field2').append('<div class="form-row mb-2" id="row2' + i + '"> \
            <div class="col-md-4"><input type="text" class="form-control" name="object_code[]" placeholder="object code" required></div> \
            <div class="col-md-4"><input type="text" class="form-control" name="barcode_select[]" placeholder="barcode" required></div> \
                <div class="col-md-4"><input type="text" class="form-control" name="alt_code[]" placeholder="Alt Code" required></div> \
                <div class="col-md-4"><input type="text" class="form-control" name="requestor[]" placeholder="requestor name" required></div> \
                <div class="col-md-4"><input type="text" class="form-control" name="designation[]" placeholder="role" required></div> \
                <div class="col-md-4"><input type="text" class="form-control" name="req_date[]" placeholder="request date" required></div> \
                <div class="col-md-4"><input type="text" class="form-control" name="description[]" placeholder="description" required></div> \
                <div class="col-md-4 mb-2"><button type="button" class="btn btn-danger btn_remove2 " id="' + i + '">-</button></div> \
            </div>');
            });

            // Remove row in Material section
            $(document).on('click', '.btn_remove2', function() {
                var button_id = $(this).attr("id");
                $('#row2' + button_id).remove();
            });
        });
    </script>

    <!-- Include Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script to show modal when barcode already exists -->
    <?php if ($error): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var barcodeErrorModal = new bootstrap.Modal(document.getElementById('barcodeErrorModal'));
                barcodeErrorModal.show();
            });
        </script>
    <?php endif; ?>
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
    <script src="js/jquery-3.3.1.min.js"></script>
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
        $(document).ready(function() {

            const config = {
                search: true, // Enable search feature
                creatable: false, // Disable creatable selection
                clearable: false, // Disable clearable selection
                maxHeight: '360px', // Max height for showing scrollbar
                size: 'sm', // Size of the select, can be 'sm' or 'lg'
            };

            // Initialize dselect for the initial dropdowns
            dselect(document.querySelector('#company'), config);
            dselect(document.querySelector('#branch'), config);
            dselect(document.querySelector('#dept'), config);


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
        });
    </script>




    <script src="assets/js/main.js"></script>

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