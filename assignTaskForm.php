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



    //get workorder_no
    $workorder_no = $_GET['id'];

    $sql = "SELECT * FROM `orders` WHERE `order_no` = '$workorder_no'";
    $result = $conn->query($sql);
}

if ($result && $result->num_rows > 0) {
    $row3 = $result->fetch_assoc();
    $order_no = $row3['order_no'];
    $creator = $row3['creator'];

    $comp_id_fk = $row3['comp_id_fk'];

    //get company name from compani table
    $compName = "SELECT * FROM compani WHERE comp_id = $comp_id_fk";
    $compNameResult = $conn->query($compName);
    if ($compNameResult && $compNameResult->num_rows > 0) {
        $row4 = $compNameResult->fetch_assoc();

        $comp_name = $row4['comp_name'];
    }

    $branch_id_fk = $row3['branch_id_fk'];

    //get branch name from branch table
    $branchName = "SELECT * FROM branches WHERE branch_id = $branch_id_fk";
    $branchNameResult = $conn->query($branchName);
    if ($branchNameResult && $branchNameResult->num_rows > 0) {
        $row5 = $branchNameResult->fetch_assoc();

        $branch_name = $row5['branch_name'];
    }

    $priority = $row3['priority'];
    $flag = $row3['flag'];
    $date = $row3['date'];
    $foc = $row3['foc'];
    $phone = $row3['foc_phone'];
    $pickup_add = $row3['pickup_address'];
    $object = $row3['object_code'];

    $barcode = $row3['barcode'];
    
    //show location of the barcode
    $location = "SELECT * FROM store WHERE box = '$barcode'";
    $locationResult = $conn->query($location);
    if ($locationResult && $locationResult->num_rows > 0) {
        $row6 = $locationResult->fetch_assoc();
        $rack_location = $row6['rack_select'];
    } else {
        $rack_location = "Selected Box is not stored in the Warehouse";
?>
        <script>
            // JavaScript to show the alert
            alert("<?php echo $rack_location; ?>");
        </script>
<?php
die();
    }

    //convert array into json
    $raw_items = $row3['item_barcode'];
    $json_items = json_encode($raw_items);

    // $alt = $row3['alt'];
    $requestor = $row3['requestor'];
    $role = $row3['role'];
    $req_date = $row3['req_date'];
    $description = $row3['description'];
    $create_date = $row3['order_creation_date'];
    $obj_type = $row3['obj_typ'];
    $quant = $row3['quant'];
    $supp_req = $row3['supp_requestor'];
    $cost_center = $row3['cost_cent'];
    $dateTime = $row3['dateTime'];
    $comment = $row3['comment'];
} else {
    echo "No order found";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //get workorder from url
    $assign_to = mysqli_real_escape_string($conn, $_POST['labour']);
    // $location = mysqli_real_escape_string($conn, $_POST['location']);
    //get box barcode from workorder table
    //same as items
    $bankInstructions = mysqli_real_escape_string($conn, $_POST['bank_instruction']);
    $adminInstructions = mysqli_real_escape_string($conn, $_POST['admin_instruction']);
    $handover_to = mysqli_real_escape_string($conn, $_POST['handover_to']);


    //check for duplicate task
    $checkTask = "SELECT * FROM assign_task WHERE order_no_fk = '$workorder_no'";
    $resultCheck = mysqli_query($conn, $checkTask);
    if ($resultCheck->num_rows > 0) {
        // If task already exists, redirect to assignTaskForm.php with error message
        $_SESSION['error_message'] = "Task already assigned!";
        header("Location: order.php");
        exit;
    }

    // Insert data into box table
    $sql = "INSERT INTO assign_task (order_no_fk, assign_to, location, bank_instruction, admin_instruction, box, items, is_read, handover_to) 
            VALUES ('$workorder_no', '$assign_to', '$rack_location', '$bankInstructions', '$adminInstructions', '$barcode', '$json_items', '0', '$handover_to')";

    if ($conn->query($sql) === TRUE) {
        // Set success message in session
        $_SESSION['success_message'] = "Task assigned successfully!";
        header("Location: order.php");
        exit;
    } else {
        echo "Failed to assign the task: " . $conn->error;
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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

    <script src="https://code.jquery.com/jquery/3.7.1/jquery.min.js"></script>
    <!--choosen-js css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <!--choosen js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

    <!-- dselect -->
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>

    <!-- ALERTIFY CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.rtl.min.css" />

    <style>
        /* form text sizing */
        .form-select {
            font-size: 0.8rem;
        }

        .form-control {
            font-size: 0.8rem;
        }


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

    <title>Assign Work Order</title>


</head>

<body>
    <!-- ======= Header ======= -->
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

    <!-- sidebar -->
    <?php include "sidebarcode.php"; ?>
    <!-- -----End Sidebar------>

    <!--form--------------------------------------form--------------------------------------->
    <!-- Start Header form -->
    <div class="headerimg text-center">
        <h2>Assign Workorder to staff</h2>
    </div>
    <!-- End Header form -->

    <div class="container d-flex justify-content-center">
        <div class="card custom-card shadow-lg mt-3">
            <div class="card-body mt-3">

                <h2 style="margin-bottom: 20px;"><strong><u><?php echo $comp_name . "/" . $branch_name ?></u></strong></h2>
                <form class="row g-3 needs-validation" id="orderForm" action="" method="POST">

                    <div class="col-md-3">
                        <label for="" class="form-label">Workorder No.</label>
                        <input type="workorder_no" class="form-control" id="" name="workorder_no" value="<?php echo $workorder_no; ?>" readonly>
                    </div>

                    <!-- Select labour -->
                    <div class="col-md-3">
                        <label for="labour">Assign to:</label>
                        <select id="labour" class="form-select" name="labour" required>
                            <option value="">Select labour</option>
                            <?php

                            $result = $conn->query("SELECT id, name, phone FROM register WHERE role = 'Labour'");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['name']}'>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Select location
                    <div class="col-md-3">
                        <label for="loc">Pickup Location:</label>
                        <select id="loc" class="form-select" name="location" required>
                            <option value="">Select location</option>       
                        </select>
                    </div> -->

                    <!-- Select location -->
                    <div class="col-md-3">
                        <label for="">Hand over to:</label>
                        <select id="" class="form-select" name="handover_to" required>
                            <option value="">Select</option>
                            <option value="Data Tech's driver">Data Tech's driver</option>
                            <option value="Courier">Courier</option>
                            <option value="Authorized person from bank">Authorized person from bank</option>
                            <option value="Handed over to admin">Handed over to admin</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Instructions by Client</label>
                        <textarea type="desc" class="form-control" id="" rows="3" name="bank_instruction" readonly><?php echo $description ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Instructions by Admin</label>
                        <textarea type="desc" class="form-control" id="" rows="3" name="admin_instruction"><?php  ?></textarea>
                    </div>
                    
                    <div class="container">
                        <div class="row">

                            <h5 class="mt-4">Details:</h5>
                            <div class="col-md-3">
                                <strong>Container/Filefolder:</strong>
                                <?php
                                echo "<ul>";
                                echo "<li>" . htmlspecialchars($barcode) . "</li>";
                                echo "</ul>";
                                ?>
                            </div>
                            <div class="col-md-3">
                                <?php
                                //in this case data is csv

                                // Remove double quotes if they exist
                                $json_items = trim($json_items, '"');

                                // Convert the comma-separated string into an array
                                $show_items_array = explode(',', $json_items);

                                // Trim whitespace from each value
                                $show_items_array = array_map('trim', $show_items_array);



                                echo '<b> Items for (' . htmlspecialchars($barcode) . '): </b>';
                                // Display each value
                                echo "<ul>";
                                foreach ($show_items_array as $item) {
                                    echo "<li>" . htmlspecialchars($item) . "</li>";
                                }
                                echo "</ul>";
                                ?>
                            </div>
                            <div class="col-md-3">
                                <strong>Location:</strong>
                                <?php
                                echo "<ul>";
                                echo "<li>" . $rack_location . "</li>";
                                echo "</ul>";
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4 mb-2">
                        <button type="submit" class="btn btn-outline-primary mr-1" name="submit" value="submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Include Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
    <!-- Updated JavaScript with proper lev2Select selection -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="assets/js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- ALERTIFY JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

    <?php
    if (isset($_SESSION['success_message'])):
    ?>
        <script>
            // Set Alertify to display notifications at the top of the page
            alertify.set('notifier', 'position', 'top-right');
            alertify.success("<?= 'Task assigned successfully' ?>");
        </script>
    <?php
        //unset message after displaying it to the user
        unset($_SESSION['success_message']); // Clear the message
    endif;
    ?>


    <!--datatable export buttons-->
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