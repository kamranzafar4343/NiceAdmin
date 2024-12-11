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

//show previous form values
if (isset($_GET['id'])) {

    $order_id = $_GET['id'];
    $sql = "SELECT * FROM `orders` WHERE `order_no`= '$order_id'";

    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $creator = $row['creator'];
    $lvl1 = $row['level1'];
    $lvl2 = $row['level2'];
    $lvl3 = $row['level3'];
    $priority = $row['priority'];
    $order_type = $row['WO_typ_action_code'];
    $date = $row['date'];
    $foc = $row['foc'];
    $foc_phone = $row['foc_phone'];
    $pick_add = $row['pickup_address'];
    $obj_code = $row['object_code'];
    $barcode = $row['barcode'];
    $alt = $row['alt'];
    $requestor = $row['requestor'];
    $role = $row['role'];
    $req_date = $row['req_date'];
    $description = $row['description'];
    $obj_type = $row['object_type'];
    $quantity = $row['quantity'];
    $supp_req = $row['supp_requestor'];
    $description = $row['description'];
    $cc = $row['cost_center'];
    $datetime = $row['dateTime'];
    $cmnt = $row['comment'];
}


if (isset($_POST['submit'])) {

    $priority = mysqli_real_escape_string($conn, $_POST['purirty']);
    $type_action = mysqli_real_escape_string($conn, $_POST['wo_typ_action']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $foc = mysqli_real_escape_string($conn, $_POST['foc']);
    $foc_phone = mysqli_real_escape_string($conn, $_POST['foc_phone']);
    $pickup_address = mysqli_real_escape_string($conn, $_POST['pickup_address']);
    $object_code = mysqli_real_escape_string($conn, $_POST['object_code']);
    $barcode_sel = mysqli_real_escape_string($conn, $_POST['barcode_select']);
    $alt_code = mysqli_real_escape_string($conn, $_POST['alt_code']);
    $requestor = mysqli_real_escape_string($conn, $_POST['requestor']);
    $role = mysqli_real_escape_string($conn, $_POST['designation']);
    $req_date = mysqli_real_escape_string($conn, $_POST['req_date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $obj_type = mysqli_real_escape_string($conn, $_POST['object_type']);
    $quant = mysqli_real_escape_string($conn, $_POST['quantity']);
    $supp_req = mysqli_real_escape_string($conn, $_POST['supplies_req']);
    $cc = mysqli_real_escape_string($conn, $_POST['cc']);
    $confirmDate = mysqli_real_escape_string($conn, $_POST['date_time']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);



    $sql = "UPDATE orders priority='$priority', WO_typ_action_code='$type_action', date='$date', foc='$foc', foc_phone='$foc_phone', pickup_address='$pickup_address', object_code='$barcode_sel', barcode='$barcode_sel', alt='$alt_code', requestor='$requestor', role='$role', req_date='$req_date', description='$description', obj_typ='$obj_type', quant='$quant', supp_requestor='$supp_req', cost_cent='$cc', dateTime='$confirmDate', comment='$comment'";

    if ($conn->query($sql) === TRUE) {
        header("Location: order.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
                    <a class="nav-link collapsed" href="account.php">
                        <i class="ri-bank-card-line"></i><span>Account Range</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Boxes Nav -->

                <li class="nav-item">
                    <a class="nav-link active" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                        <i class="ri-list-ordered"></i><span>Work Order</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="forms-nav" class="nav-content active" data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="nav-link active" href="order.php">
                                <i class="bi bi-circle"></i><span>Delivery Workorder</span>
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


                    <div class="col-md-4">
                        <label for="creater" class="form-label">Creator</label>
                        <input type="text" class="form-control" id="creater" name="creater" value="<?php echo ($_SESSION['role'] == 'admin') ? 'admin' : 'user'; ?>" readonly>
                    </div>

                    <hr style="color: white;">

                    <!-- Select Company -->
                    <div class="col-md-4">
                        <label for="lev1">Account level 1:</label>
                        <input type="text" id="lev1" class="form-control" name="level1" value="<?php echo $_SESSION['level1']; ?>">
                        <select id="lev1" class="form-select" name="level1" required>
                            <option value="">Select Account lev 1</option>
                            <?php
                            // Fetch the account levels from the database
                            $result = $conn->query("SELECT comp_id, acc_lev_1, acc_desc FROM compani");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['comp_id']}'>{$row['acc_lev_1']} - {$row['acc_desc']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Select lev 2 of selected account -->
                    <div class="col-md-4">
                        <label for="lev2">Account level 2:</label>
                        <select id="lev2" class="form-select" name="level2" required>
                            <option value="">Select level 2</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="lev3">Account level 3:</label>
                        <select id="lev3" class="form-select" name="level3">
                            <option value="">Select level 3</option>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label for="purirty" class="form-label">Service Priority</label>
                        <select class="form-select" id="purirty" name="purirty" required>
                            <option value="">Select Service Priority</option>

                            <option value="Urgent">Urgent - Rush Same Day</option>
                            <option value="Regular">Regular - Next Working Day</option>
                            <option value="Box Pickup">Box Pickup</option>
                            <option value="Cancel Workorder">Cancel Work Order</option>
                            <option value="Permanantly out">Permanantly Out Boxes</option>
                            <option value="Supplies">Supplies - Packing Material</option>

                            <!-- <option value="FileFolder">FileBOX</option>
                            <option value="FileFolder">Barcode</option> -->
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="purirty" class="form-label">WO Type Action Code</label>
                        <select class="form-select" id="" name="wo_typ_action" required>
                            <option value="">Select Status</option>
                            <option value="Delivery">Delivery</option>
                            <option value="Open">Open</option>
                            <option value="Picklist">Picklist</option>
                            <option value="Route">Route</option>
                            <option value="Print">Print</option>


                            <!-- <option value="FileFolder">FileBOX</option>
                            <option value="FileFolder">Barcode</option> -->
                        </select>
                    </div>

                    <!-- Required BY -->
                    <div class="col-md-3">
                        <label class="form-label">Required By</label>
                        <input type="datetime-local" class="form-control" name="date" required>
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
                        <label for="pickup_address" class="form-label">Pickup/Delievry Address </label>
                        <input type="text" class="form-control" id="" name="pickup_address" required>
                    </div>

                    <h2 style="color: #0056b3; margin-top: 45px;">Add Container/Filefolder</h2>

                    <!-- Object Code -->
                    <div class="col-md-3">
                        <label for="object_code" class="form-label">Object Code</label>
                        <select class="form-select" id="object_code" name="object_code" onchange="updateBarcodeInput()">
                            <option value="">Select object code</option>
                            <option value="Container">Container</option>
                            <option value="FileFolder">FileFolder</option>
                        </select>
                    </div>
                    <!-- Select Barcode -->
                    <div class="col-md-4">
                        <label for="barcode_select">Enter Barcode:</label>
                        <input type="text" class="form-control" id="barcode_select" name="barcode_select">
                    </div>
                    <!-- FOR the alternative code -->
                    <div class="col-md-4">
                        <label for="alt_code" class="form-label">Alt Code</label>
                        <input type="text" class="form-control" id="alt_code" name="alt_code">
                    </div>

                    <!-- Select Requestor -->
                    <div class="col-md-4">
                        <label for="requestor" class="form-label">Requestor Name</label>
                        <input type="text" class="form-control" id="requestor" name="requestor">
                    </div>
                    <!--  Comments -->
                    <div class="col-md-4">
                        <label for="designation" class="form-label">Contact Person Role</label>
                        <input type="text" class="form-control" id="designation" name="designation">
                    </div>


                    <div class="col-md-3">
                        <label class="form-label">request date</label>
                        <input type="datetime-local" class="form-control" name="req_date">
                    </div>
                    <!--  Comments -->
                    <div class="col-md-5">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div>

                    </div>

                    <h2 style="color: #0056b3; margin-top: 35px;">Add Supplies<span style="color:#343a40;">
                            <h5>(leave empty in case of no supplies)</h5>
                        </span></h2>
                    <!--add supplies-->
                    <div class="col-md-5">
                        <label for="object-type" class="form-label">Object type</label>
                        <select class="form-select" id="object_type" name="object_type">
                            <option value="">Select object type</option>
                            <option value="Barcode - Boxes Barcode">Barcode - Boxes Barcode</option>
                            <option value="File Box - Standard Storage Box">File Box - Standard Storage Box</option>
                            <option value="File Box - Storage Boxes Cap">File Box - Storage Boxes Cap</option>
                            <option value="Large Box - Large Storage Box">Large Box - Large Storage Box</option>
                            <option value="Storage Boxes">Storage Boxes</option>
                            <option value="Tape Storage Boxes">Tape Storage Boxes</option>

                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity">
                    </div>

                    <div class="col-md-4">
                        <label for="sup_req" class="form-label">Requestor</label>
                        <input type="text" class="form-control" id="sup_req" name="supplies_req">
                    </div>
                    <div class="col-md-4">
                        <label for="cc" class="form-label">Cost Center</label>
                        <input type="text" class="form-control" id="cc" name="cc">
                    </div>

                    <div class="col-md-4">
                        <label for="datetime" class="form-label">Confirm Date/time</label>
                        <input type="datetime-local" class="form-control" id="date_time" name="date_time">
                    </div>
                    <div class="col-md-6">
                        <label for="comment" class="form-label">Comment</label>
                        <input type="text" class="form-control" id="comment" name="comment">
                    </div>

                    <div class="text-center mt-4 mb-2">
                        <button type="submit" class="btn btn-outline-primary mr-1" name="submit" value="submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Barcode Error -->
    <div class="modal fade" id="barcodeErrorModal" tabindex="-1" aria-labelledby="barcodeErrorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barcodeErrorModalLabel">Barcode Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    The barcode you entered already exists. Please try a different one.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
            dselect(document.querySelector('#lev1'), config);
            dselect(document.querySelector('#lev2'), config);
            dselect(document.querySelector('#lev3'), config);


            // When company is changed, fetch the branches
            $('#lev1').change(function() {
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
                            $('#lev2').empty();
                            $('#lev2').append('<option value="">Select Account Level 2</option>');
                            // Add the new options from the response
                            $.each(branches, function(index, branch) {
                                $('#lev2').append('<option value="' + branch.branch_id + '">' + branch.acc_lev_2 + ' - ' + branch.account_desc + '</option>');
                            });
                            // Refresh or reinitialize dselect
                            dselect(document.querySelector('#lev2'), config);
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            });

            // When branch is changed, fetch the departments
            $('#lev2').change(function() {
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
                            $('#lev3').empty();
                            $('#lev3').append('<option value="">Select Account level 3</option>');
                            // Add the new options from the response
                            $.each(departments, function(index, department) {
                                $('#lev3').append('<option value="' + department.dept_id + '">' + department.acc_lev_3 + ' - ' + department.acc_desc + '</option>');
                            });
                            // Refresh or reinitialize dselect
                            dselect(document.querySelector('#lev3'), config);
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });

            });

            //get company, dept, branch
            var company = getElementById('lev1').value;
            var branch = getElementById('lev2').value;
            var dept = getElementById('lev3').value;
            var barcode = getElementById('barcode_select').value;

            if (company && branch) {
                // When company is changed, fetch the barcodes
                $('lev2').change(function() {
                    var branch_id = $(this).val();

                    // AJAX request to get barcodes for the selected company
                    $.ajax({
                        url: 'get_branchBarcode.php',
                        type: 'POST',
                        data: {
                            branch_id: branch_id
                        },
                        success: function(response) {
                            try {
                                var boxes = JSON.parse(response); //return the json response as an array
                                // Clear existing branches
                                $('#barcode_select').empty();
                                $('#barcode_select').append('<option value="">Select Barcode</option>');
                                // Add the new options from the response
                                $.each(boxes, function(index, box) {
                                    $('#barcode_select').append('<option value="' + box.box_id + '">' + box.barcode + '</option>');
                                });

                            } catch (e) {
                                console.error("Invalid JSON response", response);
                            }
                        }
                    });
                });

            } else if (company && branch && dept) {

            }
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