<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

include "db.php";

$email = $_SESSION['email'];

// Get user name and email from the register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
}

$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and escape special characters for security
    $rack_code = mysqli_real_escape_string($conn, $_POST['rack_code']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);
    $horizontal = mysqli_real_escape_string($conn, $_POST['horizontal']);
    $rack_number = mysqli_real_escape_string($conn, $_POST['rack_number']);
    $column_identifier = mysqli_real_escape_string($conn, $_POST['column_identifier']);
    $position_number = mysqli_real_escape_string($conn, $_POST['position_number']);

    // Check if the rack already exists (you can change this based on specific column uniqueness)
    $rackCheck = "SELECT * FROM `racks` WHERE `rack_code`='$rack_code' AND `level`='$level'";
    $rackCheckResult = $conn->query($rackCheck);

    if ($rackCheckResult->num_rows > 0) {
        $error = true; // Set error to true if rack already exists
    } else {
        // Insert new rack into the racks table
        $sql = "INSERT INTO racks (rack_code, level, horizontal, rack_number, column_identifier, position_number) 
                VALUES ('$rack_code', '$level', '$horizontal', '$rack_number', '$column_identifier', '$position_number')";

        if ($conn->query($sql) === TRUE) {
            // Redirect back to add rack form after successful insert
            header("Location: racks.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
            margin-top: 100px;
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

    <title> Add the Rack</title>


</head>

<body> <!-- ======= Header ======= -->
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

            <!-- Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="ri-home-8-line"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <!-- Companies Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="Companies.php">
                    <i class="ri-building-4-line"></i><span>Companies</span>
                </a>
            </li><!-- End Companies Nav -->

            <!-- Boxes Nav -->
            <!-- Changed 'active' class to 'collapsed' for Boxes to ensure only Racks is active -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="box.php">
                    <i class="ri-archive-stack-fill"></i><span>Boxes</span>
                </a>
            </li><!-- End Boxes Nav -->

            <!-- Items Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="showItems.php">
                    <i class="ri-shopping-cart-line"></i><span>Items</span>
                </a>
            </li><!-- End Items Nav -->

            <!-- Work Orders Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="order.php">
                    <i class="ri-list-ordered"></i><span>Work Orders</span>
                </a>
            </li><!-- End Work Orders Nav -->

            <!-- Racks Nav -->
            <!-- Set this to 'active' to highlight Racks as the current page -->
            <li class="nav-item">
                <a class="nav-link active" href="racks.php">
                    <i class="bi bi-box"></i><span>Racks</span>
                </a>
            </li><!-- End Racks Nav -->

            <!-- Pages Heading -->
            <li class="nav-heading">Pages</li>

            <!-- Profile Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.php">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li><!-- End Profile Nav -->

            <!-- Login Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-login.php">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login</span>
                </a>
            </li><!-- End Login Nav -->

            <!-- Contact Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-contact.php">
                    <i class="bi bi-envelope"></i>
                    <span>Contact</span>
                </a>
            </li><!-- End Contact Nav -->

        </ul>

    </aside><!-- End Sidebar -->


    <!-- ---------------------------------------------------End Sidebar--------------------------------------------------->


    <!--form--------------------------------------form--------------------------------------->
    <!-- Start Header form -->
    <div class="headerimg text-center">
        <i class="fa-solid fa-box" style="font-size: 50px; color: #333;"></i>
        <h2>Add a Rack</h2>
    </div>

    <!-- End Header form -->

    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3">
            <div class="card-body">
                <form class="row g-3 needs-validation" action="" method="POST">

                    <!-- Rack Code -->
                    <div class="col-md-6">
                        <label for="rack_code" class="form-label">Rack Code</label>
                        <input type="text" class="form-control" id="rack_code" name="rack_code" required>
                    </div>

                    <!-- Rack Level -->
                    <div class="col-md-6">
                        <label for="level" class="form-label">Level</label>
                        <input type="text" class="form-control" id="level" name="level" required>
                    </div>

                    <!-- Horizontal Position -->
                    <div class="col-md-6">
                        <label for="horizontal" class="form-label">Horizontal Position</label>
                        <input type="text" class="form-control" id="horizontal" name="horizontal" required>
                    </div>

                    <!-- Rack Number -->
                    <div class="col-md-6">
                        <label for="rack_number" class="form-label">Rack Number</label>
                        <input type="text" class="form-control" id="rack_number" name="rack_number" required>
                    </div>

                    <!-- Column Identifier -->
                    <div class="col-md-6">
                        <label for="column_identifier" class="form-label">Column Identifier</label>
                        <input type="text" class="form-control" id="column_identifier" name="column_identifier" required>
                    </div>

                    <!-- Position Number -->
                    <div class="col-md-6">
                        <label for="position_number" class="form-label">Position Number</label>
                        <input type="text" class="form-control" id="position_number" name="position_number" required>
                    </div>

                    <!-- Form Buttons -->
                    <div class="text-center mt-4 mb-2">
                        <button type="reset" class="btn btn-outline-info mr-1" onclick="window.location.href = 'racks.php';">Cancel</button>
                        <button type="submit" class="btn btn-outline-primary mr-1" name="submit" value="submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Include Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script to show modal when barcode already exists -->
    <?php if ($error): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var barcodeErrorModal = new bootstrap.Modal(document.getElementById('barcodeErrorModal'));
                barcodeErrorModal.show();
            });
        </script>
    <?php endif; ?>
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
    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7/z1gk35k1RA6QQg+SjaK6MjpS3TdeL1h1jDdED5+ZIIbsSdyX/twQvKZq5uY15B" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9BfDxO4v5a9J9TZz1ck8vTAvO8ue+zjqBd5l3eUe8n5EM14ZlXyI4nN" crossorigin="anonymous"></script>
    <!-- Template Main JS File -->


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

            // When company is changed, fetch the box
            $('#branch').change(function() {
                var branch_id = $(this).val();

                // AJAX request to get box for the selected company
                $.ajax({
                    url: 'get_boxes.php',
                    type: 'POST',
                    data: {
                        branch_id: branch_id
                    },
                    success: function(response) {
                        try {
                            var boxes = JSON.parse(response);
                            // Clear existing branches
                            $('#box').empty();
                            $('#box').append('<option value="">Select a Box</option>');
                            // Add the new options from the response
                            $.each(boxes, function(index, box) {
                                $('#box').append('<option value="' + box.box_id + '">' + box.barcode + '</option>');
                            });
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            });
        });
    </script>

    <script>
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

            // Store the selected branch in localStorage on change
            branchSelect.addEventListener('change', function() {
                localStorage.setItem('selectedBranch', this.value);
                loadBoxes(this.value); // Load boxes based on the selected branch
            });

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
                                loadBoxes(selectedBranch); // Load boxes based on the selected branch
                            }
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            }

            // Function to load boxes via AJAX
            function loadBoxes(branch_id) {
                $.ajax({
                    url: 'get_boxes.php',
                    type: 'POST',
                    data: {
                        branch_id: branch_id
                    },
                    success: function(response) {
                        try {
                            const boxes = JSON.parse(response);
                            boxSelect.innerHTML = '<option value="">Select a Box</option>';
                            boxes.forEach(function(box) {
                                boxSelect.innerHTML += `<option value="${box.box_id}">${box.barcode}</option>`;
                            });

                            // Set previously selected box again, if available
                            const selectedBox = localStorage.getItem('selectedBox');
                            if (selectedBox) {
                                boxSelect.value = selectedBox;
                            }
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            }

        });
    </script>
    <script>
        const dataTable = new simpleDatatables.DataTable("#myTable2", {
            searchable: false,
            fixedHeight: true,
        })
    </script>
    <script src="assets/js/main.js"></script>
</body>

</html>