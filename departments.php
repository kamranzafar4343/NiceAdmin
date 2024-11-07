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

// Get branch ID from query string
$branch_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

//Fetch departments of a branch
$sql = "SELECT * FROM `departments` WHERE `branch_id_fk` = $branch_id";
$result = $conn->query($sql);

//get name of branch to show on top of table
$sql2 = "Select branch_name from branches where branch_id= $branch_id";
$result2 = $conn->query($sql2);

$branch_name = "";

if ($result2->num_rows > 0) {
    $row2 = $result2->fetch_assoc();
    $branch_name = $row2['branch_name'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Departments</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <!-- Include the necessary DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Custom CSS to decrease font size of the table */

        .pagetitle {
            display: flex;
            width: 989px;
            flex-direction: column;

        }

        .row {
            margin-left: 52px;
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(var(--bs-gutter-y)* -1);
            margin-right: calc(var(--bs-gutter-x)* 1.5);
            margin-left: calc(var(--bs-gutter-x)* 0.2);
        }

        .datatable-container {
            border: none;
            margin-left: 12px;
            margin-top: 12px;
            /* table-layout: fixed; */
        }


        /* Define the pulse animation */
        .pagetitle {
            display: flex;
            width: 989px;
            flex-direction: column;

        }

        #fixedButtonBranch {
            position: relative;
            top: 110px;
            left: 1149px;
        }

        .row {
            margin-left: 52px;
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(var(--bs-gutter-y)* -1);
            margin-right: calc(var(--bs-gutter-x)* 1.5);
            margin-left: calc(var(--bs-gutter-x)* 0.2);
        }

        .datatable-container {
            border: none;
            margin-left: 12px;
            margin-top: 12px;
            /* table-layout: fixed; */
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

        .mt-4 {
            margin-top: 1.5rem !important;
            margin-right: 214px;
        }

        .datatable-dropdown label {
            font-size: 0.9rem;
        }

        .datatable-info {
            display: none;
        }

        .datatable-top {
            width: 1048px;

        }


        /* Card */
        .cardBranch {
            margin-bottom: 30px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
            background-color: white;
            font-size: 0.8rem;
            margin-top: 30px;
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

        .custom2 {
            font-size: 0.8rem;
            border-radius: 7px;
            padding-top: 14px;
            padding-bottom: 14px;
            padding-right: 34px;
            padding-left: 40px;
            margin-left: 20px;

            /* table-layout: fixed; */

            /* overflow: hidden; */
            /* text-overflow: ellipsis; */
            /* white-space: nowrap; */
        }

        tbody,
        td,
        tr {
            word-wrap: break-word;
            max-width: 200px;
        }

        .datatable-table>tbody>tr>td,
        .datatable-table>tbody>tr>th,
        .datatable-table>tfoot>tr>td,
        .datatable-table>tfoot>tr>th,
        .datatable-table>thead>tr>td,
        .datatable-table>thead>tr>th {
            vertical-align: top;
            padding: 8px 2px;
        }

        .image-circle {
            display: flex;
            justify-content: center;
            /* Horizontally center */
            align-items: center;
            text-align: center;
        }


        .navbar-image {
            width: 50px;
            height: 50px;
            margin-right: 7px;
        }

        .headerbox {

            display: flex;
        }

        .datatable-table>thead>tr>th {
            vertical-align: bottom;
            text-align: left;
            border-bottom: 0px solid #d9d9d9;
        }

        .pagetitleinside button {
            width: 150px;
        }

        .datatable-pagination {
            margin-left: 50px;
        }

        .datatable-top {
            width: 844px;
        }

        .datatable-bottom {
            width: 122%;
        }

        /* .custom-header-col-name{
        margin-right: 1000px;
    } */
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
            <img class="navbar-image" src="assets/img/logo3.png" alt="">

            <a href="index.php" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block">FingerLog</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <h3>List of Departments</h3>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
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
    <!--new table design-->
    <button id="fixedButtonBranch" type="button" onclick="window.location.href = 'createDepartments.php?id=<?php echo $branch_id; ?>'" class="btn btn-primary mb-3">Add Department</button>

    <main id="main" class="main">
        <div class="col-12">
            <div class="cardBranch recent-sales overflow-auto">
                <div class="card-body">
                    <h2 class="card-title fw-bold text-uppercase"><?php echo $branch_name; ?></h2>

                    <?php
                    if ($result->num_rows > 0) {
                    ?>
                        <table id="branchTable" class="table table-borderless datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <!-- <th scope="col">ID</th> -->
                                    <th scope="col">Department Name</th>
                                    <th scope="col">Contact Person</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";


                                    echo "<td>" . ($row["dept_name"]) . "</td>";
                                    echo "<td style= ' color: #fd7e14; font-weight: bold; opacity: 0.8;'> " . ($row["foc"]) . "</td>"; //foc means focal person
                                    echo "<td>" . ($row["add_1"]) . "</td>"; //add_1 is address
                                    ?>
                                    <td>
                                        <div style="display: flex; gap: 10px;">
                                            <a type="button" class="btn btn-success btn-success d-flex justify-content-center" style="padding-bottom: 0px; width:25px; height: 28px;" href="updatedepart.php?id=<?php echo $row['dept_id']; ?>"><i style="width: 20px;" class="fa-solid fa-file-lines"></i></a>
                                            <a type="button" class="btn btn-success btn-info d-flex justify-content-center " style="padding-bottom: 0px; width:25px; height: 28px;" href="updatedepart.php?id=<?php echo $row['dept_id']; ?>"><i style="width: 20px;" class="fa-solid fa-pen-to-square"></i></a>

                                            <a type="button" class="btn btn-danger btn-floating d-flex justify-content-center" style="padding-bottom: 0px; width:25px; height:28px" data-mdb-ripple-init onclick="return confirm('Are you sure you want to delete this record?');" href="deletedepart.php?id=<?php echo $row['dept_id']; ?>"> <i style="width: 20px;" class="fa-solid fa-trash"></i></a>

                                    </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </main><!-- End #main -->

    <!-- Existing scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#branchTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthChange": true,
                "pageLength": 100,
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });
        });

        // Existing JavaScript functions
    </script>
</body>

</html>