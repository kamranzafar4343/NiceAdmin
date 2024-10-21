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

// Show branch previous data
if (isset($_GET['id'])) {
  $dept_id = intval($_GET['id']);

  // Sql Query featch the branch data 
  $sql = "SELECT * FROM `departments` WHERE `dept_id` = '$dept_id'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $branch_id=$row['branch_id_fk'];
    $acc_lev_3 = $row['acc_lev_3'];
    $account_desc = $row['acc_desc'];
    $registration_date = $row['registration'];
    $expiry_date = $row['expiry'];
    $contact_person = $row['foc'];
    $contact_phone = $row['foc_phone'];
    $contact_fax = $row['contact_fax'];
    $address = $row['add_1'];
    $pickup_address = $row['pickup_address'];
  } else {
    echo "Branch not found!";
    exit;
  }
}

// Update the record
if (isset($_POST['update'])) {
  // Retrieve and sanitize form data
  $acc_lev_3 = mysqli_real_escape_string($conn, $_POST['acc_lev_3']);
  $account_desc = mysqli_real_escape_string($conn, $_POST['account_desc']);
  $registration_date = mysqli_real_escape_string($conn, $_POST['registration']);
  $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry']);
  $contact_person = mysqli_real_escape_string($conn, $_POST['foc']);
  $contact_phone = mysqli_real_escape_string($conn, $_POST['foc_phone']);
  $contact_fax = mysqli_real_escape_string($conn, $_POST['contact_fax']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $pickup_address = mysqli_real_escape_string($conn, $_POST['pickup_address']);

  // SQL query to update the record
  $sql = "UPDATE `departments` SET 
                `acc_lev_3` = '$acc_lev_3',
                `acc_desc` = '$account_desc',
                `registration` = '$registration_date',
                `expiry` = '$expiry_date',
                `foc` = '$contact_person',
                `foc_phone` = '$contact_phone',
                `contact_fax` = '$contact_fax',
                `add_1` = '$address',
                `pickup_address` = '$pickup_address' 
            WHERE `dept_id` = '$dept_id'";

  // Execute the query and check for errors
  if (mysqli_query($conn, $sql)) {
    header("Location: departments.php?id=" . $branch_id);
    exit;
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }

  $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Update Department</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
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

    .img {
      border-radius: 30%;
    }

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

    .custom-card2 {
      width: 100%;
      margin-left: 290px;
      box-shadow: none;
      border: none;

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

    .headerimg h2 {
      font-family: "Nunito", sans-serif;
      font-size: 1.5rem;
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

    .card-title {
      margin-bottom: 40px;
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

    .headerimg {
      margin-left: 290px;
    }

    .custom-card {
      width: 60%;
      margin-top: 50px;
      box-shadow: none;
      border: none;
    }
  </style>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <title>Update</title>

</head>

<body>

  <!doctype html>
  <html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
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
        margin-top: 104px;
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

  <!-- ======= Header ======= -->
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
          <i class="ri-building-4-line"></i><span>Accounts</span><i class="bi bi-chevron ms-auto"></i>
        </a>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
                    <a class="nav-link collapsed" href="account.php">
                        <i class="ri-bank-card-line"></i><span>Account Range</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Boxes Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="box.php">
          <i class="ri-archive-stack-fill"></i><span>Containers</span><i class="bi bi-chevron ms-auto"></i>
        </a>


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
        <a class="nav-link collapsed" href="pages-contact.php">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->

    </ul>

  </aside>


  <!-- ---------------------------------------------------End Sidebar--------------------------------------------------->


  <!-- Start Header form -->
  <div class="headerimg text-center">
    <img src="image/update.png.png" alt="network-logo" width="50" height="50" />
    <h2>Update department Information</h2>
  </div>
  <!-- End Header form -->

  <section class="container d-flex justify-content-center my-4">
    <div class="card custom-card2 shadow-lg" style="border: none; box-shadow:none; border:none;">
      <div class="card-body">
        <form class="row g-3 mt-2" action="" method="POST" enctype="multipart/form-data">

          <!-- Acc-Lev-2 -->
          <div class="col-md-6">
            <label for="BRANCH_ACC_LEVEL" class="form-label">Acc-Lev-3</label>
            <input type="text" class="form-control" id="acc_lev_2" name="acc_lev_3" value="<?php echo isset($acc_lev_3) ? $acc_lev_3 : ''; ?>" readonly>
          </div>

          <!-- Account Description -->
          <div class="col-md-6">
            <label for="account_description" class="form-label">Account Description</label>
            <textarea type="text" class="form-control" id="acc_desc" name="account_desc" rows="1" columns="20"><?php echo isset($account_desc) ? $account_desc : ''; ?></textarea>
          </div>

          <!-- Setup Date -->
          <div class="col-md-6">
            <label for="registration" class="form-label">Setup Date</label>
            <input type="date" class="form-control" id="registration" name="registration" value="<?php echo isset($registration_date) ? $registration_date : ''; ?>" readonly>
          </div>

          <!-- Expiry Date -->
          <div class="col-md-6 mb-3">
            <label for="expiry" class="form-label">Contract Expiration Date</label>
            <input type="date" class="form-control" id="expiry" name="expiry" value="<?php echo isset($expiry_date) ? $expiry_date : ''; ?>">
          </div>

          <!-- Contact Person -->
          <div class="col-md-6">
            <label for="" class="form-label">Contact Person</label>
            <input type="text" class="form-control" id="" name="foc" value="<?php echo isset($contact_person) ? $contact_person : ''; ?>" required pattern="[A-Za-z\s\.]+" minlength="3" maxlength="38" title="only letters allowed; at least 3" required>
          </div>

          <!-- Contact Phone -->
          <div class="col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="" name="foc_phone" value="<?php echo isset($contact_phone) ? $contact_phone : ''; ?>" required>
          </div>

          <!-- Fax -->
          <div class="col-md-6">
            <label for="fax" class="form-label">Fax</label>
            <input type="text" class="form-control" id="" name="contact_fax" value="<?php echo isset($contact_fax) ? $contact_fax : ''; ?>">
          </div>
          <!-- Pickup/Delivery Address -->
          <div class="col-md-6">
            <label for="pickup_address" class="form-label">Pickup/Delivery Address</label>
            <input type="text" class="form-control" id="" name="pickup_address" value="<?php echo isset($pickup_address) ? $pickup_address : ''; ?>" required>
          </div>
          <!-- Address -->
          <div class="col-md-6">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="" name="address" value="<?php echo isset($address) ? $address : ''; ?>" required>
          </div>


          <!-- Submit Button -->
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-outline-primary mt-3" name="update" value="update">Update</button>
          </div>
        </form>
      </div>
    </div>
  </section>

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

  <!-- Bootstrap JS (Optional) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7/z1gk35k1RA6QQg+SjaK6MjpS3TdeL1h1jDdED5+ZIIbsSdyX/twQvKZq5uY15B" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9BfDxO4v5a9J9TZz1ck8vTAvO8ue+zjqBd5l3eUe8n5EM14ZlXyI4nN" crossorigin="anonymous"></script>
  <script>
    <?php if (isset($_SESSION['data_inserted']) && $_SESSION['data_inserted']): ?>
      alert('Company Updated successfully! Click OK to see the Companies List');
      window.location.href = 'Companies.php';
      <?php unset($_SESSION['data_inserted']); // Clear the session variable 
      ?>
    <?php elseif (isset($_SESSION['data_inserted']) && !$_SESSION['data_inserted']): ?>
      alert('Failed to enter new data.');
      <?php unset($_SESSION['data_inserted']); ?>
    <?php endif; ?>

    //for the country, state, city dropdown
    document.addEventListener('DOMContentLoaded', function() {
      const countryStateCityData = {
        Pakistan: {
          Punjab: ["Lahore", "Faisalabad", "Rawalpindi", "Multan", "Gujranwala", "Okara", "Pattoki", "Sialkot", "Sargodha", "Bahawalpur", "Jhang", "Sheikhupura"],
          KPK: ["Peshawar", "Mardan", "Mingora", "Abbottabad", "Mansehra", "Kohat", "Dera Ismail Khan"],
          Sindh: ["Karachi", "Hyderabad", "Sukkur", "Larkana", "Nawabshah", "Mirpur Khas", "Shikarpur", "Jacobabad"],
          Balochistan: ["Quetta", "Gwadar", "Turbat", "Sibi", "Khuzdar", "Zhob"],

        },
        USA: {
          California: ["Los Angeles", "San Francisco", "San Diego"],
          Texas: ["Houston", "Austin", "Dallas"]
          // Add more states and cities
        },
        Canada: {
          Ontario: ["Toronto", "Ottawa", "Hamilton"],
          Quebec: ["Montreal", "Quebec City"]
          // Add more provinces and cities
        },
      };

      const countrySelect = document.getElementById('country');
      const stateSelect = document.getElementById('state');
      const citySelect = document.getElementById('city');

      // Update states dropdown when a country is selected
      countrySelect.addEventListener('change', function() {
        const selectedCountry = countrySelect.value;
        stateSelect.innerHTML = '<option value="">Select State</option>'; // Reset states
        citySelect.innerHTML = '<option value="">Select City</option>'; // Reset cities

        if (selectedCountry) {
          const states = Object.keys(countryStateCityData[selectedCountry]);
          states.forEach(function(state) {
            const option = document.createElement('option');
            option.value = state;
            option.text = state;
            stateSelect.add(option);
          });
        }
      });

      // Update cities dropdown when a state is selected
      stateSelect.addEventListener('change', function() {
        const selectedCountry = countrySelect.value;
        const selectedState = stateSelect.value;
        citySelect.innerHTML = '<option value="">Select City</option>'; // Reset cities

        if (selectedCountry && selectedState) {
          const cities = countryStateCityData[selectedCountry][selectedState];
          cities.forEach(function(city) {
            const option = document.createElement('option');
            option.value = city;
            option.text = city;
            citySelect.add(option);
          });
        }
      });
    });
  </script>

</body>

</html>