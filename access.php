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
    <link href="assets/img/dtl.png" rel="icon">
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

        .overflow-auto {
            overflow: auto !important;
            margin-top: 92px !important;
        }

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
            padding: 0 20px 20px 18px !important;
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

    <title>Access Workorders</title>

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

    <!-- Main content -->
    <main id="main" class="main">
        <div class="col-15">
            <!-- Add the buttton for the work order -->
            <div class="cardBranch recent-sales overflow-auto">
                <div class="card-body">

                    <!-- Title and Add Button -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <h5 class="card-title">Access Work Orders</h5>
                        </div>
                        <div class="col-6 text-end mt-2">
                            <button type="button" onclick="window.location.href = 'createAccessWO.php'" class="btn btn-primary mb-3">Add</button>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="" class="row g-3 mb-3">
                        <!-- Dropdown for Column Selection -->
                        <div class="col-md-4">
                            <label for="column" class="form-label">Select Column</label>
                            <select name="column" id="column" class="form-select">
                                <option value="" selected>Choose...</option>
                                <option value="comp_id_fk">Company</option>
                                <option value="branch_id_fk">Branch</option>
                                <option value="dept_id_fk">Department</option>
                                <!-- <option value="status">Status</option> -->
                                <option value="priority">Priority</option>
                            </select>
                        </div>

                        <!-- Input Field for Search Value -->
                        <div class="col-md-4">
                            <label for="value" class="form-label">Search Value</label>
                            <input type="text" name="value" id="value" class="form-control" placeholder="Enter search value">
                        </div>

                        <!-- Buttons -->
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" name="search" class="btn btn-primary w-100">Search</button>
                            <button type="submit" name="show_all" class="btn btn-secondary w-100">Show All</button>
                        </div>

                        <!-- Date Range Filter -->
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" name="filter_date" class="btn btn-info w-50">Filter Dates</button>
                        </div>
                    </form>

                    <!-- Table -->
                    <?php
                    // Query logic
                    $query = "SELECT * FROM orders WHERE 1=0"; // Default no rows

                    // Search by Column and Value
                    if (isset($_GET['search']) && !empty($_GET['column']) && !empty($_GET['value'])) {
                        $column = $conn->real_escape_string($_GET['column']);
                        $value = $conn->real_escape_string($_GET['value']);

                        if ($column === 'comp_id_fk') {
                            // Search by Company Name
                            $query = "SELECT o.* FROM orders o 
                  JOIN compani c ON o.comp_id_fk = c.comp_id 
                  WHERE c.comp_name LIKE '%$value%'";
                        } elseif ($column === 'branch_id_fk') {
                            // Search by Branch Name
                            $query = "SELECT o.* FROM orders o 
                  JOIN branches b ON o.branch_id_fk = b.branch_id 
                  WHERE b.branch_name LIKE '%$value%'";
                        } elseif ($column === 'dept_id_fk') {
                            // Search by Department Name
                            $query = "SELECT o.* FROM orders o 
                  JOIN departments d ON o.dept_id_fk = d.dept_id 
                  WHERE d.dept_name LIKE '%$value%'";
                        } else {
                            // Search other fields in the orders table
                            $query = "SELECT * FROM orders WHERE flag = 'Access' AND $column LIKE '%$value%' ORDER BY order_creation_date DESC";
                        }
                    }

                    // Filter by Date Range
                    if (isset($_GET['filter_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
                        $start_date = $conn->real_escape_string($_GET['start_date']);
                        $end_date = $conn->real_escape_string($_GET['end_date']);
                        $query = "SELECT * FROM orders WHERE flag = 'Access' AND order_creation_date BETWEEN '$start_date' AND '$end_date'";
                    }

                    // Show All Button
                    if (isset($_GET['show_all'])) {
                        $query = "SELECT * FROM orders where flag = 'Access' LIMIT 100";
                    }
                    
                    // Execute the query
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        echo '<table id="orderT" class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Branch</th>
                    <th>Department</th>
                
                    <th>Create Date</th>
                    <th>Priority</th>
                    <th>Required By</th>';
                        if ($_SESSION['role'] == 'admin') {
                            echo '<th>Action</th>';
                        }
                        echo '</tr></thead><tbody>';

                        $counter = 1;
                        while ($row = $result->fetch_assoc()) {
                            // Fetch Company Name
                            $comp_name = get_name($conn, "compani", "comp_name", "comp_id", $row['comp_id_fk']);
                            // Fetch Branch Name
                            $branch_name = get_name($conn, "branches", "branch_name", "branch_id", $row['branch_id_fk']);
                            // Fetch Department Name
                            $dept_name = get_name($conn, "departments", "dept_name", "dept_id", $row['dept_id_fk']);

                            // Format Dates
                            $createDate = date("d-m-Y", strtotime($row['order_creation_date']));

                            //handle date and empty values
                            $requiredBy = !empty($row['date']) ? date("d-m-Y", strtotime($row['date'])) : '';


                            echo "<tr>
                <td>{$row['order_no']}</td>
                <td>{$comp_name}</td>
                <td>{$branch_name}</td>
                <td>{$dept_name}</td>       
                <td>{$createDate}</td>
                <td>{$row['priority']}</td>
                <td>{$requiredBy}</td>";

                            if ($_SESSION['role'] == 'admin') {
                                echo '<td>
                    <div class="d-flex gap-2">
                        <a href="viewOrder.php?id=' . $row['order_no'] . '" class="btn btn-info btn-sm">
                            <i class="fa-solid fa-print"></i>
                        </a>
                        
                        <a href="deleteOrder.php?id=' . $row['order_no'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\');">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                  </td>';
                            }

                            echo '</tr>';
                            $counter++;
                        }

                        echo '</tbody></table>';
                    } elseif (isset($_GET['search']) || isset($_GET['filter_date']) || isset($_GET['show_all'])) {
                        echo '<p class="text-center mt-3">No results found.</p>';
                    }
                    ?>

                </div>
            </div>

            <?php
            // Function to fetch names based on IDs
            function get_name($conn, $table, $column_name, $id_column, $id_value)
            {
                $query = "SELECT $column_name FROM $table WHERE $id_column = '$id_value' LIMIT 1";
                $result = $conn->query($query);
                if ($result && $result->num_rows > 0) {
                    return $result->fetch_assoc()[$column_name];
                }
                return "N/A"; // Return default if not found
            }
            ?>


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

    <!--for datatable-->
    <script>
        new DataTable('#orderT', {
            // <!--make the table => datatable.net table and also change the alignment of the text in columns-->
            columnDefs: [{
                    className: "text-left",
                    targets: [0, 1, 2, 3, 4, 5, 6, 7]
                } // change alignment 

            ],

            //show the rows in descending order by the date
            "order": [
                [3, "desc"]
            ],

            //show 100 rows by default
            "pageLength": 100,

            //collapse by default
            "searchPanes": {
                "initCollapsed": true,
                columns: []
            }

        });
    </script>

</body>


</html>