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

    <!--bootstrap search and select-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <!-- Style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Custom CSS to decrease font size of the table */

        .add {
            /* cursor: pointer; */
            margin-left: 976px;
            margin-top: 85px;
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
            margin-top: 7px;
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

    <title>Delivery Workorders</title>

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


  <!-- sidebar start -->
  <?php
  include "sidebarcode.php";
  ?>
  <!-- sidebar end -->

    <!--form--------------------------------------form--------------------------------------->

    <!-- Main content -->
    <main id="main" class="main">
        <div class="col-14">
            <!-- Add the buttton for the work order -->
            <button id="" type="button" onclick="window.location.href = 'createDeliveryWO.php';" class="btn btn-primary mb-1 add">Add</button>
            <div class="cardBranch recent-sales overflow-auto">
                <div class="card-body">

                    <h5 class="card-title">List of Delivery Work Orders</h5>
                    <?php
                    // SQL query to fetch orders with is_read status
                    //o is given as alias for orders table
                    //a is given as alias for assign_tasks table
                    $showOrders = "
                            SELECT 
                                    o.order_no, 
                                    o.comp_id_fk, 
                                    o.branch_id_fk, 
                                    o.status, 
                                    o.order_creation_date, 
                                    o.priority, 
                                    o.date, 
                                    a.is_read
                                    FROM 
                                    orders o  
                                 LEFT JOIN 
                                assign_task a
                                ON 
                                o.order_no = a.order_no_fk
                                ORDER BY 
                                o.order_creation_date ASC
                                LIMIT 100;
                                ";
                    $resultShowOrders = $conn->query($showOrders);


                    // Check if there are any results
                    if ($resultShowOrders->num_rows > 0) {
                        // Display table
                        echo '<table id="orderT" class="table mt-4 nowrap">
                    <thead>
                        <tr>
                        <th scope="col" style="width: 6%;">WorkOrder#</th>
                        <th scope="col" style="width: 14%;">Account</th>
                        <th scope="col" style="width: 8%;">Status</th>
                        <th scope="col" style="width: 10%;">Create Date</th>
                        <th scope="col" style="width: 8%;">Service Priority</th>
                        <th scope="col" style="width: 7%;">Required By</th>';

                        // Only display the Action column if the user is an admin
                        if ($_SESSION['role'] == 'admin') {
                            echo '<th scope="col" style="width: 18%;">Action</th>';
                        }
                        echo '</tr>
                        </thead>
                        <tbody style="font-size: 11px; ">';

                        // Counter variable
                        $counter = 1;

                        // Loop through results
                        while ($row = $resultShowOrders->fetch_assoc()) {
                            echo '<tr>';
                    ?>
                            <td>
                                <div>
                                    <!-- Is Read with GIF -->

                                    <?php

                                    //only show if is_read=1 means user complete his task
                                    if ($row['is_read'] == 1) {
                                        //check if the status is completed then hide the image
                                        if ($row["status"] != 'Completed') {

                                    ?>
                                            <a
                                                href="verify_task_submission.php?id=<?php echo $row["order_no"]; ?>">
                                                <img src="assets/img/new-icon-gif-2.jpg" id="gifImage" style="height: 30px; width: 30px; margin-right: 15px; visibility: visible;" alt="gif">
                                            </a>
                                    <?php

                                        }
                                    } else {
                                        echo '';
                                    }

                                    // Workorder_no
                                    echo $row["order_no"];
                                    ?>
                                </div>
                            </td>

                            <?php

                            // Get specific company id
                            $comp_id = $row['comp_id_fk'];
                            $sql3 = "SELECT * FROM compani WHERE comp_id= '$comp_id'";
                            $result3 = $conn->query($sql3);
                            if ($result3->num_rows > 0) {
                                $row3 = $result3->fetch_assoc();
                                $comp_name = $row3['comp_name'];
                            }

                            // Get specific branch id
                            $branch_id = $row['branch_id_fk'];
                            $sql7 = "SELECT * FROM branches WHERE branch_id= '$branch_id'";
                            $result7 = $conn->query($sql7);
                            if ($result7->num_rows > 0) {
                                $row7 = $result7->fetch_assoc();
                                $branch_name = $row7['branch_name'];
                            }

                            // Show account
                            echo '<td>' . $comp_name . " / " . $branch_name . '</td>';


                            // Change the status to "In Progress"
                            if ($row['is_read'] == '1') {
                                if ($row["status"] == 'Pending') {
                                    $updateQuery = "UPDATE orders SET status = 'In Progress' WHERE order_no = " . $row['order_no'];
                                    $conn->query($updateQuery);
                                }
                            }
                            echo '<td>';

                            if ($row["status"] == 'Completed') {
                                echo '<span class="badge badge-pill badge-success" style="font-size: 12px;">' . $row["status"] . '</span>';
                            } elseif ($row["status"] == 'In Progress') {
                                echo '<span class="badge badge-pill badge-warning" style="font-size: 12px;">' . $row["status"] . '</span>';
                            } elseif ($row["status"] == 'Pending') {
                                echo '<span class="badge badge-pill badge-info" style="font-size: 12px;">' . $row["status"] . '</span>';
                            } elseif ($row["status"] == 'Cancelled') {
                                echo '<span class="badge badge-pill badge-danger" style="font-size: 12px;">' . $row["status"] . '</span>';
                            } elseif ($row["status"] == 'Dispute') {
                                echo '<span class="badge badge-pill badge-secondary" style="font-size: 12px;">' . $row["status"] . '</span>';
                            }

                            echo '</td>';


                            //convert timestamp to only date format
                            $dateTimeCreate = $row["order_creation_date"];
                            $justDateCreate = date("Y-m-d", strtotime($dateTimeCreate));
                            echo '<td style="text-align: center;">' . $justDateCreate . '</td>';

                            echo '<td style="text-align: center;">';
                            if ($row["priority"] == 'Regular') {
                                // Display a green badge for "Regular"
                                echo '<span class="badge badge-pill badge-success" style="font-size: 12px;">' . $row["priority"] . '</span>';
                            } elseif ($row["priority"] == 'Urgent') {
                                // Display a red icon for "Urgent"
                                echo '<span class="badge badge-pill badge-warning" style="font-size: 12px;">' . $row["priority"] . '</span>';
                            }
                            echo '</td>';

                            //convert timestamp to only date format
                            $dateTime = $row["date"];
                            $justDate = date("Y-m-d", strtotime($dateTime));
                            echo '<td style="text-align: center;">' . $justDate . '</td>';

                            if ($_SESSION['role'] == 'admin') {
                            ?>
                                <td>
                                    <div style="display: flex; gap: 10px;">
                                        <a type="button" class="btn btn-success btn-secondary d-flex justify-content-center" style="width:25px; height: 28px;" href="viewOrder.php?id=<?php echo $row['order_no']; ?>"><i style="width: 20px;" class="fa-solid fa-print" target="_blank"></i></a>

                                        <a type="button" class="btn btn-danger btn-floating d-flex justify-content-center" style="width:25px; height:28px" data-mdb-ripple-init
                                            onclick="return confirm('Are you sure you want to delete this record?');" href="deleteOrder.php?id=<?php echo $row['order_no']; ?>"> <i style="width: 20px;" class="fa-solid fa-trash"></i></a>

                                        <a type="button" class="btn btn-secondary btn-secondary d-flex justify-content-center" style="width:25px; height: 28px;" href="viewWO.php?id=<?php echo $row['order_no']; ?>"><i style="width: 20px;" class="fa-solid fa-eye" target="_blank"></i></a>

                                        <a type="button"
                                            class=""
                                            style="height: 30px; width: 30px;"
                                            href="assignTaskForm.php?id=<?php echo $row['order_no']; ?>"
                                            target="_blank">
                                            <img src="assets/img/Gartoon-Team-Gartoon-Misc-Stock-Task-Assigned.32.png" alt="View">
                                        </a>
                                    </div>
                                </td>
                    <?php
                            }
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

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- DataTables core library and export buttons -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

    <!-- Additional libraries for exporting (Excel, PDF) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Bootstrap and DataTables styling -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- SearchPanes and Select styling and functionality -->
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.3.3/css/searchPanes.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/2.1.0/css/select.bootstrap5.css">
    <script src="https://cdn.datatables.net/searchpanes/2.3.3/js/dataTables.searchPanes.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.3/js/searchPanes.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/select/2.1.0/js/dataTables.select.js"></script>

    <!--for icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">


    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <!--for search panes-->
    <script>
        new DataTable('#orderT', {

            //show the rows in descending order by the date
            "order": [
                [3, "desc"]
            ],

            //show 100 rows by default
            "pageLength": 100,

            layout: {
                top1: 'searchPanes'
            },

            //collapse by default
            "searchPanes": {
                "initCollapsed": true,
                columns: []
            }

        });
    </script>



</body>


</html>