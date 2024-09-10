<?php
// session_start(); // Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}
include 'db.php'; // Include the database connection

$email = $_SESSION['email'];
//get user name and email from register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
}

// Initialize query condition
$searchQuery = "";
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['query']);

    // Search query: match barcode exactly or item name partially
    $sql = "SELECT * FROM item WHERE barcode = '$searchQuery' OR item_name LIKE '%$searchQuery%'";
} else {
    // Default query if no search is performed
    $sql = "SELECT * FROM item";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>items</title>


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

        /* Basic styling for search bar */
        input.btn.btn-success {
            margin-left: 7px;
            height: 41px;
            padding: 2%;
            padding-top: 3px;
            padding-bottom: 3px;
            text-align: center;
            justify-items: center;

        }

        .search-container {
            margin: 50px;
            margin-left: 320px;
            margin-bottom: 3px !important;
        }

        #main {

            margin-top: 0 !important;
        }

        input[type="text"] {
            padding: 8px;
            font-size: 0.9rem;
            width: 363px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
        }

        .card-body {
            margin-left: 37px !important;
        }

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
            left: 1187px;
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

        /* Card */
        .cardBranch {
            margin-bottom: 30px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
            background-color: white;
            font-size: 0.8rem;
            
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
            width: 942px;
        }

        .datatable-bottom {
            width: 122%;
        }

        .barcode {
            height: 37px;
            width: 167px;
            position: relative;
            left: -18px;
        }

        /* styles for card */
        .card-body {
            padding: 18px !important;
            padding-left: 0 !important;
            padding-top: 0 !important;
        }

        /*datatable top css*/
        .datatable-top,
        .datatable-bottom {
            padding: 12px 10px;
            margin-top: 4px;
            display: flex !important;
        }

        .card-title {
            padding: 5px 0 0px 0;
            font-size: 23px;
            font-weight: 500;
            position: relative;
            left: 11px;
            color: #012970;
            margin-top: 14px;
            font-family: "Poppins", sans-serif;
            /* font-family: "Poppins", sans-serif; */
            width: 424px !important;
        }

        .datatable-input {
            padding: 4px 10px !important;
            width: 255px !important;
            height: 33px;
            font-size: 0.8rem;
            margin-left: 6px;
            outline: none;
            width: 148% !important;
            max-width: 414px;
            padding: 21px 23px !important;
            font-size: 17px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 14px;
            margin-top: 8px !important;
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
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="Companies.php">
                    <i class="ri-building-4-line"></i><span>Companies</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="" href="box.php">
                    <i class="ri-archive-stack-fill"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" data-bs-target="#tables-nav" data-bs-toggle="" href="showItems.php">
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
                    <i class="bi bi-box-arrow-left"></i>
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

    <!--new table design-->
    <button id="fixedButtonBranch" type="button" onclick="window.location.href = 'createitem.php?id=<?php echo $box_FK_item; ?>'" class="btn btn-primary mb-3">Add Item</button>

    <div class="search-container">
        <form id="searchForm" action="" method="GET">
            <input type="text" id="searchInput" name="query" placeholder="Enter item name or scan barcode..." autofocus>
            <input type="submit" value="Search" class="btn btn-success btn-success">
        </form>
    </div>

    <main id="main" class="main">

        <div class="col-12">
            <div class="cardBranch recent-sales overflow-auto">
                <div class="card-body">
                    <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns search-results">
                        <h5 class="card-title">List of Items</h5>
                        <!-- <div class="datatable-top">
                       
                       
                        <div class="datatable-search">
                            <input class="datatable-input" placeholder="Enter item name or scan barcode ..." type="search" name="search" title="Search within table">
                        </div>
                    </div> -->


                        <?php
                        if ($result->num_rows > 0) {
                        ?>
                            <table class="table table-borderless datatable mt-4" style="table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 10%;">Quantity</th>
                                        <th scope="col" style="width: 15%;">Item Name</th>
                                        <th scope="col" style="width: 14%;">Item Price</th>
                                        <!-- <th scope="col">Company id </th>
                                    <th scope="col">Branch id</th>
                                    <th scope="col">Box id</th>
                                    <th scope="col">Item id</th> -->
                                        <th scope="col" style="width: 13%;">Condition</th>
                                        <th scope="col" style="width: 20%;">Created at</th>
                                        <th scope="col" style="width: 25%;"> Barcode </th>
                                        <th scope="col" style="width: 15%;">Actions</th>

                                    </tr>
                                </thead>
                                <tbody style="table-layout: fixed;">



                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<tr>";
                                        echo "<td>" . ($row["item_quantity"]) . "</td>";
                                        echo "<td>" . ($row["item_name"]) . "</td>";
                                        echo "<td>" . ($row["item_price"]) . "</td>";

                                        // echo "<td>" . ($row["comp_FK_item"]) . "</td>";
                                        // echo "<td>" . ($row["branch_FK_item"]) . "</td>";
                                        // echo "<td>" . ($row["box_FK_item"]) . "</td>";
                                        // echo "<td>" . ($row["item_id"]) . "</td>";
                                        echo "<td><span>" . $row["status"] . "</span></td>";
                                        echo "<td>" . ($row["timestamp"]) . "</td>";
                                        echo "<td>" . '<img class="barcode" alt="' . ($row["item_id"]) . '" src="barcode.php?text=' . urlencode($row["item_id"]) . '&codetype=code128&orientation=horizontal&size=20&print=false"/>' . "</td>";

                                    ?>
                                        <td>
                                            <div style="display: flex; gap: 10px;">
                                                <a type="button" class="btn btn-success btn-info d-flex justify-content-center " style="width:25px; height: 28px;" href="itemUpdate.php?id=<?php echo $row['item_id']; ?>"><i style="width: 20px;" class="fa-solid fa-pen-to-square"></i></a>

                                                <a type="button" class="btn btn-danger btn-floating d-flex justify-content-center" style="width:25px; height:28px" data-mdb-ripple-init
                                                    onclick="return confirm('Are you sure you want to delete this record?');" href="itemDelete.php?id=<?php echo $row['item_id']; ?>"> <i style="width: 20px;" class="fa-solid fa-trash"></i></a>
                                            </div>
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
        </div>


    </main><!-- End #main -->
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
    <script src="js/main.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
        // Listen for the Enter key press
        document.getElementById("searchInput").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Prevent default form submission
                document.getElementById("searchForm").submit(); // Manually submit the form
            }
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
        import {
            Ripple,
            initMDB
        } from "mdb-ui-kit";

        initMDB({
            Ripple
        });
    </script>


</body>

</html>