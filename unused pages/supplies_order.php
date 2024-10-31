<?php
// session_start(); // Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}
include 'config/db.php';

$email = $_SESSION['email'];
//get user name and email from register table
$getAdminData = "SELECT * FROM register WHERE email = '$email'";
$resultData = mysqli_query($conn, $getAdminData);
if ($resultData->num_rows > 0) {
    $row2 = $resultData->fetch_assoc();
    $adminName = $row2['name'];
    $adminEmail = $row2['email'];
}

$showOrders = "Select * FROM orders";
$resultShowOrders = $conn->query($showOrders);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Supplies Orders</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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

    <!-- Datatable css for export buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">

    <link rel="stylesheet" href="fonts/icomoon/style.css">


    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Custom CSS to decrease font size of the table */

        .add {
            /* cursor: pointer; */
            width: 144px;
            margin-left: 1144px;
            margin-top: 89px;
            margin-bottom: 103px;
        }

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

        .pagetitle {
            display: flex;
            width: 989px;
            flex-direction: column;

        }

        .barcode {
            height: 55px;
            width: 250px;
            position: relative;
            left: -38px;
        }

        /* 
        #main {
            margin-top: 20px !important;
            padding: 20px 30px;
            transition: all 0.3s;
        } */

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

        .card-body {
            padding: 0 20px 20px 60px !important;
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
            width: 942px;

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

        .req_span {
            font-size: 10px;
        }

        .req_auth_span {
            font-size: 10px;
        }
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

                <!-- <li class="nav-item">
          <a class="nav-link active" href="order.php">
            <i class="ri-list-ordered"></i><span>Work Orders</span><i class="bi bi-chevron ms-auto"></i>
          </a>
        </li>End Work Orders Nav -->

                <li class="nav-item">
                    <a class="nav-link active" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                        <i class="ri-list-ordered"></i><span>Work Order</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="forms-nav" class="nav-content active" data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="nav-link collapsed" href="order.php">
                                <i class="bi bi-circle"></i><span>Delivery Workorder</span>
                            </a>
                        </li>
                        <li>
                        <a class="nav-link collapsed" href="access_order.php">
                                <i class="bi bi-circle"></i><span>Acess Workorder</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link collapse" href="destroy_order.php">
                                <i class="bi bi-circle"></i><span>Destroy Workorder</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link active" href="supplies_order.php">
                                <i class=" bi bi-circle"></i><span>Suppliies Workorder</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link collapse" href="permnentout_order.php">
                                <i class=" bi bi-circle"></i><span>Permanent Out Workorder</span>
                            </a>
                        </li>
                    </ul>
                </li>

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
                    <a class="nav-link active" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                        <i class="ri-list-ordered"></i><span>Work Order</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="forms-nav" class="nav-content active" data-bs-parent="#sidebar-nav">
                        <li>
                            <a class="nav-link collapsed" href="order.php">
                                <i class="bi bi-circle"></i><span>Delivery Workorder</span>
                            </a>
                        </li>
                        <li>
                        <a class="nav-link collapsed" href="access_order.php">
                                <i class="bi bi-circle"></i><span>Acess Workorder</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link collapse" href="destroy_order.php">
                                <i class="bi bi-circle"></i><span>Destroy Workorder</span>
                            </a>
                        </li>
                        <li>
                            <a  class="nav-link active" href="supplies_order.php" >
                                <i class="bi bi-circle"></i><span>Suppliies Workorder</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link collapse" href="permnentout_order.php">
                                <i class="bi bi-circle"></i><span>Permanent Out Workorder</span>
                            </a>
                        </li>
                    </ul>
                </li>


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
    <!-- Add the buttton for the work order -->
    <button id="" type="button" onclick="window.location.href = 'create_supplie_order.php';" class="btn btn-primary mb-3 add">Supplies Order</button>
    <!-- Main content -->
    <main id="main" class="main">
        <div class="col-12">
            <div class="cardBranch recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">List of Supplies Orders</h5>
                    <?php
                    // Check if there are any results
                    if ($resultShowOrders->num_rows > 0) {
                        // Display table
                        echo '<table class="table datatable mt-4" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10%;">order no</th>
                            <th scope="col" style="width: 10%;">Company</th>
                            <th scope="col" style="width: 15%;">Branch</th>
                             <th scope="col" style="width: 10%;">Box</th>
                            <th scope="col" style="width: 10%;">Item</th>
                            <th scope="col" style="width: 17%;">requestor</th>                        
                            <th scope="col" style="width: 15%;">request date</th>
                            <th scope="col" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="table-layout: fixed;">';

                        // Counter variable
                        $counter = 1;

                        // Loop through results
                        while ($row = $resultShowOrders->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . ($row['order_no']) . '</td>';

                            // Get company id
                            $comp_id = $row['company'];
                            $sql3 = "SELECT * FROM compani WHERE comp_id= '$comp_id'";
                            $result3 = $conn->query($sql3);
                            if ($result3->num_rows > 0) {
                                $row3 = $result3->fetch_assoc();
                                $comp_name = $row3['comp_name'];
                            }
                            //Show result
                            echo '<td>' . $comp_name . '</td>';

                            //get brnch id
                            $branch_id = $row['branch'];
                            $branchSql = "Select * From branch where branch_id = '$branch_id'";
                            $branchResult = $conn->query($branchSql);
                            if ($branchResult->num_rows > 0) {
                                $branchRow = $branchResult->fetch_assoc();
                                $brnach_name = $branchRow['branch_name'];
                            }
                            //show result
                            echo '<td>' . $brnach_name . '<td>';

                            //get box id
                            $box_id = $row['box'];
                            $boxSQL = "Select * From box where box_id = '$box_id'";
                            $boxSQLresult = $conn->query($boxSQL);
                            if ($boxSQLresult->num_rows > 0) {
                                $boxRow = $boxSQLresult->fetch_assoc();
                                $box_barc = $boxRow['barcode'];
                            }
                            //Show result
                            echo  $box_barc;


                            $empSQL = "Select * From employee where branch_FK_emp = '$branch_id'";
                            $empSQLresult = $conn->query($empSQL);
                            if ($empSQLresult->num_rows > 0) {
                                $empRow = $empSQLresult->fetch_assoc();
                                $Role = $empRow['Authority'];
                                $Auth_status = $empRow['auth_status'];
                            }




                            echo '<td>' . ($row["item"]) . '</td>';

                            //get emp id to show name
                            $emp_id = $row['name'];
                            $emplySql = "Select * From employee where emp_id = '$emp_id'";
                            $emplyResult = $conn->query($emplySql);
                            if ($emplyResult->num_rows > 0) {
                                $emplyRow = $emplyResult->fetch_assoc();
                                $emply_name = $emplyRow['name'];
                            }

                            echo '<td> <span class="req_span">Name:  </span>' . $emply_name . '<br>  <span class="req_span">Role:  </span>' . $Role . '</td>';
                            echo '<td>' . ($row["date"]) . '</td>';
                    ?>
                            <td>
                                <div style="display: flex; gap: 10px;">

                                    <!-- <a type="button" class="btn btn-success d-flex justify-content-center " style="width:25px; height: 28px;" href="branchUpdate.php?id=<?php echo $row['branch']; ?>"><i style="width: 20px;" class="ri-shopping-cart-2-line"></i></a> -->

                                    <a type="button" class="btn btn-success btn-info d-flex justify-content-center " style="width:25px; height: 28px;" href="OrderUpdate.php?id=<?php echo $row['branch']; ?>"><i style="width: 20px;" class="fa-solid fa-pen-to-square"></i></a>

                                    <a type="button" class="btn btn-danger btn-floating d-flex justify-content-center" style="width:25px; height:28px" data-mdb-ripple-init
                                        onclick="return confirm('Are you sure you want to delete this record?');" href="OrderDelete.php?id=<?php echo $row['branch']; ?>"> <i style="width: 20px;" class="fa-solid fa-trash"></i></a>
                                    <a type="button" class="btn btn-success" data-mdb-ripple-init onclick="return confirm('status will be out, and the for record this order is deleted from here and added to the delivery-workorder table');" href="deliveryWorkorder.php?id=<?php echo $row['branch']; ?>">Deliver</a>

                                    <!-- <a type="button" class="btn btn-info" data-mdb-ripple-init
                    onclick="return confirm('Are you sure you want to delete this record?');" href="OrderDelete.php?id=<?php echo $row['id']; ?>">Access</a> -->


                                </div>
                            </td>
                    <?php
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                    } else {
                        // Display message if no results
                        echo '<p>No items found.</p>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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