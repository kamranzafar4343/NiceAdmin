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

// SQL query to get company details
$sql = "SELECT * FROM compani ORDER BY comp_id DESC";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Companies</title>
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

  <!-- Datatable css for export buttons -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">

  <link rel="stylesheet" href="fonts/icomoon/style.css">


  <link rel="stylesheet" href="css/owl.carousel.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="css/style.css">
  
  <style>
    /* Custom CSS to decrease font size of the table */

    .add {
      cursor: pointer;
      width: 143px;
      margin-left: 844px;
      margin-top: 26px;
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

    <h3>List of Companies</h3>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">

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

  <!-- user management -->

  <?php
  include "config/db.php";

  $role = $_SESSION['role'];
  ?>

  <!-- sidebar start -->
  <?php 
    include "sidebarcode.php";
    ?>
    <!-- sidebar end -->

  <!-- ---------------------------------------------------End Sidebar--------------------------------------------------->

  <!-- <button id="fixedButton" type="button" onclick="window.location.href = 'create.php';" class="btn btn-primary mb-3 add">Add Company</button> -->
  <!-- <button id="fixedButton" type="button" onclick="window.location.href = 'emailTable.php';" class="btn btn-outline-info mail">
    <b><i class="ri-mail-line"></i></b>
  </button> -->
  <div class="container">

  </div>
  <!-- 
  <h1>Companies List</h1> -->
  <main id="main" class="main">

    <div class="col-14">

    <div class="card recent-sales overflow-auto">
    <div class="card-body mt-4">
        <!-- Title and Add Button -->
        <div class="row mb-3">
            <div class="col-6">
                <h5 class="card-title">Search Companies</h5>
            </div>
            <div class="col-6 text-end">
                <button type="button" onclick="window.location.href = 'createCompany.php'" class="btn btn-primary">Add Company</button>
            </div>
        </div>

        <!-- Search Form -->
        <form method="GET" action="" class="row g-3 mb-3">
            <!-- First Row: Column and Search Value -->
            <div class="col-md-4">
                <label for="column" class="form-label">Select Column</label>
                <select name="column" id="column" class="form-select">
                    <option value="" selected>Choose...</option>
                    <option value="comp_name">Company Name</option>
                    <option value="foc">Contact Person</option>
                    <option value="add_1">Address</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="value" class="form-label">Search Value</label>
                <input type="text" name="value" id="value" class="form-control" placeholder="Enter search value">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="search" class="btn btn-primary w-100 me-2">Search</button>
                <button type="submit" name="show_all" class="btn btn-secondary w-100">Show All</button>
            </div>

            <!-- Second Row: Date Range Filter -->
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="filter_date" class="btn btn-secondary w-50">Filter by Dates</button>
            </div>
        </form>

        <!-- Table -->
        <?php
        // Default query (no rows initially)
        $query = "SELECT * FROM compani WHERE 1=0 ";

        // If Search Button is Clicked
        if (isset($_GET['search']) && !empty($_GET['column']) && !empty($_GET['value'])) {
            $column = $conn->real_escape_string($_GET['column']);
            $value = $conn->real_escape_string($_GET['value']);
            $query = "SELECT * FROM compani WHERE $column LIKE '%$value%' ORDER BY registration DESC";
        }

        // If Date Range Filter is Applied
        if (isset($_GET['filter_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
            $start_date = $conn->real_escape_string($_GET['start_date']);
            $end_date = $conn->real_escape_string($_GET['end_date']);
            $query = "SELECT * FROM compani WHERE registration BETWEEN '$start_date' AND '$end_date'";
        }

        // If Show All Button is Clicked
        if (isset($_GET['show_all'])) {
            $query = "SELECT * FROM compani";
        }

        // Execute Query
        $result = $conn->query($query);

        // Display Table if Results Exist
        if ($result && $result->num_rows > 0) {
            echo '<table id="companies" class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">Company Name</th>
                            <th scope="col">Contact Person</th>
                            <th scope="col" style="width:15%;">Address</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>
                        <a class="text-primary fw-bold" href="Branches.php?id=' . $row['comp_id'] . '">
                            ' . htmlspecialchars($row['comp_name']) . '
                        </a>
                      </td>';
                echo '<td style="color: #6f42c1; font-weight: bold; opacity: 0.8;">' . htmlspecialchars($row['foc']) . '</td>';
                echo '<td>' . htmlspecialchars($row['add_1']) . '</td>';
                echo '<td>
                        <div style="display: flex; gap: 10px;">
                            <a type="button" class="btn btn-success btn-sm" href="CompanyInfo.php?id=' . $row['comp_id'] . '">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a type="button" class="btn btn-info btn-sm" href="update.php?id=' . $row['comp_id'] . '">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                      </td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } elseif (isset($_GET['search']) || isset($_GET['filter_date']) || isset($_GET['show_all'])) {
            echo '<p class="text-center mt-3">No results found.</p>';
        }
        ?>
    </div>
</div>


    </div>

  </main><!-- End #main -->
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
  <script src="js/main.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!--datatable export buttons-->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>



  <!--for showing print and export buttons-->
  <script>
    new DataTable('#companies', {
      pageLength: 50, // Set default number of rows displayed to 50
      layout: {
        topStart: {
          buttons: [{
              extend: 'copy',
              exportOptions: {
                columns: ':visible:not(:nth-child(3), :nth-child(10))' // Exclude the 2nd column (index starts from 0)
              },

            },

            {
              extend: 'pdf',
              exportOptions: {
                columns: ':visible:not(:nth-child(3), :nth-child(10))' // Exclude the 2nd column (index starts from 0)
              },

            },
            {
              extend: 'csv',
              exportOptions: {
                columns: ':visible:not(:nth-child(3), :nth-child(10))' // Exclude the 2nd column (index starts from 0)
              },

            },
            {
              extend: 'excel',
              exportOptions: {
                columns: ':visible:not(:nth-child(3), :nth-child(10))' // Exclude the 2nd column (index starts from 0)
              },

            },
            {
              extend: 'print',
              exportOptions: {
                columns: ':visible:not(:nth-child(3), :nth-child(10))' // Exclude the 2nd column (index starts from 0)
              },

            },
          ]
        }
      }
    });
  </script>

</body>

</html>