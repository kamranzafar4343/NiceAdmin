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

$result = [];
$company_data = null;
// Get company ID from query string
$company_id = $_GET['id'];

// Fetch company details
$sql = "SELECT * FROM compani WHERE comp_id = $company_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $company_data = $result->fetch_assoc();
  $comp_name = $company_data['comp_name'];
  $description = $company_data['acc_desc'];
  $email = $company_data['email'];
  $registration = $company_data['registration'];
  $expiry = $company_data['expiry'];
  $contact_person = $company_data['foc'];
  $phone = $company_data['foc_phone'];
  $address = $company_data['add_1'];
  $e_role = $company_data['role'];
  $e_auth = $company_data['auth'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Company Details</title>
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
  <style>
    /* css for making card text a bit large */
    .card-text {
      font-size: 15px;
    }

    /* css for setting table position */
    .cbd-position {
      position: relative;

    }

    input.btn.btn-success {
      margin-left: 7px;
      height: 41px;
      padding: 2%;
      padding-top: 3px;
      padding-bottom: 3px;
      text-align: center;
      justify-items: center;

    }

    .search-container {
      margin: 50px;
      margin-left: 320px;
      margin-bottom: 3px !important;
    }

    #main {

      margin-top: 0 !important;
    }

    input[type="text"] {
      padding: 8px;
      font-size: 0.9rem;
      width: 363px;
    }

    input[type="submit"] {
      padding: 10px 20px;
      font-size: 16px;
    }

    .card-body {
      margin-left: 37px !important;
    }

    .pagetitle {
      display: flex;
      width: 989px;
      flex-direction: column;
    }

    .row {
      margin-left: 52px;
      --bs-gutter-x: 1.5rem;
      --bs-gutter-y: 0;
      display: flex;
      flex-wrap: wrap;
      margin-top: calc(var(--bs-gutter-y)* -1);
      margin-right: calc(var(--bs-gutter-x)* 1.5);
      margin-left: calc(var(--bs-gutter-x)* 0.2);
    }

    .datatable-container {
      border: none;
      margin-left: 12px;
      margin-top: 12px;
      /* table-layout: fixed; */
    }


    /* Define the pulse animation */
    .pagetitle {
      display: flex;
      width: 989px;
      flex-direction: column;

    }

    #fixedButtonBranch {
      position: relative;
      top: 1px;
      left: 390px;
      max-width: 122px;
      max-height: 43px;
    }

    .row {
      margin-left: 52px;
      --bs-gutter-x: 1.5rem;
      --bs-gutter-y: 0;
      display: flex;
      flex-wrap: wrap;
      margin-top: calc(var(--bs-gutter-y)* -1);
      margin-right: calc(var(--bs-gutter-x)* 1.5);
      margin-left: calc(var(--bs-gutter-x)* 0.2);
    }

    .datatable-container {
      border: none;
      margin-left: 12px;
      margin-top: 12px;
      /* table-layout: fixed; */
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

    .mt-4 {
      margin-top: 1.5rem !important;
      margin-right: 214px;
    }

    .datatable-dropdown label {
      font-size: 0.9rem;
    }

    .datatable-info {
      display: none;
    }

    /* Card */
    .cardBranch {
      margin-bottom: 30px;
      border: none;
      border-radius: 5px;
      box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
      background-color: white;
      font-size: 0.8rem;

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

    .custom2 {
      font-size: 0.8rem;
      border-radius: 7px;
      padding-top: 14px;
      padding-bottom: 14px;
      padding-right: 34px;
      padding-left: 40px;
      margin-left: 20px;

      /* table-layout: fixed; */

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

    .datatable-table>tbody>tr>td,
    .datatable-table>tbody>tr>th,
    .datatable-table>tfoot>tr>td,
    .datatable-table>tfoot>tr>th,
    .datatable-table>thead>tr>td,
    .datatable-table>thead>tr>th {
      vertical-align: top;
      padding: 8px 2px;
    }

    .image-circle {
      display: flex;
      justify-content: center;
      /* Horizontally center */
      align-items: center;
      text-align: center;
    }


    .navbar-image {
      width: 50px;
      height: 50px;
      margin-right: 7px;
    }

    .headerbox {

      display: flex;
    }

    .datatable-table {
      margin-left: 347px !important;
    }

    .datatable-table>thead>tr>th {
      vertical-align: bottom;
      text-align: left;
      border-bottom: 0px solid #d9d9d9;
    }

    .pagetitleinside button {
      width: 150px;
    }

    .datatable-pagination {
      margin-left: 50px;
    }

    .barcode {
      height: 37px;
      width: 167px;
      position: relative;
      left: -18px;
    }

    /* styles for card */
    .card-body {
      padding: 10px !important;
      padding-left: 0 !important;
      padding-top: 29px !important;
      margin-left: 12px !important;
    }

    /*datatable top css*/
    .datatable-top,
    .datatable-bottom {
      padding: 12px 10px;
      margin-top: 4px;
      display: flex !important;
    }

    .card-title {
      padding: 5px 0 0px 0;
      font-size: 23px;
      font-weight: 500;
      position: relative;
      left: 11px;
      color: #012970;
      margin-top: 14px;
      font-family: "Poppins", sans-serif;
      /* font-family: "Poppins", sans-serif; */
      width: 424px !important;
    }

    .datatable-input {
      width: 840px !important;
      height: 43px !important;
      font-size: 0.8rem !important;
      margin-left: 60px !important;
      outline: none !important;
      width: 179% !important;
      /* max-width: 400px; */
      padding: 17px 21px !important;
      /* font-size: 17px; */
      /* border: 1px solid #ccc; */
      border-radius: 6px !important;
      /* transition: all 0.3s ease; */
      /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
      margin-bottom: 14px !important;
    }

    .datatable-search {
      margin-left: 485px !important;
    }

    @media (min-width: 992px) {
      .col-lg-4 {
        flex: 0 0 auto;
        width: 31.333333%;
      }

      .col-lg-8 {
        flex: 0 0 auto;
        width: 59.666667% !important;
      }
    }

    /* Custom CSS to decrease font size of the table */

    .email-col {
      width: 30px;
    }

    .company-name {
      font-size: 1rem;
    }

    .datatable-wrapper.no-footer .datatable-container {
      border: none;
      margin-left: -337px !important;
      width: 421px !important;
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

    /* copied css from other table start */


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

    /* hiding datatabe top */
    .datatable-top {
      display: none !important;
    }

    .customImage {
      border: 1px solid white;
      position: relative;
      top: -2%;
      left: 20%;

      /* Change cursor to indicate clickability */
    }

    .hiddenFileInput {
      display: none;
      /* Hide the file input */
    }

    /*Employee header
    .headerSetting {
      display: flex;
      }*/

    .emp_tb {
      border-radius: 20px;
    }

    .emp-card {
      margin-bottom: 20px;
      margin-top: 0;
    }

    .mt-5 {
      margin-top: 5rem !important;
    }

    /*emp buton styling*/
    .emp_btn {
      margin-left: 400px;
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
      <img class="navbar-image" src="assets/img/dtl.png" alt="">

      <a href="index.php" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block"></span>
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

  <!-- sidebar start -->
  <?php
  include "sidebarcode.php";
  ?>
  <!-- sidebar end -->

  <main id="main" class="main">
    <div class="container mt-5">
      <div class="row">
        <!-- First Column -->
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-header bg-primary text-white p-3">
              <h4>Company Information</h4>
            </div>
            <div class="card-body">

              <h4 class="card-title mt-0"><?php echo $comp_name; ?></h4>

              <p class="card-text ml-3 mb-3">
                <strong>Registration Date:</strong> <?php echo $registration; ?><br>
                <strong>Contract Expiry Date:</strong> <?php echo $expiry; ?><br>
                <strong>Description:</strong> <?php echo $description; ?><br>
                <br>
                <label for="" class="h6"><em>Contact Person Info:</em></label> <br>
                <strong>Contact Person:</strong> <?php echo $contact_person; ?><br>
                <strong>Designation:</strong> <?php echo $e_role; ?><br>
                <strong>Authority:</strong> <?php echo $e_auth; ?><br>
                <strong>Email:</strong> <?php echo $email; ?><br>
                <strong>Phone:</strong> <?php echo $phone; ?><br>
                <strong>Address:</strong> <?php echo $address ?> <br>




              </p>

            </div>
          </div>
        </div>

      </div>
    </div>
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
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js">
  </script>

  <script>
    //used to refer to other page 
    function redirectToFormPage() {
      // Get the current page URL
      var referrer = encodeURIComponent(window.location.href);
      // Redirect to the form page with the referrer URL as a query parameter
      window.location.href = 'createEmployee.php?referrer=' + referrer;
    }
  </script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>