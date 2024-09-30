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
if (isset($_SESSION['role']) &&$_SESSION['role'] != 'admin') {
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
$company_data = $result->fetch_assoc();


//fetch employee table
$emp_sql = "Select * from employee where comp_FK_emp = $company_id";
$result_emp = $conn->query($emp_sql);
$emp_data = $result_emp->fetch_assoc();


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
    /* copied css start */
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
      top: 47px;
      left: 419px;
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

    .datatable-top {
      width: 942px;
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
      padding-top: 0 !important;
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

      width: 240px;
      height: 35px;
      font-size: 0.8rem;
      margin-left: 401px;
      outline: none;



      font-size: 17px;
      border: 1px solid #ccc;
      border-radius: 6px;
      outline: none;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      margin-bottom: -25px;
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
        <a class="nav-link active" data-bs-target="#tables-nav" data-bs-toggle="" href="Companies.php">
          <i class="ri-building-4-line"></i><span>Companies</span><i class="bi bi-chevron ms-auto"></i>
        </a>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="box.php">
          <i class="ri-archive-stack-fill"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="showItems.php">
          <i class="ri-shopping-cart-line"></i><span>Items</span><i class="bi bi-chevron ms-auto"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="order.php">
          <i class="ri-list-ordered"></i><span>Work Orders</span><i class="bi bi-chevron ms-auto"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="racks.php">
          <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="store.php">
          <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
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
    <div class="d-flex flex-wrap">

      <!-- Table container -->

      </div>
    <!-- Card container -->
    <div class="col-md-6 col-lg-4 pb-3">
      <div class="card card-custom bg-white border-white border-0">

        <div class="card-custom-img"></div>
        <div class="card-custom-avatar">
          <form id="updateImageForm" action="update_image.php" method="POST" enctype="multipart/form-data">
            <!-- Display the company image -->

            <img class="img-fluid customImage" src="<?php echo $company_data['image']; ?>" width="70px" alt="image" id="image-<?php echo $company_data['comp_id']; ?>">


          </form>
        </div>
        <div class="card-body list-group">
          <?php if ($company_data !== null): ?>
            <h4 class="card-title-info"><?php echo $company_data['comp_name']; ?></h4>
          <?php else: ?>
            <h4 class="card-title-info">No company data found</h4>
          <?php endif; ?>
          <div class="d-flex justify-content-center">
            <a href="Branches.php?id=<?php echo $company_data['comp_id']; ?>"><i class="ri-git-merge-line remix" style="font-size: 30px;"></i></a>
            <!-- <a href="showItems.php?id=<?php echo $company_data['comp_id']; ?>"><i class="ri-shopping-cart-2-line remix" style="font-size: 30px;"></i></a> -->
          </div>
          <hr>
          <ul class="list-group list-group-horizontal d-flex justify-content-between">
            <li class="list-group-item" style="color:grey;  width: 30%;">Email</li>
            <li class="list-group-item text-end" style="text-align: right; width: 75%;"><?php echo $company_data['email']; ?></li>
          </ul>
          <ul class="list-group list-group-horizontal-sm d-flex justify-content-between">
            <li class="list-group-item" style="color:grey; width: 30%;">Phone</li>
            <li class="list-group-item text-end" style="text-align: right; width: 55%;"><?php echo $company_data['phone']; ?></li>
          </ul>
          <ul class="list-group list-group-horizontal-md d-flex justify-content-between">
            <li class="list-group-item" style="color:grey; width:50%">Reg. Date</li>
            <li class="list-group-item" style="text-align: right;width: 55%;"><?php echo $company_data['registration']; ?></li>
          </ul>
          <ul class="list-group list-group-horizontal-lg d-flex justify-content-between">
            <li class="list-group-item" style="color:grey; width: 30%;">Ex. Date</li>
            <li class="list-group-item" style="text-align: right; width: 55%;"><?php echo $company_data['expiry']; ?></li>
          </ul>
          <ul class="list-group list-group-horizontal-lg d-flex justify-content-between">
            <li class="list-group-item" style="color:grey; width: 30%;">City</li>
            <li class="list-group-item " style="text-align: right; width: 55%;"><?php echo $company_data['city']; ?></li>
          </ul>
          <ul class="list-group list-group-horizontal-lg d-flex justify-content-between">
            <li class="list-group-item" style="color:grey; width: 30%;">Country</li>
            <li class="list-group-item" style="text-align: right; width: 55%;"><?php echo $company_data['country']; ?></li>
          </ul>

        </div>
      </div>
    </div>
      
      <div class="col-md-7 col-lg-10 mt-4">
        <div class="cardBranch recent-sales overflow-auto">
          <div class="card-body" style="font-size: 0.8rem;">
            <button id="fixedButtonBranch" type="button" onclick="redirectToFormPage()" class="btn btn-primary mb-3">Add Employee</button>
            <h5 class="card-title emp-card">List of employees</h5>
            <?php
            if ($result_emp->num_rows > 0) {
            ?>
              <table class="table datatable emp_tb">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col" class="email-col">Email</th>
                    <th scope="col">Phone</th>
                    <!-- <th scope="col" >Branch</th> -->
                    <!-- <th scope="col" style="width: 24%;">Company Name</th> -->
                    <!-- <th scope="col">Gender</th> -->
                    <!-- <th scope="col">Address</th> -->
                    <th scope="col">Role</th>
                    <!-- <th scope="col" >Received</th> -->
                    <!-- <th scope="col" style="width: 30%;">Barcode</th> -->
                    <th scope="col">Action</th>
                    <th scope="col">Auth_status</th>
                  </tr>
                </thead>
                <tbody style="table-layout: fixed;">
                  <?php

                  //counter variable
                  $counter = 1;

                  while ($emp_data = $result_emp->fetch_assoc()) {

                    //dexlare variable for box_id

                    echo "<tr>";
                    echo "<tr>";
                    echo "<td>" . ($emp_data["name"]) . "</td>";

                    // echo "<td>" . $branch_name . "</td>";
                    echo "<td>" . ($emp_data["email"]) . "</td>";
                    echo "<td>" . ($emp_data["phone"]) . "</td>";
                    // echo "<td>" . ($emp_data["gender"]) . "</td>";
                    // echo "<td>" . ($emp_data["Address"]) . "</td>";
                    echo "<td>" . ($emp_data["Authority"]) . "</td>";
                    echo "<td>" . ($emp_data["auth_status"]) . "</td>";
       
                    // echo "<td>" . '<img class="barcode" alt="' . ($row["barcode"]) . '" src="barcode.php?text=' . urlencode($row["barcode"]) . '&codetype=code128&orientation=horizontal&size=20&print=false"/>' . "</td>";
                  ?>
                    <td>
                      <div style="display: flex; gap: 10px;">
                        <a type="button" class="btn btn-success btn-info d-flex justify-content-center align-items-center text-center"
                          style="padding-bottom: 0px; width:25px; height: 28px;"
                          href="employeeUpdate.php?id=<?php echo $emp_data['emp_id']; ?>">
                          <i class="ri-edit-box-line mb-1"></i>
                        </a>

                        <a type="button" class="btn btn-danger btn-floating d-flex justify-content-center align-items-center text-center"
                          style="padding-bottom: 0; width: 25px; height: 28px;"
                          data-mdb-ripple-init
                          onclick="return confirm('Are you sure you want to delete this employee?');"
                          href="employeeDelete.php?id=<?php echo $emp_data['emp_id']; ?>">
                          <i class="ri-delete-bin-6-line mb-1"></i>
                        </a>
                      </div>
                    </td>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            <?php
            } else {

              echo '<br>';
              echo 'No Employees found for Company ' . '<b>' . $company_data['comp_name'] . '<b>';
            }
            ?>
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