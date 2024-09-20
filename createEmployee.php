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

//get referer id from companyinfo page
$referrer = isset($_GET['referrer']) ? $_GET['referrer'] : 'index.php';

// Retrieve company ID from URL
$company_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


if (isset($_POST['submit'])) {
  $emp_name = mysqli_real_escape_string($conn, $_POST['employee_name']);
  $emp_phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $company_id = $_POST['company'];
  $branch_id = $_POST['branch'];
  $emp_email = mysqli_real_escape_string($conn, $_POST['email']);
  $emp_gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $emp_address = mysqli_real_escape_string($conn, $_POST['address']);
  $emp_role = mysqli_real_escape_string($conn, $_POST['role']);

  $sql = "INSERT INTO employee (name, phone, comp_FK_emp, branch_FK_emp, email, gender, Address, Authority) 
            VALUES ('$emp_name', '$emp_phone', '$company_id', '$branch_id', '$emp_email', '$emp_gender', '$emp_address', '$emp_role')";

  if ($conn->query($sql) === TRUE) {
    // Redirect back to the referrer page
    header("Location: $referrer");
    exit();
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
  <title>create employee</title>
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


    </ul>
  </nav>

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
    </li>


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
    <img src="image/add-employee-icon.png" alt="network-logo" width="50" height="50">
    <h2>Create Employee</h2>
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
          <!-- <div class="col-md-6">
            <label class="form-label">Company ID</label>
            <input type="text" class="form-control" name="compID_FK" value="" readonly>
          </div> -->

          <div class="col-md-6">
            <label for="company">Select Company:</label>
            <select id="company" class="form-select" name="company" required>
              <option value=""> Select a Company </option>

              <?php

              //fetch companies
              $result = $conn->query("SELECT comp_id, comp_name FROM compani");
              while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['comp_id']}'>{$row['comp_name']}</option>";
              }
              ?>

            </select>
          </div>

          <div class="col-md-6">
            <label for="branch">Select a Branch:</label>
            <select id="branch" class="form-select" name="branch" required>
              <option value="">Select a Branch</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Employee Name</label>
            <input type="text" class="form-control" name="employee_name" required pattern="[A-Za-z\s]+" required minlength="3" maxlength="28" title="Only letters allowed; at least 3" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" required pattern="\+?[0-9]{10,15}" minlength="10" maxlength="17" title="Phone number should be between 10 to 15 digits" required>
          </div>
          <div class="col-md-6">
            <label for="country" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
              <option value="">Select Role</option>
              <option value="ceo">CEO</option>
              <option value="cfo">CFO</option>
              <option value="cto">CTO</option>
              <option value="hr">HR</option>
              <option value="product-manager">product manager</option>
              <option value="sales-manager">sales manager</option>
              <option value="IT-manager">IT manager</option>
              <!-- Add more countries as needed -->
            </select>
          </div>

          <div class="col-md-6">
            <label for="">Select Gender:</label><br>
            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label>
            <input type="radio" id="other" name="gender" value="other">
            <label for="other">Other</label>
          </div>

          <div class="col-md-6">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" name="address" required>
          </div>

          <div class="col-12 d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-primary" name="submit" value="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // When company is changed, fetch the branches
      $('#company').change(function() {
        var company_id = $(this).val();

        // AJAX request to get branches for the selected company
        $.ajax({
          url: 'get_branches.php',
          type: 'POST',
          data: {
            company_id: company_id
          },
          success: function(response) {
            try {
              var branches = JSON.parse(response);
              // Clear existing branches
              $('#branch').empty();
              $('#branch').append('<option value="">Select a Branch</option>');
              // Add the new options from the response
              $.each(branches, function(index, branch) {
                $('#branch').append('<option value="' + branch.branch_id + '">' + branch.branch_name + '</option>');
              });
            } catch (e) {
              console.error("Invalid JSON response", response);
            }
          }
        });
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      const companySelect = document.getElementById('company');
      const branchSelect = document.getElementById('branch');
      const boxSelect = document.getElementById('box');

      // Retrieve the previously selected company from localStorage
      const selectedCompany = localStorage.getItem('selectedCompany');
      if (selectedCompany) {
        companySelect.value = selectedCompany;
        loadBranches(selectedCompany); // Load branches based on the selected company
      }

      // Store the selected company in localStorage on change
      companySelect.addEventListener('change', function() {
        localStorage.setItem('selectedCompany', this.value);
        loadBranches(this.value); // Load branches based on the new selection
      });

      // Retrieve the previously selected branch from localStorage
      const selectedBranch = localStorage.getItem('selectedBranch');
      if (selectedBranch) {
        branchSelect.value = selectedBranch;
      }

      // Store the selected branch in localStorage on change
      branchSelect.addEventListener('change', function() {
        localStorage.setItem('selectedBranch', this.value);
        loadBoxes(this.value); // Load boxes based on the selected branch
      });

      // Retrieve the previously selected box from localStorage
      const selectedBox = localStorage.getItem('selectedBox');
      if (selectedBox) {
        boxSelect.value = selectedBox;
      }

      // Store the selected box in localStorage on change
      boxSelect.addEventListener('change', function() {
        localStorage.setItem('selectedBox', this.value);
      });

      // Function to load branches via AJAX
      function loadBranches(company_id) {
        $.ajax({
          url: 'get_branches.php',
          type: 'POST',
          data: {
            company_id: company_id
          },
          success: function(response) {
            try {
              const branches = JSON.parse(response);
              branchSelect.innerHTML = '<option value="">Select a Branch</option>';
              branches.forEach(function(branch) {
                branchSelect.innerHTML += `<option value="${branch.branch_id}">${branch.branch_name}</option>`;
              });

              // Set previously selected branch again, if available
              const selectedBranch = localStorage.getItem('selectedBranch');
              if (selectedBranch) {
                branchSelect.value = selectedBranch;
              }
            } catch (e) {
              console.error("Invalid JSON response", response);
            }
          }
        });
      }
    });

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