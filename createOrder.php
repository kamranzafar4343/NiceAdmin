<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

include 'config/db.php';

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

if (isset($_POST['submit'])) {
    $company_FK_emp = mysqli_real_escape_string($conn, $_POST['comp_FK_emp']);
    $dept_FK_emp = mysqli_real_escape_string($conn, $_POST['dept_FK_emp']);
    $branch_FK_emp = mysqli_real_escape_string($conn, $_POST['branch_FK_emp']);
    $barcode = mysqli_real_escape_string($conn, $_POST['item_barcode']);
    $req_name = mysqli_real_escape_string($conn, $_POST['name']);
    $req_date = mysqli_real_escape_string($conn, $_POST['date']);
    $order_no = mysqli_real_escape_string($conn, $_POST['order_no']);


    //check that no duplicate order_no exist
    $checkOrder = "SELECT * FROM orders Where `order_no` = '$order_no' OR `box` ='$box_FK_emp'";
    $result_dup_order = mysqli_query($conn, $checkOrder);

    if (mysqli_num_rows($result_dup_order) > 0) {
        die('Error: duplicate order no or box');
    } else {
        // exceed only if emp exist for that specific company and Authorized
        $empCheckQuery = "SELECT * FROM `employee` Where branch_FK_emp = '$branch_FK_emp' AND auth_status = 'Authorized'";

        $result = (mysqli_query($conn, $empCheckQuery));

        if (mysqli_num_rows($result) > 0) {
            $sql = "INSERT INTO orders (company, branch, item, name, date, order_no) 
     VALUES ('$company_FK_emp', '$branch_FK_emp' , '$barcode', '$req_name', '$req_date', '$order_no')";

            if ($conn->query($sql) === TRUE) {
                header("Location: order.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo 'emp not authorized';
        }
    }
}


$selected_status = isset($_POST['status']) ? $_POST['status'] : 'default_value';

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

    <!--bootstrap search and select-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css">

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

    <!--choosen-js css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

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

        .error {
            color: #FF0000;
        }
    </style>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <title>Add Order</title>


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
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <!-- Dashboard Link (Visible to all users) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="ri-home-8-line"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <?php if ($_SESSION['role'] == 'admin') { ?>
                <!-- Admin-only Links -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="Companies.php">
                        <i class="ri-building-4-line"></i><span>Companies</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Companies Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="box.php">
                        <i class="ri-archive-stack-fill"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Boxes Nav -->

                <li class="nav-item">
                    <a class="nav-link active" href="order.php">
                        <i class="ri-list-ordered"></i><span>Work Orders</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Work Orders Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="racks.php">
                        <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Racks Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="store.php">
                        <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Store Nav -->

            <?php } else { ?>
                <!-- User-only Links -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="box.php">
                        <i class="ri-archive-stack-fill"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Boxes Nav -->

                <li class="nav-item">
                    <a class="nav-link active" href="order.php">
                        <i class="ri-list-ordered"></i><span>Work Orders</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Work Orders Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="racks.php">
                        <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Racks Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="store.php">
                        <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Store Nav -->
            <?php } ?>


            <li class="nav-heading">Pages</li>

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
    <!-- ---------------------------------------------------End Sidebar--------------------------------------------------->


    <!--form--------------------------------------form--------------------------------------->
    <!-- Start Header form -->
    <div class="headerimg text-center">
        <img src="image/create.png" alt="network-logo" width="50" height="50">
        <h2>Create an Order</h2>
    </div>
    <!-- End Header form -->

    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3">
            <div class="card-body">
                <form class="row g-3 needs-validation" action="" method="POST">


                    <div class="col-md-6">
                        <label class="form-label">order no.</label>
                        <input type="text" class="form-control" name="order_no" id="order_no" required>
                    </div>

                    <!-- Select Company -->
                    <div class="col-md-6">
                        <label for="company">Select Acc Lev 1:</label>
                        <select id="company" class="form-select" name="comp_FK_emp" required>
                            <option value="">Select a Company</option>
                            <?php
                            // Fetch the companies from the database
                            $result = $conn->query("SELECT * FROM compani");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['comp_id']}'>{$row['acc_lev_1']}." - ". {$row['acc_desc']} </option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Select Branch -->
                    <div class="col-md-6">
                        <label for="branch">Select a Branch:</label>
                        <select id="branch" class="form-select" name="branch_FK_emp" required>
                            <option value="">Select a Branch</option>
                            <!-- The options will be populated via AJAX based on the selected company -->
                        </select>
                    </div>

                    <!-- Select Requestor -->
                    <div class="col-md-6">
                        <label for="requestor">Select Requestor:</label>
                        <select id="requestor" class="form-select" name="name" required>
                            <option value="">Select a Requestor</option>
                            <!-- The options will be populated via AJAX based on the selected branch -->
                        </select>
                        <!-- <div id="requestorFeedback" class="valid-feedback"></div>
                        <div id="requestorFeedback" class="invalid-feedback"></div> -->
                    </div>

                    <!-- Select Box -->
                    <div class="col-md-6">
                        <label for="box">Box Barcode:</label>
                        <select id="box" class="form-select" name="" required>
                            <option value="">Select a Box</option>
                            <!-- The options will be populated via AJAX based on the selected branch -->
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Item Barcode(optional):</label>
                        <input type="text" class="form-control" name="item_barcode" id="item_barcode">
                    </div>


                    <div class="col-md-6">
                        <label class="form-label">request date</label>
                        <input type="datetime-local" class="form-control" name="date" required>
                    </div>

                    <div class="text-center mt-4 mb-2">
                        <button type="submit" class="btn btn-outline-primary mr-1" name="submit" value="submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Barcode Error -->
    <div class="modal fade" id="barcodeErrorModal" tabindex="-1" aria-labelledby="barcodeErrorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barcodeErrorModalLabel">Barcode Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    The barcode you entered already exists. Please try a different one.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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

            // When branch is changed, fetch the box
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

        // When branch is changed, fetch the employees
        $('#branch').change(function() {
            var branch_id = $(this).val();

            // AJAX request to get employees for the selected branch
            $.ajax({
                url: 'get_employee.php',
                type: 'POST',
                data: {
                    branch_id: branch_id
                },
                success: function(response) {
                    try {
                        var employees = JSON.parse(response);
                        // Clear existing branches
                        $('#requestor').empty();
                        $('#requestor').append('<option value="">Select Requestor</option>');
                        // Add the new options from the response
                        $.each(employees, function(index, employee) {
                            $('#requestor').append('<option value="' + employee.emp_id + '">' + employee.name + '</option>');
                        });
                    } catch (e) {
                        console.error("Invalid JSON response", response);
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const companySelect = document.getElementById('company');
            const branchSelect = document.getElementById('branch');
            const boxSelect = document.getElementById('box');
            const requestorSelect = document.getElementById('requestor');

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
                loadRequestor(this.value);
            });

            // Store the selected box in localStorage on change
            boxSelect.addEventListener('change', function() {
                localStorage.setItem('selectedBox', this.value);
            });

            // Store the selected requestor in localStorage on change
            requestorSelect.addEventListener('change', function() {
                localStorage.setItem('selectedRequestor', this.value);

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

            // Function to load employes of seleted branch via AJAX
            function loadRequestor(branch_id) {
                $.ajax({
                    url: 'get_employee.php',
                    type: 'POST',
                    data: {
                        branch_id: branch_id
                    },
                    success: function(response) {
                        try {
                            const employees = JSON.parse(response);
                            requestorSelect.innerHTML = '<option value="">Select Requestor</option>';
                            employees.forEach(function(employee) {
                                requestorSelect.innerHTML += `<option value="${employee.emp_id}">${employee.name}</option>`;
                            });

                            // Set previously selected box again, if available
                            const selectedRequestor = localStorage.getItem('selectedRequestor');
                            if (selectedRequestor) {
                                requestorSelect.value = selectedRequestor;
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
</body>


</html>