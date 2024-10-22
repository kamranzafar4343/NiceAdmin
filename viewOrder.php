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
//get user name and email from register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
}

$result = [];
$box_data = null;
// Get order ID from query string
$order_no = $_GET['id'];

// Fetch company details
$sql = "SELECT * FROM orders WHERE order_no = $order_no";
$result = $conn->query($sql);

// if($result && $result->num_rows>0){
//         $row3 = $result->fetch_assoc();
//         $ = $row3['name'];
//         $ = $row3['email'];
//         $ = $row3['name'];
//         $ = $row3['email'];
//         $ = $row3['name'];
//         $ = $row3['email'];
//         $ = $row3['name'];
//         $ = $row3['email'];
//         $ = $row3['name'];
//         $ = $row3['email'];
//         $ = $row3['name'];
//         $ = $row3['email'];
//         $ = $row3['name'];
//         $ = $row3['email'];
//         $ = $row3['name'];
//         $ = $row3['email'];
//         $ = $row3['name'];
//         $ = $row3['email'];
//     }


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>View Workorder</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

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

        .company-name {
            font-size: 1rem;
        }

        .datatable-wrapper.no-footer .datatable-container {
            border: none;
            margin-left: -315px !important;
            width: 700px !important;
        }

        .company-title {
            font-size: 1.1rem;
        }

        .burger {
            left: -10px;
            top: -20px;
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

        .customImage {
            border: 1px solid white;
            position: relative;
            top: 36%;
            left: 25%;

        }

        .card {
            margin-bottom: 30px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
            background-color: white;
            font-size: 0.8rem;
            margin-top: 38px;
        }

        .container-card {
            font-size: 0.8rem;
            color: #666666;
            font-family: "Open Sans";
            width: 84%;
        }

        /* Custom CSS to place card and table side by side */
        .side-by-side-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            /* Align items to the start of the container */
            gap: 20px;
            /* Space between the card and table */
        }

        .company-name {
            color: #000;
            text-decoration: none;
            display: inline-block;
            transition: color 0.3s ease;
        }

        .img-fluid {
            margin-top: 20px;
            margin-left: 37px !important;
            margin-bottom: 15px;
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

        .pagetitleinside {
            padding-left: 600px;
        }

        * {
            margin: 0;

            padding: 0;

            box-sizing: border-box;
        }

        .remix {
            margin-right: 5px;
        }

        /* styles for card */
        .custom {
            font-size: 0.8rem;
            border-radius: 7px;
            padding-top: 14px;
            padding-bottom: 14px;
            padding-right: 14px;
            padding-left: 18px;
            margin-left: 307px;
            /* table-layout: fixed; */
            /* width: 100%; */
            /* overflow: hidden; */
            /* text-overflow: ellipsis; */
            /* white-space: nowrap; */
        }

        tbody,
        td,
        tr {
            word-wrap: break-word;
            max-width: 200px;
        }

        .card-title-info {
            text-align: center;
        }

        .datatable-top {
            margin-left: 10px !important;
            width: 0px;
        }

        .customImage {
            border: 1px solid white;
            position: relative;
            top: 36%;
            left: 25%;

            /* Change cursor to indicate clickability */
        }

        .hiddenFileInput {
            display: none;
            /* Hide the file input */
        }

        /*Employee header*/
        .headerSetting {
            display: flex;
            gap: 250px;
        }

        .barcode {
            height: 55px;
            width: 250px;
            position: relative;
            left: -38px;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 20px;
        }
        .invoice-container {
            margin: 20px auto;
            padding: 20px;
            max-width: 900px;
            background-color: #fff;
        }
        .header-section {
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .section-title {
            font-weight: bold;
            text-align: center;
            
        }
        .signature-area {
            margin-top: 50px;
            text-align: center;
        }
    </style>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <img class="navbar-image" src="assets/img/logo3.png" alt="">

            <a href="index.php" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block">FingerLog</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->


                </li><!-- End Messages Nav -->

                <li class="nav-item dropdown pe-3 mr-4">

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
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="ri-home-8-line"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->


            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="Companies.php">
                    <i class="ri-building-4-line"></i><span>Accounts</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="box.php">
                    <i class="ri-archive-stack-fill"></i><span>Containers</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" data-bs-target="#tables-nav" data-bs-toggle="" href="order.php">
                    <i class="ri-list-ordered"></i><span>Work Orders</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li>

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.php">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li>
            <!-- End Profile Page Nav -->
            <!-- <li class="nav-item">
    <a class="nav-link collapsed" href="pages-register.php">
      <i class="bi bi-card-list"></i>
      <span>Register</span>
    </a>
  </li> -->
            <!-- End Register Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-login.php">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login</span>
                </a>
            </li><!-- End Login Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="logout.php">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Logout</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-contact.php">
                    <i class="bi bi-envelope"></i>
                    <span>Contact</span>
                </a>
            </li><!-- End Contact Page Nav -->

        </ul>

    </aside>

    <!-- ---------------------------------------------------End Sidebar--------------------------------------------------->


    <main id="main" class="main">
        <div class="headerbox">
        </div><!-- End Page Title -->
        <div class="pagetitleinside mt-1">
        </div>
        </div>

        <!-- Main content container -->
        <div class="">

        <!-- Invoice container -->
    <div class="invoice-container">
        <div class="header-section">
        <div class="row mt-5">
            <div class="col-4">
                <p>Data Technologies</p>
            </div>
            <div class="col-3 text-right">
                <p>MCB - Vault </p>
            </div>
            <div class="col-3 text-right">
                <p>MCB - Vault </p>
            </div>
            <div class="col-12 text-center">
                <p>MCB - Vault </p>
            </div>
            <div class="row">
                <div class="col-6">
                    <p>MCB - Vault Record Room<br>
                    Archival Unit Operation Department<br>
                    14-A Shahrah-e-Aiwan Tijari, Race Course Road Lahore, Pakistan<br>
                    CONTACT OPERATION MANAGER<br>
                    PHONE: 042 - 38353077
                    </p>
                </div>
                <div class="col-6 text-right">
                    <p>Date: 5/2024 10:03 AM<br>
                    DELIVERY WORKORDER<br>
                    REGULAR - Next Working Day<br>
                    </p>
    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <p>Location: A-H01-C-08<br>
                Container: 4003042<br>
                ID: 9970768 Complete Box<br>
                </p>
            </div>
            <div class="col-6 text-right">
                <p>Work Order No: 00069096<br>
                Account: 40394011<br>
                Acct PIC:<br>
                Service Date: 9/5/2024 10:02 AM<br>
                </p>
            </div>
        </div>

        <div class="section-title">WORKORDER SUMMARY</div>
        <div class="row">
            <div class="col-6">
                <p>Total Delivery Items:<br>
                Containers: 1<br>
                </p>
            </div>
            <div class="col-6 text-right">
                <p>Filefolders: 0<br>
                Tapes: 0<br>
                </p>
            </div>
        </div>

        <div class="signature-area">
            <p>___________________________<br>
            Signature</p>
        </div>

        
        </div>
    </div>

            <!-- Print Button -->
            <button class="btn btn-primary mt-3" onclick="window.print()">Print</button>
        </div>
    </div>
</div>

        </div>
        </div>
        <!-- End d-flex container -->
    </main><!-- End #main -->

    <!-- End #main -->
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
    <script>
        const dataTable = new simpleDatatables.DataTable("#myTable2", {
            searchable: false,
            fixedHeight: true,
        })
    </script>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js">
    </script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>