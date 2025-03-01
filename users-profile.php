<?php

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
  // If not logged in, redirect to login page
  header("Location: pages-login.php");
  exit();
}


// restict user access to labour dashoard
if ($_SESSION['role'] == 'user') {
  // If not logged in, redirect to login page
  header("Location: pages-login.php");
  exit();
}

// Include the database connection
include 'config/db.php';

// Get user email from session
$email = $_SESSION['email'];

// Get user name and email from register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
  $row2 = $resultData->fetch_assoc();
  $adminName = $row2['name'];
  $adminEmail = $row2['email'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>tasks</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/owl.carousel.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* css for icons */
    #fontStyleCon {
      text-shadow: 1px 1px 1px #ccc;
      font-size: 20px;
      color: darkgoldenrod;
      margin-right: 10px;
    }

    /* added styles for tasks table */
    .tasks-container {
      margin-left: 83px;
    }

    /* Custom CSS to decrease font size of the table */
    /* Basic styling for search bar */
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

    .pagetitle {
      display: flex;
      width: 989px;
      flex-direction: column;

    }

    .barcode {
      height: 55px;
      width: 250px;
      position: relative;
      left: -38px;
    }

    /* 
        #main {
            margin-top: 20px !important;
            padding: 20px 30px;
            transition: all 0.3s;
        } */

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
      top: 110px;
      left: 1157px;
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

    .card-body {
      padding: 20px 20px 20px 60px !important;
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

    .datatable-top {
      width: 942px;

    }

    /* Card */
    .cardBranch {
      margin-bottom: 30px;
      border: none;
      border-radius: 5px;
      box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
      background-color: white;
      font-size: 0.8rem;
      margin-top: 88px;

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

    .drpdwn {
      margin-left: 268px;
      max-width: 424px;
      margin-top: 28px;
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

  <!-- ======= header ======= -->
  <?php include 'headerfile.php'; ?>
  <?php
  include "config/db.php";
  $role = $_SESSION['role'];
  ?>

  <!-- ======= Sidebar ======= -->

  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

      <!-- Dashboard Link (Visible to all users) -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="labour_index.php">
          <i class="ri-home-8-line"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="tasks.php">
          <i class="bi bi-list-task"></i><span>Tasks</span><i class="bi bi-chevron ms-auto"></i>
        </a>
      </li>

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link active" href="users-profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->


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

  <!-- Main content -->
  <main id="main" class="main">
    <div class="content-wrapper">
      <!-- Content -->
      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profile /</span> Details</h4>
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div align="center">
                  <img src="assets/img/employee.png" alt="image" class="rounded" width="200" id="uploadedAvatar">
                  <h4 class="mt-3 mb-2"><b>Kamran Zafar </b></h4>
                  <p>Information Technology</p>
                </div>
              </div>
              <div class="col-md-8">
                <h5 style="background-color: #9BD2FF;padding: 0.4cm;border-radius: 10px;color: #121111;letter-spacing: 1px;"><b>Information</b></h5>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Designation:<span style="float:right;color:black;">Labour</span></li>
                  <li class="list-group-item">Employee No:<span style="float:right;color:black;">017</span></li>
                  <li class="list-group-item">Email:<span style="float:right;color:black;">kamranzafar4343@gmail.com</span></li>
                  <li class="list-group-item">Phone:<span style="float:right;color:black;">03184090843</span></li>
                  <li class="list-group-item">Address:<span style="float:right;color:black;">Okara</span></li>
                  <li class="list-group-item">Joined On:<span style="float:right;color:black;">2024-08-05</span></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="content-backdrop fade"></div>
    </div>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- jQuery library -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

  <!-- DataTables core library and export buttons -->
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>


  <!-- Bootstrap and DataTables styling -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <!-- SearchPanes and Select styling and functionality -->
  <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.3.3/css/searchPanes.bootstrap5.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/2.1.0/css/select.bootstrap5.css">
  <script src="https://cdn.datatables.net/searchpanes/2.3.3/js/dataTables.searchPanes.js"></script>
  <script src="https://cdn.datatables.net/searchpanes/2.3.3/js/searchPanes.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/select/2.1.0/js/dataTables.select.js"></script>

  <!--for icons-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

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
  <script src="js/main.js"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>