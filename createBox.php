<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: pages-login.php");
    exit();
}

include 'config/db.php';


$email = $_SESSION['email'];

// Get session variables
$session_userId = $_SESSION['id']; // User ID
$session_user_role = $_SESSION['role']; // User role
$session_email = $_SESSION['email']; // User email

// Get user name and email from the register table
$getAdminData = "SELECT * FROM register WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'";
$resultData = mysqli_query($conn, $getAdminData);

if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
}

// Audit log function
function logAudit($action_by, $action, $description) {
    global $conn;

    // Escape and sanitize inputs
    $action_by = mysqli_real_escape_string($conn, $action_by);
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);

    $query = "
        INSERT INTO audit_log (user_info, action, description)
        VALUES ('$action_by', '$action', '$description')
    ";

    // Execute the query
    if (!mysqli_query($conn, $query)) {
        error_log("Failed to log audit: " . mysqli_error($conn));
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $dept = mysqli_real_escape_string($conn, $_POST['dept']);
    $object_code = mysqli_real_escape_string($conn, $_POST['object_code']);
    $barcode = mysqli_real_escape_string($conn, $_POST['barcode_select']);
    $alt_code = mysqli_real_escape_string($conn, $_POST['alt_code']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    //check if barcode is already in use
    $checkBarcode = "SELECT * FROM box WHERE barcode = '$barcode'";
    $resultBarcode = mysqli_query($conn, $checkBarcode);

    if ($resultBarcode->num_rows > 0) {
        die('Barcode already in use. Please enter a different barcode.');
        exit();
    }

    // Insert data into box table
    $sql = "INSERT INTO box (comp_id_fk, branch_id_fk, dept_id_fk, object, barcode, alt_code, box_desc, status) 
            VALUES ('$company', '$branch', '$dept','$object_code',  '$barcode', '$alt_code', '$description', 'In')";

    if ($conn->query($sql) === TRUE) {

         // Prepare details for logging the audit
         $action_by = "Created by the user-id: $session_userId, user-role: $session_user_role, user-email: $session_email";
         $action = 'Create';
         $description = "Created record: Object Code - $object_code, Barcode - $barcode, Alt Code - $alt_code, Status - In, Description - $description";
        
         // Log the audit
         logAudit($action_by, $action, $description);

        $_SESSION['success_message_box'] = "Box added successfully.";
        header("location: createBox.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit;
    }

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
    <link href="assets/img/dtl.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="library/dselect.js"></script>

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
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- dselect -->
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <!-- ALERTIFY CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.rtl.min.css" />
    <style>
        /* Custom CSS to decrease font size of the table */
        .custom {
            font-size: 0.9rem;
            /* Adjust as needed */
            font-family: monospace;
        }

        .mt-5 {
            margin-top: 7rem !important;
            margin-left: -1rem;
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

        /*styles for form*/
        .card-body {
            padding: 0 20px 20px 20px;
            font-size: 0.8rem;
        }
    </style>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <title>Add container/file-folder</title>


</head>

<body> <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <img class="navbar-image" src="assets/img/dtl.png" alt="">
            <a href="index.php" class="logo d-flex align-items-center">

                <span class="d-none d-lg-block"></span>
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

    <!-- sidebar start -->
    <?php
    include "sidebarcode.php";
    ?>
    <!-- sidebar end -->

    <!--form--------------------------------------form--------------------------------------->
    <div class="headerimg text-center">
        <img src="image/create.png" alt="network-logo" width="50" height="50">
        <h2>Add Container / Filefolder</h2>
    </div>

    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3">
            <div class="card-body">
                <br>
                <form class="row g-3 needs-validation" action="" method="POST" id="boxForm">

                    <!-- company -->
                    <div class="col-md-4">
                        <label for="company">Select company:</label>
                        <select id="company" class="form-select" name="company" required>
                            <option value="">Select company</option>
                            <?php
                            // Fetch the account levels from the database
                            $result = $conn->query("SELECT comp_id, comp_name, acc_desc FROM compani");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['comp_id']}'>{$row['comp_name']} </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- branch -->
                    <div class="col-md-4">
                        <label for="branch">Select Branch:</label>
                        <select id="branch" class="form-select" name="branch">
                            <option value="">Select a branch</option>
                        </select>
                    </div>

                    <!-- dept -->
                    <div class="col-md-4">
                        <label for="dept">Select department:</label>
                        <select id="dept" class="form-select" name="dept">
                            <option value="">Select a department</option>
                        </select>
                    </div>

                    <!-- Object Code -->
                    <div class="col-md-6">
                        <label for="object_code" class="form-label">Object Code</label>
                        <select class="form-select" id="object_code" name="object_code" onchange="updateBarcodeInput()" required>
                            <option value="">Select object type</option>
                            <option value="Container">Container</option>
                            <option value="FileFolder">FileFolder</option>
                        </select>
                    </div>
                    <!-- Select Barcode -->
                    <div class="col-md-6">
                        <label for="barcode_select" class="form-label">Enter Barcode</label>
                        <input type="text" class="form-control" id="barcode_select" placeholder="Enter Barcode" name="barcode_select" required>
                    </div>
                    <!-- FOR the alternative code -->
                    <div class="col-md-6">
                        <label for="alt_code" class="form-label">Alt Code</label>
                        <input type="text" class="form-control" id="alt_code" name="alt_code" placeholder="Enter Alt code">
                    </div>
                    <hr style="color: white;">
                    <!--  Description -->
                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="summernotelib" name="description" rows="3"></textarea>
                    </div>

                    <div class="text-center mt-4 mb-2">
                        <button type="reset" class="btn btn-outline-info mr-1" onclick="window.location.href = 'Box.php';">Cancel</button>
                        <button type="submit" class="btn btn-outline-primary mr-1" id="submitBtn">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" onclick="localStorage.clear()">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!--Function to update the barcode input field on selection of the object type-->
    <script>
        function updateBarcodeInput() {
            const object_type = document.getElementById('object_code');
            const barcode_input = document.getElementById('barcode_select');
            const alt_input = document.getElementById('alt_code');

            if (object_type.value === 'Container') {
                barcode_input.minLength = 7;
                alt_input.minLength = 7;
                barcode_input.maxLength = 7;
                alt_input.maxLength = 7;
                barcode_input.placeholder = "Enter 7 digit Container Barcode";
                alt_input.placeholder = "Enter 7 digit Container alt code";
            } else {
                barcode_input.minLength = 8;
                alt_input.minLength = 8;
                barcode_input.maxLength = 8;
                alt_input.maxLength = 8;
                barcode_input.placeholder = "Enter 8 digit Filefolder Barcode";
                alt_input.placeholder = "Enter 8 digit Filefolder alt code";
            }
            //clear input on type change
            barcode_input.value = "";
            alt_input.value = "";
        }
    </script>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>




    <script>
        $(document).ready(function() {
            //d-search dropdown
            const config = {
                search: true, // Enable search feature
                creatable: false, // Disable creatable selection
                clearable: false, // Disable clearable selection
                maxHeight: '400px', // Max height for showing scrollbar
                size: 'md', // Size of the select, can be 'sm' or 'lg'
            };

            // Initialize dselect for the initial dropdowns
            dselect(document.querySelector('#company'), config);
            dselect(document.querySelector('#branch'), config);
            dselect(document.querySelector('#dept'), config);

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
                            var branches = JSON.parse(response); //return the json response as an array
                            // Clear existing branches
                            $('#branch').empty();
                            $('#branch').append('<option value="">Select a Branch</option>');
                            // Add the new options from the response
                            $.each(branches, function(index, branch) {
                                $('#branch').append('<option value="' + branch.branch_id + '">' + branch.branch_name + '</option>');
                            });
                            // Refresh or reinitialize dselect
                            dselect(document.querySelector('#branch'), config);

                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            });

            // When branch is changed, fetch the departments
            $('#branch').change(function() {
                var branch_id = $(this).val();

                // AJAX request to get dept's for the selected branch
                $.ajax({
                    url: 'get_departments.php',
                    type: 'POST',
                    data: {
                        branch_id: branch_id
                    },
                    success: function(response) {
                        try {
                            var departments = JSON.parse(response); //return the json response as an array
                            // Clear existing dept's
                            $('#dept').empty();
                            $('#dept').append('<option value="">Select department</option>');

                            // Add the new options from the response
                            $.each(departments, function(index, department) {
                                $('#dept').append('<option value="' + department.dept_id + '">' + department.dept_name + '</option>');
                            });
                            // Refresh or reinitialize dselect
                            dselect(document.querySelector('#dept'), config);
                        } catch (e) {
                            console.error("Invalid JSON response", response);
                        }
                    }
                });
            });

        });
    </script>

    <!--corrected jquery version-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </script>

    <!--tinymce text editor integration-->
    <script>
        tinymce.init({
            selector: '#summernotelib', // Replace with your textarea ID
            menubar: false,
            width: 600, // Optional: Remove the menu bar if you want
            height: 180
        });
    </script>


    <script>
        const dataTable = new simpleDatatables.DataTable("#myTable2", {
            searchable: true,
            fixedHeight: true,
        })
    </script>

    <!-- ALERTIFY JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

    <?php
    if (isset($_SESSION['success_message_box'])):
    ?>
        <script>
            // Set Alertify to display notifications at the top of the page
            alertify.set('notifier', 'position', 'top-right');
            alertify.success("<?= $_SESSION['success_message_box']; ?>");
        </script>
    <?php
        //unset message after displaying it to the user
        unset($_SESSION['success_message_box']); // Clear the message
    endif;
    ?>

    <script src="assets/js/main.js"></script>
</body>

</html>