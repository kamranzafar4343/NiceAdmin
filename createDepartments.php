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

// Retrieve branch ID from URL
$branch_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


// gives error if someone tries to access the page without a branch_id
$branchQuery = "SELECT branch_id, acc_lev_2 FROM branches WHERE branch_id = $branch_id";
$branchResult = $conn->query($branchQuery);

if ($branchResult->num_rows === 0) {
  die("Error: Branch ID does not exist.");
}

if (isset($_POST['submit'])) {
  // Fetching values from the form using POST and ensuring security with real_escape_string
  $acc_lev_3 = mysqli_real_escape_string($conn, $_POST['acc_lev_3']);
  $account_desc = mysqli_real_escape_string($conn, $_POST['account_desc']);
  $registration = mysqli_real_escape_string($conn, $_POST['registration']);
  $expiry = mysqli_real_escape_string($conn, $_POST['expiry']);
  $contact_person = mysqli_real_escape_string($conn, $_POST['foc']);
  $contact_phone = mysqli_real_escape_string($conn, $_POST['foc_phone']);
  $contact_fax = mysqli_real_escape_string($conn, $_POST['foc_fax']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $address1 = mysqli_real_escape_string($conn, $_POST['address1']);
  $address2 = mysqli_real_escape_string($conn, $_POST['address2']);
  $pickup_address = mysqli_real_escape_string($conn, $_POST['pickup_address']); // renamed input field for better understanding

    //check account level no is already exist or not
    $accCheckQuery = "SELECT * FROM `departments` WHERE `acc_lev_3` = '$acc_lev_3'";
    $accCheckResult = $conn->query($accCheckQuery);
  
    if ($accCheckResult->num_rows > 0) {
      die("Error: The account level no. '$acc_lev_3' already exists.");
    }

  // SQL query to insert the data into the database
  $sql = "INSERT INTO departments (branch_id_fk, acc_lev_3, acc_desc, registration, expiry, foc, foc_phone, contact_fax, add_1, add_2, add_3, pickup_address) 
          VALUES ('$branch_id', '$acc_lev_3', '$account_desc', '$registration', '$expiry', '$contact_person', '$contact_phone', '$contact_fax', '$address', '$address1', '$address2', '$pickup_address')";

  if ($conn->query($sql) === TRUE) {
      // Redirecting after successful insertion
      header("Location: Departments.php?id=" . $branch_id);
      exit;
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!doctype html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <title>Create departments</title>
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

    .card {
      margin-left: 145px;
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
      margin-top: 100px;
      margin-left: 100px;
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

  <title>Add Branch</title>

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
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="box.php">
        <i class="ri-archive-stack-fill"></i><span>Containers</span><i class="bi bi-chevron ms-auto"></i>
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

<body>

  <div class="headerimg text-center">
    <img src="image/create.png" alt="network-logo" width="50" height="50">
    <h2>Create Department</h2>
  </div>
  <!-- End Header form -->
  <div class="container d-flex justify-content-center">
    <div class="card custom-card shadow-lg mt-3">
      <!-- <h5 class="card-title ml-4">Create Company </h5> -->
      <div class="card-body">
        <br>
        <!-- Multi Columns Form -->
        <form class="row g-3 p-3" action="#" method="POST">
          
          <!-- Branch ID input (readonly) -->
          <!-- <div class="col-md-6">
            <label class="form-label">Branch ID</label>
            <input type="text" class="form-control" name="branch_id_fk" value="<?php echo htmlspecialchars($branch_id); ?>" readonly>
          </div> -->

        <!-- fetching acc lev 2 from branch table (readonly) -->
          <?php
          $getAccLev2 = "SELECT * FROM branches WHERE branch_id = '$branch_id'";
          $resultAccLev2 = mysqli_query($conn, $getAccLev2);
          if ($resultAccLev2->num_rows > 0) {
            $rowAccLev2 = $resultAccLev2->fetch_assoc();

            $fetchAcc2 = $rowAccLev2['acc_lev_2'];
          }

          ?>

          <div class="col-md-6">
            <label class="form-label">Department Name</label>
            <input type="text" class="form-control" name="" value="dept_name" readonly>
          </div>

          <div class="col-md-6">
            <label for="account_description" class="form-label">Account Description</label>
            <textarea type="text" class="form-control" id="acc_desc" name="account_desc" rows="1" columns="20"></textarea>
          </div>

          <div class="col-md-6">
            <label for="registration" class="form-label">Setup Date</label>
            <input type="date" class="form-control" id="registration" name="registration" required>
          </div>

          <div class="col-md-6 mb-3">
            <label for="expiry" class="form-label">Conract Exp_Date</label>
            <input type="date" class="form-control" id="expiry" name="expiry">
          </div>

          <div class="col-md-6">
            <label for="" class="form-label">Contact Person</label>
            <input type="text" class="form-control" id="" name="foc" required pattern="[A-Za-z\s\.]+" required minlength="3" maxlength="38" title="only letters allowed; at least 3" required>
          </div>

          <div class="col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="" name="foc_phone" required>
          </div>

          <div class="col-md-6">
            <label for="pickup_address" class="form-label">Pickup/Delivery Address </label>
            <input type="text" class="form-control" id="" name="pickup_address" required>
          </div>

          <div class="col-md-6">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="" name="address" required>
            <br>

          </div>

          <div class="text-center mt-4 mb-2">
            <button type="submit" class="btn btn-outline-primary mr-2" name="submit" value="submit">Submit</button>
            <button type="reset" class="btn btn-outline-secondary ">Reset</button>
          </div>
        </form>
      </div>
    </div>
  </div>

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

  <script src="assets/js/main.js"></script>
</body>

</html>