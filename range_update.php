<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: pages-login.php");
    exit();
}

include "config/db.php"; // Include database connection

$email = $_SESSION['email'];

// Get user data from the register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
}
if (isset($_GET['id'])) {
    $range_id = intval($_GET['id']);  // Get the range ID from URL

    // SQL query to fetch range data
    $sql = "SELECT * FROM `acc_range` WHERE `range_id` = '$range_id'";
    $result = $conn->query($sql);

    // Check if the range exists
    if ($result && $result->num_rows > 0) {
        // Fetch range data into variables
        $row = $result->fetch_assoc();
        $range_id = $row['range_id'];
        $acc_lev_1_id = $row['level1'];  
        $acc_lev_2_id = $row['level2'];
        $object_code = $row['object_code'];
        $begin_code = $row['begin_code'];
        $end_code = $row['end_code'];
        
        // Fetch the company name based on comp_id from the 'compani' table
        $sql1 = "SELECT `acc_lev_1` FROM `compani` WHERE `comp_id` = '$acc_lev_1_id'";
        $result1 = $conn->query($sql1);
        if ($result1 && $result1->num_rows > 0) {
            $acc_lev_1_name = $result1->fetch_assoc()['acc_lev_1'];
        } else {
            echo "Error: Level 1 not found.";
            exit;
        }

        // Fetch the branch name for level2 from the 'branches' table
        $sql2 = "SELECT `acc_lev_2` FROM `branches` WHERE `branch_id` = '$acc_lev_2_id'";
        $result2 = $conn->query($sql2);
        if ($result2 && $result2->num_rows > 0) {
            $acc_lev_2_name = $result2->fetch_assoc()['acc_lev_2'];
        }
    } else {
        // If no range found, display an error message
        echo "Account not found!";
        exit;
    }
}

// Check if the form is submitted (update the record)
if (isset($_POST['update'])) {
    // Sanitize and retrieve form data
    $level1_name = $conn->real_escape_string($_POST['level1']); 
    $level2_name = $conn->real_escape_string($_POST['level2']); 
    $object_code = $conn->real_escape_string($_POST['object_code']);
    $begin_code = $conn->real_escape_string($_POST['begin_code']);
    $end_code = $conn->real_escape_string($_POST['end_code']);

    // Fetch the correct comp_id for level1 from the company name
    $sql1 = "SELECT `comp_id` FROM `compani` WHERE `acc_lev_1` = '$level1_name'";
    $result1 = $conn->query($sql1);
    if ($result1 && $result1->num_rows > 0) {
        $level1_id = $result1->fetch_assoc()['comp_id'];
    } else {
        echo "Error: Invalid Level 1 (Company Name).";
        exit;
    }

    // Fetch the correct branch_id for level2 from the branch name
    $sql2 = "SELECT `branch_id` FROM `branches` WHERE `acc_lev_2` = '$level2_name'";
    $result2 = $conn->query($sql2);
    if ($result2 && $result2->num_rows > 0) {
        $level2_id = $result2->fetch_assoc()['branch_id'];
    } else {
        echo "Error: Invalid Level 2 (Branch Name).";
        exit;
    }

    // SQL query to update the account range record with valid IDs
    $sql = "UPDATE `acc_range` SET 
              `level1` = '$level1_id',  
              `level2` = '$level2_id', 
              `object_code` = '$object_code',
              `begin_code` = '$begin_code',
              `end_code` = '$end_code'
            WHERE `range_id` = '$range_id'";

    // Execute the query and check for success or error
    if ($conn->query($sql)) {
        // Redirect to the account.php page after successful update
        header("Location: account.php?id=" . $range_id);
        exit;
    } else {
        // Display an error message if the update fails
        echo "Error updating record: " . $conn->error;
    }

    // Close the database connection
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

    <title> define account ranges</title>


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
                    <a class="nav-link ative" href="account.php">
                        <i class="ri-bank-card-line"></i><span>Account Range</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Boxes Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="box.php">
                        <i class="ri-archive-stack-fill"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Boxes Nav -->


                <li class="nav-item">
                    <a class="nav-link collapsed" href="order.php">
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
                    <a class="nav-link collapsed" href="showItems.php">
                        <i class="ri-shopping-cart-line"></i><span>Items</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Items Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="order.php">
                        <i class="ri-list-ordered"></i><span>Work Orders</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Work Orders Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="racks.php">
                        <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Racks Nav -->

                <li class="nav-item">
                    <a class="nav-link active" href="store.php">
                        <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
                    </a>
                </li><!-- End Store Nav -->
            <?php } ?>


            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.php">
                    <i class="bi bi-person"></i><span>Profile</span>
                </a>
            </li><!-- End Profile Nav -->

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

    <!-- Start Header Form -->
    <div class="headerimg text-center">
        <i class="bi bi-shop" style="font-size: 50px; color: #333;"></i>
        <h2>Update Account Range</h2>
    </div>
    <!-- End Header Form -->

    <!-- Start Form Container -->
    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3" style="max-width: 800px;"> <!-- Reduce the width -->
            <div class="card-body">
                <form class="row g-3 needs-validation" action="" method="POST" id="rackForm">

                    <!-- Acc Level 1 -->
                    <div class="col-md-6">
                        <label for="acc_range_level" class="form-label">Acc-Lev-1</label>
                        <input type="text" class="form-control" id="lev1" name="level1" value="<?php echo $acc_lev_1_name; ?>" required>
                    </div>

                    <!-- Acc Level 2 -->
                    <div class="col-md-6">
                        <label for="acc_range_level2" class="form-label">Acc-Lev-2</label>
                        <input type="text" class="form-control" id="lev2" name="level2" value="<?php echo $acc_lev_2_name; ?>" required>
                    </div>

                    <!-- Object Code Dropdown -->
                    <div class="col-md-4">
                        <label for="object_code" class="form-label">Object Code</label>
                        <select class="form-select" id="object_code" name="object_code" required>
                            <option value="Container" <?php echo ($object_code == 'Container') ? 'selected' : ''; ?>>Container</option>
                            <option value="FileFolder" <?php echo ($object_code == 'FileFolder') ? 'selected' : ''; ?>>FileFolder</option>
                        </select>
                    </div>

                    <!-- Begin Code -->
                    <div class="col-md-4">
                        <label for="begin_code" class="form-label">Begin Code</label>
                        <input type="text" class="form-control" id="begin_code" name="begin_code" value="<?php echo $begin_code; ?>" required>
                    </div>

                    <!-- End Code -->
                    <div class="col-md-4">
                        <label for="end_code" class="form-label">End Code</label>
                        <input type="text" class="form-control" id="end_code" name="end_code" value="<?php echo $end_code; ?>" required>
                    </div>

                    <!-- Form Buttons -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-outline-primary mt-3" name="update" value="update">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Form Container -->

    <!-- Include Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modal for duplicate entry error -->
    <div class="modal fade" id="duplicateErrorModal" tabindex="-1" aria-labelledby="duplicateErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicateErrorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Duplicate entry detected. Please ensure all fields are unique.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Updated JavaScript with proper lev2Select selection -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Function to load branches via AJAX
        function loadlev2(company_id) {
            $.ajax({
                url: 'get_acc_lev_2.php',
                type: 'POST',
                data: {
                    company_id: company_id
                },
                success: function(response) {
                    try {
                        const acc_lev_2 = JSON.parse(response);
                        const lev2Select = document.getElementById('lev2');
                        lev2Select.innerHTML = '<option value="">Select a Branch</option>';
                        acc_lev_2.forEach(function(branch) {
                            lev2Select.innerHTML += `<option value="${branch.branch_id}">${branch.acc_lev_2}</option>`;
                        });

                    } catch (e) {
                        console.error("Invalid JSON response", response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                }
            });
        }

        // Event listener for Account Level 1 change
        document.getElementById('lev1').addEventListener('change', function() {
            const company_id = this.value;
            if (company_id) {
                loadlev2(company_id); // Load Level 2 data based on selected Level 1
            } else {
                document.getElementById('lev2').innerHTML = '<option value="">Select level 2</option>';
            }
        });
    </script>

    <!-- JavaScript to prevent form submission when duplicate detected -->
    <script>
        document.getElementById('rackForm').addEventListener('submit', function(event) {
            if (document.querySelector('#duplicateErrorModal').classList.contains('show')) {
                event.preventDefault();
            }
        });
    </script>


</body>

</html>