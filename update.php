<?php

// session_start(); // Start the session
session_start();


// Check if the user is logged in
if (!isset($_SESSION['email'])) {
  // If not logged in, redirect to login page
  header("Location: pages-login.php");
  exit();
}

include "db.php";

$email = $_SESSION['email'];
//get user name and email from register table
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
  <meta charset="UTF-8">
  <title>Update Company</title>
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
    .image-circle {
      margin-left: 335px;
      margin-top: 36px;
      margin-bottom: 18px;
      border: 2px solid white;
      width: 85px;
      padding: 5px;
    }

    .image-circle:hover {
      opacity: 0.60;
    }

    .image-circle img {
      width: 120px;
    }

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
  <?php
  include "db.php";

  //get company id for updating the specific company
  if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM `compani` WHERE `comp_id`='$user_id'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $comp_name = $row['comp_name'];
    $phone = $row['phone'];
    $email = $row['email'];
    $password = $row['password'];
    $city = $row['city'];
    $state = $row['state'];
    $country = $row['country'];
    $registration = $row['registration'];
    $expiry = $row['expiry'];
  }

  //update the record
  if (isset($_POST['update'])) {
    $user_id = $_POST['comp_id'];

    $comp_name = mysqli_real_escape_string($conn, $_POST['comp_name']);
    $phone =  mysqli_real_escape_string($conn, $_POST['phone']);
    $email =  mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $registration = mysqli_real_escape_string($conn, $_POST['registration']);
    $expiry = mysqli_real_escape_string($conn, $_POST['expiry']);

    $sql = "UPDATE `compani` SET `comp_name`='$comp_name', `phone`='$phone', `email`='$email', `password`='$hashedPassword', `city`='$city', `state`='$state', `country`='$country', `registration`='$registration', `expiry`='$expiry'  WHERE `comp_id`='$user_id'";

    if (mysqli_query($conn, $sql)) {
      $_SESSION['data_inserted'] = true;
    } else {
      $_SESSION['data_inserted'] = false;

      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // header("location:update.php");
    // exit();

    $conn->close();
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
    <h2>Update Company Information</h2>
  </div>
  <!-- End Header form -->

  <section class="container d-flex justify-content-center my-4">
    <div class="card custom-card2  shadow-lg" style="border: none; box-shadow:none; border:none;">
      <div class="card-body">
        <form id="updateImageForm" action="update_image.php" method="POST" enctype="multipart/form-data">
          <!-- Display the company image -->
          <div class="image-circle">
            <img src="<?php echo $row['image']; ?>" width="70px" alt="image" id="image-<?php echo $row['comp_id']; ?>" style="cursor:pointer;">
            <input type="file" id="file-<?php echo $row['comp_id']; ?>" style="display:none;" onchange="uploadImage(<?php echo $row['comp_id']; ?>)" />
          </div>
        </form>
        <!-- <h5 class="card-title">Update Company Information</h5> -->
        <form class="row g-3 mt-2" action="" method="POST" enctype="multipart/form-data">
          <div class="col-md-6">
            <label class="form-label">Company name</label>
            <input type="text" class="form-control" name="comp_name" required pattern="[A-Za-z\s]+" required minlength="3" maxlength="38" title="only letters allowed; at least 3" value="<?php echo $comp_name; ?>" required>
            <input type="hidden" name="comp_id" value="<?php echo $user_id; ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" required pattern="\+?[0-9]{10,15}" minlength="10" maxlength="17" title="Phone number should be between 10 to 15 digits" value="<?php echo $phone; ?>" required pattern="\d{10,15}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required minlength="8" maxlength="12" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
              title="It must be 8-16 characters, include at least one number, one uppercase and one lowercase letter" value="<?php echo $password; ?>" required minlength="6">
          </div>
          <div class="col-md-6">
            <label for="country" class="form-label">Country</label>
            <select class="form-select" id="country" name="country" value="<?php echo $country; ?>" required>
              <option value="">Select Country</option>
              <option value="Pakistan">Pakistan</option>
              <option value="USA">USA</option>
              <option value="Canada">Canada</option>
              <option value="UK">UK</option>
              <!-- Add more countries as needed -->
            </select>
          </div>

          <div class="col-md-6">
            <label for="state" class="form-label">State</label>
            <select class="form-select" id="state" name="state" value="<?php echo $state; ?>" required>
              <option value="">Select State</option>
              <!-- Options will be dynamically populated based on selected country -->
            </select>
          </div>

          <div class="col-md-6">
            <label for="city" class="form-label">City</label>
            <select class="form-select" id="city" name="city" value="<?php echo $city; ?>" required>
              <option value="">Select City</option>
              <!-- Options will be dynamically populated based on selected state -->
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Registration date</label>
            <input type="date" class="form-control" name="registration" value="<?php echo $registration; ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Expiry date</label>
            <input type="date" class="form-control" name="expiry" value="<?php echo $expiry; ?>" required>
          </div>
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

    //click on the picture to update with ajax
    $(document).on('click', 'img', function() {
      $(this).next('input[type="file"]').click();
    });

    function uploadImage(comp_id) {
      var fileInput = document.getElementById('file-' + comp_id);
      var file = fileInput.files[0];
      var formData = new FormData();
      formData.append('image', file);
      formData.append('comp_id', comp_id);

      $.ajax({
        url: 'update_image.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          // Update the image source with the new image path
          $('#image-' + comp_id).attr('src', response);
        },
        error: function() {
          alert('Image upload failed. Please try again.');
        }
      });
    }
  </script>

</body>

</html>