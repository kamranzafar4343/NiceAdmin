<?php

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

// Include the database connection
include 'config/db.php';

// Get session email 
$email = $_SESSION['email'];

// Get user name, email, and role from the register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
    $userRole = $row2['role']; // Assuming you have a 'role' column in the 'register' table
}

// Check if the user is an admin, otherwise redirect
if (isset($_SESSION['role']) && $_SESSION['role'] != 'admin') {
    // If the user is not an Admin, redirect to index page
    header("Location: index.php");
    exit();
}


if (isset($_POST['submit'])) {

    $comp_name = mysqli_real_escape_string($conn, $_POST['comp_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $registration = mysqli_real_escape_string($conn, $_POST['registration']);
    $expiry = mysqli_real_escape_string($conn, $_POST['expiry']);
    $foc = mysqli_real_escape_string($conn, $_POST['foc']); //foc means focal person = contact person
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $auth = mysqli_real_escape_string($conn, $_POST['authority']);
    $foc_phone = mysqli_real_escape_string($conn, $_POST['foc_phone']);
    $comp_email = mysqli_real_escape_string($conn, $_POST['comp_email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    //check comp name is already exist or not
    $accCheckQuery = "SELECT * FROM `compani` WHERE `comp_name` = '$comp_name'";
    $accCheckResult = $conn->query($accCheckQuery);

    if ($accCheckResult && $accCheckResult->num_rows > 0) {
        die("Error: The company name already exists.");
    }

    //check if email already exist or not
    $emailCheckQuery = "SELECT * FROM `compani` WHERE `email` = '$comp_email'";
    $emailCheckResult = $conn->query($emailCheckQuery);

    if ($emailCheckResult && $emailCheckResult->num_rows > 0) {
        die("Error: The email already exists for another company.");
    }

    // Insert the record into the database
    $sql = "INSERT INTO `compani` (`comp_name`, `acc_desc`, `registration`, `expiry`, `foc`, `role`, `auth` , `foc_phone`, `email`, `add_1`) 
            VALUES ('$comp_name', '$desc', '$registration', '$expiry', '$foc', '$role', '$auth', '$foc_phone', '$comp_email', '$address')";


    //added code to insert data into branch table and redirect to branches table of specific company
    if (mysqli_query($conn, $sql)) {

        // Step 2: Get the ID of the newly inserted company
        $newCompanyId = mysqli_insert_id($conn);

        $insertBranchSql = "INSERT INTO `branches` (`comp_id_fk`, `branch_name`, `account_desc`, `registration_date` , `expiry_date`, `contact_person`, `role`, `auth`, `contact_phone`, `address`) VALUES ('$newCompanyId', '$comp_name Head Office', '$desc', '$registration', '$expiry', '$foc', '$role', '$auth','$foc_phone', '$address')";

        if (mysqli_query($conn, $insertBranchSql)) {

            //get id of newly inserted branch
            $newBranchId = mysqli_insert_id($conn);

            $addStaff = "INSERT INTO `employee` (`branch_id_fk`, `name`, `email`, `phone`, `role`, `Authority`) VALUES ('$newBranchId', '$foc', '$comp_email', '$foc_phone', '$role', '$auth') ";
        }
    }

    if (mysqli_query($conn, $addStaff)) {
        header("Location: Branches.php?id=" . $newCompanyId);
        exit; // Stop further script execution
    } else {
        echo "Error creating branch: " . mysqli_error($conn);
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

    <style>
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
    </style>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <title>Register Company</title>


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


    <?php
    include "config/db.php";

    $role = $_SESSION['role'];
    ?>

    <!-- sidebar start -->
    <?php
    include "sidebarcode.php";
    ?>
    <!-- sidebar end -->

    <!--form--------------------------------------form--------------------------------------->
    <!-- Start Header form -->
    <div class="headerimg text-center">
        <img src="image/create.png" alt="network-logo" width="50" height="50">
        <h2>Create Company</h2>
    </div>
    <!-- End Header form -->
    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3">
            <!-- <h5 class="card-title ml-4">Create Company </h5> -->
            <div class="card-body">
                <br>
                <!-- Multi Columns Form -->
                <form class="row g-3 needs-validation" action="" method="POST">

                    <div class="col-md-6">
                        <label for="" class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="comp_name" name="comp_name" required>
                    </div>

                    <div class="col-md-6">
                        <label for="account_description" class="form-label">Description</label>
                        <textarea class="form-control" id="desc" name="desc" required></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="registration" class="form-label">Setup Date</label>
                        <input type="date" class="form-control" id="registration" name="registration" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="expiry" class="form-label">Contract Exp_Date</label>
                        <input type="date" class="form-control" id="expiry" name="expiry">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Contact Person</label>
                        <input type="text" class="form-control" id="" name="foc" required pattern="[A-Za-z\s\.]+" required minlength="3" maxlength="38" title="only letters allowed; at least 3" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Designation</label>
                        <select name="role" id="" class="form-select">
                            <option value="">Select Role of the Employee</option>
                            <option value="Unit Head Re-pricing, Archiving & NOC Issuance|CDBOD					
">Unit Head Re-pricing, Archiving & NOC Issuance|CDBOD
                            </option>
                            <option value="Manager Archiving & NOC Issuance					
">Manager Archiving & NOC Issuance
                            </option>
                            <option value="Sr. Officer Archiving | ASSETS OPERATIONS-CDBOD 					
">Sr. Officer Archiving | ASSETS OPERATIONS-CDBOD
                            </option>
                            <option value="Officer Archiving | ASSETS OPERATIONS-CDBOD					
 					
">Officer Archiving | ASSETS OPERATIONS-CDBOD

                            </option>
                            <option value="Unit Head | Collection Operations					 					
">Unit Head | Collection Operations

                            </option>
                            <option value="Senior Officer Remittance Services | C&GTBO Division					
				
">Senior Officer Remittance Services | C&GTBO Division

                            </option>
                            <option value="Compliance Officer | C&GTBO Division					
 					
">Compliance Officer | C&GTBO Division

                            </option>
                            <option value="Unit Head-System Development & Quality Assurance |GTCMOD					
				
 					
">Unit Head-System Development & Quality Assurance |GTCMOD

                            </option>
                            <option value="Senior Manager Infrastructure & Services | BFC Office					
				
">Senior Manager Infrastructure & Services | BFC Office

                            </option>
                            <option value="Team Lead – North					
 					
">Team Lead – North

                            </option>
                            <option value="Record Management Officer					
				
 					
">Record Management Officer

                            </option>
                            <option value="Head of General Services						
">Head of General Services
                            </option>
                            <option value="General Manager Accounts					
				
">General Manager Accounts

                            </option>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Access/Authority</label>
                        <select name="authority" id="" class="form-select">
                            <option value="">Select level of access</option>
                            <option value="can get information about branch boxes">can get information about branch boxes</option>
                            <option value="only retrieve department boxes">only retrieve department boxes</option>
                            <option value="all departments of their branch">all departments of their branch</option>
                            <option value="all departments and all branches of company">all departments and all branches of company</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="" name="foc_phone" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="comp_email" name="comp_email" required>
                    </div>

                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="" name="address" required>
                    </div>

                    <div class="text-center mt-4 mb-2">
                        <button type="submit" class="btn btn-outline-primary mr-2" name="submit" value="submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary ">Reset</button>
                    </div>
                </form>
                <!------------------------  Form end ---------------------->

            </div>
        </div>
    </div>
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



    <!-- Validation Script of the header and the size of the image -->
    <script>
        const dataTable = new simpleDatatables.DataTable("#myTable2", {
            searchable: false,
            fixedHeight: true,
        })
    </script>
    <script>
        //prevent resubmission on refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script src="assets/js/main.js"></script>
</body>

</html>