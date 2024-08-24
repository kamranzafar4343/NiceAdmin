<?php


// Retrieve company ID from URL
$company_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


include "db.php";
// Validate company ID
$companyQuery = "SELECT comp_id, comp_name FROM compani WHERE comp_id = $company_id";
$companyResult = $conn->query($companyQuery);

if ($companyResult->num_rows === 0) {
    die("Error: Company ID does not exist.");
}

if (isset($_POST['submit'])) {
    $contactPersonName = mysqli_real_escape_string($conn, $_POST['ContactPersonName']);
    $contactPersonPhone = mysqli_real_escape_string($conn, $_POST['ContactPersonPhone']);
    $contactPersonResignation = mysqli_real_escape_string($conn, $_POST['ContactPersonResignation']);
    $city = mysqli_real_escape_string($conn, $_POST['City']);
    $state = mysqli_real_escape_string($conn, $_POST['State']);
    $country = mysqli_real_escape_string($conn, $_POST['Country']);

    $sql = "INSERT INTO branch (compID_FK, ContactPersonName, ContactPersonPhone, ContactPersonResignation, City, State, Country) 
            VALUES ('$company_id', '$contactPersonName', '$contactPersonPhone', '$contactPersonResignation', '$city', '$state', '$country')";

    if ($conn->query($sql) === TRUE) {
        header("Location: table-data2.php?id=" . $company_id);
        exit; // Ensure script ends after redirect
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
    .h2, h2 {
        font-size: 1.5rem;
    }
}
.headerimg h2{
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
        .card-title{
            margin-bottom: 40px;
        }
.card{
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
        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
        <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
      </a><!-- End Profile Image Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6>Kevin Anderson</h6>
          <span>Web Designer</span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
            <i class="bi bi-gear"></i>
            <span>Account Settings</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
            <i class="bi bi-question-circle"></i>
            <span>Need Help?</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="#">
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
    <a class="nav-link active" data-bs-target="#tables-nav" data-bs-toggle="" href="tables-data.php">
      <i class="ri-building-4-line"></i><span>Companies</span><i class="bi bi-chevron ms-auto"></i>
    </a>
  </li><!-- End Tables Nav -->

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
        <h2>Create Branch</h2>
    </div>
    <!-- End Header form -->
    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3">
            <!-- <h5 class="card-title ml-4">Create Company </h5> -->
            <div class="card-body">
                <br>
                <!-- Multi Columns Form -->
        <form class="row g-3 p-3" action="#" method="POST">
            <!-- Company ID input (readonly) -->
            <div class="col-md-6">
                <label class="form-label">Company ID</label>
                <input type="text" class="form-control" name="compID_FK" value="<?php echo htmlspecialchars($company_id); ?>" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label">Contact Person Name</label>
                <input type="text" class="form-control" name="ContactPersonName" required pattern="[A-Za-z\s]+" required minlength="3" maxlength="14" title="Only letters allowed; at least 3" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Person Phone</label>
                <input type="text" class="form-control" name="ContactPersonPhone" required pattern="[0-9]{10,13}" title="Phone number should be between 10 to 15 digits" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Person Resignation</label>
                <input type="text" class="form-control" name="ContactPersonResignation" required pattern="[A-Za-z\s]+" required minlength="4" maxlength="14" title="only letters ; at least 4" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="City" required pattern="[A-Za-z\s]+" title="City name should only contain letters and spaces" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">State</label>
                <input type="text" class="form-control" name="State" required pattern="[A-Za-z\s]+" title="State name should only contain letters and spaces" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" name="Country" required pattern="[A-Za-z\s]+" title="Country name should only contain letters and spaces" required>
            </div>

            <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary" name="submit" value="submit">Submit</button>
            </div>
        </form>
</div>
</div>
</div>

    
    <script>
        <?php if (isset($_SESSION['data_inserted']) && $_SESSION['data_inserted']): ?>
            alert('Company Registered successfully!');
            window.location.href = 'tables-data.php';
            <?php unset($_SESSION['data_inserted']); // Clear the session variable 
            ?>
        <?php elseif (isset($_SESSION['data_inserted']) && !$_SESSION['data_inserted']): ?>
            alert('Failed to enter new data.');
            <?php unset($_SESSION['data_inserted']); ?>
        <?php endif; ?>
    </script>

</body>

</html>