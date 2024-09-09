<?php

// session_start(); // Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

include 'db.php';

$result = [];
$company_data = null;
// Get company ID from query string
$company_id = $_GET['id'];

// Fetch company details
$sql = "SELECT * FROM compani WHERE comp_id = $company_id";
$result = $conn->query($sql);
$company_data = $result->fetch_assoc();
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
    .img-fluid{
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
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>Kevin Anderson</h6>
                            <span>Web Designer</span>
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
        <a class="nav-link active" data-bs-target="#tables-nav" data-bs-toggle="" href="box.php">
          <i class="ri-archive-stack-fill"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="showItems.php">
          <i class="ri-shopping-cart-line"></i><span>Items</span><i class="bi bi-chevron ms-auto"></i>
        </a>
      </li>

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
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
      <!-- <div class="pagetitle">
        <h1 class="mb-1 mt-4">Companies</h1>
        <div>
          <nav class="mt-0">
            <ol class="breadcrumb mt-0">
              <li class="breadcrumb-item">Company</li>
              <li class="breadcrumb-item active">Details</li>
            </ol>
          </nav>
        </div> -->
    </div><!-- End Page Title -->
    <div class="pagetitleinside mt-1">
      <!-- <button type="button" onclick="window.location.href = 'createBranch.php';" class="btn btn-outline-primary mb-3">Add Branch</button> -->
    </div>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
      <br>
    <?php endif; ?>

    <!-- Main content container -->
    <div class="d-flex flex-wrap">

      <!-- Card container -->
      <div class="col-md-6 col-lg-4 pb-3">
        <div class="card card-custom bg-white border-white border-0">

          <div class="card-custom-img"></div>
          <div class="card-custom-avatar">
            <form id="updateImageForm" action="update_image.php" method="POST" enctype="multipart/form-data">
              <!-- Display the company image -->
            
                <img class="img-fluid customImage"  src="<?php echo $company_data['image']; ?>" width="70px" alt="image" id="image-<?php echo $company_data['comp_id']; ?>">
                
             
            </form>
          </div>
          <div class="card-body list-group">
            <h4 class="card-title-info"><?php echo $company_data['comp_name']; ?></h4>
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

            <!-- <ul class="list-group list-group-horizontal-lg">
              <li class="list-group-item">Branches</li>
              <li class="list-group-item">An item</li>
            </ul> -->
            <!-- <div class="card-footer" style="background: inherit; border-color: inherit;">
              <a href="#" class="btn btn-outline-primary">Branches</a>
            </div> -->
          </div>
        </div>
      </div>

      <!-- Table container -->
      <div class="col-md-6 col-lg-8">
        <?php
        // if ($result->num_rows > 0) {
        //   echo "<table class='datatable custom' style='background-color: #ffffff;'><thead><tr>";
        //   echo "<th class='custom-header'>Company#</th>
        // <th class='custom-header'>Branch#</th>
        // <th class='custom-header'>Representative</th>
        // <th class='custom-header'>Resignation</th>
        // <th class='custom-header'>Phone</th>
        // <th class='custom-header'>City</th>
        // <th class='custom-header'>State</th>
        // <th class='custom-header'>Country</th>
        // <th class='custom-header'>Action</th>";
        //   echo "</tr></thead><tbody>";

        // while ($row = $result->fetch_assoc()) {
        //   echo "<tr>";
        //   echo "<td>" . htmlspecialchars($row["compID_FK"]) . "</td>";
        //   echo "<td>" . htmlspecialchars($row["branch_id"]) . "</td>";
        //   echo "<td>" . htmlspecialchars($row["ContactPersonName"]) . "</td>";
        //   echo "<td>" . htmlspecialchars($row["ContactPersonResignation"]) . "</td>";
        //   echo "<td>" . htmlspecialchars($row["ContactPersonPhone"]) . "</td>";
        //   echo "<td>" . htmlspecialchars($row["City"]) . "</td>";
        //   echo "<td>" . htmlspecialchars($row["State"]) . "</td>";
        //   echo "<td>" . htmlspecialchars($row["Country"]) . "</td>";
        ?>
        <!-- <td>
              <a class="btn btn-danger" href="branchDelete.php?id=<?php echo $row['compID_FK']; ?>">Delete</a>
            </td> -->
        <?php
        //     echo "</tr>";
        //   }

        //   echo "</tbody></table>";
        // } else {
        //   echo "";
        // }
        ?>
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